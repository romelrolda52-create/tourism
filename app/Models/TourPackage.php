<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'itinerary',
        'status',
        'available_slots',
        'image',
        'guide_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'itinerary' => 'array',
        'available_slots' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the guide for the tour package.
     */
    public function guide(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guide_id');
    }

    /**
     * Get the destinations included in the tour package.
     */
    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class);
    }

    /**
     * Get the bookings for the tour package.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for active packages.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if package has available slots.
     */
    public function hasAvailableSlots(): bool
    {
        $bookedSlots = $this->bookings()->where('status', '!=', 'cancelled')->count();
        return $bookedSlots < $this->available_slots;
    }

    /**
     * Get available slots remaining.
     */
    public function getRemainingSlotsAttribute(): int
    {
        $bookedSlots = $this->bookings()->where('status', '!=', 'cancelled')->count();
        return max(0, $this->available_slots - $bookedSlots);
    }

    /**
     * Get formatted itinerary days.
     */
    public function getItineraryHtmlAttribute(): string
    {
        if (empty($this->itinerary)) {
            return '<p class="text-gray-500">Itinerary not specified</p>';
        }

        $html = '<div class="space-y-3">';
        foreach ($this->itinerary as $day => $activities) {
            $html .= "<div class='border-l-4 border-blue-500 pl-4'>";
            $html .= "<h4 class='font-bold text-lg mb-2'>Day {$day}</h4>";
            $html .= "<ul class='space-y-1 text-sm'>";
            foreach ((array) $activities as $activity) {
                $html .= "<li class='flex items-center gap-2'><i class='fas fa-check text-blue-500 text-xs'></i>{$activity}</li>";
            }
            $html .= '</ul></div>';
        }
        $html .= '</div>';
        return $html;
    }
}

