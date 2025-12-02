@extends('layouts.layout')
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
                                    <h4 class="mb-sm-0 font-size-18">View Sellers</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <button class="btn btn-primary mt-3" type="button" style="float:right;" data-bs-toggle="modal" data-bs-target="#balance_modal">View Seller Balance</button>
                                        </div>
                                        <!-- balance modal -->
                                        @include('seller.modals.supplier-balance')
                                        <h4 class="card-title mb-4 mt-4">Sellers</h4>
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Place</th>
                                                    <th>mobile</th>
                                                    <th>Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sellers as $seller)
                                                    <tr>
                                                        <td style="text-transform: uppercase;white-space:normal;">
                                                            <a href="{{ route('seller.show',$seller->id) }}">{{ $seller->seller_name  }}</a>
                                                        </td>
                                                        <td style="text-transform: uppercase;white-space:normal;">{{ $seller->seller_city  }}</td>
                                                        <td style="text-transform: uppercase;white-space:normal;">{{$seller->seller_mobile}}</td>
                                                        <td>{{ $seller->total_balance }}</td>
                                                        <td>
                                                            <a href="{{ route('purchaseIndex',$seller->id) }}" title="View Purchases">
                                                                <button type="button" class="btn btn-light waves-effect text-info">
                                                                    <i class="mdi mdi-file font-size-18"></i>
                                                                </button>
                                                            </a>
                                                            <a title="Pay">
                                                                <button type="button" class="btn btn-light waves-effect text-info" data-bs-toggle="modal" data-bs-target="#payModal{{$seller->id}}" @if($seller->total_balance == 0) disabled @endif>
                                                                    <i class="bx bx-rupee font-size-22"></i>
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('sellerSummary',$seller->id) }}" title="View Summary">
                                                                <button type="button" class="btn btn-light waves-effect text-info">
                                                                    <i class="mdi mdi-history font-size-18"></i>
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('seller_courier',$seller->id) }}" title="Courier Address" target="_blank">
                                                                <button type="button" class="btn btn-light waves-effect text-info">
                                                                    <i class="mdi mdi-box-shadow font-size-18"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @include('seller.modals.payment')
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
