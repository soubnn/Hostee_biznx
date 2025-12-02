@extends('layouts.layout')
@section('content')
<script>
    function printDiv() {

        $('#btnPrint').hide();

        var printContents = document.getElementById('printBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.location.reload();

    }

</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Invoice</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row" id="printBody">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="invoice-title">
                                            <h4 class="float-end font-size-16">Job Card No : <span style="color:red:">{{ $consignments->invoice_no }}</span></h4>
                                            <div class="mb-4">
                                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="40"/>
                                            </div>
                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <address>
                                                    <strong>Order Date:</strong><br>
                                                        {{ Carbon\carbon::parse($consignments->date)->format('d F Y')  }}
                                                    {{-- <br><br> --}}
                                                </address>
                                            </div>
                                            <div class="col-sm-6 col-md-6 text-sm-end">
                                                <address style="text-transform:uppercase;">
                                                    <strong>Billed To:</strong><br>
                                                    {{ $consignments->customer_name }}<br>
                                                    {{ $consignments->customer_place }}<br>
                                                    {{ $consignments->phone }}<br>
                                                    {{ $consignments->email }}
                                                </address>
                                            </div>

                                        </div>
                                        <hr style="border-top: solid 1px #000 !important;">
                                        <div class="py-2 mt-3" style="text-align: center;">
                                            <h3 class="font-size-18 fw-bold">Invoice Details</h3>
                                        </div>
                                        <div class="py-2 mt-3">
                                            <h3 class="font-size-15 fw-bold">Order summary</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">No.</th>
                                                        <th>Item</th>
                                                        <th class="text-end">Price</th>
                                                        <th class="text-end">Qty</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-transform: uppercase;">
                                                    @if ($consignments->service_charge >0)
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>Service Charge</td>
                                                            <td class="text-end">₹{{ $consignments->service_charge }}</td>
                                                            <td class="text-end">1</td>
                                                            <td class="text-end">₹{{ $consignments->service_charge }}</td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                    @endif
                                                    <tr>
                                                    </tr>
                                                    @if ($consignments->parts_charge >0)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>Parts Charge</td>
                                                        <td class="text-end">₹{{ $consignments->parts_charge }}</td>
                                                        <td class="text-end">1</td>
                                                        <td class="text-end">₹{{ $consignments->parts_charge }}</td>
                                                    </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                    @endif
                                                    @php
                                                        $subtotal = $consignments->service_charge + $consignments->parts_charge;
                                                    @endphp
                                                    @if($sales != Null)

                                                        @foreach ( $sales as $sales)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            @php
                                                                $get_product = DB::table('products')->where('id',$sales->product_id)->first();
                                                            @endphp

                                                            @if($get_product == Null )
                                                                <td>{{ $sales->product_id }}</td>
                                                            @else
                                                                <td>{{ $get_product->product_name }}</td>
                                                            @endif

                                                            <td class="text-end">₹{{ $sales->price }}</td>
                                                            <td class="text-end">{{ $sales->qty }}</td>
                                                            <td class="text-end">₹{{ $sales->total }}</td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                            $subtotal = $subtotal+$sales->total;
                                                        @endphp

                                                        @endforeach
                                                    @endif
                                                    <tr>
                                                        <td colspan="4" class="text-end">Sub Total</td>
                                                        <td class="text-end">₹{{ $subtotal }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="border-0 text-end">
                                                            <strong>Advance</strong></td>
                                                        <td class="border-0 text-end">₹{{ $consignments->advance }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="border-0 text-end">
                                                            <strong>Total</strong></td>
                                                            @php
                                                                $total = $subtotal - $consignments->advance;
                                                            @endphp
                                                        <td class="border-0 text-end"><h5 class="m-0">{{ $total }}</h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <button type="button"  class="btn btn-success waves-effect waves-light me-1" id="btnPrint" onclick="printDiv();"><i class="fa fa-print"></i>
                                                    <span style="margin-left:10px;font-weight:500;">Print Invoice</span>
                                                </button>
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
