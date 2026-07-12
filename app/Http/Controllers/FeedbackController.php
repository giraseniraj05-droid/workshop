<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Services\FeedbackService;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    /**
     * Store feedback for a completed booking.
     */
    public function store(StoreFeedbackRequest $request, $bookingId)
    {
        $data = $request->validated();
        $data['booking_id'] = $bookingId;

        $this->feedbackService->submitFeedback($data);

        return redirect()->back()
            ->with('success', __('messages.review_submitted_success'));
    }
}
