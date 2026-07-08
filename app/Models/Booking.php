<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $collection = 'bookings';

    protected $fillable = [
        'customer_id',
        'worker_id',
        'service_id',
        'booking_date',
        'preferred_time',
        'address',
        'notes',
        'status', // 'pending', 'accepted', 'rejected', 'completed', 'cancelled'
    ];

    /**
     * Get the customer (user) who booked this service.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the worker (user) assigned to this booking.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    /**
     * Get the service that was booked.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
