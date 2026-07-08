<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $collection = 'services';

    protected $fillable = [
        'name',
        'name_en',
        'name_ar',
        'slug',
        'description',
        'description_en',
        'description_ar',
        'image',
        'gallery',
        'icon',
        'status',
        'price',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'price' => 'double',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name_en ?? $service->name);
            }
        });

        static::updating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name_en ?? $service->name);
            }
        });
    }

    /**
     * Get the name dynamically based on locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        $field = "name_{$locale}";
        return $this->getAttributeValue($field) ?? $this->getAttributeValue('name_en') ?? $this->getAttributeValue('name') ?? '';
    }

    /**
     * Get the description dynamically based on locale.
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = "description_{$locale}";
        return $this->getAttributeValue($field) ?? $this->getAttributeValue('description_en') ?? $this->getAttributeValue('description') ?? '';
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get assignments for this service.
     */
    public function assignments()
    {
        return $this->hasMany(WorkerServiceAssignment::class, 'service_id');
    }

    /**
     * Get the bookings for this service.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }
}
