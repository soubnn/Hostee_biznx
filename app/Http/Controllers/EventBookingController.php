<?php

namespace App\Http\Controllers;

use App\Models\EventBooking;
use App\Models\UpcomingEvent;
use Illuminate\Http\Request;

class EventBookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id'    => 'required|exists:upcoming_events,id',
            'name'        => 'required|string|max:255',
            'place'       => 'nullable|string|max:255',
            'whatsapp_no' => 'required|string|max:20',
            'phone'       => 'required|string|max:20',
        ]);

        EventBooking::create($request->all());

        return back()->with('success', 'Thank you! Your booking has been submitted.');
    }
}
