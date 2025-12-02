@extends('layouts.layout')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sales Returned Items</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Serial Number</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Taxable</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales_items as $item)
                                            <tr>
                                                <td style="white-space: normal">
                                                    @php
                                                        $product=DB::table('products')->where('id',$item->product)->first();
                                                    @endphp
                                                    {{ $product->product_name }}
                                                </td>
                                                <td style="white-space: normal">{{ $item->serial_number }}</td>
                                                <td style="white-space: normal">{{ $item->unit_price }}</td>
                                                <td style="white-space: normal">{{ $item->quantity }}</td>
                                                <td style="white-space: normal">{{ $item->unit_price * $item->quantity }}</td>
                                                <td style="white-space: normal">{{ round(($item->unit_price * $item->quantity * $item->tax)/100,2) }}</td>
                                                <td style="white-space: normal">{{ $item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <a class="btn btn-primary" href="{{ route('utility.sales.credit_note',$sale->id) }}" target="_blank">Credit Note</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@endsection
