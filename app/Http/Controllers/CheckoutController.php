<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\MailAvailable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use App\Jobs\ProcessPaymentCapture;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    private function getPayPalClient(): PayPalHttpClient
    {
        $environment = config('paypal.mode') === 'live'
            ? new ProductionEnvironment(config('paypal.client_id'), config('paypal.client_secret'))
            : new SandboxEnvironment(config('paypal.client_id'), config('paypal.client_secret'));

        return new PayPalHttpClient($environment);
    }

    /**
     * Display the checkout page for a specific plan
     */
    public function show(Request $request, $plan = null): View
    {
        // Check if this is trial mode from session, POST data, or session trial_plan
        $trialMode = session()->has('trial_mode') || $request->input('plan') == config('paypal.trial_plan_id') || session('trial_plan') == config('paypal.trial_plan_id');

        // If plan is not provided in URL, check query parameter for backward compatibility
        if (!$plan) {
            $plan = $request->query('plan');
        }

        // Also check POST data for plan
        if (!$plan) {
            $plan = $request->input('plan');
        }

        if (!$plan) {
            // Fallback to session-stored intent
            $plan = session('intent_plan');
            if ($plan) {
                // consume the intent once
                session()->forget('intent_plan');
            }
        }

        // For trial mode, we don't require a specific plan initially
        if (!$plan && !$trialMode) {
            abort(404, 'Plan not specified');
        }

        // Get all active plans for the modal (exclude trial plans)
        $allPlans = Plan::with('features')
            ->where('is_active', true)
            ->where('id', '!=', config('paypal.trial_plan_id'))
            ->orderBy('price', 'asc')
            ->get();

        // For trial mode, we don't need a specific planModel initially
        $planModel = null;
        if ($plan) {
            $planModel = Plan::with('features')->findOrFail($plan);
        }

        return view('web.checkout', compact('planModel', 'allPlans'));
    }

    /**
     * Create PayPal order
     */
    /**
     * Create PayPal order
     */
    public function createOrder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'plan_id' => 'required|string',
                'billing_info' => 'required|array'
            ]);

            // Get plan details from database
            $plan = Plan::findOrFail($request->plan_id);

            // Create order record in database (keep original currency)
            $order = PlanOrder::create([
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'currency' => $plan->currency, // Store original currency
                'status' => 'pending',
                'billing_info' => $request->billing_info,
            ]);

            $client = $this->getPayPalClient();

            $orderRequest = new OrdersCreateRequest();
            $orderRequest->prefer('return=representation');
            $orderRequest->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $order->id,
                    "amount" => [
                        "value" => number_format($plan->price, 2, '.', ''), // Keep original amount
                        "currency_code" => "USD" // Force USD for PayPal
                    ],
                    "description" => "Package: " . $plan->name
                ]],
                "application_context" => [
                    "cancel_url" => route('checkout.cancel'),
                    "return_url" => route('checkout.success')
                ]
            ];

            $response = $client->execute($orderRequest);

            // Update order with PayPal order ID
            $order->update([
                'paypal_order_id' => $response->result->id
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $response->result->id,
                'status' => $response->result->status
            ]);
        } catch (\Exception $e) {
            Log::error('PayPal order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completeTrial(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            // Check if user already has trial
            if ($user->is_trial) {
                return response()->json(['success' => false, 'message' => 'You have already used your trial'], 400);
            }

            // Get plan details (trial plan)
            $plan = Plan::find(config('paypal.trial_plan_id'));
            if (!$plan) {
                return response()->json(['success' => false, 'message' => 'Trial plan not found'], 404);
            }

            // Create trial order record
            $order = PlanOrder::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => 0, // Free trial
                'currency' => $plan->currency,
                'status' => 'completed',
                'payment_status' => 'trial',
                'paid_at' => now(),
                'transaction_id' => 'TRIAL-' . uniqid(),
                'billing_info' => $request->billing_info ?: [],
                'payment_details' => json_encode(['type' => 'trial', 'activated_at' => now()])
            ]);
                    $userEmail = $order->user->email;
                    $userSubject = "Your plan '{$plan->name}' is activated!";
                    $userBody = "Hello {$order->user->name},\n\n"
                        . "Your order for the plan '{$plan->name}' has been successfully completed.\n"
                        . "Transaction ID: {$order->transaction_id}\n"
                        . "Plan Duration: {$plan->duration} Day\n"
                        . "Mail Credits: {$plan->mail_available}\n\n"
                        . "Thank you for choosing " . config('app.name') . ".";
                    if($userEmail!=null){
                    try{
                        Mail::raw($userBody, function ($message) use ($userEmail, $userSubject) {
                        $message->to($userEmail)
                            ->subject($userSubject);
                    });
                    }catch(\Exception $e)
                    {
                        Log::error('Mail sending exception: '.$e->getMessage(), [
                            'email' => $userEmail,
                            'exception' => $e
                        ]);
                    }
                    }
            // Create mail credits for trial
            MailAvailable::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'total_mail' => $plan->mail_available,
                'available_mail' => $plan->mail_available,
                'created_at' => now(),
            ]);

            // Activate trial
            $user->is_trial = 1;
            $user->valid_trial_date = Carbon::today()->addDays(7);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Trial activated successfully']);

        } catch (\Exception $e) {
            Log::error('Trial activation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to activate trial'], 500);
        }
    }

    // public function capturePayment(Request $request): JsonResponse
    // {
    //     try {
    //         $request->validate([
    //             'order_id' => 'required|string|min:1',
    //         ]);

    //         // Additional validation - ensure order_id looks like a PayPal order ID
    //         if (empty($request->order_id) || !preg_match('/^[A-Z0-9]+$/', $request->order_id)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid order ID format.'
    //             ], 400);
    //         }

    //         // Find the order by PayPal order ID
    //         $order = PlanOrder::where('paypal_order_id', $request->order_id)->first();

    //         if (!$order) {
    //             \Log::warning('Order not found for PayPal order ID', [
    //                 'paypal_order_id' => $request->order_id,
    //                 'user_id' => Auth::id()
    //             ]);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Order not found. Please try again.'
    //             ], 404);
    //         }

    //         // Check if order is ready for capture
    //         if ($order->status !== 'pending') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Order is not ready for payment capture.'
    //             ], 400);
    //         }

    //         // Dispatch the payment capture job to queue
    //         \App\Jobs\ProcessPaymentCapture::dispatch($request->order_id, Auth::id());

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Payment processing started. You will be redirected shortly.',
    //             'status' => 'processing'
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         \Log::error('Validation failed for payment capture', [
    //             'errors' => $e->errors(),
    //             'request_data' => $request->all()
    //         ]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid request data.'
    //         ], 422);
    //     } catch (\Exception $e) {
    //         \Log::error('PayPal payment capture dispatch failed: ' . $e->getMessage(), [
    //             'exception' => $e,
    //             'request_data' => $request->all()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Payment processing failed. Please try again.'
    //         ], 500);
    //     }
    // }

    public function capturePayment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'order_id' => 'required|string|min:1',
            ]);

            // Additional validation - ensure order_id looks like a PayPal order ID
            if (empty($request->order_id) || !preg_match('/^[A-Z0-9]+$/', $request->order_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid order ID format.'
                ], 400);
            }

            // Find the order by PayPal order ID
            $order = PlanOrder::with('plan')->where('paypal_order_id', $request->order_id)->first();

            if (!$order) {
                Log::warning('Order not found for PayPal order ID', [
                    'paypal_order_id' => $request->order_id,
                    'user_id' => Auth::id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found. Please try again.'
                ], 404);
            }

            // Check if order is ready for capture
            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order is not ready for payment capture.'
                ], 400);
            }

            $client = $this->getPayPalClient();
            $request = new OrdersCaptureRequest($request->order_id);
            $request->prefer('return=representation');

            try {
                $response = $client->execute($request);

                if ($response->statusCode === 201 || $response->statusCode === 200) {
                    $paypalOrder = $response->result;

                    // Update order status
                    $order->update([
                        'status' => 'completed',
                        'payment_status' => 'completed',
                        'paid_at' => now(),
                        'transaction_id' => $paypalOrder->purchase_units[0]->payments->captures[0]->id,
                        'payment_details' => json_encode($paypalOrder)
                    ]);
                
                $plan = Plan::findOrFail($order->plan_id);
                    MailAvailable::create([
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'total_mail' => $plan->mail_available,
                        'available_mail' => $plan->mail_available,
                        'created_at' => now(),
                    ]);

                    //order mail for user
                    $userEmail = $order->user->email;
                    $userSubject = "Your plan '{$plan->name}' is activated!";
                    $userBody = "Hello {$order->user->name},\n\n"
                        . "Your order for the plan '{$plan->name}' has been successfully completed.\n"
                        . "Transaction ID: {$order->transaction_id}\n"
                        . "Plan Duration: {$plan->duration} Day\n"
                        . "Mail Credits: {$plan->mail_available}\n\n"
                        . "Thank you for choosing " . config('app.name') . ".";
                    if($userEmail!=null){
                    Mail::raw($userBody, function ($message) use ($userEmail, $userSubject) {
                        $message->to($userEmail)
                            ->subject($userSubject);
                    });
                    }
                    

                    //admin mail 
                    $adminEmail = config('mail.admin_email'); // set in .env
                    $adminSubject = "New Plan Ordered";
                    $adminBody = "User: {$order->user->name} ({$order->user->email})\n"
                        . "Plan: {$plan->name}\n"
                        . "Amount: {$order->amount} {$order->currency}\n"
                        . "Transaction ID: {$order->transaction_id}\n"
                        . "Paid at: " . now()->toDateTimeString();
                    if($adminEmail!=null){
                        
                    $mail_status=Mail::raw($adminBody, function ($message) use ($adminEmail, $adminSubject) {
                        $message->to($adminEmail)
                            ->subject($adminSubject);
                    });
                    
                     }

                    //end mail

                    // Update user's plan
                    $user = Auth::user();
                    $user->update([
                        'plan_id' => $order->plan_id,
                        'plan_expires_at' => now()->addDays($order->plan->duration),
                        'mail_available' => $order->mail_available
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Payment captured successfully!',
                        'status' => 'completed',
                        'redirect_url' => route('checkout.success')
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('PayPal capture failed: ' . $e->getMessage(), [
                    'exception' => $e,
                    'order_id' => $request->order_id
                ]);

                // Update order status to failed
                $order->update([
                    'status' => 'failed',
                    'payment_status' => 'failed'
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment capture failed. Please try again.'
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for payment capture', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle PayPal webhook
     */
    public function webhook(Request $request): JsonResponse
    {
        // Verify webhook signature (PayPal SDK)
        // Process the webhook data
        // Update order status in database

        return response()->json(['status' => 'ok']);
    }


    // public function success(Request $request): View
    // {
    //     // Get transaction_id from cache instead of session (since jobs run asynchronously)
    //     $transactionId = \Cache::get('payment_success_' . Auth::id());

    //     // Clear the cache value after use
    //     if ($transactionId) {
    //         \Cache::forget('payment_success_' . Auth::id());
    //     }

    //     // Get order details for success page
    //     $order = null;
    //     if ($transactionId) {
    //         $order = PlanOrder::with(['plan', 'user'])
    //             ->where('transaction_id', $transactionId)
    //             ->first();
    //     }

    //     return view('web.checkout-success', compact('transactionId', 'order'));
    // }


    public function success(Request $request): View
    {
        // If this is a trial completion, do not show any paid order details
        if (session()->has('trial_completed')) {
            return view('web.checkout-success', [
                'transactionId' => null,
                'order' => null,
            ]);
        }

        // Get the most recent completed order for the current user
        $order = PlanOrder::with(['plan', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->latest()
            ->first();

        return view('web.checkout-success', [
            'transactionId' => $order->transaction_id ?? null,
            'order' => $order
        ]);
    }
    /**
     * Show payment cancel page
     */
    public function cancel(Request $request): RedirectResponse
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}
