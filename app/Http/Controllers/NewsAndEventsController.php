<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NewsEvent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class NewsAndEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news_events = NewsEvent::all();
        return view('news_events.index', compact('news_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news_events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'date'          => 'required|date',
            'description'   => 'required|string',
            'photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $news_event = new NewsEvent();
        $news_event->title          = $request->title;
        $news_event->location       = $request->location;
        $news_event->date           = $request->date;
        $news_event->description    = $request->description;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/news_events', $fileName);
            $news_event->photo = $fileName;
        }
        $status = $news_event->save();
        if($status){
            Toastr::success("News/Event added successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('news_events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = NewsEvent::findOrFail($id);
        return view('news_events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = NewsEvent::findOrFail($id);
        $event->title = $request->title;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->description = $request->description;

        if ($request->hasFile('photo')) {
            if ($request->hasFile('photo')) {
                \Storage::delete('public/news_events/' . $event->photo);
            }
            $photo = $request->file('photo');
            $fileName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/news_events', $fileName);
            $event->photo = $fileName;
        }
        $status = $event->save();
        if ($status) {
            Toastr::success("News/Event updated successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('news_events.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = NewsEvent::findOrFail($id);
        \Storage::delete('public/news_events/' . $event->photo);
        $status = $event->delete();

        if ($status) {
            Toastr::success("News/Event deleted successfully!", "Success", ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error("Please try again!", "Error", ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('news_events.index');
    }
}
