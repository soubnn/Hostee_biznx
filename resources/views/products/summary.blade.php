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
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View product</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Products</h4>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Supplier</th>
                                            <th>Sales</th></th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td style="white-space: normal;">{{ $product->product_name }}</td>
                                                <td style="white-space: normal;">{{ $product->category_details->category_name }}</td>
                                                <td style="white-space: normal;">{{ $product->product_supplier }}</td>
                                                <td style="white-space: normal;">{{ $product->sales_items_count }}</td>
                                                <td><a href="{{ route('product.summary_items',$product->id) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
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
@endsection
