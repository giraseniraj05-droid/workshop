<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\WorkerServiceAssignment;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard homepage with stats.
     */
    public function index()
    {
        $stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('status', 'active')->count(),
            'total_workers' => User::where('role', 'Worker')->count(),
            'active_workers' => User::where('role', 'Worker')->where('status', 'active')->count(),
            'total_customers' => User::where('role', 'Customer')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'open_enquiries' => Enquiry::where('status', 'open')->count(),
        ];

        $recentAssignments = WorkerServiceAssignment::with(['worker', 'service', 'admin'])
            ->orderBy('assigned_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAssignments'));
    }
}
