@extends('utility.layout')
@section('content')
<script>
    function check_all() {
        let all_check = document.getElementById('all_check');
        var checkboxes = document.getElementsByClassName('item_check');
        var quantityInputs = document.getElementsByClassName('quantity-input');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = all_check.checked;
            quantityInputs[i].disabled = !all_check.checked;
        }
    }

    function toggleQuantityInput(index) {
        var checkbox = document.getElementById('verify_details_' + index);
        var quantityInput = document.getElementById('quantity_' + index);

        quantityInput.disabled = !checkbox.checked;
    }
    function show_method() {
        var payment_status = $("#payment_status").val();
        console.log(payment_status);
        if(payment_status == 'paid'){
            document.getElementById('method_div').style.display = 'block';
        }
        else{
            document.getElementById('method_div').style.display = 'none';
        }
    }
</script>



            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Sales Management</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label>Invoice Number</label>
                                                <input type="text" value="{{ $sale->invoice_number }}" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label>Sales Date</label>
                                                <input type="text" value="{{ carbon\Carbon::parse($sale->sales_date)->format('d-m-Y') }}" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label>Customer</label>
                                                @php
                                                    $customer = DB::table('customers')->where('id',$sale->customer_id)->first();
                                                @endphp
                                                <input type="text" value="{{ $customer->name }}" class="form-control" disabled>
                                            </div>
                                            @php
                                                $amountPaid = DB::table('daybooks')->where('type','Income')->where('job',$sale->invoice_number)->where('income_id','FROM_INVOICE')->sum('amount');
                                            @endphp
                                            <div class="col-md-3 mb-3">
                                                <label>Total</label>
                                                <input type="text" value="{{ $sale->grand_total }}" class="form-control" id="grand_total" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label>Discount</label>
                                                <input type="number" step="0.01" value="{{ $sale->discount }}" class="form-control" name="discount" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label>Grand Total</label>
                                                <input type="text" value="{{ ($sale->grand_total) - ($sale->discount) }}" id="discounted_total" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <h4 class="mt-3 mb-3">Sales Items</h4>
                                        <table class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Serial Number</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Taxable</th>
                                                    <th>Tax</th>
                                                    <th>Total</th>
                                                    <th>Returned</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sales_items as $item)
                                                    @if($item->returned == $item->product_quantity)
                                                        <tr class="text-danger">
                                                    @else
                                                        <tr>
                                                    @endif
                                                        <td style="white-space: normal">
                                                            @php
                                                                $product=DB::table('products')->where('id',$item->product_id)->first();
                                                            @endphp
                                                            {{ $product->product_name }}
                                                        </td>
                                                        <td style="white-space: normal">{{ $item->serial_number }}</td>
                                                        <td style="white-space: normal">{{ $item->unit_price }}</td>
                                                        <td style="white-space: normal">{{ $item->product_quantity }}</td>
                                                        <td style="white-space: normal">{{ $item->unit_price * $item->product_quantity }}</td>
                                                        <td style="white-space: normal">{{ round(($item->unit_price * $item->product_quantity * $item->gst_percent)/100,2) }}</td>
                                                        <td style="white-space: normal">{{ $item->sales_price }}</td>
                                                        <td style="white-space: normal">{{ $item->returned }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-3">
                                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#return_items">Return Items</button>
                                        </div>
                                        <!-- Modal -->
                                        <div id="return_items" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title add-task-title">Return Sales Items</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('utility.sales_items.return',$sale->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <table class="table table-bordered dt-responsive nowrap w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check font-size-16 align-middle">
                                                                                <input class="form-check-input" type="checkbox" id="all_check" style="border-color: #000;" onclick="check_all()">
                                                                            </div>
                                                                        </td>
                                                                        <th>Product Name</th>
                                                                        <th>Current Quantity</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Tax</th>
                                                                        <th>Quantity</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ( $sales_items as $index => $item )
                                                                        @php
                                                                            $balance = $item->product_quantity - $item->returned;
                                                                        @endphp
                                                                        @if($balance > 0)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-check font-size-16">
                                                                                        <input class="form-check-input item_check" type="checkbox" id="verify_details_{{ $index }}" name="sales_item[]" value="{{ $item->id }}" style="border-color: #000;" onclick="toggleQuantityInput({{ $index }})">
                                                                                    </div>
                                                                                </td>
                                                                                <td style="white-space: normal">
                                                                                    @php
                                                                                        $product=DB::table('products')->where('id',$item->product_id)->first();
                                                                                    @endphp
                                                                                    {{ $product->product_name }}
                                                                                </td>
                                                                                <td style="white-space: normal">{{ $item->product_quantity - $item->returned }}</td>
                                                                                <td style="white-space: normal" id="unit_price_{{ $index }}">{{ $item->unit_price }}</td>
                                                                                <td style="white-space: normal" id="gst_{{ $index }}">{{ round(($item->unit_price * $item->gst_percent)/100,2) }}</td>
                                                                                <td style="width: 150px;">
                                                                                    <input type="number" class="form-control quantity-input" id="quantity_{{ $index }}" name="quantity[]" value="1" max="{{ $item->product_quantity - $item->returned }}" min="1" disabled>
                                                                                </td>
                                                                                <input type="hidden" name="product_total_{{ $index }}" id="total_hidden_0">
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <label class="col-form-label" style="float:left;">Payment Status</label>
                                                                    <select class="form-control" name="payment_status" id='payment_status' onchange="show_method()" style="width:100%;">
                                                                        <option value="not paid">Add to Customer Balance</option>
                                                                        <option value="paid">Paid</option>
                                                                    </select>
                                                                    @error('payment_status')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-lg-4" id="method_div" style="display:none;">
                                                                    <label class="col-form-label" style="float:left;">Payment Method</label>
                                                                    <select class="form-control" name="payment_method" id='payment_method' style="width:100%;">
                                                                        <option value="CASH">Cash</option>
                                                                        <option value="ACCOUNT">Account</option>
                                                                    </select>
                                                                    @error('payment_method')
                                                                        <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-end">
                                                                    <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Seving...';this.form.submit();">Return Sales</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
