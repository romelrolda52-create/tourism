<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'destination_id',
        'hotel_id',
        'room_id',
        'vehicle_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'booking_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'total_price',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'number_of_guests' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the destination of the booking.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get the hotel of the booking.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the room of the booking.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the vehicle of the booking.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the payments for the booking.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Generate a unique booking ID.
     */
    public static function generateBookingId()
    {
        $prefix = 'HTL';
        $date = date('Ymd');
        $random = strtoupper(uniqid());
        return $prefix . '-' . $date . '-' . $random;
    }

    /**
     * Calculate total price based on nights and room rate.
     */
    public function calculateTotalPrice()
    {
        $nights = $this->check_in_date->diffInDays($this->check_out_date);
        $roomPrice = $this->room ? $this->room->price_per_night : 0;
        return $nights * $roomPrice;
    }

    /**
     * Get number of nights for this booking.
     */
    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    /**
     * Get status options.
     */
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'checked_in' => 'Checked In',
            'checked_out' => 'Checked Out',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_id)) {
                $booking->booking_id = self::generateBookingId();
            }
        });
    }
}
