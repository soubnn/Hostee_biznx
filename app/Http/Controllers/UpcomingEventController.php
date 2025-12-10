<?php

namespace App\Http\Controllers;

use App\Exports\EventBookingsExport;
use App\Models\UpcomingEvent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UpcomingEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $up_events = UpcomingEvent::all();
        return view('upcoming_events.index', compact('up_events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('upcoming_events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'date'          => 'required|date',
            'description'   => 'required|string',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = new UpcomingEvent();
        $event->title = $request->title;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->description = $request->description;

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $fileName = time().'_'.$photo->getClientOriginalName();
            $photo->storeAs('public/upcoming_events', $fileName);
            $event->image = $fileName;
        }

        $status = $event->save();

        if ($status) {
            Toastr::success("Event added successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('upcoming_events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = UpcomingEvent::with('bookings')->findOrFail($id);
        return view('upcoming_events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'date'         => 'required|date',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = UpcomingEvent::findOrFail($id);

        $event->title = $request->title;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->description = $request->description;

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete('upcoming_events/'.$event->image);
            }

            $photo = $request->file('image');
            $fileName = time().'_'.$photo->getClientOriginalName();
            $photo->storeAs('public/upcoming_events', $fileName);
            $event->image = $fileName;
        }

        $status = $event->save();

        if ($status) {
            Toastr::success("Event updated successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('upcoming_events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = UpcomingEvent::findOrFail($id);

        if ($event->image) {
            Storage::disk('public')->delete('upcoming_events/'.$event->image);
        }

        $status = $event->delete();

        if ($status) {
            Toastr::success("Event deleted successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('upcoming_events.index');
    }

    public function downloadBookings($id)
    {
        return Excel::download(new EventBookingsExport($id), 'event_bookings.xlsx');
    }
}
