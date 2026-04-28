<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'feedback',
        'rating',
        'booking_id',
        'admin_reply',
        'replied_at',
        'replied_by',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];



    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function scopeHasReply($query)
    {
        return $query->whereNotNull('admin_reply');
    }

    public function getReplyStatusAttribute()
    {
        if ($this->admin_reply) {
            return 'Replied';
        }
        return 'Pending';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->rating) {
            5 => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
            4 => 'bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300',
            3 => 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300',
            2 => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
            1 => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300',
        };
    }
}

