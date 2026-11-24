<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('mail:forward-replies')->everyMinute()->withoutOverlapping();
// Automatic follow-ups to site owners who have not replied (see config/followups.php).
Schedule::command('mail:send-followups')->hourly()->withoutOverlapping();

// Moved from app/Console/kernel.php, which Laravel 12 no longer reads.
// Plan expiry reminder (3 days before expiry), every day at 9 AM India time.
Schedule::command('email:expiry-reminder')->dailyAt('09:00')->timezone('Asia/Kolkata')->withoutOverlapping();
// Reset daily mail credits at midnight India time.
Schedule::command('mail:reset-mail-available')->dailyAt('00:00')->timezone('Asia/Kolkata')->withoutOverlapping();
