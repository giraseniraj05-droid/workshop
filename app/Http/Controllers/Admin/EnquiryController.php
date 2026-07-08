<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\EnquiryRepository;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnquiryController extends Controller
{
    protected $enquiryRepository;

    public function __construct(EnquiryRepository $enquiryRepository)
    {
        $this->enquiryRepository = $enquiryRepository;
    }

    /**
     * Display a listing of enquiries.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status']);
        $enquiries = $this->enquiryRepository->getAll($filters);

        return view('admin.enquiries.index', compact('enquiries'));
    }

    /**
     * Show enquiry details and reply form.
     */
    public function show($id)
    {
        $enquiry = $this->enquiryRepository->find($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Reply to enquiry and resolve it.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => ['required', 'string', 'min:5', 'max:5000'],
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'resolved',
            'replied_at' => Carbon::now(),
        ]);

        // Note: For production, we would send a reply email to the customer here.
        // For v1, the reply is saved in database and can be reviewed in the admin panel.

        return redirect()->route('admin.enquiries.show', $id)
            ->with('success', __('messages.enquiry_reply_success'));
    }
}
