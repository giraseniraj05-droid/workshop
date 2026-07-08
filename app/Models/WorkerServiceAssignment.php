<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WorkerServiceAssignment extends Model
{
    protected $collection = 'worker_service_assignments';

    protected $fillable = [
        'worker_id',
        'service_id',
        'assigned_by',
        'assigned_at',
        'removed_at',
        'status', // 'active' or 'inactive'
    ];

    /**
     * Cast attributes to specific types.
     */
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'removed_at' => 'datetime',
        ];
    }

    /**
     * Get the worker (user) associated with this assignment.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    /**
     * Get the service associated with this assignment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Get the admin user who created this assignment.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
