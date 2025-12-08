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
        $this->command->info('Starting Plan Seeder...');
        
        try {
            // Disable foreign key checks for clean truncate
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->command->info('Disabled foreign key checks');

            $this->command->info('Truncating existing plans and features...');
            Plan::truncate();
            PlansFeature::truncate();
            $this->command->info('Successfully truncated plans and features');

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->command->info('Re-enabled foreign key checks');

            // Define all plans
            $plans = [
                [
                'name' => 'Trial plan',
                'slug' => 'trial',
                'description' => '',
                'price' => 0.00,
                'duration' => 7,
                'mail_available' => 2,
                'is_active' => true,
                'is_trial' => true,
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => '',
                'price' => 198,
                'duration' => 30,
                'mail_available' => 100,
                'is_active' => true,
                'is_trial' => false,
                'features' => [
                    ['feature' => '20K Active Blogs'],
                    ['feature' => 'High Authority'],
                    ['feature' => 'Custom Outreach'],
                    ['feature' => 'Genuine Contact Email'],
                    ['feature' => 'Bulk Email Campaign'],
                    ['feature' => 'Connected with 50K+ Site Owners'],
                    ['feature' => 'Constantly Partnering with Site Owners'],
                    ['feature' => 'Unlimited Team Members'],
                ]
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => '',
                'price' => 449,
                'duration' => 30,
                'mail_available' => 250,
                'is_active' => true,
                'is_trial' => false,
                'features' => [
                    ['feature' => '40K Active Blogs'],
                    ['feature' => 'High Authority'],
                    ['feature' => 'Custom Outreach'],
                    ['feature' => 'Genuine Contact Email'],
                    ['feature' => 'Bulk Email Campaign'],
                    ['feature' => 'Connected with 50K+ Site Owners'],
                    ['feature' => 'Constantly Partnering with Site Owners'],
                    ['feature' => 'Unlimited Team Members'],
                ]
            ],
            [
                'name' => 'Agency',
                'slug' => 'agency',
                'description' => '',
                'price' => 1199,
                'duration' => 30,
                'mail_available' => 1000,
                'is_active' => true,
                'is_trial' => false,
                'features' => [
                    ['feature' => 'Unlimited Active Blogs'],
                    ['feature' => 'High Authority'],
                    ['feature' => 'Custom Outreach'],
                    ['feature' => 'Show Outreach Price'],
                    ['feature' => 'Unlimited Emails Sent'],
                    ['feature' => 'Genuine Contact Email'],
                    ['feature' => 'Bulk Email Campaign'],
                    ['feature' => 'Connected with 50K+ Site Owners'],
                    ['feature' => 'Constantly Partnering with Site Owners'],
                    ['feature' => 'Negotiable Price'],
                    ['feature' => 'Live Chat'],
                    ['feature' => 'Unlimited Team Members'],
                ]
            ],
            ];

            $totalPlans = count($plans);
            $this->command->info("Creating {$totalPlans} plans...");
            $bar = $this->command->getOutput()->createProgressBar($totalPlans);

            foreach ($plans as $index => $planData) {
                $planNumber = $index + 1;
                $this->command->info("\nProcessing plan {$planNumber}/{$totalPlans}: {$planData['name']}");

                try {
                    $features = $planData['features'] ?? [];
                    $isTrial = $planData['is_trial'] ?? false;
                    unset($planData['features'], $planData['is_trial']);

                    // Create plan
                    $plan = Plan::create($planData);
                    $this->command->info("✓ Created plan: {$plan->name}");

                    // Attach features
                    if (!empty($features)) {
                        $plan->features()->createMany($features);
                        $this->command->info("✓ Added " . count($features) . " features to {$plan->name}");
                    }

                    $bar->advance();
                } catch (\Exception $e) {
                    $this->command->error("✗ Failed to create plan {$planData['name']}: " . $e->getMessage());
                    Log::error("Failed to create plan", [
                        'plan' => $planData['name'],
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $bar->finish();
            $this->command->newLine(2);

            // Log trial plan ID
            $trialPlan = Plan::where('slug', 'trial')->first();
            if ($trialPlan) {
                $this->command->info("✓ Trial plan ID: {$trialPlan->id}");
                Log::info("Trial plan created with ID: {$trialPlan->id}");
            } else {
                $this->command->warn("No trial plan found after seeding");
            }

            $this->command->info('✓ Plan seeding completed successfully!');

        } catch (\Exception $e) {
            $this->command->error('✗ Error in PlanSeeder: ' . $e->getMessage());
            Log::error('PlanSeeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to fail the seeder
        }
    }
}