<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admins
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'name' => "Super Admin {$i}",
                'email' => "superadmin{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'status' => 'active',
            ]);
            $user->assignRole('Super Admin');
        }

        // 2. Admins
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Admin User {$i}",
                'email' => "admin{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'status' => 'active',
            ]);
            $user->assignRole('Admin');
        }

        // 3. Workers
        $firstNames = ['John', 'Robert', 'Michael', 'David', 'James', 'William', 'Charles', 'Joseph', 'Thomas', 'Daniel', 'Paul', 'Mark', 'Donald', 'George', 'Kenneth', 'Steven', 'Edward', 'Brian', 'Ronald', 'Anthony'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson', 'Martinez', 'Anderson', 'Taylor', 'Thomas', 'Hernandez', 'Moore', 'Martin', 'Jackson', 'Thompson', 'White'];
        
        for ($i = 1; $i <= 20; $i++) {
            $name = $firstNames[$i - 1] . ' ' . $lastNames[$i - 1];
            $user = User::create([
                'name' => $name,
                'email' => "worker{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'Worker',
                'status' => 'active', // default active
            ]);
            $user->assignRole('Worker');
        }

        // 4. Customers
        $customerFirstNames = ['Mary', 'Patricia', 'Jennifer', 'Elizabeth', 'Linda', 'Barbara', 'Susan', 'Jessica', 'Sarah', 'Karen', 'Nancy', 'Lisa', 'Betty', 'Margaret', 'Sandra', 'Ashley', 'Kimberly', 'Emily', 'Donna', 'Michelle', 'Carol', 'Amanda', 'Dorothy', 'Melissa', 'Deborah', 'Stephanie', 'Rebecca', 'Sharon', 'Laura', 'Cynthia'];
        
        for ($i = 1; $i <= 30; $i++) {
            $name = $customerFirstNames[$i - 1] . ' ' . $lastNames[($i - 1) % count($lastNames)];
            $user = User::create([
                'name' => $name,
                'email' => "customer{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'Customer',
                'status' => 'active',
            ]);
            $user->assignRole('Customer');
        }
    }
}
