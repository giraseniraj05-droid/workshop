<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\WorkerServiceAssignment;
use Carbon\Carbon;

class WorkerServiceAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = User::where('role', 'Worker')->get();
        $services = Service::all();
        $admin = User::where('role', 'Admin')->first();

        foreach ($workers as $index => $worker) {
            // Assign every worker to their primary service based on modular index
            $primaryServiceIndex = $index % count($services);
            $service = $services[$primaryServiceIndex];

            WorkerServiceAssignment::create([
                'worker_id' => $worker->id,
                'service_id' => $service->id,
                'assigned_by' => $admin->id,
                'assigned_at' => Carbon::now()->subMonths(2),
                'removed_at' => null,
                'status' => 'active',
            ]);

            // Assign some workers (e.g. even indices) to a secondary service
            if ($index % 2 === 0) {
                $secondaryServiceIndex = ($primaryServiceIndex + 1) % count($services);
                $secondaryService = $services[$secondaryServiceIndex];

                WorkerServiceAssignment::create([
                    'worker_id' => $worker->id,
                    'service_id' => $secondaryService->id,
                    'assigned_by' => $admin->id,
                    'assigned_at' => Carbon::now()->subMonths(1),
                    'removed_at' => null,
                    'status' => 'active',
                ]);
            }

            // Create some past inactive history assignments (removed assignments) for demonstration
            if ($index % 3 === 0) {
                $historyServiceIndex = ($primaryServiceIndex + 2) % count($services);
                $historyService = $services[$historyServiceIndex];

                WorkerServiceAssignment::create([
                    'worker_id' => $worker->id,
                    'service_id' => $historyService->id,
                    'assigned_by' => $admin->id,
                    'assigned_at' => Carbon::now()->subMonths(4),
                    'removed_at' => Carbon::now()->subMonths(3),
                    'status' => 'inactive',
                ]);
            }
        }
    }
}
