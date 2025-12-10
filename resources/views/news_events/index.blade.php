@extends('layouts.layout')
@section('content')
<script>
    $(document).ready(function(){
        $("#datatable").dataTable({
            "pageLength" : 100
        });
    });
</script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">View News Events</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">News Events / <a href="{{ route('news_events.index') }}">View News Events</a></li>
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
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 mt-5">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news_events as $event)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->status }}</td>
                                        <td>
                                            <a href="{{ route('news_events.show', $event->id) }}" class="btn btn-info">View</a>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-warning waves-effect" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $event->id }}">
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger waves-effect" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $event->id }}">
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
            </div> <!-- end col -->
            @foreach($news_events as $event)
                @include('news_events.modals.delete_modal')
                @include('news_events.modals.edit_modal')
            @endforeach
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- End Page-content -->


@endsection
