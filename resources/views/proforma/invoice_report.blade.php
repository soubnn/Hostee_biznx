@extends('layouts.layout')
@section('content')
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Estimate</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row" id="printBody">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="invoice-title">
                                            @php
                                                $current_month = Carbon\carbon::now()->format('m');
                                                $current_year = Carbon\carbon::now()->format('y');
                                                if($current_month > 4){
                                                    $next_year = $current_year+1;
                                                    $est_string = $current_year.$next_year;
                                                }
                                                else{
                                                    $prev_year = $current_year-1;
                                                    $est_string = $prev_year.$current_year;
                                                }

                                            @endphp
                                            <h4 class="float-end font-size-16">Invoice No : <span style="color:red:">{{ 'EST'.$estimate->id.$est_string }}</span></h4>
                                            <div class="mb-4">
                                                <img src="{{ asset('assets/images/tslogo-dark.png') }}" alt="logo" height="40"/>
                                            </div>
                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <address>
                                                    <strong>Invoice To:</strong><br>
                                                    {{ $estimate->customer_name }}<br>
                                                    {{ $estimate->customer_phone }}
                                                </address>
                                            </div>
                                            <div class="col-sm-6 col-md-6 text-sm-end">
                                                <address>
                                                    <strong>Invoice Date:</strong><br>
                                                        {{ Carbon\carbon::parse($estimate->invoice_date)->format('d F Y')  }}
                                                    {{-- <br><br> --}}
                                                </address>
                                            </div>
                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="py-2 mt-3" style="text-align: center;">
                                            <h3 class="font-size-18 fw-bold">Invoice Details</h3>
                                        </div>
                                        <div class="py-2 mt-3">
                                            <h3 class="font-size-15 fw-bold">Invoice summary</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">No.</th>
                                                        <th>Product</th>
                                                        <th class="text-end">Price</th>
                                                        <th class="text-end">Qty</th>
                                                        @if ($gst_count > 0)
                                                            <th class="text-end">Taxable</th>
                                                            <th class="text-end">GST(%)</th>
                                                            <th class="text-end">Tax</th>
                                                        @endif
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-transform: uppercase;">
                                                    @php
                                                        $i=1;
                                                    @endphp
                                                    @foreach ( $estimate_details as $estimate_details)
                                                        @if($estimate_details->product_name)
                                                            <tr>
                                                                <td>{{ $i }}</td>

                                                                @php
                                                                    $get_product = DB::table('products')->where('id',$estimate_details->product_name)->first();
                                                                @endphp
                                                                @if ($get_product)
                                                                    @php
                                                                    $name_length = strlen($get_product->product_name);
                                                                    @endphp
                                                                    @if ($name_length > 50 && $name_length < 100)
                                                                        @php
                                                                            $product_name1 = substr($get_product->product_name,0,50);
                                                                            $product_name2 = substr($get_product->product_name,50);
                                                                        @endphp
                                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                    @elseif($name_length > 100)
                                                                        @php
                                                                            $product_name1 = substr($get_product->product_name,0,50);
                                                                            $product_name2 = substr($get_product->product_name,50,50);
                                                                            $product_name3 = substr($get_product->product_name,100);
                                                                        @endphp
                                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @else
                                                                        <td>{{ $get_product->product_name }}</td>
                                                                    @endif
                                                                @else
                                                                    @php
                                                                    $name_length = strlen($estimate_details->product_name);
                                                                    @endphp
                                                                    @if ($name_length > 50 && $name_length <= 100)
                                                                        @php
                                                                            $product_name1 = substr($estimate_details->product_name,0,50);
                                                                            $product_name2 = substr($estimate_details->product_name,50);
                                                                        @endphp
                                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                    @elseif($name_length > 100 && $name_length <= 150)
                                                                        @php
                                                                            $product_name1 = substr($estimate_details->product_name,0,50);
                                                                            $product_name2 = substr($estimate_details->product_name,50,50);
                                                                            $product_name3 = substr($estimate_details->product_name,100);
                                                                        @endphp
                                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @elseif($name_length > 150)
                                                                        @php
                                                                            $product_name1 = substr($estimate_details->product_name,0,50);
                                                                            $product_name2 = substr($estimate_details->product_name,50,50);
                                                                            $product_name3 = substr($estimate_details->product_name,100,50);
                                                                            $product_name4 = substr($estimate_details->product_name,150);
                                                                        @endphp
                                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}</td>
                                                                    @else
                                                                        <td>{{ $estimate_details->product_name }}</td>
                                                                    @endif
                                                                @endif
                                                                <td class="text-end">₹{{ $estimate_details->unit_price }}</td>
                                                                <td class="text-end">{{ $estimate_details->qty }}</td>
                                                                @if ($gst_count > 0)
                                                                    @php
                                                                        $amount = $estimate_details->unit_price * $estimate_details->qty;
                                                                    @endphp
                                                                    <td class="text-end">₹{{ $amount }}</td>
                                                                    <td class="text-end">{{ $estimate_details->product_tax }}</td>
                                                                    @php
                                                                        $gst = $amount * ($estimate_details->product_tax/100);
                                                                    @endphp
                                                                    <td class="text-end">₹{{ $gst }}</td>
                                                                @endif
                                                                <td class="text-end">₹{{ $estimate_details->total }}</td>
                                                            </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        @endif

                                                    @endforeach
                                                    <tr>
                                                        @if ($gst_count > 0)
                                                            <td colspan="7" class="border-0 text-end">
                                                        @else
                                                            <td colspan="4" class="border-0 text-end">
                                                        @endif
                                                            <strong>Grand Total</strong></td>
                                                        <td class="border-0 text-end"><h5 class="m-0">{{ $estimate->grand_total }}</h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="{{ route('generate_invoice',$estimate->id ) }}" target="_blank">
                                                    <button type="button"  class="btn btn-success waves-effect waves-light me-1">
                                                        <i class="fa fa-print"></i>
                                                        <span style="margin-left:10px;font-weight:500;">Print Invoice</span>
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
