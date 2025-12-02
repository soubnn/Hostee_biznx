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

        var count = 1;
        var tableRows = [];
        var gTotal = 0;
        var stockOk = true;
        var selectedProducts = [];

        $(document).ready(function(){

            $.ajaxSetup({
		    	headers : {
		    		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		    	}
		    });

            $(window).keydown(function(event){
                if(event.keyCode == 13){
                    event.preventDefault();
                    return false;
                }
            });
        });

        function calculateDiscount()
        {
            var discountAmount = $("#discount").val();
            if(discountAmount == '' || discountAmount < 0)
            {
                discountAmount = 0;
            }
            else
            {
                discountAmount = parseFloat(discountAmount).toFixed(2);
            }
            gTotal = document.getElementById('grand_total').value;
            discountedAmount = parseFloat(gTotal).toFixed(2) - discountAmount;
            $("#grandTotalBold").html("Grand total : ₹"+parseFloat(discountedAmount).toFixed(2));
            // console.log(discountedAmount);
        }

        function calculateNewGST(gstPercent, rowCount)
        {
            console.log('row count is '+rowCount);
            console.log('gst percent is '+gstPercent);
            var total = parseFloat($("#total" + rowCount).text());
            console.log('total is '+total);
            var newTotal = (total * parseFloat(gstPercent) / 100);
            console.log('new total '+newTotal);
            $("#gst" + rowCount).html(newTotal);
            var newSTotal = total + newTotal;
            $("#stotal" + rowCount).html(newSTotal.toFixed(2));
            $("#total_hidden_" + rowCount).val(newSTotal.toFixed(2));
            calculateGrandTotal();
            calculateDiscount();
        }

        function calculateGrandTotal()
        {
            gTotal = 0;
            $(".sTotal").each(function(){
                gTotal += parseFloat($(this).text() || 0);
            });
            $("#grandTotalBold").html("Grand total : ₹" + gTotal.toFixed(2));
            $("#grand_total").val(gTotal.toFixed(2));
        }

        function calculateGSTAndTotal(rowNumber)
        {
            // console.log("working " + rowNumber);
            var gstPercentage = $("#product_tax" + rowNumber).val();
            // console.log(gstPercentage);
            var gst = (parseFloat($("#total" + rowNumber).text()) * parseFloat(gstPercentage)) / 100;
            $("#gst" + rowNumber).html(gst.toFixed(2));
            var subTotal = gst + parseFloat($("#total" + rowNumber).text());
            $("#stotal" + rowNumber).html(subTotal.toFixed(2));
            $("#total_hidden_" + rowNumber).val(subTotal.toFixed(2));
            calculateGrandTotal();
            calculateDiscount();
        }

        function calculateTotal(rowNumber)
        {
            var unitPrice = $("#unitPrice" + rowNumber).val();
            var quantity = $("#productQty" + rowNumber).val();
            var total = unitPrice * quantity;
            document.getElementById("total" + rowNumber).innerHTML = total.toFixed(2);
            calculateGSTAndTotal(rowNumber);
            calculateGrandTotal();
            calculateDiscount();
            checkStock(rowNumber);
        }

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

        function clearTableFields(row)
        {
            document.getElementById("unitPrice"+row).value = '';
            document.getElementById("cgstPercentage"+row).value = '';
            document.getElementById("sgstPercentage"+row).value = '';
            document.getElementById("productQty"+row).value = '';
            document.getElementById("total"+row).innerHTML = '';
            document.getElementById("gst"+row).innerHTML = '';
            document.getElementById("stotal"+row).innerHTML = '';
        }

        function getCustomerDetails(customerValue)
        {
            if(customerValue != '')
            {
                if(customerValue == "addNewCustomer")
                {
                    $("#newCustomerModal").modal("toggle");
                    $("#newCustomerModal").modal("show");
                }
                else
                {
                    // console.log("Customer is " + customerValue);
                    $.ajax({
                        type : "get",
                        url : "{{ route('getCustomerDetails') }}",
                        data : { customer : customerValue},
                        success : function(res)
                        {
                            // console.log(res);
                            if(res.gst_no)
                            {
                                $("#gst_number").val(res.gst_no);
                                $("#GSTNo").removeAttr("checked");
                                $("#GSTYes").attr('checked','');
                                showGSTNumber("Yes")
                            }
                            else
                            {
                                $("#gst_number").val('');
                                $("#GSTYes").removeAttr("checked");
                                $("#GSTNo").attr('checked','');
                                showGSTNumber("No");
                            }
                            $("#customer_name").val(res.name);
                            $("#customer_phone").val(res.mobile);
                        }
                    });
                }
            }
            else
            {
                showGSTNumber("No");
                $("#customer_name").val('');
                $("#customer_phone").val('');
                $("#gst_number").val('');
            }
        }
        function check_staff(staff){
            if(staff == ''){
                document.getElementById('sales_submit_btn').disabled = true;
            }
            else{
                document.getElementById('sales_submit_btn').disabled = false;
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
                                    <h4 class="mb-sm-0 font-size-18">Sales</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Sales Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>

                                        <form action="{{ route('direct_sales.store_summary') }}" method="POST" enctype="multipart/form-data" id="salesForm" autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="invoice_number">Invoice No</label>
                                                        <input id="invoice_number" name="invoice_number" type="text" class="form-control" value="{{ $consignments->invoice_no }}" readonly>
                                                        <small class="text-danger" id="invoiceNumberError" style="display: none">Invoice number cannot be empty</small>
                                                        @error('invoice_number')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sales_date">Sales Date</label>
                                                        <input id="sales_date" name="sales_date" type="date" class="form-control" value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}"  readonly>
                                                        @error('sales_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="customer_phone" class="control-label">Customer Mobile</label>
                                                        <input id="customer_phone" name="customer_phone" type="tel" class="form-control" value="{{ $customer->mobile }}" pattern="[0-9]{10}" readonly>
                                                        <small class="text-danger" id="mobileNumberError" style="display: none">Mobile Number is invalid or empty</small>
                                                        @error('customer_phone')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="control-label">GST Available</label>
                                                        <br>
                                                        <div class="row">
                                                            @if($consignments->customer_relation == 'B2B')
                                                                <div class="col-md-6">
                                                                    <label id="labelYes" class="control-label">YES</label>
                                                                    <input for="labelYes" id="GSTYes" name="gst_available" type="radio" value="Yes" onclick="showGSTNumber(this.value)" checked>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label id="labelNo" class="control-label">NO</label>
                                                                    <input for="labelNo" id="GSTNo" name="gst_available" type="radio" value="No" onclick="showGSTNumber(this.value)" disabled>
                                                                </div>
                                                            @elseif($consignments->customer_relation == 'B2C')
                                                                <div class="col-md-6">
                                                                    <label id="labelYes" class="control-label">YES</label>
                                                                    <input for="labelYes" id="GSTYes" name="gst_available" type="radio" value="Yes" onclick="showGSTNumber(this.value)" disabled>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label id="labelNo" class="control-label">NO</label>
                                                                    <input for="labelNo" id="GSTNo" name="gst_available" type="radio" value="No" checked onclick="showGSTNumber(this.value)">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="control-label">Payment Method</label>
                                                        <select class="form-control select2" name="pay_method" id="pay_method" required>
                                                            <option disabled selected>Select</option>
                                                            <option value="CASH" @if($consignments->payment_status == 'paid' && $consignments->payment_method == 'cash') selected @endif>CASH</option>
                                                            <option value="ACCOUNT" @if($consignments->payment_status == 'paid' && $consignments->payment_method == 'account') selected @endif>ACCOUNT</option>
                                                            <!--<option value="LEDGER" @if($consignments->payment_status == 'paid' && $consignments->payment_method == 'ledger') selected @endif>LEDGER</option>-->
                                                            <option value="CREDIT" @if($consignments->payment_status == 'not paid') selected @endif>CREDIT</option>
                                                        </select>
                                                        <small class="text-danger" id="paymentMethodError" style="display: none">Please choose a payment method</small>
                                                        @error('pay_method')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3 autocomplete">
                                                        <label class="control-label">Customer Name</label>
                                                        <input id="customer_name" name="customer_name" type="text" class="form-control" value="{{ $customer->name }}, {{ $customer->place }}" readonly>
                                                        <input id="customer_id" name="customer_id" type="hidden" class="form-control" value="{{ $customer->id }}">
                                                        <small class="text-danger" id="customerNameError" style="display: none">Customer Name cannot be empty</small>
                                                        @error('customer_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sales_staff">Sales Person</label>
                                                        <select id="sales_staff" name="sales_staff" class="form-control select2" onchange="check_staff(this.value)" required>
                                                            <option selected disabled>SELECT STAFF</option>
                                                            @php
                                                                $staffs = DB::table('staffs')->where('status', 'active')->get();
                                                            @endphp
                                                            @foreach ($staffs as $staff)
                                                            <option value="{{ $staff->id }}">{{ strtoupper($staff->staff_name) }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('sales_staff')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    @if($consignments->customer_relation == 'B2B' && $consignments->gst_no)
                                                        <div class="mb-3" id="gstDiv">
                                                            <label class="control-label">GST Number</label>
                                                            <input id="gst_number" name="gst_number" type="text" class="form-control" value="{{ $consignments->gst_no }}" readonly>
                                                            <small class="text-danger" id="gstNumberError" style="display: none">GST Number cannot be empty</small>
                                                            @error('gst_number')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label>Products</label>
                                                        <small class="text-danger" id="productsError" style="display: none">Please add any products before saving</small>
                                                        <div class="table-responsive">
                                                            <table class="table" id="productsTable" style="width: 100%;">
                                                                <thead>
                                                                    <th class="w-25">PRODUCT</th>
                                                                    <th class="w-15">SERIAL</th>
                                                                    <th class="w-15">UNIT PRICE</th>
                                                                    <th class="w-15">QTY</th>
                                                                    <th class="w-15">TAXABLE</th>
                                                                    <th class="w-15">TAX</th>
                                                                    <th class="w-15">GST</th>
                                                                    <th class="w-15">TOTAL</th>
                                                                    {{-- <th class="w-15">DELETE</th> --}}
                                                                </thead>
                                                                <tbody id="purchaseTableBody">
                                                                    <small class="text-danger" id="alreadyAddedProduct" style="display: none">Product Already added</small>
                                                                    @php
                                                                        $i=1;
                                                                    @endphp
                                                                    @foreach ($sales as $sale)
                                                                        <tr id="row{{ $i }}">
                                                                            @php
                                                                                $get_product = DB::table('products')->where('id',$sale->product_id)->first();
                                                                            @endphp
                                                                            @if($get_product)
                                                                                <td id="prod{{ $i }}" style="max-width: 150px;">
                                                                                    <select class="select2 products" style="width: 100%" id="productSelect{{ $i }}" name="productSelect[]" onchange="productSelected(this.value,{{ $i }})">
                                                                                        <option value="{{ $get_product->id }}" selected>[{{ $get_product->product_code }}] {{ $get_product->product_name }}</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><input class="form-control" type="text" value="{{ $sale->serial }}" id="serial{{ $i }}" name="serial[]" style="width: 100%; text-transform: uppercase"></td>
                                                                            @else
                                                                                <td id="prod{{ $i }}" style="max-width: 150px;">
                                                                                    <select class="select2 products" style="width: 100%" id="productSelect{{ $i }}" name="productSelect[]" onchange="productSelected(this.value,{{ $i }})">
                                                                                        @php
                                                                                            $products = DB::table('products')->where('product_name','SERVICE')->first();
                                                                                        @endphp
                                                                                        <option value="{{ $products->id }}" selected>[{{ $products->product_code }}] {{ $products->product_name }}</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><input class="form-control" type="text" value="{{ $sale->product_id.'-'.$sale->serial }}" id="serial{{ $i }}" name="serial[]" style="width: 100%; text-transform: uppercase"></td>
                                                                            @endif
                                                                            <td><input class="form-control" type="number" value="{{ $sale->price }}" id="unitPrice{{ $i }}" name="unitPrice[]" step=".01" onkeyup="calculateTotal({{ $i }})" onchange="calculateTotal({{ $i }})" style="width: 100%" readonly></td>
                                                                            <td id="qtyTD{{ $i }}" style="max-width: 80px;"><input class="form-control" id="productQty{{ $i }}" name="productQty[]" type="number" step=".10" value="{{ $sale->qty }}" onkeyup="calculateTotal({{ $i }})" min="0" onchange="calculateTotal({{ $i }})" style="width: 100%" readonly></td>
                                                                            <td id="total{{ $i }}" onchange="calculateGSTAndTotal({{ $i }})">{{ $sale->price * $sale->qty }}</td>
                                                                            <td>
                                                                                <select class="form-control" name="productTax[]" id="product_tax{{ $i }}" onchange="calculateNewGST(this.value,{{ $i }})" style="width:100%">
                                                                                    <option value="{{ $sale->tax }}" selected>{{ $sale->tax }}</option>
                                                                                    {{-- <option value="0" id="0Value_0">0</option>
                                                                                    <option value="3" id="3Value_0">3</option>
                                                                                    <option value="5" id="5Value_0">5</option>
                                                                                    <option value="12" id="12Value_0">12</option>
                                                                                    <option value="18" id="18Value_0">18</option>
                                                                                    <option value="28" id="28Value_0">28</option> --}}
                                                                                </select>
                                                                            </td>
                                                                            <td id="gst{{ $i }}">{{ $sale->gst }}</td>
                                                                            <td style="font-weight:bold" id="stotal{{ $i }}" class="sTotal">{{ $sale->total }}</td>
                                                                            <input type="hidden" name="total[]" id="total_hidden_{{ $i }}" value="{{ $sale->total }}">
                                                                        </tr>
                                                                        @php
                                                                            $i++;
                                                                        @endphp
                                                                    @endforeach
                                                                    <input type="hidden" name="consignment_id" value="{{ $consignment_id }}">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="mb-3" style="text-align: right">
                                                        <button class="btn btn-primary" type="button" id="addMoreButton" onclick="addNewRow()">Add More&nbsp;<i class="bx bx-plus"></i></button>
                                                    </div> --}}
                                                    <h5>Enter Discount : </h5>
                                                    <input type="number" class="mb-3 form-control" name="discount" id="discount" onkeyup="calculateDiscount()" placeholder="Discount" step="0.01" value="{{ old('discount') }}" style="width: 30%">
                                                    <div class="mb-3" style="text-align: right">
                                                        @php
                                                            $grand_total = DB::table('sales')->where('job_card_id',$consignments->id)->sum('total');
                                                        @endphp
                                                        <h4 style="margin-right: 5%"><b id="grandTotalBold">Grand total : ₹{{ $grand_total }}</b></h4>
                                                        <input type="hidden" name="grand_total" id="grand_total" value="{{ $grand_total }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="sales_submit_btn" disabled>Generate Invoice</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card-->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
