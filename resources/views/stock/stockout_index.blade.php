@extends('layouts.layout')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View Stock Out Products</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
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
                                        @foreach($stocks as $stock)
                                            <tr class="text-danger">
                                                @php
                                                    $pro_name=DB::table('products')->where('id',$stock->product_id)->first();
                                                    $name_length = strlen($pro_name->product_name );
                                                @endphp
                                                @if ($name_length > 30 && $name_length < 60)
                                                    @php
                                                        $product_name1 = substr($pro_name->product_name ,0,30);
                                                        $product_name2 = substr($pro_name->product_name ,30);
                                                    @endphp
                                                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                @elseif($name_length > 60)
                                                    @php
                                                        $product_name1 = substr($pro_name->product_name ,0,30);
                                                        $product_name2 = substr($pro_name->product_name ,30,30);
                                                        $product_name3 = substr($pro_name->product_name ,60);
                                                    @endphp
                                                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                @else
                                                    <td>{{ $pro_name->product_name  }}</td>
                                                @endif
                                                <td>
                                                    {{ $pro_name->product_code }}
                                                </td>
                                                <td>
                                                    @php
                                                        $pro_cat=DB::table('products')->where('id',$stock->product_id)->first();
                                                        $cat_id=$pro_cat->category_id;
                                                        $cat_name=DB::table('product_categories')->where('id',$cat_id)->first();
                                                    @endphp
                                                    {{ $cat_name->category_name }}
                                                </td>
                                                @if($pro_name->product_selling_price)
                                                    <td>₹ {{$pro_name->product_selling_price}}</td>
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
