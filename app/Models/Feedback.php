<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Feedback extends Model
{
    protected $collection = 'feedback';

    protected $fillable = [
        'booking_id',
        'customer_id',
        'worker_id',
        'service_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Get the booking associated with the feedback.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Get the customer who left the feedback.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the worker who performed the service.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    /**
     * Get the service that was rated.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
