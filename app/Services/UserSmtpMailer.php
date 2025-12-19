<?php

namespace App\Services;

use App\Models\UserMailSetting;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;
class UserSmtpMailer
{
    public static function send($userId, $to, $mailable)
{
    $smtp = UserMailSetting::where('user_id', $userId)
        ->where('is_primary', true)
        ->firstOrFail();
   
    // Override SMTP settings dynamically
    config(['mail.mailers.smtp' => [
        'transport' => 'smtp',
        'host' => $smtp->smtp_host,
        'port' => $smtp->smtp_port ?? 587,
        'encryption' => $smtp->smtp_encryption ?? 'ssl',
        'username' => $smtp->email,
        'password' => decrypt($smtp->password),
        'timeout' => null,
        'auth_mode' => null,
    ]]);

    // Send using  Mail
    Mail::mailer('smtp')->to($to)->send($mailable
    ->from(new Address($smtp->email, $smtp->name))
    // ->replyTo($smtp->email)
    
    );
}
}
