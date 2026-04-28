<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
    'name',
    'description',
    'location',
    'latitude',
    'longitude',
    'image',
    'price',
    'is_active'
];

protected $casts = [
    'latitude' => 'decimal:8',
    'longitude' => 'decimal:8',
    'price' => 'decimal:2',
    'is_active' => 'boolean',
];

public function scopeActive($query)
{
    return $query->where('is_active', true);
}
}
