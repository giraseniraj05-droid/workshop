<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\WorkerServiceAssignment;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'Customer')->get();
        $services = Service::all();
        $statuses = ['pending', 'accepted', 'rejected', 'completed', 'cancelled'];
        
        $times = ['09:00 AM - 11:00 AM', '11:00 AM - 01:00 PM', '02:00 PM - 04:00 PM', '04:00 PM - 06:00 PM'];
        $notesList = [
            'Please call me 10 minutes before arrival.',
            'Requires extra attention to details in the kitchen area.',
            'No special requirements, thank you.',
            'Please bring all necessary cleaning supplies.',
            'Gate code is #1234.'
        ];

        for ($i = 0; $i < 20; $i++) {
            $customer = $customers[$i % count($customers)];
            $service = $services[$i % count($services)];
            $status = $statuses[$i % count($statuses)];
            
            // Find a worker assigned to this service
            $assignedWorkerId = null;
            if (in_array($status, ['accepted', 'completed'])) {
                $assignment = WorkerServiceAssignment::where('service_id', $service->id)
                    ->where('status', 'active')
                    ->first();
                if ($assignment) {
                    $assignedWorkerId = $assignment->worker_id;
                }
            }

            Booking::create([
                'customer_id' => $customer->id,
                'worker_id' => $assignedWorkerId,
                'service_id' => $service->id,
                'booking_date' => Carbon::now()->addDays(($i % 5) - 2)->format('Y-m-d'), // range between 2 days ago and 3 days from now
                'preferred_time' => $times[$i % count($times)],
                'address' => (100 + $i) . ' Marina Heights, Dubai Marina, Dubai',
                'notes' => $i % 2 === 0 ? $notesList[$i % count($notesList)] : null,
                'status' => $status,
                'created_at' => Carbon::now()->subDays(10 - ($i / 2)),
            ]);
        }
    }
}
