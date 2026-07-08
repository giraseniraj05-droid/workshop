<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate all collections to start fresh
        \App\Models\User::truncate();
        \App\Models\Service::truncate();
        \App\Models\WorkerProfile::truncate();
        \App\Models\WorkerServiceAssignment::truncate();
        \App\Models\Booking::truncate();
        \App\Models\Enquiry::truncate();
        \Webrek\MongoPermission\Models\Role::truncate();
        \Webrek\MongoPermission\Models\Permission::truncate();

        $this->call([
            RoleAndPermissionSeeder::class,
            ServiceSeeder::class,
            UserSeeder::class,
            WorkerProfileSeeder::class,
            WorkerServiceAssignmentSeeder::class,
            BookingSeeder::class,
            EnquirySeeder::class,
        ]);
    }
}
