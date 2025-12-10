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

        // If an explicit plan is provided and it's NOT the trial plan, clear trial_mode
        if ($plan && $plan != config('paypal.trial_plan_id')) {
            session()->forget('trial_mode');
        }

        // Check if this is trial mode from session, POST data, or session trial_plan
        $trialMode = session()->has('trial_mode') || $request->input('plan') == config('paypal.trial_plan_id') || session('trial_plan') == config('paypal.trial_plan_id');

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

        // For trial mode, we need the trial plan available for selection
        if ($trialMode) {
            $trialPlan = Plan::with('features')->find(config('paypal.trial_plan_id'));
            if ($trialPlan) {
                // Add trial plan to allPlans for JavaScript to find it
                $allPlans->push($trialPlan);
            }
        }

        // For trial mode, we don't need a specific planModel initially
        $planModel = null;
        if ($plan) {
            $planModel = Plan::with('features')->findOrFail($plan);
        }

        return view('web.checkout', compact('planModel', 'allPlans', 'trialMode'));
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

            // Create order record in database
            $order = PlanOrder::create([
                'user_id' => Auth::id(),
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'currency' => config('app.currency'),
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
                'currency' => config('app.currency'),
                'status' => 'completed',
                'payment_status' => 'trial',
                'paid_at' => now(),
                'transaction_id' => 'TRIAL-' . uniqid(),
                'billing_info' => $request->billing_info ?: [],
                'payment_details' => json_encode(['type' => 'trial', 'activated_at' => now()])
            ]);
            $userEmail = $order->user->email;
            $userSubject = "Your plan '{$plan->name}' is activated!";
            $app_name = config('app.name');
            $support_mail = config('mail.admin_email');
            $userBody = $this->userTrialMail($order->user->name,$plan->name,$plan->duration,$order->transaction_id,$plan->mail_available,$app_name,$support_mail);
            
            if ($userEmail != null) {
                try {
                    Mail::html($userBody, function ($message) use ($userEmail, $userSubject) {
                        $message->to($userEmail)
                            ->subject($userSubject);
                    });
                } catch (\Exception $e) {
                    Log::error('Mail sending exception: ' . $e->getMessage(), [
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
                    $amount="{$order->currency}{$order->amount}";
                    $app_name = config('app.name');
                    $support_mail = config('mail.admin_email');
                    $userBody=$this->orderUserMail($order->user->name,$plan->name,$plan->duration,$order->transaction_id,$plan->mail_available,$amount,$order->paid_at,$app_name,$support_mail);
                    if ($userEmail != null) {
                        Mail::html($userBody, function ($message) use ($userEmail, $userSubject) {
                            $message->to($userEmail)
                                ->subject($userSubject);
                        });
                    }


                    //admin mail
                    $adminEmail = config('mail.admin_email'); // set in .env
                    $adminSubject = "New Plan Ordered";
                    // $amount="{$order->currency} {$order->amount}";
                    
                    $adminBody = $this->orderAdminMail($order->user->name,$order->user->email,$plan->name,$amount,$order->transaction_id,$order->paid_at,$app_name);
                    if ($adminEmail != null) {

                        $mail_status = Mail::html($adminBody, function ($message) use ($adminEmail, $adminSubject) {
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

    public function userTrialMail($name,$plan,$plan_duration,$transection_id,$mail_available,$app_name,$support_mail){

        $dashbord=route('dashboard');
        $contact=route('contact');
        $body='<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#eef2f7;">
    <tr>
        <td align="center" style="padding:22px 8px;">

            <!-- MAIN CONTAINER -->
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                style="max-width:620px; margin:0 auto; background:white; border-radius:14px; overflow:hidden; box-shadow:0 10px 28px rgba(0,0,0,0.12);">

                <!-- HEADER -->
                <tr>
                    <td align="center"
                        style="background:linear-gradient(135deg,#4f46e5,#6366f1); padding:38px 16px;">
                        <svg style="color: #34ff34;width: 60px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>

                        <h1
                            style="color:#ffffff; margin:0; font-size:24px; font-weight:bold; line-height:1.25; font-family:Arial,Helvetica,sans-serif;">
                            Your Plan is Activated
                        </h1>
                        <p
                            style="color:#e0e7ff; margin:12px 0 0 0; font-size:14px; line-height:1.5; font-family:Arial,Helvetica,sans-serif;">
                            Your subscription is now live
                        </p>
                    </td>
                </tr>

                <!-- BODY -->
                <tr>
                    <td
                        style="padding:28px 18px; font-family:Arial,Helvetica,sans-serif; color:#1f2937; line-height:1.7;">

                        <p style="font-size:16px; margin:0 0 18px 0;">
                            Hello <strong style="color:#4f46e5;">'.$name.'</strong>,
                        </p>

                        <p style="font-size:14px; margin:0 0 22px 0; color:#374151;">
                            Your order for the plan <strong>'.$plan.'</strong> has been successfully completed. Below are your activation details:
                        </p>

                        <!-- INFO CARD -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                            style="background:#f9fafb; border-radius:12px; border:1px solid #e5e7eb;">

                            <tr>
                                <td style="padding:16px 14px;">

                                    <!-- STACKED GRID -->
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">

                                        <tr>
                                            <td style="padding:6px 0; font-size:12px; color:#6b7280;"><strong>Transaction ID</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 12px 0; font-size:13px; color:#111827; word-break:break-all;">
                                                '.$transection_id.'
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:6px 0; font-size:12px; color:#6b7280;"><strong>Plan Duration</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 12px 0; font-size:13px; color:#111827;">
                                                '.$plan_duration.' Days
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:6px 0; font-size:12px; color:#6b7280;"><strong>Mail Credits</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0; font-size:13px; color:#111827;">
                                                '.$mail_available.'(total)
                                            </td>
                                        </tr>

                                    </table>

                                </td>
                            </tr>
                        </table>

                        <p style="font-size:14px; margin:22px 0 26px 0; color:#374151;">
                            Thank you for choosing <strong style="color:#4f46e5;">'.$app_name.'</strong>. You may now begin sending email campaigns instantly.
                        </p>

                        <!-- CTA BUTTON -->
                        <div align="center" style="margin:12px 0 22px;">
                            <a href="'.$dashbord.'" target="_blank"
                                style="background:#4f46e5; color:#ffffff; font-size:15px; font-weight:bold; text-decoration:none; padding:14px 36px; border-radius:10px; display:inline-block;">
                                Go to Dashboard →
                            </a>
                        </div>

                        <p align="center" style="margin:0; font-size:12px; color:#6b7280;">
                            Need help? Contact our support anytime.
                        </p>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td align="center"
                        style="background:#f3f4f6; padding:22px 16px; color:#6b7280; font-size:12px; line-height:1.6; font-family:Arial,sans-serif;">
                        © 2025 <strong>'.$app_name.'</strong>. All rights reserved.<br><br>
                        Support:
                        <a href='.$contact.'
                            style="color:#4f46e5; font-weight:bold; text-decoration:none;">
                          Contact us
                        </a>
                    </td>
                </tr>

            </table>
            <!-- END CONTAINER -->

        </td>
    </tr>
</table>';
return $body;
    }

    public function orderAdminMail($name,$email,$plan,$amount,$transection_id,$paid_at,$app_name){
        $body='
        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e5e7eb; font-family:Arial,Helvetica,sans-serif;">
            <tr>
                <td align="center" style="padding:20px 10px;">

                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:620px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,0.12);">
                        
                        <!-- Header - Warning Style -->
                        <tr>
                            <td align="center" style="background:linear-gradient(135deg,#dc2626,#ef4444); padding:40px 20px;">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:#ffffff; margin-bottom:16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                                </svg>
                                <h1 style="color:#ffffff; margin:0; font-size:26px; font-weight:bold; line-height:1.3;">New Plan Order</h1>
                                <p style="color:#fecaca; margin:12px 0 0; font-size:16px;">Admin Notification</p>
                            </td>
                        </tr>

                        <!-- Body -->
                        <tr>
                            <td style="padding:32px 24px; color:#1f2937; line-height:1.7;">
                                <p style="margin:0 0 16px; font-size:17px;">Hello Admin,</p>
                                
                                <p style="margin:0 0 24px; font-size:15px; color:#374151;">
                                    A new user has successfully purchased a subscription. Please review the details below:
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9fafb; border-radius:12px; border:1px solid #e5e7eb;">
                                    <tr>
                                        <td style="padding:20px;">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr><td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>User</strong></td></tr>
                                                <tr><td style="padding:0 0 12px; font-size:15px; color:#111827;">'.$name.'<br><span style="color:#4f46e5;">'.$email.'</span></td></tr>

                                                <tr><td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Plan</strong></td></tr>
                                                <tr><td style="padding:0 0 12px; font-size:15px; color:#111827;">'.$plan.'</td></tr>

                                                <tr><td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Amount</strong></td></tr>
                                                <tr><td style="padding:0 0 12px; font-size:15px; color:#16a34a; font-weight:bold;">'.$amount.'</td></tr>

                                                <tr><td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Transaction ID</strong></td></tr>
                                                <tr><td style="padding:0 0 12px; font-size:15px; color:#111827; word-break:break-all;">'.$transection_id.'</td></tr>

                                                <tr><td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Paid At</strong></td></tr>
                                                <tr><td style="padding:0; font-size:15px; color:#111827;">'.$paid_at .'</td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:16px; margin:24px 0;">
                                    <p style="margin:0; font-size:14px; color:#b91c1c;">⚠️ Please verify this transaction and activate the user account if not already done.</p>
                                </div>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td align="center" style="background:#1e293b; padding:24px; color:#94a3b8; font-size:13px;">
                                © 2025 <strong style="color:#ffffff;">'.$app_name.'</strong> — Admin Notification System
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
        return $body;
    }
    public function orderUserMail($name, $plan, $plan_duration, $transection_id, $mail_available, $amount, $paid_at,$app_name,$support_mail)
{
    $dashboardUrl = route("dashboard");
    $contact=route("contact");
    $body = '
    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
        style="background-color:#eef2f7; font-family:Arial,Helvetica,sans-serif;">
        <tr>
            <td align="center" style="padding:15px 8px;">

                <!-- Main Wrapper -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation"
                    style="max-width:620px; margin:0 auto; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 10px 28px rgba(0,0,0,0.12);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:#4f46e5; background:linear-gradient(135deg,#4f46e5,#6366f1); padding:36px 18px;">
                            <svg style="color: #34ff34;width: 60px;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.67 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>

                            <h1 style="color:#ffffff; margin:0; font-size:26px; font-weight:bold; line-height:1.3;">
                                Plan Activated Successfully!
                            </h1>

                            <p style="color:#e0e7ff; margin:10px 0 0; font-size:15px; line-height:1.5;">
                                Welcome aboard! You\'re all set to start.
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:28px 20px; color:#1f2937; line-height:1.6;">

                            <p style="font-size:17px; margin:0 0 14px;">
                                Hello <strong style="color:#4f46e5;">' . $name . '</strong>,
                            </p>

                            <p style="font-size:15px; margin:0 0 24px; color:#374151;">
                                Your order for the <strong>' . $plan . '</strong> plan has been completed successfully.
                                Below are your plan details:
                            </p>

                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#f9fafb; border-radius:12px; border:1px solid #e5e7eb;">

                                <tr>
                                    <td style="padding:16px 14px;">

                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">

                                            <tr>
                                                <td style="padding:6px 0; font-size:12px; color:#6b7280;">
                                                    <strong>Transaction ID</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 0 12px 0; font-size:13px; color:#111827;">
                                                    ' . $transection_id . '
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:6px 0; font-size:12px; color:#6b7280;">
                                                    <strong>Plan Duration</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 0 12px 0; font-size:13px; color:#111827;">
                                                    ' . $plan_duration . ' days
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:6px 0; font-size:12px; color:#6b7280;">
                                                    <strong>Mail Credits</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0; font-size:13px; color:#111827;">
                                                    ' . $mail_available . '/day
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:6px 0; font-size:12px; color:#6b7280;">
                                                    <strong>Amount</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0; font-size:13px; color:#111827;">
                                                    ' . $amount . '
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:6px 0; font-size:12px; color:#6b7280;">
                                                    <strong>Paid At</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0; font-size:13px; color:#111827;">
                                                    ' . $paid_at . '
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px; margin:26px 0 0; color:#374151;">
                                Thank you for choosing <strong style="color:#4f46e5;">'.$app_name.'</strong>. You can start creating
                                and sending campaigns instantly.
                            </p>

                            <!-- Button -->
                            <div align="center" style="margin:32px 0 8px;">
                                <a href=' . $dashboardUrl . '
                                    target="_blank"
                                    style="background:#4f46e5; color:#ffffff; font-weight:bold; font-size:16px; text-decoration:none; padding:14px 32px; border-radius:8px; display:inline-block;">
                                    Go to Dashboard →
                                </a>
                            </div>

                            <p align="center" style="font-size:13px; color:#6b7280; margin:18px 0 0;">
                                Need help? Our support team is always ready to assist.<a href='.$contact.' target="_blank" style="color:#4f46e5; font-weight:bold; text-decoration:none;">Contact us</a>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f3f4f6; padding:24px 18px; color:#6b7280; font-size:12.5px; line-height:1.7;">
                            © 2025 <strong>'.$app_name.'</strong>. All rights reserved.
                           
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>';

    return $body;
}


}
