<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Store a new booking request in the database.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $data['customer_id'] = Auth::id();

        $this->bookingService->createBooking($data);

        return redirect()->route('dashboard')
            ->with('success', __('messages.booking_success'));
    }
}
