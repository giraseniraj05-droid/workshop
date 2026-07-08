<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkerProfile;

class WorkerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = User::where('role', 'Worker')->get();

        $skillsPool = [
            ['Glass Cutting', 'Aluminium Fabrication', 'Framing', 'Window Fitting'],
            ['Deep Cleaning', 'Sanitization', 'Carpet Cleaning', 'Office Cleaning'],
            ['Tiling', 'Marble Polishing', 'Grouting', 'Wall Tiling'],
            ['Wall Painting', 'Waterproofing', 'Wood Polishing', 'Exterior Coatings'],
            ['Gypsum Board Plastering', 'Cement Rendering', 'Drywall Repair', 'Skimming'],
            ['Cabinet Installation', 'Wood Flooring', 'Door Repairs', 'Furniture Assembly'],
            ['Pipe Repair', 'Tap Installation', 'Drain Unblocking', 'Sanitary Fitting'],
            ['Drywall Partitions', 'Grid Ceiling', 'POP Designing', 'Acoustic Panel Setup']
        ];

        $bios = [
            'Experienced specialist focused on delivering high-quality residential maintenance and repairs.',
            'Dedicated professional with over 5 years of service industry expertise, delivering reliable results.',
            'Specialized service technician with a reputation for precision and excellent customer satisfaction.',
            'Friendly and punctual specialist who prioritizes quality craftsmanship and safety standards.'
        ];

        foreach ($workers as $index => $worker) {
            // Assign worker skills based on index (so we spread workers across the 8 service categories)
            $serviceIndex = $index % 8;
            $skills = $skillsPool[$serviceIndex];

            WorkerProfile::create([
                'user_id' => $worker->id,
                'photo' => "profiles/worker_" . ($index + 1) . ".jpg",
                'phone' => '+971 50 123 ' . str_pad(4567 + $index, 4, '0', STR_PAD_LEFT),
                'address' => (10 + $index) . ' Al Barsha St, Dubai, UAE',
                'bio' => $bios[$index % count($bios)],
                'experience' => ($index % 8) + 3, // 3 to 10 years of experience
                'skills' => $skills,
                'linkedin' => 'https://www.linkedin.com/in/worker' . ($index + 1),
                'facebook' => 'https://www.facebook.com/worker' . ($index + 1),
                'instagram' => 'https://www.instagram.com/worker' . ($index + 1),
            ]);
        }
    }
}
