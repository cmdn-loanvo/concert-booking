<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $fillable = [
        'title',
        'start_time'
    ];

    public function seatTypes()
    {
        return $this->hasMany(SeatType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
