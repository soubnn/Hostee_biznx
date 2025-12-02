@extends('utility.layout')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Purchase Return</h4>
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
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>gst(%)</th>
                                            <th>Purhcase Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase_items as $item)
                                            <tr>
                                                <td style="white-space: normal">
                                                    @php
                                                        $product=DB::table('products')->where('id',$item->product)->first();
                                                    @endphp
                                                    {{ $product->product_name }}</td>
                                                <td>
                                                @php
                                                    $cat_name=DB::table('product_categories')->where('id',$product->category_id)->first();
                                                @endphp
                                                {{ $cat_name->category_name }}</td>
                                                <td style="white-space: normal">{{$item->unit_price}}</td>
                                                <td style="white-space: normal">{{ $item->quantity }}</td>
                                                <td style="white-space: normal">{{ $item->tax }} %</td>
                                                <td style="white-space: normal">{{ $item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <a class="btn btn-primary" href="{{ route('utility.purchase.debit_note',$purchase->id) }}" target="_blank">Debit Note</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@endsection
