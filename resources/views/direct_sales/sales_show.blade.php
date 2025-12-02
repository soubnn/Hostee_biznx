@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
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
                                    <h4 class="mb-sm-0 font-size-18">View Sales</h4>

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
                                                {{-- <th>GST Percentage</th> --}}
                                                <th>Total</th>

                                            </tr>
                                            </thead>


                                            <tbody>
                                            @foreach($salesItems as $item)
                                                @php
                                                    $product=DB::table('products')->where('id',$item->product_id)->first();
                                                @endphp
                                                @if($product)
                                                <tr>
                                                    <td style="white-space:normal;">
                                                        {{ $product->product_name }}</td>
                                                    <td>
                                                    @php
                                                        $cat_name=DB::table('product_categories')->where('id',$product->category_id)->first();
                                                    @endphp
                                                    {{ $cat_name->category_name }}</td>
                                                    <td>₹ {{$item->price}}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    {{-- <td></td> --}}
                                                    <td>₹ {{ $item->total }}</td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td>{{ $item->product_id }}</td>
                                                    <td>SERVICE</td>
                                                    <td>₹ {{$item->price}}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    {{-- <td></td> --}}
                                                    <td>₹ {{ $item->total }}</td>
                                                </tr>
                                                @endif
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
