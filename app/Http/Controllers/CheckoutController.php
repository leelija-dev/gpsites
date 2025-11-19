<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

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
    public function show(Request $request): View
    {
        $planId = $request->query('plan');
        
        if (!$planId) {
            abort(404, 'Plan not found');
        }

        $plan = Plan::with('features')
            ->where('id', $planId)
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            abort(404, 'Plan not found');
        }

        return view('web.checkout', compact('plan'));
    }

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

            $plan = Plan::findOrFail($request->plan_id);
            $client = $this->getPayPalClient();
            
            $orderRequest = new OrdersCreateRequest();
            $orderRequest->prefer('return=representation');
            $orderRequest->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $plan->id,
                    "amount" => [
                        "value" => number_format($plan->price, 2, '.', ''),
                        "currency_code" => "USD"
                    ],
                    "description" => "Package: " . $plan->name
                ]],
                "application_context" => [
                    "cancel_url" => route('checkout.cancel'),
                    "return_url" => route('checkout.success')
                ]
            ];

            $response = $client->execute($orderRequest);
            
            return response()->json([
                'success' => true,
                'order_id' => $response->result->id,
                'status' => $response->result->status
            ]);
            
        } catch (\Exception $e) {
            \Log::error('PayPal order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create PayPal order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Capture PayPal payment
     */
    public function capturePayment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'order_id' => 'required|string',
            ]);

            $client = $this->getPayPalClient();
            $captureRequest = new OrdersCaptureRequest($request->order_id);
            
            $response = $client->execute($captureRequest);
            
            return response()->json([
                'success' => true,
                'transaction_id' => $response->result->purchase_units[0]->payments->captures[0]->id,
                'status' => $response->result->status
            ]);
            
        } catch (\Exception $e) {
            \Log::error('PayPal payment capture failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment capture failed: ' . $e->getMessage()
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

    /**
     * Show payment success page
     */
    public function success(Request $request): View
    {
        $transactionId = $request->query('transaction_id');
        
        return view('web.checkout-success', compact('transactionId'));
    }

    /**
     * Show payment cancel page
     */
    public function cancel(Request $request): RedirectResponse
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}