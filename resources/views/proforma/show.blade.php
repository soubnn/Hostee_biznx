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
function change_total(id){
    var unit_price = document.getElementById('unit_price_'+id).value;
    var qty = document.getElementById('qty_'+id).value;
    var total = unit_price * qty;
    total_input = document.getElementById('total_'+id);
    total_hidden_input = document.getElementById('total_hidden_'+id);
    total_input.value = total.toFixed(2);
    total_hidden_input.value = total.toFixed(2);
}
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Invoice Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h4 class="card-title mb-4">Invoice Details</h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-wrap gap-2" style="float: right;">
                                                    <a href="{{ route('invoice_report',$estimate->id) }}">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light">Generate Invoice</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Qty</th>
                                                    <th>GST</th>
                                                    <th>Total</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($estimate_details as $estimate_details)
                                                <tr>
                                                    @php
                                                        if (is_numeric($estimate_details->product_name) && ctype_digit(strval($estimate_details->product_name))) {
                                                            $get_product = DB::table('products')->where('id', $estimate_details->product_name)->first();
                                                        } else {
                                                            $get_product = null;
                                                        }
                                                    @endphp
                                                    @if ($get_product)
                                                        @php
                                                            $name_length = strlen($get_product->product_name);
                                                        @endphp
                                                        @if ($name_length > 50 && $name_length < 100)
                                                            @php
                                                                $product_name1 = substr($get_product->product_name,0,50);
                                                                $product_name2 = substr($get_product->product_name,50);
                                                            @endphp
                                                                <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                        @elseif($name_length > 100)
                                                            @php
                                                                $product_name1 = substr($get_product->product_name,0,50);
                                                                $product_name2 = substr($get_product->product_name,50,50);
                                                                $product_name3 = substr($get_product->product_name,100);
                                                            @endphp
                                                                <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                        @else
                                                            <td>{{ $get_product->product_name }}</td>
                                                        @endif
                                                    @else
                                                        @php
                                                            $name_length = strlen($estimate_details->product_name);
                                                        @endphp
                                                        @if ($name_length > 50 && $name_length <= 100)
                                                            @php
                                                                $product_name1 = substr($estimate_details->product_name,0,50);
                                                                $product_name2 = substr($estimate_details->product_name,50);
                                                            @endphp
                                                                <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                        @elseif($name_length > 100 && $name_length <= 150)
                                                            @php
                                                                $product_name1 = substr($estimate_details->product_name,0,50);
                                                                $product_name2 = substr($estimate_details->product_name,50,50);
                                                                $product_name3 = substr($estimate_details->product_name,100);
                                                            @endphp
                                                                <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                        @elseif($name_length > 150)
                                                            @php
                                                                $product_name1 = substr($estimate_details->product_name,0,50);
                                                                $product_name2 = substr($estimate_details->product_name,50,50);
                                                                $product_name3 = substr($estimate_details->product_name,100,50);
                                                                $product_name4 = substr($estimate_details->product_name,150);
                                                            @endphp
                                                                <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}</td>
                                                        @else
                                                            <td>{{ $estimate_details->product_name }}</td>
                                                        @endif
                                                    @endif
                                                    <td>{{ $estimate_details->unit_price }}</td>
                                                    <td>{{ $estimate_details->qty }}</td>
                                                    <td>{{ $estimate_details->product_tax }}%</td>
                                                    <td>{{ $estimate_details->total }}</td>
                                                    {{-- <td><button type="button" class="btn btn-light waves-effect text-info" data-bs-toggle="modal" data-bs-target="#edit{{ $estimate_details->id }}">Edit</button></td> --}}
                                                </tr>
                                                <!-- Modal -->
                                                <div id="edit{{ $estimate_details->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title">Edit Estimate</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('estimate.edit.items',$estimate_details->id) }}">
                                                                @csrf
                                                                {{-- @method('PATCH') --}}
                                                                    <div class="row">
                                                                        @php
                                                                            $get_product = DB::table('products')->where('id',$estimate_details->product_name)->first();
                                                                        @endphp
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label for="Product">Product</label>
                                                                                @if ($get_product)
                                                                                    <input type="text" name="product_name" class="form-control upper-case" value="{{ $get_product->product_name }}">
                                                                                @else
                                                                                    <input type="text" name="product_name" class="form-control upper-case" value="{{ $estimate_details->product_name }}">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label for="contact_no">Warrenty</label>
                                                                                <input type="text" name="warrenty" class="form-control upper-case" value="{{ $estimate_details->warrenty }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label for="job_role">Unit Price</label>
                                                                                <input type="number" min="0" step="0.1" name="unit_price" id="unit_price_{{ $estimate_details->id }}" class="form-control upper-case" Value="{{ $estimate_details->unit_price }}" onkeypress="change_total({{ $estimate_details->id }})" onkeyup="change_total({{ $estimate_details->id }})" onchange="change_total({{ $estimate_details->id }})">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label for="Quantity" class="col-form-label">Quantity</label>
                                                                                <input type="number" name="qty" min="0" step="0.5" id="qty_{{ $estimate_details->id }}" class="form-control upper-case validate" Value="{{ $estimate_details->qty }}" onkeypress="change_total({{ $estimate_details->id }})" onkeyup="change_total({{ $estimate_details->id }})" onchange="change_total({{ $estimate_details->id }})">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label">Total</label>
                                                                                <input type="text" id="total_{{ $estimate_details->id }}" class="form-control upper-case" Value="{{ $estimate_details->total }}" readonly>
                                                                                <input type="hidden" name="total" id="total_hidden_{{ $estimate_details->id }}" Value="{{ $estimate_details->total }}">
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
