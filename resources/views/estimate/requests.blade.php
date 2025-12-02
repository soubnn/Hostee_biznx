@extends('layouts.layout')
@section('content')
    <script>
        $(document).ready(function() {
            $("#datatable").dataTable({
                "pageLength": 100
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
                            <h4 class="mb-sm-0 font-size-18">View Estimate Requests</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Requests</h4>
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Need</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Reference</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($estimate_requests as $requests)
                                            <tr>
                                                <td>{{ $requests->need }}</td>
                                                <td>{{ $requests->customer_name }}</td>
                                                <td>{{ $requests->customer_contact }}</td>
                                                <td>{{ $requests->customer_email }}</td>
                                                <td>{{ $requests->reference }}</td>
                                                <td style="white-space: normal;">{{ $requests->message }}</td>
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
