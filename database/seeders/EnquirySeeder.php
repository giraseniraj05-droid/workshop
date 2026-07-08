<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Enquiry;
use Carbon\Carbon;

class EnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        
        $names = ['Sarah Miller', 'Alex Carter', 'Emma Watson', 'James Bond', 'Jessica Alba', 'Bruce Wayne', 'Diana Prince', 'Clark Kent', 'Barry Allen', 'Hal Jordan'];
        $emails = ['sarah@example.com', 'alex@example.com', 'emma@example.com', 'james@example.com', 'jessica@example.com', 'bruce@example.com', 'diana@example.com', 'clark@example.com', 'barry@example.com', 'hal@example.com'];
        $messages = [
            'Do you provide custom framing designs for window installations?',
            'What products do you use for deep cleaning? Are they pet-safe?',
            'How long does it take to tile a 20 sqm living room floor?',
            'Can I get a quotation for a complete 3-bedroom villa painting job?',
            'Do you fix cracked plaster work on ceilings?',
            'Can you build a custom wooden bookshelf for my study room?',
            'My bathroom sink pipe is leaking. Is this covered in sanitary installation?',
            'Do you offer custom false ceiling designs with LED strip channels?',
            'Do you have same-day emergency plumbing service?',
            'Can I get a discount if I book deep cleaning for my entire office building?'
        ];

        for ($i = 0; $i < 10; $i++) {
            $service = $services[$i % count($services)];
            $status = $i % 2 === 0 ? 'resolved' : 'open';
            
            Enquiry::create([
                'customer_name' => $names[$i],
                'email' => $emails[$i],
                'phone' => '+971 55 987 ' . str_pad(6540 + $i, 4, '0', STR_PAD_LEFT),
                'service_id' => $service->id,
                'message' => $messages[$i],
                'status' => $status,
                'admin_reply' => $status === 'resolved' ? 'Yes, we can absolutely help you with this! A specialist has been notified to email you a detailed quote/answer.' : null,
                'replied_at' => $status === 'resolved' ? Carbon::now()->subDays($i) : null,
                'created_at' => Carbon::now()->subDays($i + 1),
            ]);
        }
    }
}
