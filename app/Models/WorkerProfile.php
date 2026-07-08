<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WorkerProfile extends Model
{
    protected $collection = 'worker_profiles';

    protected $fillable = [
        'user_id',
        'photo',
        'phone',
        'address',
        'bio',
        'experience',
        'skills', // Array of skills
        'linkedin',
        'facebook',
        'instagram',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected function casts(): array
    {
        return [
            'experience' => 'integer',
            'skills' => 'array',
        ];
    }

    /**
     * Get the user that owns the worker profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
