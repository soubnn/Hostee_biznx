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
                                    <h4 class="mb-sm-0 font-size-18">View Purchases</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Generate GST Purchase Report</h4>
                                        <br>
                                        <form action="{{ route('generatePurchaseGSTReport') }}" method="get" target="_blank">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Start Date</label>
                                                    <input type="date" class="form-control" required name="startDate">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>End Date</label>
                                                    <input type="date" class="form-control" required name="endDate">
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success mt-4" value="PDF" name="output">Generate PDF</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success mt-4" value="EXCEL" name="output">Generate Excel</button>
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
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Invoice Date</th>
                                                <th>Seller Name</th>
                                                <th>Invoice #</th>
                                                <th>No. of Items</th>
                                                <th>Total Amount</th>
                                                <th>View</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                             @foreach($purchases as $purchase)


                                            <tr>
                                                <td data-sort="DDMMYYYY">
                                                    @if ($purchase->invoice_date)
                                                    {{ Carbon\carbon::parse($purchase->invoice_date)->format('d-m-Y')}}
                                                    @endif
                                                </td>
                                                @php
                                                    $seller=DB::table('sellers')->where('id',$purchase->seller_details)->first();
                                                @endphp
                                                <td>{{ $seller->seller_name }}</td>
                                                <td>
                                                    <a href="{{ route('purchase.show', $purchase->id) }}">
                                                        {{ $purchase->invoice_no }}
                                                    </a>
                                                </td>
                                                @php
                                                    $purchaseCount = DB::table('purchase_items')->where('purchase_id',$purchase->id)->count();
                                                @endphp
                                                <td>{{$purchaseCount}}</td>
                                                @if ($purchase->grand_total)
                                                    @if($purchase->discount)
                                                        <td>₹{{$purchase->grand_total - $purchase->discount}}</td>
                                                    @else
                                                        <td>₹{{$purchase->grand_total}}</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('purchase.show', $purchase->id) }}"><button type="button" class="btn btn-light waves-effect text-success" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </button></a>
                                                        {{-- <button type="button" class="btn btn-light waves-effect text-danger">
                                                            <i class="mdi mdi-delete font-size-18"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                                <!-- Modal -->
                {{-- <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title add-task-title">Edit Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="NewtaskForm" role="form">
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Category</label>
                                    <div class="col-lg-12">
                                        @php
                                        $pro_cat=DB::table('products')->where('id',$stock->product_id)->first();
                                        $cat_id=$pro_cat->category_id;
                                        $cat_name=DB::table('product_categories')->where('id',$cat_id)->first();
                                    @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $cat_name->category_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Brand</label>
                                    <div class="col-lg-12">
                                        @php
                                        $pro_name=DB::table('products')->where('id',$stock->product_id)->first();
                                    @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $pro_name->product_code }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Product Name</label>
                                    <div class="col-lg-12">
                                        @php
                                                $pro_name=DB::table('products')->where('id',$stock->product_id)->first();
                                            @endphp

                                        <input id="taskname" name="staffname" type="text" class="form-control validate" placeholder="" Value="{{ $pro_name->product_name }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone1" class="col-form-label">Price</label>
                                    <div class="col-lg-12">
                                        <input id="phone1" name="phone1" type="text" class="form-control validate" placeholder="" Value="{{$stock->product_unit_price}}">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone2" class="col-form-label">Quantity</label>
                                    <div class="col-lg-12">
                                        <input id="phone2" name="phone2" type="text" class="form-control validate" placeholder="" Value="{{ $stock->product_qty }}">
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <button type="button" class="btn btn-primary" id="addtask">Update Changes</button>

                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal --> --}}


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
