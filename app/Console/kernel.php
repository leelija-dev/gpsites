<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendPlanExpirationReminder::class,
        \App\Console\Commands\ResetAvailableMail::class, 
    ];

    protected function schedule(Schedule $schedule)
    {
        // Runs every day at 9 AM
        $schedule->command('email:expiry-reminder')->dailyAt('09:00');
        
        // Optional: for testing, run every minute
        // $schedule->command('email:expiry-reminder')->everyMinute();
        $schedule->command('mail:reset-available')
         ->dailyAt('15:20')
        ->timezone('Asia/Kolkata');
        
    // For testing, you can uncomment this line to run every minute
    //$schedule->command('mail:reset-available')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
