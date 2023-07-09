<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bus_id',
        'name',
        'from',
        'to',
        'distance',
        'price',
    ];

    /**
     * Get the bus for the trip.
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
