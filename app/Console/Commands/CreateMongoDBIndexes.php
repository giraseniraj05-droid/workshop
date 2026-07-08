<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\WorkerServiceAssignment;
use App\Models\Booking;

class CreateMongoDBIndexes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongodb:create-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create performance indexes on MongoDB collections';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating indexes for Services...');
        Service::raw(function ($collection) {
            $collection->createIndex(['status' => 1]);
            $collection->createIndex(['slug' => 1], ['unique' => true]);
        });

        $this->info('Creating indexes for Worker Service Assignments...');
        WorkerServiceAssignment::raw(function ($collection) {
            $collection->createIndex(['worker_id' => 1]);
            $collection->createIndex(['service_id' => 1]);
            $collection->createIndex(['worker_id' => 1, 'service_id' => 1]);
        });

        $this->info('Creating indexes for Bookings...');
        Booking::raw(function ($collection) {
            $collection->createIndex(['status' => 1]);
            $collection->createIndex(['customer_id' => 1]);
            $collection->createIndex(['worker_id' => 1]);
        });

        $this->info('All MongoDB indexes created successfully!');
        return Command::SUCCESS;
    }
}
