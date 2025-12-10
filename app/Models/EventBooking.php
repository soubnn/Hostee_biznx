<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'event_id',
        'name',
        'place',
        'whatsapp_no',
        'phone',
    ];

    public function event()
    {
        return $this->belongsTo(UpcomingEvent::class, 'event_id');
    }
}
