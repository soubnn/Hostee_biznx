@extends('layouts.layout')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">News Event Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li><a href="{{ route('news_events.index') }}">News Events</a></li>
                                <li class="breadcrumb-item active">Event Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-4">Event Information</h4>
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
                                </tr>
                                @if($event->photo)
                                    <tr>
                                        <th>Photo:</th>
                                        <td><img src="{{ asset('storage/news_events/' . $event->photo) }}" class="img-fluid" alt="Event Photo"></td>
                                    </tr>
                                @endif
                            </table>
                            <div class="mt-4">
                                <a href="{{ route('news_events.index') }}" class="btn btn-secondary">Back to Events</a>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning waves-effect" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $event->id }}">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            @include('news_events.modals.edit_modal')
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- End Page-content -->

@endsection
