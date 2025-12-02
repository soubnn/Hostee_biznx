@extends('layouts.layout')
@section('content')

    <script type="text/javascript">
        function reload_div(){

            var div_product_select = document.getElementById('div_product_select');
            var div_product_text = document.getElementById('div_product_text');
            var product_select = document.getElementById('product_name_select');

            $("#product_name_text").removeAttr("name");

            div_product_text.style.display = 'none';
            div_product_select.style.display = 'block';
            product_select.setAttribute("name","product_name");
        }
        function get_product_details(product_id){
            console.log(product_id);
            if(product_id == 'new_product'){
                var div_product_select = document.getElementById('div_product_select');
                var div_product_text = document.getElementById('div_product_text');
                var product_text = document.getElementById('product_name_text');

                $("#product_name_select").removeAttr("name");

                div_product_select.style.display = 'none';
                div_product_text.style.display = 'block';
                product_text.setAttribute("name","product_name");

            }
            else{
                    $.ajax({
                    type : "get",
                    url : "{{ route('getProductDetails') }}",
                    dataType : "json",
                    data : {product : product_id},
                    success : function(response)
                    {
                        document.getElementById("unit_price_new").value = response.product_price;
                        change_total_new();
                    }
                });
            }
        }
        function change_total(id){
            var unit_price  = document.getElementById('unit_price_'+id).value;
            var qty         = document.getElementById('qty_'+id).value;
            var amount      = unit_price * qty;
            var gst         = document.getElementById('product_tax_'+id).value;
            var tax         = amount * (gst/100);
            var total       = amount + tax;

            taxable_input            = document.getElementById('taxable_'+id);
            gst_input                = document.getElementById('gst_'+id);
            total_input              = document.getElementById('total_'+id);
            total_hidden_input       = document.getElementById('total_hidden_'+id);
            taxable_input.value      = amount.toFixed(2);
            gst_input.value          = tax.toFixed(2);
            total_input.value        = total.toFixed(2);
            total_hidden_input.value = total.toFixed(2);
        }
        function change_total_new(){
            var unit_price      = document.getElementById('unit_price_new').value;
            var qty             = document.getElementById('qty_new').value;
            var gst             = document.getElementById('product_tax_new').value;
            var amount          = unit_price * qty;
            var tax             = amount * (gst/100);
            var total           = amount + tax;

            taxable_input       = document.getElementById('taxable_new');
            gst_input           = document.getElementById('gst_new');
            total_input         = document.getElementById('total_new');
            total_hidden_input  = document.getElementById('total_hidden_new');
            taxable_input.value = amount.toFixed(2);
            gst_input.value     = tax.toFixed(2);
            total_input.value   = total.toFixed(2);
            total_hidden_input.value = total.toFixed(2);
        }
        function get_category_products(){
            var category = document.getElementById('product_category_sel').value;
            var product_name_select = document.getElementById('product_name_select');
            $.ajax({
                type : "get",
                url : "{{ route('getCategoryProduct') }}",
                dataType : "json",
                data : {category : category},
                success : function(response)
                {
                    product_name_select.innerHTML = '';
                    var newOption1 = document.createElement("option");
                    newOption1.setAttribute("value","");
                    newOption1.innerHTML = "Select Product";
                    product_name_select.appendChild(newOption1);
                    var newOption2 = document.createElement("option");
                    newOption2.setAttribute("value","new_product");
                    newOption2.innerHTML = "{ New Product }";
                    product_name_select.appendChild(newOption2);
                    for(var i = 0; i < response.length; i++)
                    {
                        var new_dynamic_option = document.createElement("option");
                        new_dynamic_option.setAttribute("value",response[i].id);
                        new_dynamic_option.innerHTML = response[i].product_name;
                        product_name_select.appendChild(new_dynamic_option);
                    }
                }
            });

        }
    </script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Estimate</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Estimate Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>
                                        <form action="{{ route('estimate.update',$estimate->id) }}" method="POST">
                                            @csrf
                                            @method("PATCH")
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="customer_name">Customer Name</label>
                                                        <input name="customer_name" class="form-control" type="text" value="{{ old('customer_name', $estimate->customer_name) }}">
                                                        @error('customer_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="customer_phone">Customer Phone</label>
                                                        <input name="customer_phone" class="form-control" type="text" value="{{ old('customer_phone', $estimate->customer_phone) }}">
                                                        @error('customer_phone')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="valid_upto">Valid Upto</label>
                                                        <input name="valid_upto" class="form-control" type="date" value="{{ Carbon\carbon::parse($estimate->valid_upto)->format('Y-m-d') }}">
                                                        @error('valid_upto')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12" id="product_div">
                                                    <div class="row">
                                                        <div class="d-flex flex-wrap gap-2 col-md-2">
                                                            <button type="submit" class="btn btn-success waves-effect waves-light mb-3" id="purchaseSubmitBtn">Save Details</button>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 col-md-2">
                                                            <a href="{{ route('estimate.show',$estimate->id) }}"><button type="button" class="btn btn-primary waves-effect waves-light mb-3">Go back</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Estimate Items</h4>
                                        <table class="table" id="productsTable" style="width: 100%;text-transform:uppercase;">
                                            <colgroup>
                                                @if ($estimate->estimate_type == 'Product')
                                                    <col span="1" width="35%">
                                                @elseif ($estimate->estimate_type == 'System')
                                                    <col span="1" width="8%">
                                                    <col span="1" width="27%">
                                                @endif
                                                <col span="1" width="20%">
                                                <col span="1" width="20%">
                                                <col span="1" width="10%">
                                                <col span="1" width="7%">
                                                <col span="1" width="8%">
                                            </colgroup>
                                            <thead>
                                                @if($estimate->estimate_type == 'Product')
                                                    <th>PRODUCT</th>
                                                @elseif ($estimate->estimate_type == 'System')
                                                    <th>CATEGORY</th>
                                                    <th>PRODUCT</th>
                                                @endif
                                                <th>WARRENTY</th>
                                                <th>UNIT PRICE</th>
                                                <th>QTY</th>
                                                <th>TAXABLE</th>
                                                <th>GST(%)</th>
                                                <th>TAX</th>
                                                <th>TOTAL</th>
                                                <th>Actions</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($estimate_items as $item)
                                                    <tr>
                                                        @if ($estimate->estimate_type == 'System')
                                                            <td>{{ $item->product_category }}</td>
                                                        @endif
                                                        @php
                                                        $productDetails = DB::table('products')->where('id',$item->product_name)->first();
                                                        @endphp
                                                        @if($productDetails)
                                                            <td>{{ $productDetails->product_name }}</td>
                                                        @else
                                                            <td>{{ strtoupper($item->product_name) }}</td>
                                                        @endif
                                                        <td>{{ $item->warrenty }}</td>
                                                        <td>{{ $item->unit_price }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        @php
                                                            $amount = $item->unit_price * $item->qty;
                                                        @endphp
                                                        <td>{{ $amount }}</td>
                                                        <td>{{ $item->product_tax }}</td>
                                                        @php
                                                            $gst = $amount * ($item->product_tax/100);
                                                        @endphp
                                                        <td>{{ $gst }}</td>
                                                        <td>{{ $item->total }}</td>
                                                        <td>
                                                            <i class="bx bx-pencil text-primary" data-bs-toggle="modal" data-bs-target="#edit_item{{ $item->id }}"></i>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <i class="bx bx-trash text-danger" data-bs-toggle="modal" data-bs-target="#delete_item{{ $item->id }}"></i>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div id="edit_item{{ $item->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title add-task-title">Edit Estimate Item</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('estimate.edit.items',$item->id) }}">
                                                                    @csrf
                                                                        <div class="row">
                                                                            @if( $estimate->estimate_type == 'System')
                                                                                <div class="col-sm-6">
                                                                                    <div class="mb-3">
                                                                                        <label for="date">Category</label>
                                                                                        <input type="text" class="form-control" value="{{ $item->product_category }}" style="text-transform:uppercase;" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            @php
                                                                                $get_product = DB::table('products')->where('id',$item->product_name)->first();
                                                                            @endphp
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label for="Product">Product</label>
                                                                                    @if ($get_product)
                                                                                        <input type="text" name="product_name" class="form-control upper-case" value="{{ $get_product->product_name }}">
                                                                                    @else
                                                                                        <input type="text" name="product_name" class="form-control upper-case" value="{{ $item->product_name }}">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label for="contact_no">Warrenty</label>
                                                                                    <input type="text" name="warrenty" class="form-control upper-case" value="{{ $item->warrenty }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label for="job_role">Unit Price</label>
                                                                                    <input type="number" min="0" step="0.1" name="unit_price" id="unit_price_{{ $item->id }}" class="form-control upper-case" Value="{{ $item->unit_price }}" onkeypress="change_total({{ $item->id }})" onkeyup="change_total({{ $item->id }})" onchange="change_total({{ $item->id }})">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label for="Quantity">Quantity</label>
                                                                                    <input type="number" name="qty" min="0" step="0.5" id="qty_{{ $item->id }}" class="form-control upper-case validate" Value="{{ $item->qty }}" onkeypress="change_total({{ $item->id }})" onkeyup="change_total({{ $item->id }})" onchange="change_total({{ $item->id }})">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label class="col-form-label">Taxable</label>
                                                                                    <input type="text" id="taxable_{{ $item->id }}" class="form-control upper-case" Value="{{ $amount }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label class="col-form-label">GST%</label>
                                                                                    <select class="form-control select2" name="product_tax" id="product_tax_{{ $item->id }}" data-dropdown-parent="#edit_item{{ $item->id }}" style="width: 100%;" onchange="change_total({{ $item->id }})">
                                                                                        <option value="0" @if($item->product_tax == '0') selected @endif>0</option>
                                                                                        <option value="3" @if($item->product_tax == '3') selected @endif>3</option>
                                                                                        <option value="5" @if($item->product_tax == '5') selected @endif>5</option>
                                                                                        <option value="12" @if($item->product_tax == '12') selected @endif>12</option>
                                                                                        <option value="18" @if($item->product_tax == '18') selected @endif>18</option>
                                                                                        <option value="28" @if($item->product_tax == '28') selected @endif>28</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label class="col-form-label">Tax</label>
                                                                                    <input type="text" id="gst_{{ $item->id }}" class="form-control upper-case" Value="{{ $gst }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="mb-3">
                                                                                    <label class="col-form-label">Total</label>
                                                                                    <input type="text" id="total_{{ $item->id }}" class="form-control upper-case" Value="{{ $item->total }}" readonly>
                                                                                    <input type="hidden" name="total" id="total_hidden_{{ $item->id }}" Value="{{ $item->total }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    <!-- Delete Modal -->
                                                    <div id="delete_item{{ $item->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-body" style="background-color: rgb(224, 221, 221);">
                                                                        <form method="Post" action="{{ route('estimate.delete_item', $item->id) }}">
                                                                            @csrf
                                                                            <div class="form-group mb-3">
                                                                                <div class="col-lg-12 text-center">
                                                                                    <i class="dripicons-warning text-danger" style="font-size: 50px;">
                                                                                    </i>
                                                                                    <h4>Are You Sure ??</h4>
                                                                                    <p style="font-weight: 300px;font-size:18px;">
                                                                                        You can't be revert this!
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-info" id="addtask">Yes, delete</button>
                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div>
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button class="btn btn-success" type="button" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#new_item">Add New Item</button>
                                    </div>
                                </div>
                                <!-- end card-->

                                <!-- Modal -->
                                <div id="new_item" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title add-task-title">Add New Item</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form  method="POST" action="{{ route('estimate.new_item') }}">
                                                @csrf
                                                    <div class="row">
                                                        @if( $estimate->estimate_type == 'System')
                                                            @php
                                                                $categories = DB::table('product_categories')->get();
                                                            @endphp
                                                            <div class="col-sm-6">
                                                                <div class="mb-3">
                                                                    <label for="Category">Category</label>
                                                                    <select class="form-select select2" name="product_category" id="product_category_sel" style="width: 100%" data-dropdown-parent="#new_item" onchange="get_category_products()">
                                                                        <option selected disabled>Select Category</option>
                                                                        @foreach ( $categories as $category )
                                                                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3" id="div_product_select">
                                                                    <label for="product">Product</label>
                                                                    <select class="form-select select2" id="product_name_select" name="product_name" style="width: 100%" data-dropdown-parent="#new_item" onchange="get_product_details(this.value);">

                                                                    </select>
                                                                </div>
                                                                <div class="mb-3" id="div_product_text" style="display: none;">
                                                                    <label for="product">Product</label>
                                                                    <input type="text" id="product_name_text" class="form-control" name="" onkeyup="this.value = this.value.toUpperCase()">
                                                                    <i class="text-success bx bx-repost" id="reload" style="font-size: 20px;" onclick="reload_div()"></i>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-6">
                                                                @php
                                                                    $products = DB::table('products')->get();
                                                                @endphp
                                                                <div class="mb-3" id="div_product_select">
                                                                    <label for="product">Product</label>
                                                                    <select class="form-select select2" onchange="get_product_details(this.value);" id="product_name_select" name="product_name" style="width: 100%" data-dropdown-parent="#new_item">
                                                                        <option selected disabled>Select Product</option>
                                                                        <option value="new_product">{ new product }</option>
                                                                        @foreach ( $products as $product )
                                                                            <option value="{{ $product->id }}" {{ old('product_name' == $product->id ? 'selected' : '') }}>{{ $product->product_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3" id="div_product_text" style="display: none;">
                                                                    <label for="product">Product</label>
                                                                    <input type="text" id="product_name_text" class="form-control" name="" onkeyup="this.value = this.value.toUpperCase()">
                                                                    <i class="text-success bx bx-repost" id="reload" style="font-size: 20px;" onclick="reload_div()"></i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="contact_no">Warrenty</label>
                                                                <input type="text" name="warrenty" class="form-control upper-case" value="{{ old('warrenty') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="job_role">Unit Price</label>
                                                                <input type="number" min="0" step="0.1" name="unit_price" id="unit_price_new" class="form-control upper-case" Value="{{ old('unit_price') }}" onkeypress="change_total_new()" onkeyup="change_total_new()" onchange="change_total_new()">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="Quantity">Quantity</label>
                                                                <input type="number" name="qty" min="0" step="0.5" id="qty_new" value="1" class="form-control upper-case validate" Value="{{ old('qty') }}" onkeypress="change_total_new()" onkeyup="change_total_new()" onchange="change_total_new()">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="col-form-label">Taxable</label>
                                                                <input type="text" id="taxable_new" class="form-control upper-case" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="col-form-label">GST%</label>
                                                                <select class="form-control select2" name="product_tax" id="product_tax_new" data-dropdown-parent="#new_item" style="width: 100%;" onchange="change_total_new()">
                                                                    <option value="0">0</option>
                                                                    <option value="3">3</option>
                                                                    <option value="5">5</option>
                                                                    <option value="12">12</option>
                                                                    <option value="18" selected>18</option>
                                                                    <option value="28">28</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="col-form-label">Tax</label>
                                                                <input type="text" id="gst_new" class="form-control upper-case" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="total">Total</label>
                                                                <input type="text" id="total_new" class="form-control upper-case" Value="0" readonly>
                                                                <input type="hidden" name="total" id="total_hidden_new" Value="0">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="{{ $item->estimate_id }}" name="estimate_id">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.innerHTML='Adding...';this.form.submit();">Add Details</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
