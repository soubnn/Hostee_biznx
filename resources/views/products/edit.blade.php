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
            <div class="main-content">

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
            </script>

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Product Details</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">

                                                <tbody>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Product Code</th>
                                                    <td colspan="6">{{ $product->product_code }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#code_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="code_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_code',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Product Code</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="product_code" value="{{ $product->product_code }}" placeholder="Enter Product Code">
                                                                        @error('product_code')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Product Name</th>
                                                    <td colspan="6">{{ $product->product_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#name_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="name_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_name',$product->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Product Name</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" placeholder="Enter Product Name">
                                                                        @error('product_name')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">HSN Code</th>
                                                    <td colspan="6">{{ $product->hsn_code }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#hsn_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="hsn_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_hsn',$product->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Customer Place</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="hsn_code" value="{{ $product->hsn_code }}" placeholder="Enter HSN Code">
                                                                        @error('hsn_code')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}


                                                <tr>
                                                    <th class="text-nowrap" scope="row">Unit Type</th>
                                                    <td colspan="6"> {{ $product->product_unit_details }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#unit_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="unit_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_unit',$product->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Unit Details</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control select2" name="product_unit_details" data-dropdown-parent="#unit_modal" style="width:100%;">
                                                                            <option value="">Select Type</option>
                                                                            <option value="No.">No.</option>
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
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Price</th>
                                                    <td colspan="6">{{ $product->product_price }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#price_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="price_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_price',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Price</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="product_price" type="number" placeholder="Enter Price" value="{{ $product->product_price }}" step="0.01">
                                                                        @error('product_price')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Selling Price</th>
                                                    <td colspan="6">{{ $product->product_selling_price }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#selling_price_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="selling_price_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_selling_price',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Selling Price</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="product_selling_price" type="number" placeholder="Enter Price" value="{{ $product->product_selling_price }}" step="0.01">
                                                                        @error('product_selling_price')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">MRP</th>
                                                    <td colspan="6">{{ $product->product_mrp }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#mrp_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="mrp_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_mrp',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">MRP</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="product_mrp" type="number" placeholder="Enter Price" value="{{ $product->product_mrp }}" step="0.01">
                                                                        @error('product_mrp')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Tax Schedule</th>
                                                    <td colspan="6">
                                                        @if ( $product->product_schedule == "SCHEDULE 1")
                                                            SCHEDULE I (0% GST)
                                                        @endif
                                                        @if ( $product->product_schedule  == "SCHEDULE 2")
                                                            SCHEDULE II (3% GST)
                                                        @endif
                                                        @if ( $product->product_schedule  == "SCHEDULE 3")
                                                            SCHEDULE III (5% GST)
                                                        @endif
                                                        @if ( $product->product_schedule  == "SCHEDULE 4")
                                                            SCHEDULE IV (12% GST)
                                                        @endif
                                                        @if ( $product->product_schedule  == "SCHEDULE 5")
                                                            SCHEDULE V (18% GST)
                                                        @endif
                                                        @if ( $product->product_schedule  == "SCHEDULE 6")
                                                            SCHEDULE VI (28% GST)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#schedule_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="schedule_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_tax_schedule',$product->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Tax Schedule</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="hidden" name="product_cgst" id="product_cgst" value="">
                                                                        <input type="hidden" name="product_sgst" id="product_sgst" value="">
                                                                        <select class="form-control select2" data-dropdown-parent="#schedule_modal" style="width:100%;" name="product_schedule" onchange="getGST(this.value)">
                                                                            <option value="">Select Schedule</option>
                                                                            <option value="SCHEDULE 1">SCHEDULE I (0% GST)</option>
                                                                            <option value="SCHEDULE 2">SCHEDULE II (3% GST)</option>
                                                                            <option value="SCHEDULE 3">SCHEDULE III (5% GST)</option>
                                                                            <option value="SCHEDULE 4">SCHEDULE IV (12% GST)</option>
                                                                            <option value="SCHEDULE 5">SCHEDULE V (18% GST)</option>
                                                                            <option value="SCHEDULE 6">SCHEDULE VI (28% GST)</option>
                                                                        </select>
                                                                        @error('product_schedule')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Category</th>
                                                    @php
                                                        $product_category = DB::table('product_categories')->where('id',$product->category_id)->first();
                                                        @endphp
                                                        <td colspan="6">{{ $product_category->category_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#category_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="category_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_category',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Category</label>
                                                                    <div class="col-lg-12">
                                                                        @php
                                                                            $categories = DB::table('product_categories')->get();
                                                                        @endphp
                                                                        <select class="form-control select2" data-dropdown-parent="#category_modal" style="width:100%;" name="category_id">
                                                                            <option value="">Select Category</option>
                                                                            @foreach ($categories as $category)
                                                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('category_id')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Warrenty</th>
                                                    <td colspan="6">{{ $product->product_warrenty }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#warrenty_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="warrenty_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product Warrenty</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_warrenty',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Warrenty</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" value="{{ $product->product_warrenty }}" name="product_warrenty">
                                                                        @error('product_warrenty')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Maximum Stock</th>
                                                    <td colspan="6">{{ $product->product_max_stock }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#max_stock_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="max_stock_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_max_stock',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Maximum Stock</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="number" class="form-control" name="product_max_stock" value="{{ $product->product_max_stock }}" min="0" step="0.01">
                                                                        @error('product_max_stock')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Expiry Date</th>
                                                    @if($product->product_expiry_date)
                                                        <td colspan="6">{{ Carbon\carbon::parse($product->product_expiry_date)->format('d-m-Y') }}</td>
                                                    @else
                                                    <td colspan="6">{{ $product->product_expiry_date }}</td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#expiry_date_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="expiry_date_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_expiry',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Expiry Date</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="date" class="form-control" name="product_expiry_date" value="{{ $product->product_expiry_date }}">
                                                                        @error('product_expiry_date')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Supplier</th>
                                                    <td colspan="6">{{ $product->product_supplier }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#supplier_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="supplier_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_supplier',$product->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Supplier</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="product_supplier" type="text" placeholder="Enter Supplier" value="{{ $product->product_supplier }}">
                                                                        @error('product_supplier')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Brand</th>
                                                    <td colspan="6">{{ $product->product_brand }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#brand_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="brand_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_brand',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Brand</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="product_brand" value="{{ $product->product_brand }}" placeholder="Enter Brand">
                                                                        @error('product_brand')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Description</th>
                                                    <td colspan="6">
                                                        {{ $product->product_description }}
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#description_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="description_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_description',$product->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Description</label>
                                                                    <div class="col-lg-12">
                                                                        <textarea  class="form-control" name="product_description" rows="4">{{ $product->product_description }}</textarea>
                                                                        @error('product_description')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Image</th>
                                                    <td colspan="6">
                                                        @if ($product->product_image)

                                                            <img src="{{ asset('storage/products/' . $product->product_image) }}" width="20%">
                                                        @else
                                                        {{ $product->product_image }}
                                                        @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#image_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="image_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_image',$product->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Image</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="file" class="form-control" name="product_image" rows="4">
                                                                        @error('product_image')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}



                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
