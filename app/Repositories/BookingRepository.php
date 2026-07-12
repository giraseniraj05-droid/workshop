<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    /**
     * Get all bookings with filtering.
     */
    public function getAll(array $filters = [])
    {
        $query = Booking::with(['customer', 'worker', 'service', 'feedback']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('booking_date', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Find booking by ID.
     */
    public function find($id)
    {
        return Booking::with(['customer', 'worker', 'service', 'feedback'])->findOrFail($id);
    }

    /**
     * Get bookings for a specific customer.
     */
    public function getForCustomer($customerId)
    {
        return Booking::where('customer_id', $customerId)
            ->with(['worker', 'service', 'feedback'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get bookings for a specific worker.
     */
    public function getForWorker($workerId)
    {
        return Booking::where('worker_id', $workerId)
            ->with(['customer', 'service', 'feedback'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get pending bookings count.
     */
    public function getPendingCount()
    {
        return Booking::where('status', 'pending')->count();
    }
}
