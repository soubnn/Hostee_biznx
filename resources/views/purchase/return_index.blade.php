@extends('layouts.layout')
@section('content')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Returned Purchases</h4>
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
                                                    <th>Old Invoice #</th>
                                                    <th>Returned Date</th>
                                                    <th>Seller Name</th>
                                                    <th>No. of<br>Returned Items</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($returned_purchases as $purchase)
                                                    @php
                                                        $purchase_details = DB::table('purchases')->where('id',$purchase->purchase_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td style="white-space: normal">
                                                            <a href="{{ route('purchase.returned_items', $purchase->id) }}">
                                                                {{ $purchase->invoice_number }}
                                                            </a>
                                                        </td>
                                                        <td style="white-space: normal">{{ $purchase_details->invoice_no }}</td>
                                                        <td style="white-space: normal">{{ Carbon\carbon::parse($purchase->return_date)->format('d-m-Y')}}</td>
                                                        @php
                                                            $seller=DB::table('sellers')->where('id',$purchase_details->seller_details)->first();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $seller->seller_name }}</td>
                                                        @php
                                                            $purchaseCount = DB::table('purchase_return_items')->where('return_id',$purchase->id)->count();
                                                        @endphp
                                                        <td style="white-space: normal">{{$purchaseCount}}</td>
                                                        <td style="white-space: normal">
                                                            <div class="d-flex gap-3">
                                                                <a href="{{ route('purchase.returned_items', $purchase->id) }}">
                                                                    <button type="button" class="btn btn-light waves-effect text-success">
                                                                        <i class="mdi mdi-eye font-size-18"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="{{ route('utility.purchase.debit_note',$purchase->id) }}" target="_blank">
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
