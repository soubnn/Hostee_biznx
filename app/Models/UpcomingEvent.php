<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingEvent extends Model
{
    use HasFactory;

    public function bookings()
    {
        return $this->hasMany(EventBooking::class, 'event_id');
    }

}
