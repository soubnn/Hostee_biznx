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
                            <h4 class="mb-sm-0 font-size-18">View {{ $heading }} Works</h4>
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
                                            <th>Customer</th>
                                            <th>Work Description</th>
                                            <th>Add By</th>
                                            @if($heading != 'Approved' && $heading != 'Canceled')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($works as $work)
                                            <tr>
                                                <td data-sort=''>{{ Carbon\carbon::parse($work->date)->format('d-m-Y h:i A') }}</td>
                                                @php
                                                    $customer = DB::table('customers')->where('id',$work->customer)->first();
                                                @endphp
                                                <td style="white-space: normal;">
                                                    <a href="{{ route('field.show',$work->id) }}">
                                                        @if($customer)
                                                            {{ $customer->name }}, {{ $customer->place }}
                                                        @else
                                                            {{ $work->customer }}
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="white-space: normal;">{{ $work->work }}</td>
                                                <td style="white-space: normal;">{{ $work->add_by }}</td>
                                                @if($work->status != 'approved' && $heading != 'Canceled')
                                                    <td>
                                                        @if($work->status == 'delivered')
                                                            @if(Auth::user()->username == 'ramiz' || Auth::user()->username == 'hashim')
                                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approve_modal_{{ $work->id }}">Approve</button>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-primary" disabled>Approve</button>
                                                            @endif
                                                        @elseif($work->status == 'pending')
                                                            <a href="{{ route('field.show', $work->id) }}"  class="btn btn-sm btn-primary">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                            {{--  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#deliver_modal_{{ $work->id }}">Deliver</button>  --}}
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                            <!-- Deliver Modal -->
                                            <div id="deliver_modal_{{ $work->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="Post" action="{{ route('field.deliver',$work->id ) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12 text-center">
                                                                        <i class="dripicons-checkmark text-success" style="font-size: 50px;"></i>
                                                                        <h4>Are You Sure ??</h4>
                                                                        <p style="font-weight: 300px;font-size:18px;">Completed the field work.</p>
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
                                            <!-- Approve Modal -->
                                            <div id="approve_modal_{{ $work->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form method="Post" action="{{ route('field.approve',$work->id ) }}">
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
