<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
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
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        // PayPal order creation logic here
        return response()->json([
            'success' => true,
            'order_id' => 'PAYPAL_ORDER_' . time() . '_' . $plan->id,
            'plan' => $plan
        ]);
    }

    /**
     * Capture PayPal payment
     */
    public function capturePayment(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        // PayPal SDK integration would go here
        // For now, we'll simulate the capture
        
        // In a real implementation, you would:
        // 1. Use PayPal SDK to capture the payment
        // 2. Save order details to database
        // 3. Send confirmation email
        // 4. Return success/failure response

        // Simulate successful payment
        return response()->json([
            'success' => true,
            'transaction_id' => 'TXN_' . time(),
            'status' => 'COMPLETED'
        ]);
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
        // Redirect back to checkout or show error message
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}
