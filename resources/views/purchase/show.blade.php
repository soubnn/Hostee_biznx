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
                                    <h4 class="mb-sm-0 font-size-18">View Purchase</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        @php
                                            $get_purchase = DB::table('purchases')->where('id',$purchase_id)->first();
                                            $invoice_date = $get_purchase->invoice_date;
                                            $date_string = Carbon\carbon::parse($invoice_date)->format('dm');
                                            $ref_id = $purchase_id.$date_string;
                                            $purchase_count = DB::table('purchase_items')->where('purchase_id',$purchase_id)->count();
                                            $purchase_products_count = DB::table('purchase_items')->where('purchase_id',$purchase_id)->sum('product_quantity');
                                        @endphp
                                        <table class="table table-bordered nowrap w-100">
                                            <tr>
                                                <th>Ref ID</th>
                                                <th>Total Amount</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $ref_id }}</td>
                                                <td>{{ $get_purchase->grand_total }}</td>
                                            </tr>
                                            <tr>
                                                <th>No Of Items</th>
                                                <th>No Of Products</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $purchase_count }}</td>
                                                <td>{{ $purchase_products_count }}</td>
                                            </tr>
                                            <tr>
                                                <th>Purchase Date</th>
                                                <th colspan="2">Purchase Bill</th>
                                            </tr>
                                            <tr>
                                                <td>{{ Carbon\carbon::parse($invoice_date)->format('d-M-Y') }}</td>
                                                <form method="POST" action="{{ route('purchase.add_purchase_bill',$purchase_id) }}" enctype="multipart/form-data">
                                                @csrf
                                                    <td colspan="2">
                                                        @if ($get_purchase->purchase_bill)
                                                            <a href="{{ asset('storage/purchase/'.$get_purchase->purchase_bill) }}" target="_blank">{{ $ref_id.'- purchase bill' }}</a>
                                                        @else
                                                            <input type="file" class="form-control" name="purchase_bill">
                                                            <button type="submit" class="btn btn-primary mt-3">Save</button>
                                                        @endif
                                                    </td>
                                                </form>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Unit Price (INCL:GST)</th>
                                                <th>Quantity</th>
                                                <th>GST Percentage</th>
                                                <th>Purhcase Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($purchaseItems as $item)
                                                <tr>
                                                    <td style="white-space:normal">
                                                        @php
                                                            $product=DB::table('products')->where('id',$item->product_id)->first();
                                                        @endphp
                                                        {{ $product->product_name }}</td>
                                                    <td>
                                                    @php
                                                        $cat_name=DB::table('product_categories')->where('id',$product->category_id)->first();
                                                    @endphp
                                                    {{ $cat_name->category_name }}</td>
                                                    @php
                                                        $unitPrice = $item->unit_price;
                                                        $gstPercent = $item->gst_percent;
                                                        $gstAmount = ($unitPrice * $gstPercent) / 100;
                                                        $totalPrice = $unitPrice + $gstAmount;
                                                        $totalPrice = number_format($totalPrice, 2);
                                                    @endphp
                                                    <td>₹ {{$totalPrice}}</td>
                                                    <td>{{ $item->product_quantity }}</td>
                                                    <td>{{ $item->gst_percent }} %</td>
                                                    <td>₹ {{ $item->purchase_price }}</td>
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
