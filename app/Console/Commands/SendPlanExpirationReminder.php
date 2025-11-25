<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlanOrder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendPlanExpirationReminder extends Command
{
    protected $signature = 'email:expiry-reminder';
    protected $description = 'Send reminder emails for plans expiring in 3 days';

    public function handle()
    {
        $this->info('⏳ Checking for expiring plans...');

        $threeDaysFromNow = Carbon::now()->addDays(3)->startOfDay();

        $orders = PlanOrder::with(['user', 'plan'])
            ->whereNotNull('paid_at')
            ->where('status', 'active')
            ->get();

        foreach ($orders as $order) {

            $expiryDate = Carbon::parse($order->paid_at)->addMonths($order->plan->duration);

            if ($expiryDate->isSameDay($threeDaysFromNow)) {

                Mail::send('emails.plan-expiration-reminder', [
                    'userName' => $order->user->name,
                    'planName' => $order->plan->name,
                    'expiryDate' => $expiryDate->format('F j, Y')
                ], function ($message) use ($order) {
                    $message->to($order->user->email)
                        ->subject("Reminder: Your plan expires in 3 days!");
                });

                $this->info("Mail sent → " . $order->user->email);
            }
        }

        return Command::SUCCESS;
    }
}
