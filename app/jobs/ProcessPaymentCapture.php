<?php

namespace App\Jobs;

use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\MailAvailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class ProcessPaymentCapture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $paypalOrderId;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($paypalOrderId, $userId)
    {
        $this->paypalOrderId = $paypalOrderId;
        $this->userId = $userId;
        
        \Log::info('ProcessPaymentCapture job created', [
            'paypal_order_id' => $paypalOrderId,
            'user_id' => $userId
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('ProcessPaymentCapture job started', [
            'paypal_order_id' => $this->paypalOrderId,
            'user_id' => $this->userId
        ]);

        try {
            $client = $this->getPayPalClient();
            $captureRequest = new OrdersCaptureRequest($this->paypalOrderId);
            $response = $client->execute($captureRequest);

            \Log::info('PayPal capture response', [
                'paypal_order_id' => $this->paypalOrderId,
                'response_status' => $response->statusCode,
                'result' => $response->result
            ]);

            $transactionId = $response->result->purchase_units[0]->payments->captures[0]->id;

            \Log::info('Transaction ID extracted', [
                'paypal_order_id' => $this->paypalOrderId,
                'transaction_id' => $transactionId
            ]);

            // Find and update the order
            $order = PlanOrder::where('paypal_order_id', $this->paypalOrderId)->first();
            
            \Log::info('Order found', [
                'paypal_order_id' => $this->paypalOrderId,
                'order_id' => $order ? $order->id : null
            ]);
            
            if ($order) {
                $updateData = [
                    'transaction_id' => $transactionId,
                    'status' => 'completed',
                    'payment_details' => $response->result,
                    'paid_at' => now(),
                ];

                $order->update($updateData);

                \Log::info('Order updated successfully', [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId
                ]);

                // Create mail credits
                $plan = Plan::findOrFail($order->plan_id);
                MailAvailable::create([
                    'user_id' => $this->userId,
                    'order_id' => $order->id,
                    'total_mail' => $plan->mail_available,
                    'available_mail' => $plan->mail_available,
                    'created_at' => now(),
                ]);

                \Log::info('Mail credits created', [
                    'user_id' => $this->userId,
                    'order_id' => $order->id,
                    'mail_available' => $plan->mail_available
                ]);

                // Store transaction_id in a cache/database for success page
                // Since session doesn't work in queue context, use cache instead
                \Cache::put('payment_success_' . $this->userId, $transactionId, now()->addMinutes(30));
            } else {
                \Log::error('Order not found for PayPal order ID', [
                    'paypal_order_id' => $this->paypalOrderId
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Queue job ProcessPaymentCapture failed', [
                'paypal_order_id' => $this->paypalOrderId,
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Update order status to failed
            $order = PlanOrder::where('paypal_order_id', $this->paypalOrderId)->first();
            if ($order) {
                $order->update(['status' => 'failed']);
                \Log::info('Order marked as failed', ['order_id' => $order->id]);
            }
            
            throw $e;
        }
    }

    private function getPayPalClient(): PayPalHttpClient
    {
        $environment = config('paypal.mode') === 'live' 
            ? new ProductionEnvironment(config('paypal.client_id'), config('paypal.client_secret'))
            : new SandboxEnvironment(config('paypal.client_id'), config('paypal.client_secret'));

        return new PayPalHttpClient($environment);
    }
}