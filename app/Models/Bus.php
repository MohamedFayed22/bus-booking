<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'driver_name',
        'bus_number',
        'bus_type',
        'seats_count',
    ];

    /**
     * Get the trips for the bus.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
