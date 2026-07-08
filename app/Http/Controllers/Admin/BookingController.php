<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\WorkerRepository;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingRepository;
    protected $bookingService;
    protected $serviceRepository;
    protected $workerRepository;

    public function __construct(
        BookingRepository $bookingRepository,
        BookingService $bookingService,
        ServiceRepository $serviceRepository,
        WorkerRepository $workerRepository
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->bookingService = $bookingService;
        $this->serviceRepository = $serviceRepository;
        $this->workerRepository = $workerRepository;
    }

    /**
     * Display listing of all bookings with filters.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'service_id', 'start_date', 'end_date']);
        
        $bookings = $this->bookingRepository->getAll($filters);
        $services = $this->serviceRepository->getAll();

        return view('admin.bookings.index', compact('bookings', 'services'));
    }

    /**
     * Show booking details, allowing status changes and worker assignment.
     */
    public function show($id)
    {
        $booking = $this->bookingRepository->find($id);
        
        // Fetch only active workers assigned to the specific service of this booking
        $workers = $this->workerRepository->getPublicWorkersForService($booking->service_id);

        return view('admin.bookings.show', compact('booking', 'workers'));
    }

    /**
     * Update booking details (status, worker assignment).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected,completed,cancelled'],
            'worker_id' => ['nullable', 'string'],
        ]);

        // 1. Assign worker if updated
        if ($request->filled('worker_id')) {
            $this->bookingService->assignWorker($id, $request->worker_id);
        }

        // 2. Update status
        $this->bookingService->updateStatus($id, $request->status);

        return redirect()->route('admin.bookings.show', $id)
            ->with('success', __('messages.booking_update_success'));
    }
}
