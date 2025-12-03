<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\AppServiceProvider;

class ClearTrialPlanCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trial:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cached trial plan ID and refresh from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing trial plan cache...');
        AppServiceProvider::clearTrialPlanCache();
        $this->info('Trial plan cache cleared and refreshed from database.');
        $this->info('New trial_plan_id: ' . config('paypal.trial_plan_id'));
    }
}
