<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;

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
            ->where('status', 'completed')
            ->get();

        foreach ($orders as $order) {
            
            $expiryDate = Carbon::parse($order->paid_at)->addDays($order->plan->duration);
            try{
            if ($expiryDate->isSameDay($threeDaysFromNow)) {

                
                $expire_date = $expiryDate->format('F j, Y g:i A');
                $admin_mail=config('mail.admin_email');
                $app_name=config('app.name');
                $body=$this->expireMail($order->id,$order->user->name,$order->user->email,$order->plan->name,$expire_date,$admin_mail,$app_name);
                 Mail::html($body, function ($message) use ($order) {
                 $message->to($order->user->email)
                 ->subject("Reminder: Your plan expires in 3 days!");
});

                    Log::info('Plan Expiry Reminder Mail Sent successfully', [
                    'user_id' => $order->user_id,
                    'email'   => $order->user->email,
                    'plan_id' => $order->plan_id,
                    'expiry'  => $expiryDate->toDateString(),
                ]);


                $this->info("Mail sent → " . $order->user->email);
            }
            } catch (\Exception $e) {
                Log::error('Plan Expiry Reminder Mail Failed', [
            'user_id'  => $order->user_id,
            'email'    => $order->user->email,
            'plan_id'  => $order->plan_id,
            'expiry'   => $expiryDate ?? null,
            'error'    => $e->getMessage(),
        ]);
            }
        }

        return Command::SUCCESS;
    }
    public function expireMail($id,$name,$email,$plan,$expire_date,$admin_mail,$app_name){
        $order=route('view-my-order', encrypt(['id' => $id]));
        $body='<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#eef2f7;">
    <tr>
        <td align="center" style="padding:20px 10px;">

            <!-- Main Container -->
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:620px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,0.12);">

                <!-- Header -->
                <tr>
                    <td align="center" style="background:linear-gradient(135deg,#f59e0b,#f97316); padding:40px 20px;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:#ffffff; margin-bottom:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 0v3.75m0-3.75h.008m9.75 2.25a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h1 style="color:#ffffff; margin:0; font-size:26px; font-weight:bold; line-height:1.3;">Your Plan Expires Soon!</h1>
                        <p style="color:#fff7ed; margin:12px 0 0; font-size:16px;">Renew now to keep sending emails without interruption</p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:32px 24px; color:#1f2937; line-height:1.7;">

                        <p style="margin:0 0 16px; font-size:17px;">Hello <strong style="color:#f59e0b;">'.$name.'</strong>,</p>

                        <p style="margin:0 0 24px; font-size:15px; color:#374151;">
                            This is a friendly reminder that your current plan is expiring soon. To avoid any disruption in your email campaigns, please renew before the expiry date.
                        </p>

                        <!-- Info Card -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9fafb; border-radius:12px; border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:20px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Username</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 16px; font-size:15px; color:#111827;">'.$name.'</td>
                                        </tr>

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Current Plan</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 16px; font-size:15px; color:#111827;">'.$plan.'</td>
                                        </tr>

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Expiry Date</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0; font-size:15px; color:#dc2626; font-weight:bold;">'.$expire_date.'</td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>

                        <div style="margin:32px 0; padding:20px; background:#fff7ed; border-left:5px solid #f97316; border-radius:8px;">
                            <p style="margin:0; font-size:15px; color:#9a3412;">
                                After <strong>'.$expire_date.'</strong>, your account will be downgraded to the plan  and scheduled campaigns will be paused.
                            </p>
                            
                        </div>
                        <div align="center" style="margin:32px 0;">
                        <a href='.$order.' target="_blank" style="color:#f59e0b; font-size:14px; text-decoration:underline;">
                                View Plan Details →
                        </a>
                        </div>                        

                        <p align="center" style="margin:32px 0 0; font-size:13px; color:#6b7280;">
                            Need help choosing a plan? Contact us at <a href="'.$admin_mail.'" style="color:#f59e0b;">'.$admin_mail.'</a>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="background:#1e293b; padding:24px; color:#94a3b8; font-size:13px;">
                        © 2025 <strong style="color:#ffffff;">'.$app_name.'</strong>. All rights reserved.<br>
                        This is an automated reminder • No reply needed
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>';

        return $body;
    }
}
