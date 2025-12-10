@extends('layouts.layout')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex justify-content-between">
                            <h4 class="mb-0">Upcoming Event Details</h4>
                            <div>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('upcoming_events.index') }}">Upcoming
                                            Events</a></li> /
                                    <li>Event Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                
                                <div class="d-flex mb-4 justify-content-between">
                                    <div>
                                        <h4 class="text-start">Event Information</h4>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit_modal{{ $event->id }}">
                                            Edit
                                        </button>

                                        <a href="{{ route('upcoming_events.index') }}" class="btn btn-secondary">Back to
                                            Events</a>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Title:</th>
                                        <td>{{ $event->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>{{ $event->location }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date:</th>
                                        <td>{{ Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td>{{ $event->description }}</td>

                                        @if ($event->image)
                                            <th>Image:</th>
                                            <td>
                                                <img src="{{ asset('storage/upcoming_events/' . $event->image) }}"
                                                    class="img-fluid" style="max-width: 250px;">
                                            </td>
                                        @endif
                                    </tr>
                                </table>
                                
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mt-4 mb-3">Event Bookings</h4>

                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 mt-5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Place</th>
                                            <th>Whatsapp No</th>
                                            <th>Phone</th>
                                            <th>Booked At</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($event->bookings as $index => $booking)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $booking->name }}</td>
                                            <td>{{ $booking->place }}</td>
                                            <td>{{ $booking->whatsapp_no }}</td>
                                            <td>{{ $booking->phone }}</td>
                                            <td>{{ $booking->created_at->format('d-m-Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                <a href="{{ route('upcoming_events.download', $event->id) }}" class="btn btn-success mb-3">
                                    Download Bookings (Excel)
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                @include('upcoming_events.modals.edit_modal')

            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div> <!-- End Page-content -->
@endsection
