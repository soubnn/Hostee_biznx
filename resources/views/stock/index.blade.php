@extends('layouts.layout')
@section('content')
<!--<script>-->
<!--$(document).ready(function(){-->
<!--    $("#datatable").dataTable({-->
<!--        "pageLength" : 50-->
<!--    });-->
<!--});-->
<!--</script>-->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Stock</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div style="padding-left: 15px;">
                                        <a href="{{ route('stock.export.csv') }}" class="btn btn-primary mt-3" target="_blank">
                                            Generate Excel
                                        </a>
                                        <a href="{{ route('stockout_product') }}">
                                            <button class="btn btn-primary mt-3" type="button" style="float:right;margin-right:20px;">View Stock Out Product</button>
                                        </a>
                                        <button class="btn btn-primary mt-3" type="button" style="float:right;margin-right:20px;" data-bs-toggle="modal" data-bs-target="#balance_modal">View Stock Balance</button>
                                    </div>
                                    <!-- balance modal -->
                                    <div id="balance_modal" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title add-task-title">Stock Balance</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label for="taskname" class="col-form-label">Current Stock Balance</label>
                                                        <div class="col-lg-12">
                                                            @php
                                                                // $stock_balance = DB::table('stocks')->where('product_qty','>','0')->sum('product_unit_price * product_qty')->get();
                                                                $stock_balance = DB::table('stocks')->select(DB::raw('sum(product_unit_price * product_qty) as total'))->whereNotIn('product_id',[159,162])->get();
                                                            @endphp
                                                            <input type="text" class="form-control validate" placeholder="" value="{{ $stock_balance[0]->total }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $stock = DB::table('stocks')->get();
                                                @endphp
                                                @foreach($stock as $stock)
                                                    @if($stock->product_qty < 1)
                                                        <tr class="text-danger">
                                                    @else
                                                        <tr>
                                                    @endif
                                                        @php
                                                            $product = DB::table('products')->where('id',$stock->product_id)->first();
                                                        @endphp
                                                        <td style="white-space: normal;">{{ $product->product_name  }}</td>
                                                        <td>
                                                            {{ $product->product_code }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $pro_cat=DB::table('products')->where('id',$stock->product_id)->first();
                                                                $cat_id=$pro_cat->category_id;
                                                                $cat_name=DB::table('product_categories')->where('id',$cat_id)->first();
                                                            @endphp
                                                            {{ $cat_name->category_name }}
                                                        </td>
                                                        @if($product->product_selling_price)
                                                            <td>₹ {{$product->product_selling_price}}</td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{ $stock->product_qty }}</td>
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
