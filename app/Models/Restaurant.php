<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location', 
        'cuisine_type',
        'average_price',
        'status',
        'image',
        'phone',
        'email'
    ];

    protected $casts = [
        'average_price' => 'decimal:2',
    ];
}
