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
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th>Invoice Date</th>
                                                <th>Customer Name</th>
                                                <th>No. of Items</th>
                                                <th>Amount</th>
                                                <th>View</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sales as $sale)
                                                    <tr>
                                                        <td data-sort=""  style="white-space: normal">{{ $sale->invoice_number }}</td>
                                                        <td style="white-space: normal">
                                                            {{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}
                                                        </td>
                                                        @php
                                                            $customer=DB::table('customers')->where('id',$sale->customer_id)->first();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $customer->name }}</td>
                                                        @php
                                                            $purchaseCount = DB::table('sales_items')->where('sales_id',$sale->id)->count();
                                                        @endphp
                                                        @php
                                                            if($sale->discount)
                                                            {
                                                                $discount = (float)$sale->discount;
                                                                $amount = (float)$sale->grand_total - $discount;
                                                            }
                                                            else
                                                            {
                                                                $amount = $sale->grand_total;
                                                            }
                                                        @endphp
                                                        <td style="white-space: normal">{{$purchaseCount}}</td>
                                                        <td style="white-space: normal">{{$amount}}</td>
                                                        <td style="white-space: normal">
                                                            <div class="d-flex gap-3">
                                                                @if($purchaseCount > 0)
                                                                    <a href="{{ route('utility.sales.return_items', $sale->id) }}">
                                                                        <button type="button" class="btn btn-light waves-effect text-success">
                                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                                        </button>
                                                                    </a>
                                                                @endif
                                                            </div>
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
