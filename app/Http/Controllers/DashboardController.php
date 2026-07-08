<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BookingRepository;

class DashboardController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Handle the dashboard routing.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (in_array($user->role, ['Super Admin', 'Admin'])) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'Worker') {
            return redirect()->route('worker.dashboard');
        }

        // Default: Customer Dashboard
        $bookings = $this->bookingRepository->getForCustomer($user->id);

        return view('dashboard', compact('bookings'));
    }
}
