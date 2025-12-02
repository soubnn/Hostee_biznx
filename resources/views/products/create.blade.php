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
        function getGST(schedule)
        {
            if(schedule == "SCHEDULE 1")
            {
                $("#product_cgst").val('0');
                $("#product_sgst").val('0');
            }
            else if(schedule == "SCHEDULE 2")
            {
                $("#product_cgst").val('1.5');
                $("#product_sgst").val('1.5');
            }
            else if(schedule == "SCHEDULE 3")
            {
                $("#product_cgst").val('2.5');
                $("#product_sgst").val('2.5');
            }
            else if(schedule == "SCHEDULE 4")
            {
                $("#product_cgst").val('6');
                $("#product_sgst").val('6');
            }
            else if(schedule == "SCHEDULE 5")
            {
                $("#product_cgst").val('9');
                $("#product_sgst").val('9');
            }
            else if(schedule == "SCHEDULE 6")
            {
                $("#product_cgst").val('14');
                $("#product_sgst").val('14');
            }
            else if(schedule == '')
            {
                $("#product_cgst").val('');
                $("#product_sgst").val('');
            }
        }
        // add produt category
        $(document).ready(function (){

            $('#category_id').select2({
                placeholder:'Select Product Category',
                theme:'bootstrap4',
                tags:true,
            }).on('select2:close', function (){
                var element = $(this);
                var new_category = $( "#category_id option:selected" ).text().toUpperCase();

                console.log(new_category);

                if (new_category != '')
                {
                    $.ajaxSetup({
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type : "post",
                        url : "{{ route('add_category') }}",
                        dataType : "JSON",
                        data:{category_name : new_category},
                        success:function (response)
                        {
                            console.log(response);
                            if (response != "Error")
                            {
                                var newOption = "<option value='" + response.id + "' selected>" + response.category_name + "</option>";
                                $("#category_id").append(newOption);
                            }
                        }
                    });
                }
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
                                    <h4 class="mb-sm-0 font-size-18">Product Registration</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Basic Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>

                                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="product_code">Product Code</label>
                                                        <input style="text-transform: uppercase;" style="text-transform: uppercase;" id="product_code" name="product_code" type="text" class="form-control" value="{{ old('product_code') }}">
                                                        @error('product_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="productname">Product Name</label>
                                                        <input style="text-transform: uppercase;" id="productname" name="product_name" type="text" class="form-control" value="{{ old('product_name') }}">
                                                        @error('product_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        @php
                                                            $cats=DB::table('product_categories')->get();
                                                        @endphp
                                                        <label class="control-label">Category</label>
                                                        <select class="form-control select2" name="category_id" id="category_id" value="{{ old('category_id') }}" requried>
                                                            <option value="" selected disabled>Select</option>
                                                            @foreach ( $cats as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>GST Schedule</label>
                                                        <select class="form-control select2" id="product_schedule" name="product_schedule" onchange="getGST(this.value)">
                                                            <option value="">Select GST Schedule</option>
                                                            <option value="SCHEDULE 1">GST SCHEDULE I</option>
                                                            <option value="SCHEDULE 2">GST SCHEDULE II</option>
                                                            <option value="SCHEDULE 3">GST SCHEDULE III</option>
                                                            <option value="SCHEDULE 4">GST SCHEDULE IV</option>
                                                            <option value="SCHEDULE 5">GST SCHEDULE V</option>
                                                            <option value="SCHEDULE 6">GST SCHEDULE VI</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="hsn_code">HSN CODE</label>
                                                        <input id="hsn_code" name="hsn_code" type="text" class="form-control validate" placeholder="" Value="{{ old('hsn_code') }}">
                                                        @error('hsn_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_unit_details">Unit Type</label>
                                                        <select id="product_unit_details" name="product_unit_details" class="form-control validate" >
                                                            <option value="">Select Type</option>
                                                            <option value="No." selected>No.</option>
                                                            <option value="mm">in millimeters (mm)</option>
                                                            <option value="cm">in centimeters (cm)</option>
                                                            <option value="m">in meters (m)</option>
                                                            <option value="g">in grams (g)</option>
                                                            <option value="kg">in kilogram (kg)</option>
                                                            <option value="ml">in millilitres (ml)</option>
                                                            <option value="l">in litres (l)</option>
                                                        </select>
                                                        @error('product_unit_details')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_price">Price</label>
                                                        <input id="product_price" name="product_price" type="text" class="form-control validate" placeholder="" Value="{{ old('product_price') }}">
                                                        @error('product_price')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label for="tax">State GST</label>
                                                                <input id="product_sgst" name="product_sgst" type="text" class="form-control" value="{{ old('product_sgst') }}">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="tax">Central GST</label>
                                                                <input id="product_cgst" name="product_cgst" type="text" class="form-control" value="{{ old('product_cgst') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Other Details</h6>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="product_warrenty">Warrenty</label>
                                                        <input style="text-transform: uppercase;" id="product_warrenty" name="product_warrenty" type="text" class="form-control validate" placeholder="" Value="{{ old('product_warrenty')}}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_selling_price">Selling Price</label>
                                                        <input style="text-transform: uppercase;" id="product_selling_price" name="product_selling_price" type="text" class="form-control validate" placeholder="" Value="{{ old('product_selling_price') > 0 ? old('product_selling_price') : 0 }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_mrp" class="col-form-label">MRP</label>
                                                        <input style="text-transform: uppercase;" id="product_mrp" name="product_mrp" type="text" class="form-control validate" placeholder="" Value="{{ old('product_mrp') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_supplier" class="col-form-label">Supplier</label>
                                                        <select class="form-control select2" id="product_supplier" name="product_supplier">
                                                            <option selected disabled>Select</option>
                                                            @php
                                                                $sellers = DB::table('sellers')->orderby('seller_name','asc')->get();
                                                            @endphp
                                                            @foreach($sellers as $seller)
                                                            <option value="{{ $seller->seller_name }}">{{ $seller->seller_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_image">Product Image</label>
                                                        <input class="form-control" name="product_image" type="file">
                                                        @error('product_image')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="product_expiry_date">Expiry Date</label>
                                                        <input id="product_expiry_date" name="product_expiry_date" type="date" class="form-control validate" placeholder="" Value="{{ old('product_expiry_date') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_brand" class="col-form-label">Brand</label>
                                                        <input style="text-transform: uppercase;" id="product_brand" name="product_brand" type="text" class="form-control validate" placeholder="" Value="{{ old('product_brand') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_description">Product Description</label>
                                                        <textarea class="form-control" name="product_description" id="product_description" rows="5">{{ old('product_description') }}</textarea>
                                                        @error('product_description')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Save Details</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                {{-- <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Product Images</h4>

                                        <form action="https://themesbrand.com/" method="post" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>

                                            <div class="dz-message needsclick">
                                                <div class="mb-3">
                                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                </div>

                                                <h4>Drop files here or click to upload.</h4>
                                            </div>

                                        </form>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Image</button>
                                        </div>
                                    </div>


                                </div>  --}}
                                <!-- end card-->


                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
