<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use App\Models\User;
use App\Notifications\NewEnquirySubmittedNotification;

class EnquiryController extends Controller
{
    /**
     * Store a new general enquiry.
     */
    public function store(StoreEnquiryRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'open';

        $enquiry = Enquiry::create($data);

        // Load relations for notifications
        $enquiry->load('service');

        // Send email to admins
        $admins = User::whereIn('role', ['Admin', 'Super Admin'])->where('status', 'active')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewEnquirySubmittedNotification($enquiry));
        }

        return redirect()->back()
            ->with('success', __('messages.enquiry_success'));
    }
}
