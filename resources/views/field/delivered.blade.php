@extends('layouts.layout')
@section('content')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                order: [[0, 'desc']],
                "pageLength": 100,
                // order: [[1, 'desc']],
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
                            <h4 class="mb-sm-0 font-size-18">View Works</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Field Works</h4>
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Work Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dates as $date)
                                            <tr>
                                                <td data-sort=''>{{ Carbon\carbon::parse($date)->format('d-m-Y') }}</td>
                                                <td style="white-space: normal;">Works</td>
                                                <td>
                                                    @if(Auth::user()->username == 'ramiz' || Auth::user()->username == 'hashim')
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approve_modal_{{ $date }}">Approve</button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-primary" disabled>Approve</button>
                                                    @endif
                                                    <a href="{{ route('field.delivered', $date) }}" class="btn btn-sm btn-primary">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Approve Modal -->
                                            <div id="approve_modal_{{ $date }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="Post" action="{{ route('field_date.approve',$date) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12 text-center">
                                                                        <i class="dripicons-checkmark text-success" style="font-size: 50px;"></i>
                                                                        <h4>Are You Sure ??</h4>
                                                                        <p style="font-weight: 300px;font-size:18px;">Approve this field work.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-info" id="addtask">Yes, confirm</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
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
