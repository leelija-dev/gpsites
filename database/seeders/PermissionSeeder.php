<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

// use 
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           
            // Blog
            'view blog',
            'create blog',
            'edit blog',
            'delete blog',

            // Blog Category
            'view blog category',
            'create blog category',
            'edit blog category',
            'delete blog category',

            //Orders
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
             
            //Contacts
            'view contacts',
            'create contacts',
            'edit contacts',
            'delete contacts',

            //Plans
            'view plans',
            'create plans',
            'edit plans',
            'delete plans',

            //Customers
            'view customer',
            'create customer',
            'edit customer',
            'delete customer',

            //Mail History
            'view mail history',
            'create mail history',
            'edit mail history',
            'delete mail history',
            
            //Newsletter
            'view newsletter',
            'create newsletter',
            'edit newsletter',
            'delete newsletter',

            //Promotions
            'view promotions mail',
            'create promotions mail',
            'edit promotions mail',
            'delete promotions mail',

             // Admin
            'view admin',
            'create admin',
            'edit admin',
            'delete admin',

            // Role
            'view role',
            'create role',
            'edit role',
            'delete role',

            // Permission
            'view permission',
            'create permission',
            'edit permission',
            'delete permission',

        ];
        $oldPermissions = Permission::where('guard_name', 'admin')->get();

        foreach ($oldPermissions as $permission) {

            // Remove permission from roles
            DB::table('role_has_permissions')
                ->where('permission_id', $permission->id)
                ->delete();

            // Delete permission
            $permission->delete();
        }

         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        // Create superadmin role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin',
        ]);
        // Give ALL permissions to superadmin
        $allPermissions = Permission::where(
            'guard_name',
            'admin'
        )->get();

        $superAdminRole->syncPermissions($allPermissions);

        $this->command->info(
            '✓ Permissions and superadmin role created successfully.'
        );

    }
}
