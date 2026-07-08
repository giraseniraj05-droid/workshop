<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Enquiry extends Model
{
    protected $collection = 'enquiries';

    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'service_id',
        'message',
        'status', // 'open', 'resolved'
        'admin_reply',
        'replied_at',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    /**
     * Get the service associated with this enquiry.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
