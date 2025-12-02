@extends('layouts.layout')
@section('content')
<script>
    function send_message(){
        let product_name = document.getElementById('product_name').value;
        let product_price = document.getElementById('product_price').value;
        let product_warrenty = document.getElementById('product_warrenty').value;
        let contact = document.getElementById('contact_1').value;
        console.log('contact is '+contact);
        let message = "PRODUCT DETAILS \n----------------------\nPRODUCT NAME : "+product_name+"\n"+"PRICE : "+product_price+"\n"+"WARRANTY : "+product_warrenty+"\n\n -Team Techsoul";
        message = encodeURI(message);
        window.open('https://api.whatsapp.com/send/?phone=91'+contact+'&text='+message, '_blank');
    }
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Products</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="row mb-3">
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="mt-2">
                                            <h5>Products</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center" action="{{ route('products.view') }}" method="get">
                                            <div class="search-box me-2">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control border-0" placeholder="Search..." id="search" name="search" value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            <button class="btn btn-light" style="color: rgb(18, 16, 182)"><i class="bx bx-search-alt search-icon"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($products as $product)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="text-end mb-3">
                                                        <button class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#share_modal_{{ $product->id }}">
                                                            <i class="bx bx-share-alt"></i>
                                                        </button>
                                                    </div>
                                                    <a href="{{ route('product.edit',$product->id) }}" class="text-dark">
                                                        <div class="product-img position-relative" >
                                                            @if($product->product_image == '')
                                                                <img src="{{ asset('assets/images/no_image.jpg') }}" alt="" class="img-fluid mx-auto d-block product-images">
                                                            @else
                                                                <img src="{{ asset('storage/products/'.$product->product_image) }}" alt="" class="img-fluid mx-auto d-block product-images">
                                                            @endif
                                                        </div>
                                                        <div class="mt-4 text-center">
                                                            <h5 class="mb-3 text-truncate">{{ $product->product_name }}</h5>
                                                            <h5 class="my-0"><b>₹ {{ $product->product_selling_price }}</b></h5>
                                                            <h5 class="my-0"><b>MRP: ₹ {{ $product->product_mrp }}</b></h5>
                                                            @if ($product->stockDetails)
                                                                @if($product->stockDetails->product_qty > 0)
                                                                    <span class="my-0 mt-1">{{ $product->stockDetails->product_qty }} Qty Available</span>
                                                                @else
                                                                    <span class="my-0 text-danger mt-1">Out of Stock</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            @include('products.modals.share-product')
                                        </div>
                                    @endforeach
                                </div>
                                <!-- end row -->
                                <div class="d-flex justify-content-end">
                                    {{ $products->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
