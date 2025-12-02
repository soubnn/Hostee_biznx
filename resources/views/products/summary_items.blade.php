@extends('layouts.layout')
@section('content')
<script>
    $(document).ready(function(){
        $("#datatable").DataTable({
            "pageLength" : 100,
            "order": [[0, "desc"]],
            "columnDefs": [
                { "type": "date", "targets": 0 }
            ]
        });
    });
</script>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">View Sales</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Customer/Seller</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Sales Staff</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_details as $purchase)
                                        <tr class="text-success">
                                            <td style="white-space: normal;" data-sort="{{ $purchase->invoice_date }}">{{ Carbon\Carbon::parse($purchase->invoice_date)->format('Y-m-d') }}</td>
                                            <td style="white-space: normal;">
                                                <a href="{{ route('purchase.show',$purchase->purchase_id) }}" target="_blank">
                                                    {{ $purchase->invoice_no }}
                                                </a>
                                            </td>
                                            @php
                                                $seller = DB::table('sellers')->where('id', $purchase->seller_details)->first();
                                            @endphp
                                            <td style="white-space: normal;">{{ $seller->seller_name }}</td>
                                            <td style="white-space: normal;"></td>
                                            <td style="white-space: normal;">₹ {{ $purchase->purchase_price }}</td>
                                            <td style="white-space: normal;">{{ $purchase->product_quantity }}</td>
                                            <td style="white-space: normal;"></td>
                                        </tr>
                                    @endforeach
                                    @foreach ($direct_sales as $direct_sale)
                                        <tr class="text-danger">
                                            <td style="white-space: normal;" data-sort="{{ $direct_sale->sales_date }}">{{ Carbon\Carbon::parse($direct_sale->sales_date)->format('Y-m-d') }}</td>
                                            <td style="white-space: normal;">
                                                <a href="{{ route('directSales.show', $direct_sale->sales_id) }}" target="_blank">
                                                    {{ $direct_sale->invoice_number }}
                                                </a>
                                            </td>
                                            <td style="white-space: normal;">{{ $direct_sale->customer_name }}</td>
                                            <td style="white-space: normal;">{{ $direct_sale->serial_number }}</td>
                                            <td style="white-space: normal;">₹ {{ $direct_sale->sales_price }}</td>
                                            <td style="white-space: normal;">{{ $direct_sale->product_quantity }}</td>
                                            @php
                                                $staff = DB::table('staffs')->where('id', $direct_sale->sales_staff)->first();
                                            @endphp
                                            <td style="white-space: normal;">{{ $staff->staff_name }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($purchase_returns as $purchase_return)
                                        <tr class="text-danger">
                                            <td style="white-space: normal;" data-sort="{{ $purchase_return->return_date }}">{{ Carbon\Carbon::parse($purchase_return->return_date)->format('Y-m-d') }}</td>
                                            <td style="white-space: normal;">
                                                <a href="{{ route('utility.purchase.debit_note', $purchase_return->return_id) }}" target="_blank">
                                                    {{ $purchase_return->invoice_number }}
                                                </a>
                                            </td>
                                            @php
                                                $purchase_details = DB::table('purchases')->where('id', $purchase_return->purchase_id)->first();
                                                $purchase_items = DB::table('purchase_items')->where('id', $purchase_return->purchase_item_id)->first();
                                                $seller = DB::table('sellers')->where('id', $purchase_details->seller_details)->first();
                                            @endphp
                                            <td style="white-space: normal;">{{ $seller->seller_name }}</td>
                                            <td style="white-space: normal;">Purchase Return</td>
                                            <td style="white-space: normal;">₹ {{ $purchase_return->total }}</td>
                                            <td style="white-space: normal;">{{ $purchase_return->quantity }}</td>
                                            <td style="white-space: normal;"></td>
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
