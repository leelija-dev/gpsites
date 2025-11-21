<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanOrder;
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

        return view('web.checkout', compact('planModel'));
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

            $transactionId = $response->result->purchase_units[0]->payments->captures[0]->id;

            // Find and update the order in database
            $order = PlanOrder::where('paypal_order_id', $request->order_id)->first();
            
            if ($order) {
                $order->update([
                    'transaction_id' => $transactionId,
                    'status' => 'completed',
                    'payment_details' => $response->result,
                    'paid_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'transaction_id' => $transactionId,
                'status' => $response->result->status
            ]);
        } catch (\Exception $e) {
            \Log::error('PayPal payment capture failed: ' . $e->getMessage());
            
            // Update order status to failed
            $order = PlanOrder::where('paypal_order_id', $request->order_id)->first();
            if ($order) {
                $order->update(['status' => 'failed']);
            }

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