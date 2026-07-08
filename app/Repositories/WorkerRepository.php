<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\WorkerServiceAssignment;
use App\Models\Service;

class WorkerRepository
{
    /**
     * Get all workers.
     */
    public function getAll()
    {
        return User::where('role', 'Worker')->get();
    }

    /**
     * Get all active workers.
     */
    public function getActive()
    {
        return User::where('role', 'Worker')->where('status', 'active')->get();
    }

    /**
     * Get active workers assigned to a specific active service (Public visibility).
     */
    public function getPublicWorkersForService($serviceId)
    {
        // Enforce visibility rules:
        // Worker.status = active AND WorkerServiceAssignment.status = active AND WorkerServiceAssignment.removed_at = null AND Service.status = active
        $assignments = WorkerServiceAssignment::where('service_id', $serviceId)
            ->where('status', 'active')
            ->whereNull('removed_at')
            ->pluck('worker_id');

        return User::where('role', 'Worker')
            ->where('status', 'active')
            ->whereIn('_id', $assignments)
            ->with('workerProfile')
            ->get();
    }

    /**
     * Get active workers for public display (assigned to at least one active service).
     */
    public function getPublicWorkers()
    {
        // Get IDs of active services
        $activeServiceIds = Service::active()->pluck('id');

        // Get worker IDs who are assigned to active services
        $activeWorkerIds = WorkerServiceAssignment::where('status', 'active')
            ->whereNull('removed_at')
            ->whereIn('service_id', $activeServiceIds)
            ->pluck('worker_id')
            ->unique();

        return User::where('role', 'Worker')
            ->where('status', 'active')
            ->whereIn('_id', $activeWorkerIds)
            ->with('workerProfile')
            ->get();
    }

    /**
     * Find a worker by ID.
     */
    public function find($id)
    {
        return User::where('role', 'Worker')->findOrFail($id);
    }

    /**
     * Find a worker profile by User ID.
     */
    public function findProfile($userId)
    {
        return WorkerProfile::where('user_id', $userId)->first();
    }

    /**
     * Update worker status.
     */
    public function updateStatus($id, $status)
    {
        $worker = $this->find($id);
        $worker->status = $status;
        $worker->save();
        return $worker;
    }

    /**
     * Get services assigned to a worker.
     */
    public function getAssignedServices($workerId)
    {
        $serviceIds = WorkerServiceAssignment::where('worker_id', $workerId)
            ->where('status', 'active')
            ->whereNull('removed_at')
            ->pluck('service_id');

        return Service::whereIn('_id', $serviceIds)->get();
    }

    /**
     * Get full assignment history for a worker.
     */
    public function getAssignmentHistory($workerId)
    {
        return WorkerServiceAssignment::where('worker_id', $workerId)
            ->with(['service', 'admin'])
            ->orderBy('assigned_at', 'desc')
            ->get();
    }
}
