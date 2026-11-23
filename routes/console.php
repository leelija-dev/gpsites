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
