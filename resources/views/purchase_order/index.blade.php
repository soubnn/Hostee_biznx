@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
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
                                <h4 class="mb-sm-0 font-size-18">View Purchase Order</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Purchase Orders</h4>
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                        <thead>
                                            <tr>
                                                <th>Pur No</th>
                                                <th>Seller</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                                <th>Approve</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase_orders as $purchase_order)
                                                <tr>
                                                    <td data-sort="">{{ $purchase_order->purchase_order_number }}</td>
                                                    <td style="white-space: normal">{{ $purchase_order->seller_name }}</td>
                                                    <td>{{ $purchase_order->seller_mobile }}</td>
                                                    <td>{{ $purchase_order->purchase_order_date }}</td>
                                                    <td>{{ $purchase_order->grand_total }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light text-danger" data-bs-toggle="modal" data-bs-target="#delete_purchase_order_modal{{$purchase_order->id}}">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </button>
                                                        <a href="{{ route('purchase_order.edit',$purchase_order->id) }}">
                                                            <button class="btn btn-light text-primary">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{ route('purchase_order.show',$purchase_order->id) }}">
                                                            <button class="btn btn-light text-primary">
                                                                <i class="mdi mdi-eye"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approve_purchase_order_modal{{$purchase_order->id}}">
                                                            &nbsp;<i class="mdi mdi-check-circle text-light"></i>&nbsp;
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Delete Modal -->
                                                <div id="delete_purchase_order_modal{{$purchase_order->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <form method="Post" action="{{ route('delete_purchase_order',$purchase_order->id) }}">
                                                                        @csrf
                                                                        <div class="form-group mb-3">
                                                                            <div class="col-lg-12 text-center">
                                                                                <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                                                                <h4>Are You Sure ??</h4>
                                                                                <p style="font-weight: 300px;font-size:18px;">The Purchase Order will be Deleted..</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 text-end">
                                                                                <button type="submit" class="btn btn-info" id="addtask">Yes, Delete</button>
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                                <!-- End Delete Modal -->

                                                <!-- approve Modal -->
                                                <div id="approve_purchase_order_modal{{$purchase_order->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <form method="Post" action="{{ route('purchase_order.approve',$purchase_order->id) }}">
                                                                        @csrf
                                                                        <div class="form-group mb-3">
                                                                            <div class="col-lg-12 text-center">
                                                                                <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                                                                <h4>Are You Sure ??</h4>
                                                                                <p style="font-weight: 300px;font-size:18px;">The Purchase Order will be approved</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 text-end">
                                                                                <button type="submit" class="btn btn-info" id="addtask">Yes, approve</button>
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                                <!-- End approve Modal -->

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
