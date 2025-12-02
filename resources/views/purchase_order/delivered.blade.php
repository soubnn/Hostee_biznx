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

                                        <h4 class="card-title mb-4">Delivered Purchase Order</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Pur No</th>
                                                <th>Seller Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>View</th>
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
                                                            <a href="{{ route('purchase_order.show',$purchase_order->id) }}">
                                                                <button class="btn btn-light text-primary">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>
                                                            </a>
                                                        </td>
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
