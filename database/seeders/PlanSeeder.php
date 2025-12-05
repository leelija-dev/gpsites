<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\PlansFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Plan::truncate();
        PlansFeature::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Define all plans — NO manual IDs!
        $plans = [
            [
                'name' => 'Trial',
                'slug' => 'trial',
                'description' => 'Experience our service for free for 7 days.',
                'price' => 0.00,
                'duration' => 7,
                'mail_available' => 2,
                'is_active' => true,
                'is_trial' => true, // Recommended: add this column
                'features' => [
                    ['feature' => '2 Mail Credits'],
                    ['feature' => '7 Days Access'],
                    ['feature' => 'Basic Support'],
                    ['feature' => 'Limited Features'],
                ]
            ],
            // Add your paid plans here later
            // [
            //     'name' => 'Basic',
            //     'slug' => 'basic',
            //     'price' => 99.00,
            //     ...
            // ],
        ];

        foreach ($plans as $planData) {
            $features = $planData['features'] ?? [];
            $isTrial = $planData['is_trial'] ?? false;
            unset($planData['features'], $planData['is_trial']);

            // Create plan (id is auto-incremented)
            $plan = Plan::create($planData);

            // Attach features
            foreach ($features as $featureData) {
                $plan->features()->create($featureData);
            }

            // Optional: Update config cache or set session if needed
            // But better: use a column like `is_trial` instead of config ID
        }

        // Optional: Refresh config cache if you really need trial_plan_id in config
        // But better to avoid this and query DB instead
        if (config('paypal.trial_plan_id') === null) {
            $trialPlan = Plan::where('slug', 'trial')->first();
            if ($trialPlan) {
                // You can store it dynamically, but better to query when needed
                // Or set once via php artisan tinker or env
                Log::info("Trial plan created with ID: {$trialPlan->id}");
                // You can update .env or config dynamically if needed
            }
        }
    }
}