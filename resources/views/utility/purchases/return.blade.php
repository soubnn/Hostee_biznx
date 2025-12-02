@extends('utility.layout')
@section('content')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Purchase Management</h4>
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
                                                    <th>Seller Name</th>
                                                    <th>No. of Items</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchases as $purchase)
                                                    <tr>
                                                        <td style="white-space: normal" data-sort="">{{ $purchase->invoice_no }}</td>
                                                        <td style="white-space: normal">
                                                            @if ($purchase->invoice_date)
                                                            {{ Carbon\carbon::parse($purchase->invoice_date)->format('d-m-Y')}}
                                                            @endif
                                                        </td>
                                                        @php
                                                            $seller=DB::table('sellers')->where('id',$purchase->seller_details)->first();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $seller->seller_name }}</td>
                                                        @php
                                                            $purchaseCount = DB::table('purchase_items')->where('purchase_id',$purchase->id)->count();
                                                        @endphp
                                                        <td style="white-space: normal">{{$purchaseCount}}</td>
                                                        <td style="white-space: normal">
                                                            <div class="d-flex gap-3">
                                                                <a href="{{ route('utility.purchase.return_items', $purchase->id) }}">
                                                                    <button type="button" class="btn btn-light waves-effect text-success">
                                                                        <i class="mdi mdi-eye font-size-18"></i>
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
