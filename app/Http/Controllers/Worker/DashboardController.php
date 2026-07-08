<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\WorkerRepository;
use App\Repositories\BookingRepository;

class DashboardController extends Controller
{
    protected $workerRepository;
    protected $bookingRepository;

    public function __construct(
        WorkerRepository $workerRepository,
        BookingRepository $bookingRepository
    ) {
        $this->workerRepository = $workerRepository;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Display the worker dashboard home view.
     */
    public function index()
    {
        $workerId = Auth::id();
        
        $assignedServices = $this->workerRepository->getAssignedServices($workerId);
        $bookings = $this->bookingRepository->getForWorker($workerId);

        return view('worker.dashboard', compact('assignedServices', 'bookings'));
    }
}
