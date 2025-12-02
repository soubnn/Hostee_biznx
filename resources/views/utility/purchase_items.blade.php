@extends('utility.layout')
@section('content')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
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
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>GST Percentage</th>
                                                <th>Purhcase Price</th>
                                                <th>Edit</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                             @foreach($purchases as $item)


                                            <tr>
                                                <td>
                                                    @php
                                                        $product=DB::table('products')->where('id',$item->product_id)->first();
                                                    @endphp
                                                    {{ $product->product_name }}</td>
                                                <td>
                                                @php
                                                    $cat_name=DB::table('product_categories')->where('id',$product->category_id)->first();
                                                @endphp
                                                {{ $cat_name->category_name }}</td>
                                                <td>₹ {{$item->unit_price}}</td>
                                                <td>{{ $item->product_quantity }}</td>
                                                <td>{{ $item->gst_percent }} %</td>
                                                <td>₹ {{ $item->purchase_price }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#purchase{{$item->id}}">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-light waves-effect text-danger">
                                                            <i class="mdi mdi-delete font-size-18"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                                <!-- Modal -->
                <div id="purchase{{ $item->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title add-task-title">Edit Purchase</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="NewtaskForm" role="form" action="{{ route('utility_edit_purchase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Category</label>
                                    <div class="col-lg-12">
                                        @php
                                        $pro_cat=DB::table('products')->where('id',$item->product_id)->first();
                                        $cat_id=$pro_cat->category_id;
                                        $cat_name=DB::table('product_categories')->where('id',$cat_id)->first();
                                    @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $cat_name->category_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Product Code</label>
                                    <div class="col-lg-12">
                                        @php
                                        $pro_name=DB::table('products')->where('id',$item->product_id)->first();
                                    @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $pro_name->product_code }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Product Name</label>
                                    <div class="col-lg-12">
                                        @php
                                                $pro_name=DB::table('products')->where('id',$item->product_id)->first();
                                            @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $pro_name->product_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone1" class="col-form-label">Price</label>
                                    <div class="col-lg-12">
                                        <input id="phone1" name="price" type="number" class="form-control validate" placeholder="" Value="{{$item->unit_price}}">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone2" class="col-form-label">Quantity</label>
                                    <div class="col-lg-12">
                                        <input id="phone2" name="qty" type="number" class="form-control validate" placeholder="" Value="{{ $item->product_quantity }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Updating...';this.form.submit();">Update Changes</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


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
