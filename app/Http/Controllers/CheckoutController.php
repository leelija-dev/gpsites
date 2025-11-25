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
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use App\Jobs\ProcessPaymentCapture;

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
            abort(404, 'Plan not specified');
        }

        $planModel = Plan::with('features')->findOrFail($plan);

        // Get all active plans for the modal
        $allPlans = Plan::with('features')->where('is_active', true)->orderBy('price', 'asc')->get();

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
            \Log::error('PayPal order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }


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
            $order = PlanOrder::where('paypal_order_id', $request->order_id)->first();

            if (!$order) {
                \Log::warning('Order not found for PayPal order ID', [
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

            // Dispatch the payment capture job to queue
            \App\Jobs\ProcessPaymentCapture::dispatch($request->order_id, Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Payment processing started. You will be redirected shortly.',
                'status' => 'processing'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed for payment capture', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('PayPal payment capture dispatch failed: ' . $e->getMessage(), [
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
        // Get transaction_id from cache instead of session (since jobs run asynchronously)
        $transactionId = \Cache::get('payment_success_' . Auth::id());

        // Clear the cache value after use
        if ($transactionId) {
            \Cache::forget('payment_success_' . Auth::id());
        }

        // Get order details for success page
        $order = null;
        if ($transactionId) {
            $order = PlanOrder::with(['plan', 'user'])
                ->where('transaction_id', $transactionId)
                ->first();
        }

        return view('web.checkout-success', compact('transactionId', 'order'));
    }

    /**
     * Show payment cancel page
     */
    public function cancel(Request $request): RedirectResponse
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}
