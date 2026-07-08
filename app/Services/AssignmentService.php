<?php

namespace App\Services;

use App\Models\WorkerServiceAssignment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssignmentService
{
    /**
     * Assign a worker to a service.
     */
    public function assignWorker($workerId, $serviceId)
    {
        // Check if an active assignment already exists
        $exists = WorkerServiceAssignment::where('worker_id', $workerId)
            ->where('service_id', $serviceId)
            ->where('status', 'active')
            ->whereNull('removed_at')
            ->exists();

        if ($exists) {
            return null; // Already assigned
        }

        // Create new assignment record
        return WorkerServiceAssignment::create([
            'worker_id' => $workerId,
            'service_id' => $serviceId,
            'assigned_by' => Auth::id(),
            'assigned_at' => Carbon::now(),
            'removed_at' => null,
            'status' => 'active',
        ]);
    }

    /**
     * Remove a worker from a service.
     */
    public function removeWorker($workerId, $serviceId)
    {
        // Find active assignment
        $assignment = WorkerServiceAssignment::where('worker_id', $workerId)
            ->where('service_id', $serviceId)
            ->where('status', 'active')
            ->whereNull('removed_at')
            ->first();

        if (!$assignment) {
            return false;
        }

        // Mark it as inactive and record removed_at timestamp
        $assignment->update([
            'status' => 'inactive',
            'removed_at' => Carbon::now(),
        ]);

        return true;
    }
}
