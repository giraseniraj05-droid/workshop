<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository
{
    /**
     * Get reviews/feedback for a specific service.
     */
    public function getForService($serviceId)
    {
        return Feedback::with('customer')
            ->where('service_id', $serviceId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get reviews/feedback for a specific worker.
     */
    public function getForWorker($workerId)
    {
        return Feedback::with(['customer', 'service'])
            ->where('worker_id', $workerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get all feedback.
     */
    public function getAll(array $filters = [])
    {
        $query = Feedback::with(['customer', 'worker', 'service']);

        if (!empty($filters['rating'])) {
            $query->where('rating', (int) $filters['rating']);
        }

        if (!empty($filters['worker_id'])) {
            $query->where('worker_id', $filters['worker_id']);
        }

        if (!empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
