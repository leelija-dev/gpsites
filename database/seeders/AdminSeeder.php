<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Admin Seeder...');
        
        try {
            $adminData = [
                'name' => 'Site Admin',
                'email' => 'admin@leelija.com',
                'password' => 'admin123',
                'status' => true
            ];

            $this->command->info('Creating admin user...');
            
            $admin = Admin::firstOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );

            if ($admin->wasRecentlyCreated) {
                $this->command->info('✓ Admin user created successfully!');
                $this->command->line('  Email: ' . $admin->email);
                $this->command->line('  Password: admin123');
                $this->command->warn('  Please change the password after first login!');
                
                Log::info('Admin user created', ['admin_id' => $admin->id, 'email' => $admin->email]);
            } else {
                $this->command->info('✓ Admin user already exists');
                $this->command->line('  Email: ' . $admin->email);
            }

            $this->command->info('Admin seeding completed successfully!');

        } catch (\Exception $e) {
            $this->command->error('✗ Error in AdminSeeder: ' . $e->getMessage());
            Log::error('AdminSeeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to fail the seeder
        }
    }
}