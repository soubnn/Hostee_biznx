@extends('layouts.layout')
@section('content')
@push('indian-state-script')
    <script src=" {{ asset('assets/js/indian-states.js') }} "></script>
@endpush
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
        var gTotal = 0;
        var tableRows = [];

        $(document).ready(function(){

            $.ajaxSetup({
		    	headers : {
		    		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		    	}
		    });

            $("#productRegistrationForm").submit(function(e){

                e.preventDefault();
                var productCode = $("#product_code").val();
                var productName = $("#product_name").val();
                var category = $("#category_id").val();

                if(productCode == '')
                {
                    document.getElementById("productCodeError").style.display = "block";
                }
                else if(productName == '')
                {
                    document.getElementById("productCodeError").style.display = "none";
                    document.getElementById("productNameError").style.display = "block";
                }
                else if(category == '')
                {
                    document.getElementById("productCodeError").style.display = "none";
                    document.getElementById("productNameError").style.display = "none";
                    document.getElementById("categoryError").style.display = "block";
                }
                else
                {
                    document.getElementById("productCodeError").style.display = "none";
                    document.getElementById("productNameError").style.display = "none";
                    document.getElementById("categoryError").style.display = "none";

                    var formData = new FormData(this);

                    $.ajax({
                        type : "post",
                        url : "../addProduct",
                        dataType : "json",
                        data : formData,
                        cache : false,
                        processData : false,
                        contentType : false,
                        success : function(res)
                        {
                            console.log(res);
                            if(res != "Error")
                            {
                                $("#productRegistrationForm").trigger("reset");
                                $("#addProductModal").modal("toggle");
                                var newDynamicOption = document.createElement("option");
                                newDynamicOption.setAttribute("value",res.id);
                                newDynamicOption.innerHTML = "[" + res.product_code +"]" + res.product_name;
                                const elements = document.getElementsByClassName("products");
                                for (var counter = 0 ; counter < elements.length; counter++)
                                {
                                    elements[counter].appendChild(newDynamicOption);
                                }

                            }
                        }
                    });
                }

            });

            $(window).keydown(function(event){
                if(event.keyCode == 13){
                    event.preventDefault();
                    return false;
                }
            });
        });

        function calculateNewGST(gstPercent, rowCount)
        {
            var total = parseFloat($("#total" + rowCount).text());
            console.log(total);
            var newTotal = (total * parseFloat(gstPercent) / 100);
            console.log(newTotal);
            $("#gst" + rowCount).html(newTotal);
            var newSTotal = total + newTotal;
            $("#stotal" + rowCount).html(newSTotal.toFixed(2));
            $("#hidden_total_" + rowCount).val(newSTotal.toFixed(2));
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

        function calculateDiscount()
        {
            var discountAmount = $("#discount").val();
            if(discountAmount == '')
            {
                discountAmount = 0;
            }
            else
            {
                discountAmount = parseFloat(discountAmount).toFixed(2);
            }
            discountedAmount = parseFloat(gTotal).toFixed(2) - discountAmount;
            $("#grandTotalBold").html("Grand total : ₹"+parseFloat(discountedAmount).toFixed(2));
            console.log(discountedAmount);
        }

        function calculateGSTAndTotal(rowNumber)
        {
            console.log("working " + rowNumber);
            var gstPercentage = $("#product_tax" + rowNumber).val();
            console.log(gstPercentage);
            var gst = (parseFloat($("#total" + rowNumber).text()) * parseFloat(gstPercentage)) / 100;
            $("#gst" + rowNumber).html(gst.toFixed(2));
            var subTotal = gst + parseFloat($("#total" + rowNumber).text());
            $("#stotal" + rowNumber).html(subTotal.toFixed(2));
            $("#hidden_total_" + rowNumber).val(subTotal.toFixed(2));
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

        function deleteRow(row)
        {
            $("#row"+row).remove();
            $("#discount").val(0);
            calculateGrandTotal();
            calculateDiscount();
            tableRows = tableRows.filter(function(e){ return e !== row});
            console.log(tableRows);
        }

        function addNewRow()
        {
            console.log("Clicked add button");

            var newRow = document.createElement("tr");
            newRow.setAttribute("id", "row" + count);

            //Column1
            var newColumn1 = document.createElement("td");
            var newProductSel = document.createElement("select");
            newProductSel.setAttribute("class","select2 products");
            newProductSel.setAttribute("style","width: 100%");
            newProductSel.setAttribute("id","productSelect" + count);
            newProductSel.setAttribute("name","productSelect[]");
            newProductSel.setAttribute("onchange","productSelected(this.value,"+count+")");

            $.ajax({
                type : "get",
                url : "../getProducts",
                dataType : "json",
                success : function(response)
                {
                    console.log(response);
                    var newOption1 = document.createElement("option");
                    newOption1.setAttribute("value","");
                    newOption1.innerHTML = "Select Product";
                    newProductSel.appendChild(newOption1);
                    var newOption2 = document.createElement("option");
                    newOption2.setAttribute("value","addProduct");
                    newOption2.innerHTML = "Add Product";
                    newProductSel.appendChild(newOption2);

                    for(var i = 0; i < response.length; i++)
                    {
                        var newDynamicOption = document.createElement("option");
                        newDynamicOption.setAttribute("value",response[i].id);
                        newDynamicOption.innerHTML = "[" + response[i].product_code +"]" + response[i].product_name;
                        newProductSel.appendChild(newDynamicOption);
                        // console.log("Added option");
                    }
                }
            });
            newColumn1.appendChild(newProductSel);

            //Column 2
            var newColumn2 = document.createElement("td");
            newColumn2.setAttribute("id", "hsn" + count);

            //Column 3
            var newColumn3 = document.createElement("td");
            var newUnitPrice = document.createElement("input");
            newUnitPrice.setAttribute("type","number");
            newUnitPrice.setAttribute("step",".01");
            newUnitPrice.setAttribute("value","");
            newUnitPrice.setAttribute("class","form-control");
            newUnitPrice.setAttribute("id","unitPrice" + count);
            newUnitPrice.setAttribute("name","unitPrice[]");
            newUnitPrice.setAttribute("onkeyup","calculateTotal(" + count +")");
            newUnitPrice.setAttribute("onchange","calculateTotal(" + count +")");
            newUnitPrice.setAttribute("style","width:100%");
            newColumn3.appendChild(newUnitPrice);

            //Column 4
            var newColumn4 = document.createElement("td");
            var newQty = document.createElement("input");
            newQty.setAttribute("type","number");
            newQty.setAttribute("value","1");
            newQty.setAttribute("class","form-control");
            newQty.setAttribute("id","productQty" + count);
            newQty.setAttribute("name","productQty[]");
            newQty.setAttribute("min","0");
            newQty.setAttribute("step",".01");
            newQty.setAttribute("onkeyup","calculateTotal(" + count + ")");
            newQty.setAttribute("onchange","calculateTotal(" + count + ")");
            newQty.setAttribute("style","width:100%");
            newColumn4.appendChild(newQty);

            //Column 5
            var newColumn5 = document.createElement("td");
            newColumn5.setAttribute("id","total" + count);
            newColumn5.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
            newColumn5.innerHTML = "₹0";

            //Column 6
            var newColumn6 = document.createElement("td");

            //Tax Select
            var taxSelect = document.createElement("select");
            taxSelect.setAttribute("class","form-control");
            taxSelect.setAttribute("name","productTax[]");
            taxSelect.setAttribute("id","product_tax" + count);
            taxSelect.setAttribute("onchange", "calculateNewGST(this.value," + count +")");

            var newOption1 = document.createElement("option");
            newOption1.setAttribute("value","0");
            newOption1.setAttribute("id","0Value_" + count);
            newOption1.innerHTML = 0;

            var newOption2 = document.createElement("option");
            newOption2.setAttribute("value","3");
            newOption2.setAttribute("id","3Value_" + count);
            newOption2.innerHTML = 3;

            var newOption3 = document.createElement("option");
            newOption3.setAttribute("value","5");
            newOption3.setAttribute("id","5Value_" + count);
            newOption3.innerHTML = 5;

            var newOption4 = document.createElement("option");
            newOption4.setAttribute("value","12");
            newOption4.setAttribute("id","12Value_" + count);
            newOption4.innerHTML = 12;

            var newOption5 = document.createElement("option");
            newOption5.setAttribute("value","18");
            newOption5.setAttribute("id","18Value_" + count);
            newOption5.innerHTML = 18;

            var newOption6 = document.createElement("option");
            newOption6.setAttribute("value","28");
            newOption6.setAttribute("id","28Value_" + count);
            newOption6.innerHTML = 28;

            taxSelect.appendChild(newOption1);
            taxSelect.appendChild(newOption2);
            taxSelect.appendChild(newOption3);
            taxSelect.appendChild(newOption4);
            taxSelect.appendChild(newOption5);
            taxSelect.appendChild(newOption6);
            newColumn6.appendChild(taxSelect);

            //Column 7
            var newColumn7 = document.createElement("td");
            newColumn7.setAttribute("id", "gst" + count);
            newColumn7.innerHTML = "₹0";

            //Column 8
            var newColumn8 = document.createElement("td");
            newColumn8.setAttribute("id","stotal" + count);
            newColumn8.setAttribute("class","sTotal");
            newColumn8.setAttribute("style", "font-weight:bold");
            newColumn8.innerHTML = "₹0";

            //Column 9
            var newColumn9 = document.createElement("td");
            newColumn9.setAttribute("class", "text-danger");
            var deleteIcon = document.createElement("i");
            deleteIcon.setAttribute("class","bx bx-trash");
            deleteIcon.setAttribute("id", "delete" + count);
            deleteIcon.setAttribute("onclick", "deleteRow(" + count +")");
            newColumn9.appendChild(deleteIcon);

            //Hidden 1
            var stateGST = document.createElement("input");
            stateGST.setAttribute("type", "hidden");
            stateGST.setAttribute("name", "total[]");
            stateGST.setAttribute("id", "hidden_total_" + count);

            var tableBody = document.getElementById("purchaseTableBody");
            newRow.appendChild(newColumn1);
            newRow.appendChild(newColumn2);
            newRow.appendChild(newColumn3);
            newRow.appendChild(newColumn4);
            newRow.appendChild(newColumn5);
            newRow.appendChild(newColumn6);
            newRow.appendChild(newColumn7);
            newRow.appendChild(newColumn8);
            newRow.appendChild(newColumn9);
            newRow.appendChild(stateGST);
            tableBody.appendChild(newRow);

            $("#productSelect" + count).select2();
            count++;
        }

        function clearTableFields(row)
        {
            document.getElementById("unitPrice"+row).value = '';
            document.getElementById("productQty"+row).value = '';
            document.getElementById("total"+row).innerHTML = '';
            document.getElementById("gst"+row).innerHTML = '';
            document.getElementById("stotal"+row).innerHTML = '';
        }

        function productSelected(productValue, row)
        {
            if(productValue == "addProduct")
            {
                $("#addProductModal").modal("toggle");
                $("#addProductModal").modal("show");
                clearTableFields(row);
            }
            else
            {
                if(productValue != '')
                {
                    $.ajax({
                        type : "get",
                        url : "../getProductDetails",
                        dataType : "json",
                        data : {product : productValue},
                        success : function(response)
                        {
                            tableRows.push(row);
                            console.log(tableRows);
                            document.getElementById("hsn"+row).innerHTML = response.hsn_code;
                            document.getElementById("unitPrice"+row).value = response.product_price;
                            document.getElementById("productQty"+row).value = 1;
                            document.getElementById("total"+row).innerHTML = parseFloat(response.product_price).toFixed(2);
                            var cgst = parseFloat((response.product_cgst * response.product_price) / 100);
                            var sgst = parseFloat((response.product_sgst * response.product_price) / 100);
                            var gst = parseFloat(response.product_cgst) + parseFloat(response.product_sgst);
                            var tax = parseFloat((gst * response.product_price) / 100);
                            if(gst == 0)
                            {
                                document.getElementById("0Value_" + row).setAttribute("selected","selected");
                            }
                            else if(gst == 3)
                            {
                                document.getElementById("3Value_" + row).setAttribute("selected","");
                            }
                            else if(gst == 5)
                            {
                                document.getElementById("5Value_" + row).setAttribute("selected","");
                            }
                            else if(gst == 12)
                            {
                                document.getElementById("12Value_" + row).setAttribute("selected","");
                            }
                            else if(gst == 18)
                            {
                                document.getElementById("18Value_" + row).setAttribute("selected","");
                            }
                            else if(gst == 28)
                            {
                                document.getElementById("28Value_" + row).setAttribute("selected","");
                            }
                            document.getElementById("gst"+row).innerHTML = tax.toFixed(2);
                            var stotal = parseFloat(response.product_price) + cgst + sgst;
                            document.getElementById("stotal" + row).innerHTML = stotal.toFixed(2);
                            document.getElementById("hidden_total_" + row).value = stotal.toFixed(2);
                            calculateGrandTotal();

                        }
                    });
                }
                else
                {
                    clearTableFields(row);
                }
            }
        }

        function resetFields()
        {
            $("#sellerName").val('');
            $("#openingBalance").val('');
            $("#sellerPhone").val('');
            $("#sellerMobile").val('');
            $("#sellerCity").val('');
            $("#sellerArea").val('');
            $("#sellerPincode").val('');
            $("#sellerState").val('');
            $("#sellerDistrict").val('');
            $("#sellerStateCode").val('');
            $("#sellerBankAccountNumber").val('');
            $("#sellerBankIfscCode").val('');
            $("#sellerBankName").val('');
            $("#sellerBankBranch").val('');
            $("#sellerGstNumber").val('');
            $("#sellerPanNumber").val('');
            $("#sellerTinNumber").val('');
            $("#sellerEmail").val('');
        }
        function registerSeller()
        {
            var sellerName = $("#sellerName").val();
            var sellerOpeningBalance = $("#openingBalance").val();
            var sellerPhoneNumber = $("#sellerPhone").val();
            var sellerMobileNumber = $("#sellerMobile").val();
            var sellerCity = $("#sellerCity").val();
            var sellerArea = $("#sellerArea").val();
            var sellerPincode = $("#sellerPincode").val();

            var sellerState = $("#sellerState").val();
            var sellerDistrict = $("#sellerDistrict").val();
            var sellerStateCode = $("#sellerStateCode").val();

            var sellerBankAcc = $("#sellerBankAccountNumber").val();
            var sellerBankIfsc = $("#sellerBankIfscCode").val();
            var sellerBankName = $("#sellerBankName").val();
            var sellerBankBranch = $("#sellerBankBranch").val();

            var sellerGstNumber = $("#sellerGstNumber").val();
            var sellerPanNumber = $("#sellerPanNumber").val();
            var sellerTinNumber = $("#sellerTinNumber").val();
            var sellerEmail = $("#sellerEmail").val();

            if(sellerName == '')
            {
                document.getElementById("sellerNameErrorMsg").style.display="block";
            }
            else if(sellerOpeningBalance == '')
            {
                sellerOpeningBalance = 0;
                document.getElementById("sellerOpErrorMsg").style.display="block";
            }
            else if(sellerMobileNumber == '')
            {
                document.getElementById("sellerMobileErrorMsg").style.display="block";
            }
            else
            {
                document.getElementById("sellerNameErrorMsg").style.display="none";
                document.getElementById("sellerMobileErrorMsg").style.display="none";
                document.getElementById("sellerOpErrorMsg").style.display="none";

                $.ajaxSetup({
					headers : {
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					}
				});

                $.ajax({
                    type : "post",
                    url : "{{ route('seller.store') }}",
                    dataType : "JSON",
                    data : {seller_name : sellerName, seller_city : sellerCity, seller_area : sellerArea, seller_district : sellerDistrict,
                        seller_state : sellerState, seller_pincode : sellerPincode, seller_phone : sellerPhoneNumber, seller_mobile : sellerMobileNumber,
                        seller_email : sellerEmail, seller_state_code : sellerStateCode, seller_opening_balance : sellerOpeningBalance,
                        seller_bank_name : sellerBankName, seller_bank_acc_no : sellerBankAcc, seller_bank_ifsc : sellerBankIfsc,
                        seller_bank_branch : sellerBankBranch, seller_gst: sellerGstNumber, seller_pan : sellerPanNumber,seller_tin : sellerTinNumber},
                    success : function(response)
                    {
                        console.log(response);
                        if(response != "Error")
                        {
                            var newOption = "<option value='" + response.id + "' selected>" + response.seller_name + " , " + response.seller_city + "</option>";
                            $("#seller_details").append(newOption);
                            $("#addSellerModal").modal("toggle");

                            resetFields();

                        }
                    }
                });
            }
        }

        function getBankDetails(ifsc)
        {
            if(ifsc.length == 11)
            {
                var url = "https://ifsc.razorpay.com/" + ifsc;
                $.ajax({
                    type : "get",
                    url : url,
                    dataType : "json",
                    success : function(response)
                    {
                        console.log(response);
                        $("#sellerBankName").val(response.BANK);
                        $("#sellerBankBranch").val(response.BRANCH);
                    }
                });
            }
            else
            {
                $("#sellerBankName").val('');
                $("#sellerBankBranch").val('');
            }
        }

        function addSeller(seller)
        {
            if(seller == "add")
            {
                console.log("added seller");
                $("#addSellerModal").modal("toggle");
                $("#addSellerModal").modal("show");
            }
            else{
                enable_btn();
            }
        }
        $(document).ready(function () {

            $(document).on('show.bs.modal', '.modal', function (event) {
                var zIndex = 1040 + (10 * $('.modal:visible').length);
                $(this).css('z-index', zIndex);
                setTimeout(function() {
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                }, 0);
            });
        });

        function category_modal(category){
            if(category == 'new category'){
                $('#newCategoryModal').modal("toggle");
                $("#newCategoryModal").modal("show");
            }
        }
        function add_new_category()
        {
            var category_name = $("#category_name").val();

            if(category_name == '')
            {
                document.getElementById("category_name_error").style.display="block";
            }

            else
            {
                // document.getElementById("category_name_error").style.display="none";
                $.ajaxSetup({
	    			headers : {
	    				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	    			}
	    		});
                $.ajax({
                    type : "post",
                    url : "{{ route('add_category') }}",
                    dataType : "JSON",
                    data : {category_name  : category_name },
                    success : function(response)
                    {
                        console.log(response);
                        if(response != "Error")
                        {
                            var newOption = "<option value='" + response.id + "' >" + response.category_name + "</option>";
                            $("#category_id").append(newOption);
                            $("#newCategoryModal").modal("toggle");
                        }
                    }
                });
            }
        }

        function enable_btn(){

            var invoice_no = document.getElementById('invoice_no').value;
            var seller = document.getElementById('seller_details').value;
            var transaction_type = document.getElementById('transaction_type').value;
            console.log('invoice '+invoice_no+' seller '+seller+' t_type '+transaction_type);
            if(invoice_no == '' || seller == '' || transaction_type == ''){
                document.getElementById('purchase_submit_btn').disabled = true;
            }
            else{
                document.getElementById('purchase_submit_btn').disabled = false;
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
                                    <h4 class="mb-sm-0 font-size-18">Purchase</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">purchase/purchase</li></a>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Purchase Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>

                                        <form action="{{ route('purchase.store') }}" method="POST" enctype="multipart/form-data" id="purchaseForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="ref_no">Ref No</label>
                                                        <input id="ref_no" name="ref_no" type="text" class="form-control" value="{{ old('ref_no') }}" style="text-transform: uppercase;">
                                                        @error('ref_no')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="invoice_no">Invoice No</label>
                                                        <input id="invoice_no" name="invoice_no" type="text" class="form-control" value="{{ old('invoice_no') }}" style="text-transform: uppercase;" onkeypress="enable_btn()" onkeyup="enable_btn()">
                                                        <small class="text-danger" id="invoiceNumberError" style="display: none">Invoice number cannot be empty</small>
                                                        @error('invoice_no')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="delivery_date">Delivery Date</label>
                                                        <input id="delivery_date" name="delivery_date" type="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                                                        @error('delivery_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="control-label">Transaction Type</label>
                                                        <select class="form-control select2" name="transaction_type" id="transaction_type" onchange="enable_btn()">
                                                            <option disabled selected>Select</option>
                                                            <option value="NON-GST" >NON-GST</option>
                                                            <option value="GST" >GST</option>
                                                        </select>
                                                        @error('transaction_type')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="control-label">Invoice Date</label>
                                                        <input id="invoice_date" name="invoice_date" type="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                                                        @error('invoice_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_details">Seller</label>
                                                        <select id="seller_details" name="seller_details" class="form-control select2" onchange="addSeller(this.value)" onselect="addSeller(this.value)">
                                                            <option value="">Select Seller</option>
                                                            <option value="add">{ Add Seller }</option>
                                                            @php
                                                                $sellers = DB::table('sellers')->get();
                                                            @endphp
                                                            @foreach ($sellers as $seller)
                                                            <option value="{{ $seller->id }}">{{ $seller->seller_name }} @if ($seller->seller_city) , {{ $seller->seller_city }}@endif</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-danger" id="sellerError" style="display: none">Seller cannot be empty</small>
                                                        @error('seller_details')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label>Products</label>
                                                        <table class="table" id="productsTable" style="width: 100%">
                                                            <colgroup>
                                                                <col span="1" style="width: 30%">
                                                                <col span="1" style="width: 8%">
                                                                <col span="1" style="width: 12%">
                                                                <col span="1" style="width: 8%">
                                                                <col span="1" style="width: 9%">
                                                                <col span="1" style="width: 8%">
                                                                <col span="1" style="width: 10%">
                                                                <col span="1" style="width: 11%">
                                                                <col span="1" style="width: 3%">
                                                            </colgroup>
                                                            <thead>
                                                                <th width="30%">PRODUCT</th>
                                                                <th>HSN</th>
                                                                <th>UNIT PRICE</th>
                                                                <th>QTY</th>
                                                                <th>TOTAL</th>
                                                                <th>TAX</th>
                                                                <th>GST</th>
                                                                <th>TOTAL</th>
                                                                <th>DELETE</th>
                                                            </thead>
                                                            <tbody id="purchaseTableBody">
                                                                <tr id="row0">
                                                                    <td style="max-width: 150px;">
                                                                        <select class="select2 products" style="width: 100%" id="productSelect0" name="productSelect[]" onchange="productSelected(this.value,0)">
                                                                            <option value="">Select Product</option>
                                                                            <option value="addProduct">{ Add Product }</option>
                                                                            @php
                                                                                $products = DB::table('products')->get();
                                                                            @endphp
                                                                            @foreach ($products as $product)
                                                                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td id="hsn0"></td>
                                                                    <td><input class="form-control" type="number" value="" id="unitPrice0" name="unitPrice[]" step=".01" onkeyup="calculateTotal(0)" onchange="calculateTotal(0)" style="width: 100%"></td>
                                                                    <td><input class="form-control" id="productQty0" name="productQty[]" type="number" step=".01" value="1" onkeyup="calculateTotal(0)" min="0" onchange="calculateTotal(0)" style="width: 100%"></td>
                                                                    <td id="total0" onchange="calculateGSTAndTotal(0)">₹0</td>
                                                                    <td>
                                                                        <select class="form-control" name="productTax[]" id="product_tax0" onchange="calculateNewGST(this.value,0)">
                                                                            <option value="0" id="0Value_0">0</option>
                                                                            <option value="3" id="3Value_0">3</option>
                                                                            <option value="5" id="5Value_0">5</option>
                                                                            <option value="12" id="12Value_0">12</option>
                                                                            <option value="18" id="18Value_0">18</option>
                                                                            <option value="28" id="28Value_0">28</option>
                                                                        </select>
                                                                    </td>
                                                                    <td id="gst0">₹0</td>
                                                                    <td style="font-weight:bold" id="stotal0" class="sTotal">₹0</td>
                                                                    <td class="text-danger"><i class="bx bx-trash" id="delete0" onclick="deleteRow(0)"></i></td>
                                                                    <input type="hidden" name="total[]" id="hidden_total_0">
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mb-3" style="text-align: right">
                                                        <button class="btn btn-primary" type="button" id="addMoreButton" onclick="addNewRow()">Add More<i class="bx bx-plus"></i></button>
                                                    </div>
                                                    <h5>Enter Discount : </h5>
                                                    <input type="number" class="mb-3 form-control" name="discount" id="discount" onkeyup="calculateDiscount()" placeholder="Discount" step="0.01" value="{{ old('discount') }}" style="width: 30%">
                                                    <div class="mb-3" style="text-align: right">
                                                        <h4 style="margin-right: 5%"><b id="grandTotalBold">Grand total : ₹0</b></h4>
                                                        <input type="hidden" name="grand_total" id="grand_total">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="purchase_submit_btn" disabled>Save Details</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <!-- end card-->


                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <div id="addSellerModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Add Seller Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Name</label>
                                        <input class="form-control" id="sellerName" name="sellerName" type="text" required>
                                        <small style="color: red; display: none" id="sellerNameErrorMsg" >* Seller name cannot be empty</small>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Opening Balance</label>
                                        <input id="openingBalance" name="openingBalance" type="number" class="form-control" placeholder="" Value="0">
                                        <small style="color: red; display: none" id="sellerOpErrorMsg" >* Opening balance cannot be empty</small>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerPhone" class="col-form-label">Phone</label>
                                        <input id="sellerPhone" name="sellerPhone" type="text" class="form-control validate" placeholder="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerMobile" class="col-form-label">Mobile</label>
                                        <input id="sellerMobile" name="sellerMobile" type="text" class="form-control validate" placeholder="">
                                        <small style="color: red; display: none" id="sellerMobileErrorMsg" >* Seller mobile cannot be empty</small>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Place</label>
                                        <input class="form-control" id="sellerCity" name="sellerCity" type="text" value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerArea" class="col-form-label">City</label>
                                        <div class="col-md-12">
                                            <input type="text" name="sellerArea" class="form-control" id="sellerArea" value="">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerEmail" class="col-form-label">Email</label>
                                        <input id="sellerEmail" name="sellerEmail" type="email" class="form-control validate" placeholder="" value="" style="text-transform:lowercase;">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerPincode" class="col-form-label">Pincode</label>
                                        <input id="sellerPincode" name="sellerPincode" type="text" class="form-control validate" placeholder="" value="">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label class="col-form-label">State</label>
                                        <select class="form-control form-select" id="sellerState" name="sellerState" onchange="getDistrict(this.value)">
                                            <option value="">Select State</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option value="Andaman and Nicobar">Andaman and Nicobar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Capital Territory of Delhi">Capital Territory of Delhi</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4 col-md-4">
                                        <label class="col-form-label">District</label>
                                        <select class="form-control form-select" id="sellerDistrict" name="sellerDistrict">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4 col-md-4">
                                        <label class="col-form-label">State Code</label>
                                        <input class="form-control" id="sellerStateCode" name="sellerStateCode" readonly>
                                    </div>
                                    <br><h5>Bank Account Details</h5>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerBankAccountNumber" class="col-form-label">Account Number</label>
                                        <input id="sellerBankAccountNumber" name="sellerBankAccountNumber" type="number" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerBankIfscCode" class="col-form-label">IFSC Code</label>
                                        <input id="sellerBankIfscCode" name="sellerBankIfscCode" type="text" class="form-control validate" placeholder="" Value="" onkeyup="getBankDetails(this.value);">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerBankName" class="col-form-label">Bank</label>
                                        <input id="sellerBankName" name="sellerBankName" type="text" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerBankBranch" class="col-form-label">Branch</label>
                                        <input id="sellerBankBranch" name="sellerBankBranch" type="text" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <br><h5>Other Details</h4>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerGstNumber" class="col-form-label">GST Number</label>
                                        <input id="sellerGstNumber" name="sellerGstNumber" type="text" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerPanNumber" class="col-form-label">PAN Number</label>
                                        <input id="sellerPanNumber" name="sellerPanNumber" type="text" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerTinNumber" class="col-form-label">TIN Number</label>
                                        <input id="sellerTinNumber" name="sellerTinNumber" type="text" class="form-control validate" placeholder="" Value="">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="sellerStatus" class="col-form-label">Status</label>
                                        <input id="sellerStatus" name="sellerStatus" type="text" class="form-control validate" Value="Active" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <button type="button" class="btn btn-primary" name="addSellerButton" onclick="registerSeller()">Add Seller</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <div id="addProductModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Add Product Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="productRegistrationForm" enctype="multipart/form-data" method="POST" action="javascript:void(0)">
                                    <div class="row">
                                        <div class="form-group mb-3 col-md-6">
                                            <label class="col-form-label">Product Name *</label>
                                            <input id="product_name" name="product_name" type="text" class="form-control" placeholder="" Value="">
                                            <small id="productNameError" style="display:none" class="text-danger">Product Name cannot be empty</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="hsn_code" class="col-form-label">HSN CODE</label>
                                            <input id="hsn_code" name="hsn_code" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_unit_details" class="col-form-label">Unit Type</label>
                                            <select id="product_unit_details" name="product_unit_details" class="form-control validate">
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
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label class="col-form-label">Category *</label>
                                            <select class="select2 form-control" id="category_id" name="category_id" onchange="category_modal(this.value)" style="width:100%;" data-dropdown-parent="#productRegistrationForm">
                                                <option value="">Select Category</option>
                                                <option value="new category">{ New Category }</option>
                                                @php
                                                    $categories = DB::table('product_categories')->get();
                                                @endphp
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="categoryError" style="display: none">Category cannot be empty!</small>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label class="col-form-label">GST Schedule</label>
                                            <select class="form-control" id="product_schedule" name="product_schedule" onchange="getGST(this.value)">
                                                <option value="">Select GST Schedule</option>
                                                <option value="SCHEDULE 1">GST SCHEDULE I</option>
                                                <option value="SCHEDULE 2">GST SCHEDULE II</option>
                                                <option value="SCHEDULE 3">GST SCHEDULE III</option>
                                                <option value="SCHEDULE 4">GST SCHEDULE IV</option>
                                                <option value="SCHEDULE 5">GST SCHEDULE V</option>
                                                <option value="SCHEDULE 6">GST SCHEDULE VI</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_cgst" class="col-form-label">CSGT</label>
                                            <input id="product_cgst" name="product_cgst" type="text" class="form-control validate" placeholder="" value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_sgst" class="col-form-label">SGST</label>
                                            <input id="product_sgst" name="product_sgst" type="text" class="form-control validate" placeholder="" value="">
                                        </div>
                                        <br><h5>Other Details</h5>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_warrenty" class="col-form-label">Warrenty</label>
                                            <input id="product_warrenty" name="product_warrenty" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_expiry_date" class="col-form-label">Expiry Date</label>
                                            <input id="product_expiry_date" name="product_expiry_date" type="date" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_selling_price" class="col-form-label">Selling Price</label>
                                            <input id="product_selling_price" name="product_selling_price" type="text" class="form-control validate" placeholder="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_price" class="col-form-label">Price</label>
                                            <input id="product_price" name="product_price" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_mrp" class="col-form-label">MRP</label>
                                            <input id="product_mrp" name="product_mrp" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_supplier" class="col-form-label">Supplier</label>
                                            <select class="form-control select2" style="width: 100%" data-dropdown-parent="#productRegistrationForm" id="product_supplier" name="product_supplier">
                                                <option selected disabled>Select Supplier</option>
                                                @php
                                                    $sellers = DB::table('sellers')->get();
                                                @endphp
                                                @foreach ($sellers as $seller)
                                                    <option value="{{ $seller->seller_name }}">{{ $seller->seller_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_company" class="col-form-label">Company</label>
                                            <input id="product_company" name="product_company" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_brand" class="col-form-label">Brand</label>
                                            <input id="product_brand" name="product_brand" type="text" class="form-control validate" placeholder="" Value="">
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_description" class="col-form-label">Description</label>
                                            <textarea id="product_description" name="product_description" type="text" class="form-control validate" Value="">
                                            </textarea>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label for="product_image" class="col-form-label">Product Image</label>
                                            <input type="file" class="form-control" name="product_image" id="product_image">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-end">
                                            <button type="submit" class="btn btn-primary" name="addProductButton">Add Product</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- new category modal -->
                <div id="newCategoryModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title add-task-title">New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="NewtaskForm" method="POST" action="{{ route('product_category.store') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="taskname" class="col-form-label">Category</label>
                                    <div class="col-lg-12">
                                        <input id="category_name" name="category_name" type="text" class="form-control validate" placeholder="" Value="{{ old('category_name') }}">
                                        @error('category_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <button type="button" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Saving..';add_new_category();">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

@endsection
