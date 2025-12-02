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
                                    <h4 class="mb-sm-0 font-size-18">View Requests</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Marketing Requests</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Phone</th>
                                                    <th>Job Role</th>
                                                    <th>Company Name</th>
                                                    <th>Company Place</th>
                                                    <th>Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($marketings as $marketings)
                                                <tr>
                                                    <td data-sort="YYYYMMDD">{{ Carbon\carbon::parse($marketings->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $marketings->customer_name }}</td>
                                                    <td>{{ $marketings->contact_no }}</td>
                                                    <td>{{ $marketings->job_role }}</td>
                                                    <td>{{ $marketings->company_name  }}</td>
                                                    <td>{{ $marketings->company_place  }}</td>
                                                    @if($marketings->status == 'APPROVED')
                                                        <td class="text-success">{{ $marketings->status  }}</td>
                                                    @elseif ($marketings->status == 'REJECTED')
                                                        <td class="text-danger">{{ $marketings->status  }}</td>
                                                    @endif
                                                    <td><a href="{{ route('marketing.show',$marketings->id) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->





@endsection
