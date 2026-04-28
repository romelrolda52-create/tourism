<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'transportation_vehicles';

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_per_trip',
        'status',
        'image',
        'description',
    ];

    protected $casts = [
        'price_per_trip' => 'decimal:2',
        'capacity' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getRemainingCapacityAttribute()
    {
        $booked = $this->bookings()->where('status', '!=', 'cancelled')->sum('number_of_guests');
        return max(0, $this->capacity - $booked);
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'car' => 'fa-car',
            'van' => 'fa-shuttle-van',
            'bus' => 'fa-bus',
            'boat' => 'fa-ship',
            'plane' => 'fa-plane',
            default => 'fa-car',
        };
    }
}

