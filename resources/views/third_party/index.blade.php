@extends('layouts.layout')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">View Servicers</h4>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Servicer Name</th>
                                        <th>Servicer Contact</th>
                                        <th>Servicer Place</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($third_partis as $index => $third_party)
                                        <tr>
                                            <td>{{ $index + 1 }}</td> 
                                            <td>{{ $third_party->servicer_name }}</td> 
                                            <td>{{ $third_party->servicer_contact }}</td> 
                                            <td>{{ $third_party->servicer_place }}</td> 
                                            <td>
                                                <button type="button" class="btn btn-light waves-effect text-primary" data-bs-toggle="modal" data-bs-target="#editServicerModal{{ $third_party->id }}">
                                                    Edit 
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
            @foreach($third_partis as  $third_party)
                @include('third_party.modals.edit-servicer')
            @endforeach
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
