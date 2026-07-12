<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\WorkerRepository;
use App\Repositories\FeedbackRepository;

class ServiceController extends Controller
{
    protected $serviceRepository;
    protected $workerRepository;
    protected $feedbackRepository;

    public function __construct(
        ServiceRepository $serviceRepository,
        WorkerRepository $workerRepository,
        FeedbackRepository $feedbackRepository
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->workerRepository = $workerRepository;
        $this->feedbackRepository = $feedbackRepository;
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

        // Fetch feedback / reviews for the service
        $reviews = $this->feedbackRepository->getForService($service->id);
        $averageRating = $reviews->avg('rating') ?: 0;
        $reviewsCount = $reviews->count();

        return view('services.show', compact('service', 'workers', 'reviews', 'averageRating', 'reviewsCount'));
    }
}
