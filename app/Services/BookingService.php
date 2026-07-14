<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\NewBookingSubmittedNotification;
use App\Notifications\BookingStatusChangedNotification;
use App\Notifications\WorkerAssignedToBookingNotification;
use Illuminate\Support\Facades\Notification;

class BookingService
{
    /**
     * Submit a new booking.
     */
    public function createBooking(array $data)
    {
        $booking = Booking::create([
            'customer_id' => $data['customer_id'],
            'service_id' => $data['service_id'],
            'worker_id' => $data['worker_id'] ?? null,
            'booking_date' => $data['booking_date'],
            'preferred_time' => $data['preferred_time'],
            'address' => $data['address'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        // Load relations for notifications
        $booking->load(['customer', 'service']);

        // Send notification to admins
        $admins = User::whereIn('role', ['Admin', 'Super Admin'])->where('status', 'active')->get();
        foreach ($admins as $admin) {
            try {
                $admin->notify(new NewBookingSubmittedNotification($booking));
            } catch (\Throwable $e) {
                logger()->error('Failed to send booking notification to admin ' . $admin->email . ': ' . $e->getMessage());
            }
        }

        // If customer chose a worker during booking, notify worker immediately
        if ($booking->worker_id) {
            $booking->load('worker');
            try {
                $booking->worker->notify(new WorkerAssignedToBookingNotification($booking));
            } catch (\Throwable $e) {
                logger()->error('Failed to send worker assignment notification: ' . $e->getMessage());
            }
        }

        return $booking;
    }

    /**
     * Update booking status.
     */
    public function updateStatus($bookingId, $status)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = $status;
        $booking->save();

        $booking->load(['customer', 'service', 'worker']);

        // Notify customer of status change
        try {
            $booking->customer->notify(new BookingStatusChangedNotification($booking));
        } catch (\Throwable $e) {
            logger()->error('Failed to send booking status change notification: ' . $e->getMessage());
        }

        return $booking;
    }

    /**
     * Assign or reassign worker to a booking.
     */
    public function assignWorker($bookingId, $workerId)
    {
        $booking = Booking::findOrFail($bookingId);
        $oldWorkerId = $booking->worker_id;

        $booking->worker_id = $workerId;
        
        // If booking is pending, automatically transition to accepted when assigned?
        // Let's keep it as is, or set status to accepted if desired. The admin panel can handle transitions explicitly.
        
        $booking->save();
        $booking->load(['customer', 'service', 'worker']);

        // Notify worker of the assignment if it's a new worker
        if ($workerId && $workerId !== $oldWorkerId) {
            try {
                $booking->worker->notify(new WorkerAssignedToBookingNotification($booking));
            } catch (\Throwable $e) {
                logger()->error('Failed to send worker assignment notification: ' . $e->getMessage());
            }
        }

        return $booking;
    }
}
