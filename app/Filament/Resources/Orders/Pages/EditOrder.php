<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\MailAvailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            
        ];
    }
   protected function mutateFormDataBeforeFill(array $data): array
{
    // Load the mail_available relationship if it exists
    $order = $this->record->load('mailAvailable');
    
    if ($order->mailAvailable) {
        $data['mail_available'] = [
            'total_mail' => $order->mailAvailable->total_mail,
            'available_mail' => $order->mailAvailable->available_mail
        ];
    }
    
    return $data;
}

protected function afterSave(): void
{
    $order = $this->record;
    
    // Update or create mail_available record
    MailAvailable::updateOrCreate(
        ['order_id' => $order->id],
        [
            'user_id' => $order->user_id, // Make sure to set user_id
            'total_mail' => $this->data['mail_available']['total_mail'],
            'available_mail' => $this->data['mail_available']['available_mail'],
        ]
    );
    if ($this->data['send_mail'] ?? false) {

            // Get user from users table (orders.user_id → users.id)
            $user = $order->user;
            $userMail=$user->email;
            $name=$user->name;
            $plan_name=$order->plan->name;
            $new_expiry_date=$order->expire_at->format('d-m-Y H:i:s');
            $order_id=$order->id;
            $app_name=config('app.name');
            $subject='Your requested plan expire date extended';
            $plan_details=route('view-my-order',encrypt($order->id));
            $body='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Expiry Date Update</title>
    <style>
        /* Inline styles for email compatibility */
        @media only screen and (max-width: 600px) {
            .mobile-full {
                width: 100% !important;
            }
            .mobile-padding {
                padding: 20px 15px !important;
            }
            .mobile-text-center {
                text-align: center !important;
            }
            .mobile-heading {
                font-size: 22px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5; color: #333333;">
    <!-- Main wrapper table -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f5f5f5; padding: 30px 0;">
        <tr>
            <td align="center">
                <!-- Main content table -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" class="mobile-full" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    
                    <!-- Header with logo/brand -->
                    <tr>
                        <td align="center" style="padding: 30px 0; background-color: #2c3e50;">
                            <table cellpadding="2" cellspacing="2" border="0">
                            
                                <tr>
                                    <td style="font-size: 20px; font-weight: bold; color: #ffffff;">Your Account Expiry Date Has Been Updated</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Hero section -->
                    <tr>
                        <td class="mobile-padding" style="padding: 40px 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                
                                <tr>
                                 <p style="font-size:17px; margin:0 0 14px;">
                                    Hello <strong style="color:#4f46e5;">'.$name.'</strong>,
                                </p>
                                </tr>

                                 
                                <tr>
                                    <td align="center" class="mobile-text-center">
                                       
                                        <p style="font-size: 16px; line-height: 1.6; color: #555555; margin: 0;">We have updated your account expiry date as requested. Please see the details below.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Updated information section -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px 20px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9f9f9; border-radius: 8px; border: 1px solid #eeeeee;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 20px;">
                                                    <h2 style="font-size: 20px; font-weight: bold; color: #2c3e50; margin: 0;">Updated Account Details</h2>
                                                </td>
                                            </tr>
                                            
                                            <!-- User details -->
                                            <tr>
                                                <td>
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                       <tr>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #555555;">Order ID:</strong>
                                                            </td>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <span style="color: #2c3e50;">#'.$order_id.'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #555555;">User Name:</strong>
                                                            </td>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <span style="color: #2c3e50;">'.$name.'</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #555555;">Plan:</strong>
                                                            </td>
                                                            <td width="50%" style="padding: 12px 0; border-bottom: 1px solid #eeeeee;">
                                                                <span style="color: #2c3e50;">'.$plan_name.'</span>
                                                            </td>
                                                        </tr>
                                                         
                                                        <tr>
                                                            <td width="50%" style="padding: 12px 0;">
                                                                <strong style="color: #555555; font-size: 16px;">New Expiry Date:</strong>
                                                            </td>
                                                            <td width="50%" style="padding: 12px 0;">
                                                                <span style="color: #27ae60; font-size: 16px; font-weight: bold;">'.$new_expiry_date.'</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Important notice -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fff8e1; border-left: 4px solid #ffc107; border-radius: 4px;">
                                <tr>
                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Action buttons -->
                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px 40px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href='.$plan_details.' target="_blank" style="background:#f59e0b; color:#ffffff; font-weight:bold; font-size:16px; text-decoration:none; padding:16px 40px; border-radius:10px; display:inline-block; margin:0 8px;">
                                             View Plan Details
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f8f9fa; border-top: 1px solid #eeeeee;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" class="mobile-text-center" style="padding-bottom: 20px;">
                                        <p style="font-size: 14px; line-height: 1.5; color: #777777; margin: 0;">
                                            This is an automated notification regarding your account status. Please do not reply to this email.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" class="mobile-text-center">
                                        <p style="font-size: 14px; color: #777777; margin: 0 0 10px 0;">
                                            &copy; 2023 '.$app_name.'. All rights reserved.
                                        </p>
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
            if ($user && $user->email) {
                Mail::html($body, function ($message) use ($userMail, $subject) {
                            $message->to($userMail)
                                ->subject($subject);
                        });
                Log::info('update expire date  mail sent successfully to ' . $userMail);
            }
        }
}

}
