<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Webrek\MongoPermission\Models\Role;
use Webrek\MongoPermission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'manage_services',
            'manage_workers',
            'manage_bookings',
            'manage_enquiries',
            'manage_admins',
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Create Roles and Assign Permissions
        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo($permissions);

        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'manage_services',
            'manage_workers',
            'manage_bookings',
            'manage_enquiries',
        ]);

        $worker = Role::create(['name' => 'Worker', 'guard_name' => 'web']);
        $customer = Role::create(['name' => 'Customer', 'guard_name' => 'web']);
    }
}
