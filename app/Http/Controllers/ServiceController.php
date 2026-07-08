<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\WorkerRepository;

class ServiceController extends Controller
{
    protected $serviceRepository;
    protected $workerRepository;

    public function __construct(
        ServiceRepository $serviceRepository,
        WorkerRepository $workerRepository
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->workerRepository = $workerRepository;
    }

    /**
     * Display service details and assigned active workers.
     */
    public function show($slug)
    {
        $service = $this->serviceRepository->findActiveBySlug($slug);

        if (!$service) {
            abort(404, 'Service not found or is currently inactive.');
        }

        // Get only active workers assigned to this active service
        $workers = $this->workerRepository->getPublicWorkersForService($service->id);

        return view('services.show', compact('service', 'workers'));
    }
}
