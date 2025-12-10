@extends('layouts.layout')
@section('content')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Enquiry Details</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Enquiry Date</th>
                                                        <td colspan="6">{{ Carbon\carbon::parse($contact->date)->format('d-m-Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Name</th>
                                                        <td colspan="6">{{ $contact->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Contact</th>
                                                        <td colspan="6">{{ $contact->contact }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Email</th>
                                                        <td colspan="6" style="text-transform: lowercase;">{{ $contact->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Message</th>
                                                        <td colspan="6" style="white-space: normal;">{{ $contact->message }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
