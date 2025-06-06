<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatType extends Model
{
    protected $fillable = [
        'concert_id',
        'name',
        'total_quantity',
        'price'
    ];

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
