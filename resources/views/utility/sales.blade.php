@extends('utility.layout')
@section('content')
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
                            <h4 class="mb-sm-0 font-size-18">Sales Management</h4>
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
                                                <td style="white-space:normal;" data-sort="">
                                                    <a href="{{ route('util_sales_details', $sale->id) }}">{{ $sale->invoice_number }}</a>
                                                </td>
                                                <td style="white-space:normal;">
                                                    @if ($sale->sales_date)
                                                    {{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}
                                                    @endif
                                                </td>
                                                @php
                                                    $customer=DB::table('customers')->where('id',$sale->customer_id)->first();
                                                @endphp
                                                <td style="white-space:normal;">{{ $customer->name }}</td>
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
                                                <td style="white-space:normal;">{{$purchaseCount}}</td>
                                                <td style="white-space:normal;">{{$amount}}</td>
                                                <td>
                                                    @if($purchaseCount > 0)
                                                        <a class="btn btn-light waves-effect text-success" href="{{ route('util_sales_details', $sale->id) }}">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-light waves-effect text-success" disabled>
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </button>
                                                    @endif
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
