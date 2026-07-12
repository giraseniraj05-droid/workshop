<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class FeedbackService
{
    /**
     * Submit a new feedback/review for a booking.
     */
    public function submitFeedback(array $data)
    {
        $bookingId = $data['booking_id'];
        $booking = Booking::with('feedback')->findOrFail($bookingId);

        // Business rule: only the booking's own customer
        if ($booking->customer_id !== Auth::id()) {
            throw new AccessDeniedHttpException('You are not authorized to submit feedback for this booking.');
        }

        // Business rule: only for completed bookings
        if ($booking->status !== 'completed') {
            throw ValidationException::withMessages([
                'booking' => ['Feedback can only be submitted for completed bookings.'],
            ]);
        }

        // Business rule: one review per booking
        if ($booking->feedback) {
            throw ValidationException::withMessages([
                'booking' => ['Feedback has already been submitted for this booking.'],
            ]);
        }

        $feedback = Feedback::create([
            'booking_id' => $booking->id,
            'customer_id' => Auth::id(),
            'worker_id' => $booking->worker_id,
            'service_id' => $booking->service_id,
            'rating' => (int) $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return $feedback;
    }
}
