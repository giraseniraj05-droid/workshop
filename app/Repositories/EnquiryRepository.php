<?php

namespace App\Repositories;

use App\Models\Enquiry;

class EnquiryRepository
{
    /**
     * Get all enquiries.
     */
    public function getAll(array $filters = [])
    {
        $query = Enquiry::with('service');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Find enquiry by ID.
     */
    public function find($id)
    {
        return Enquiry::with('service')->findOrFail($id);
    }

    /**
     * Get open enquiries count.
     */
    public function getOpenCount()
    {
        return Enquiry::where('status', 'open')->count();
    }
}
