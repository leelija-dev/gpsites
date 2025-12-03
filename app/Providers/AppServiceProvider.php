<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Plan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dynamically set trial_plan_id from database
        $this->setDynamicTrialPlanId();
    }

    /**
     * Set the trial plan ID dynamically from the database
     */
    private function setDynamicTrialPlanId(): void
    {
        try {
            $trialPlanId = Cache::rememberForever('trial_plan_id', function () {
                $trialPlan = Plan::where('price', '<=', 1)->first();
                return $trialPlan ? $trialPlan->id : config('paypal.trial_plan_id', 14);
            });

            // Override the config value
            config(['paypal.trial_plan_id' => $trialPlanId]);
        } catch (\Exception $e) {
            // If database is not available, use the default
            // This can happen during installation or migration
        }
    }

    /**
     * Clear the trial plan ID cache (useful after plan updates)
     */
    public static function clearTrialPlanCache(): void
    {
        Cache::forget('trial_plan_id');
        // Re-set the config value
        try {
            $trialPlanId = Cache::rememberForever('trial_plan_id', function () {
                $trialPlan = \App\Models\Plan::where('price', '<=', 1)->first();
                return $trialPlan ? $trialPlan->id : config('paypal.trial_plan_id', 14);
            });
            config(['paypal.trial_plan_id' => $trialPlanId]);
        } catch (\Exception $e) {
            // Keep current value if database not available
        }
    }
}
