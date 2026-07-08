<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository
{
    /**
     * Get all active services.
     */
    public function getActive()
    {
        return Service::active()->get();
    }

    /**
     * Get all services (active and inactive) for admin panel.
     */
    public function getAll()
    {
        return Service::all();
    }

    /**
     * Find service by ID.
     */
    public function find($id)
    {
        return Service::findOrFail($id);
    }

    /**
     * Find active service by slug.
     */
    public function findActiveBySlug($slug)
    {
        return Service::active()->where('slug', $slug)->first();
    }

    /**
     * Create a new service.
     */
    public function create(array $data)
    {
        return Service::create($data);
    }

    /**
     * Update an existing service.
     */
    public function update($id, array $data)
    {
        $service = $this->find($id);
        $service->update($data);
        return $service;
    }

    /**
     * Delete a service.
     */
    public function delete($id)
    {
        $service = $this->find($id);
        return $service->delete();
    }
}
