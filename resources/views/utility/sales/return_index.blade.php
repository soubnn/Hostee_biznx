@extends('utility.layout')
@section('content')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Returned Sales</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>Returned Date</th>
                                                    <th>Customer Name</th>
                                                    <th>No. of<br>Returned Items</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($returned_sales as $sale)
                                                    @php
                                                        $sale_details = DB::table('direct_sales')->where('id',$sale->sale_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td style="white-space: normal">
                                                            <a href="{{ route('utility.sales.returned_items', $sale->id) }}">
                                                                {{ $sale_details->invoice_number }}
                                                            </a>
                                                        </td>
                                                        <td style="white-space: normal">
                                                            {{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}
                                                        </td>
                                                        <td style="white-space: normal">{{ Carbon\carbon::parse($sale->return_date)->format('d-m-Y')}}</td>
                                                        @php
                                                            $customer=DB::table('customers')->where('id',$sale_details->customer_id)->first();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $customer->name }}</td>
                                                        @php
                                                            $saleCount = DB::table('sales_return_items')->where('return_id',$sale->id)->count();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $saleCount }}</td>
                                                        <td style="white-space: normal">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('utility.sales.returned_items', $sale->id) }}">
                                                                    <button type="button" class="btn btn-light waves-effect text-success">
                                                                        <i class="mdi mdi-eye font-size-18"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="{{ route('utility.sales.credit_note',$sale->id) }}" target="_blank">
                                                                    <button type="button" class="btn btn-light waves-effect text-primary">
                                                                        <i class="mdi mdi-printer-settings font-size-18"></i>
                                                                    </button>
                                                                </a>
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
