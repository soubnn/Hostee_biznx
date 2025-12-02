@extends('utility.layout')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sales Return</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label>Invoice Number</label>
                                        <input type="text" value="{{ $salesDetails->invoice_number }}" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Sales Date</label>
                                        <input type="text" value="{{ carbon\Carbon::parse($salesDetails->sales_date)->format('d-m-Y') }}" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Customer</label>
                                        @php
                                            $customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
                                        @endphp
                                        <input type="text" value="{{ $customer->name }}" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Sales Person</label>
                                        @php
                                            $staff = DB::table('staffs')->where('id',$salesDetails->sales_staff)->first();
                                        @endphp
                                        <input type="text" value="{{ $staff->staff_name }}" class="form-control" readonly>
                                    </div>
                                    @php
                                        $amountPaid = DB::table('daybooks')->where('type','Income')->where('job',$salesDetails->invoice_number)->where('income_id','FROM_INVOICE')->sum('amount');
                                    @endphp
                                    <div class="col-md-3 mb-3">
                                        <label>Total</label>
                                        <input type="text" value="{{ $salesDetails->grand_total }}" class="form-control" id="grand_total" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Discount</label>
                                        <input type="text" value="{{ $salesDetails->discount }}" class="form-control" name="discount" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Grand Total</label>
                                        <input type="text" value="{{ ($salesDetails->grand_total) - ($salesDetails->discount) }}" id="discounted_total" class="form-control" readonly>
                                    </div>
                                </div>
                                <h4 class="mt-3">Sales Items</h4>
                                <table class="table table-bordered dt-responsive mt-3 nowrap w-100" style="text-transform: uppercase;">
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
                                        @foreach($sales as $item)
                                            <tr>
                                                <td>
                                                    @php
                                                        $product=DB::table('products')->where('id',$item->product_id)->first();
                                                    @endphp
                                                    {{ $product->product_name }}</td>
                                                <td>
                                                {{ $item->serial_number }}</td>
                                                <td>₹ {{ $item->unit_price }}</td>
                                                <td>{{ $item->product_quantity }}</td>
                                                <td>₹ {{ $item->unit_price * $item->product_quantity }}</td>
                                                <td>₹ {{ round(($item->unit_price * $item->product_quantity * $item->gst_percent)/100,2) }}</td>
                                                <td>₹ {{ $item->sales_price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-3 mb-3">
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#return_modal">Sales Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
                @include('utility.modals.sales-return-modal')
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@endsection
