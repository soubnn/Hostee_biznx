@extends('layouts.layout')
@section('content')
<script>
    function printDiv1() {

        // var printBtn = document.getElementById('btnPrint1');
        $('#btnPrint1').hide();
        $('#btnPrint2').hide();

        var printContents = document.getElementById('totalBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.location.reload();

    }
    function printDiv2() {

        $('#btnPrint2').hide();

        var printContents = document.getElementById('datewiseBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.location.reload();

    }
</script>
            <div class="main-content" id="totalBody" >

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Purchase Report</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">Purchase Report</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">From : {{ Carbon\carbon::parse($start_date)->format('d M Y') }}</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">To : {{ Carbon\carbon::parse($end_date)->format('d M Y') }}</h4>
                                            </div>
                                            <div class="col-3 text-end">
                                                <button type="button" class="btn btn-success" id="btnPrint1" onclick="printDiv1();">
                                                    <i class="fa fa-print"></i><span style="margin-left: 10px;">Print</span>
                                                </button>
                                            </div>

                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                                <thead>
                                                    <tr style="font-size: 16px;">
                                                        <th>From : {{ Carbon\carbon::parse($start_date)->format('d M Y') }}</th>
                                                        <th>To : {{ Carbon\carbon::parse($end_date)->format('d M Y') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">No. Of Purchases</th>
                                                        <td colspan="6">{{ $purchase_count }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">No. Of Purchased Products</th>
                                                        <td colspan="6">{{ $purchase_product_count }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">Total Purchased Amount</th>
                                                        <td colspan="6">₹{{ $total_purchase_amount }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->


                        </div> <!-- end row -->

                        <div class="row" id="datewiseBody">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">Date Wise Purchase Report</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">From : {{ Carbon\carbon::parse($start_date)->format('d M Y')}}</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">To : {{ Carbon\carbon::parse($end_date)->format('d M Y')}}</h4>
                                            </div>
                                            <div class="col-3 text-end">
                                                <button type="button" class="btn btn-success" id="btnPrint2" onclick="printDiv2();">
                                                    <i class="fa fa-print"></i><span style="margin-left: 10px;">Print</span>
                                                </button>
                                            </div>

                                        </div>

                                        @foreach ( $purchase1 as $purchase)
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered table-striped table-nowrap mb-0">
                                                    <thead>
                                                        <tr style="font-size: 14px;">
                                                            <th>Date : {{ Carbon\carbon::parse($purchase->invoice_date)->format('d M Y') }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $datewise_purchase = DB::table('purchases')->where('invoice_date',$purchase->invoice_date)->get();
                                                    @endphp
                                                    @foreach ( $datewise_purchase as $datewise_purchase)

                                                    <tbody>
                                                        <tr style="font-size: 14px;">
                                                            <th>Invoice No. : {{ $datewise_purchase->invoice_no }}</th>
                                                            <th></th>
                                                        </tr>
                                                        <tr style="font-size: 14px;">

                                                            @php
                                                                $get_seller = DB::table('sellers')->where('id',$datewise_purchase->seller_details)->get();
                                                            @endphp
                                                            @foreach ( $get_seller as $get_seller )
                                                                <th class="text-nowrap" scope="row">Seller : {{ $get_seller->seller_name  }}</th>
                                                                <th></th>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr style="font-size: 16px;">
                                                                        <th>Product</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Qty</th>
                                                                        <th>GST%</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $purchase_details = DB::table('purchase_items')->where('purchase_id',$datewise_purchase->id)->get();
                                                                    @endphp
                                                                    @foreach ( $purchase_details as $purchase_details)
                                                                        <tr>
                                                                            @php
                                                                                $get_product = DB::table('products')->where('id',$purchase_details->product_id)->get();
                                                                            @endphp
                                                                            @foreach ( $get_product  as $get_product )
                                                                                <td>{{ $get_product->product_name }}</td>
                                                                            @endforeach
                                                                            <td>{{ $purchase_details->unit_price }}</td>
                                                                            <td>{{ $purchase_details->product_quantity }}</td>
                                                                            <td>{{ $purchase_details->gst_percent }}</td>
                                                                            <td>{{ $purchase_details->purchase_price }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                        <tr style="font-size: 14px;">
                                                            @php
                                                                $datewise_purchase_amount = DB::table('purchase_items')->where('purchase_id',$datewise_purchase->id)->sum('purchase_price');
                                                            @endphp
                                                            <th class="text-nowrap" scope="row">Total Purchase Amount : ₹{{ $datewise_purchase_amount }}</th>
                                                        </tr>

                                                    </tbody>

                                                    @endforeach



                                                </table>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div> <!-- end col -->


                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection

