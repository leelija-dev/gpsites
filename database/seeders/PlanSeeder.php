<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\PlansFeature;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate existing data
        Plan::truncate();
        PlansFeature::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $trialPlanId = config('paypal.trial_plan_id', 14);

        $plans = [
            [
                'id' => $trialPlanId, // Use config value for trial plan ID
                'name' => 'Trial Plan',
                'slug' => 'trial-plan',
                'description' => 'Experience our service for free for 7 days.',
                'price' => 0.00,
                'currency' => 'USD',
                'duration' => 7,
                'mail_available' => 2,
                'is_active' => true,
                'features' => [
                    ['feature' => '2 Mail Credits'],
                    ['feature' => '7 Days Access'],
                    ['feature' => 'Basic Support'],
                ]
            ],
        ];

        foreach ($plans as $planData) {
            $features = $planData['features'];
            unset($planData['features']);

            $plan = Plan::create($planData);

            foreach ($features as $featureData) {
                $plan->features()->create($featureData);
            }
        }
    }
}
