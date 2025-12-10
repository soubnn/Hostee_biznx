@extends('layouts.layout')
@section('content')
    <script>
        $(document).ready(function() {
            $("#datatable").dataTable({
                "pageLength": 10
            });
        });
    </script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View Upcoming Events</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">Upcoming Events /
                                        <a href="{{ route('upcoming_events.index') }}">View Events</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 mt-5">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Location</th>
                                            {{-- <th>Image</th> --}}
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($up_events as $event)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</td>
                                                <td>{{ $event->title }}</td>
                                                <td>{{ $event->location }}</td>
                                                {{-- <td>
                                                    @if ($event->image)
                                                        <img src="{{ asset('storage/upcoming_events/' . $event->image) }}" class="img-fluid" style="max-width: 150px;">
                                                    @endif
                                                </td> --}}

                                                <td>
                                                    <a href="{{ route('upcoming_events.show', $event->id) }}"
                                                        class="btn btn-info">
                                                        View
                                                    </a>

                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#edit_modal{{ $event->id }}">
                                                        Edit
                                                    </button>

                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#delete_modal{{ $event->id }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($up_events as $event)
                    @include('upcoming_events.modals.delete_modal')
                    @include('upcoming_events.modals.edit_modal')
                @endforeach

            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div> <!-- End Page-content -->
@endsection
