@extends('layouts.layout')
@section('content')
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"> purchase Order</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row" id="printBody">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="invoice-title">
                                            <h4 class="float-end font-size-16">Purchase Order No : <span style="color:red:">{{ $purchase_order->purchase_order_number }}</span></h4>
                                            <div class="mb-4">
                                                <img src="{{ asset('assets/images/tslogo-dark.png') }}" alt="logo" height="40"/>
                                            </div>
                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <address>
                                                    <strong>Purchase Order To:</strong><br>
                                                    {{ $purchase_order->seller_mobile }}<br>
                                                    {{ $purchase_order->seller_name }}
                                                </address>
                                            </div>
                                            <div class="col-sm-6 col-md-6 text-sm-end">
                                                <address>
                                                    <strong>Purchase Order Date:</strong><br>
                                                        {{ $purchase_order->purchase_order_date  }}
                                                    {{-- <br><br> --}}
                                                </address>
                                            </div>
                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="py-2 mt-3" style="text-align: center;">
                                            <h3 class="font-size-18 fw-bold">Purchase Order Details</h3>
                                        </div>
                                        <div class="py-2 mt-3">
                                            <h3 class="font-size-15 fw-bold">Purchase Order summary</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">No.</th>
                                                        <th>Product</th>
                                                        <th class="text-end">Qty</th>
                                                        <th class="text-end">Price</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-transform: uppercase;">
                                                    @php
                                                        $i=1;
                                                    @endphp
                                                    @foreach ($purchase_order_details as $purchase_order_detail)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            @php
                                                                $get_product = DB::table('products')->where('id',$purchase_order_detail->product_name)->first();
                                                            @endphp
                                                            @if ($get_product)
                                                                <td style="white-space: normal">{{ $get_product->product_name }}</td>
                                                            @else
                                                                <td style="white-space: normal">{{ $purchase_order_detail->product_name }}</td>
                                                            @endif
                                                            <td class="text-end">{{ $purchase_order_detail->qty }}</td>
                                                            <td class="text-end">{{ $purchase_order_detail->unit_price }}</td>
                                                            <td class="text-end">{{ $purchase_order_detail->total }}</td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2" class="border-0 text-end">
                                                            <strong>Total Quantity</strong>
                                                        </td>
                                                        <td class="border-0 text-end"><h5 class="m-0" id="Qty">{{ $totalQty }}</h5></td>
                                                        <td class="border-0 text-end">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="border-0 text-end"><h5 class="m-0">{{ $purchase_order->grand_total }}</h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="{{ route('generate_purchase_order',$purchase_order->id ) }}" target="_blank">
                                                    <button type="button"  class="btn btn-success waves-effect waves-light me-1">
                                                        <i class="fa fa-print"></i>
                                                        <span style="margin-left:10px;font-weight:500;">Print Purchase Order</span>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
