@extends('layouts.layout')
@section('content')
    <style>
        .w-100 {
            width: 100%;
        }

        .w-85 {
            width: 85%;
        }

        .w-50 {
            width: 50%;
        }

        .w-25 {
            width: 25%;
        }

        .w-15 {
            width: 15%;
        }
    </style>
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

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $.ajax({
            //     type : "get",
            //     url : "{{ route('getCustomerDetails') }}",
            //     success : function(res)
            //     {
            //         // console.log(res);
            //         autocomplete(document.getElementById("customer_name"), res);
            //     }
            // });

            loadInvoiceNumber("No");

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        function loadInvoiceNumber(isGst) {
            $.ajax({
                type: "get",
                url: "{{ route('getLatestInvoiceNumber') }}",
                data: {
                    isGst: isGst
                },
                success: function(res) {
                    // console.log(res);
                    console.log(res);
                    $("#invoice_number").val(res);
                }
            });
        }

        function showGSTNumber(decision) {
            if (decision == "Yes") {
                document.getElementById("gstDiv").style.display = "block";
                loadInvoiceNumber(decision);
            }

            if (decision == "No") {
                document.getElementById("gstDiv").style.display = "none";
                loadInvoiceNumber(decision);
            }

        }

        function calculateDiscount() {
            var discountAmount = $("#discount").val();
            if (discountAmount == '' || discountAmount < 0) {
                discountAmount = 0;
            } else {
                discountAmount = parseFloat(discountAmount).toFixed(2);
            }
            discountedAmount = parseFloat(gTotal).toFixed(2) - discountAmount;
            $("#grandTotalBold").html("Grand total : ₹" + parseFloat(discountedAmount).toFixed(2));
            // console.log(discountedAmount);
        }

        function calculateNewGST(gstPercent, rowCount) {
            var priceWithTax = parseFloat($("#priceWithTax" + rowCount).val()) || 0;
            var quantity = parseFloat($("#productQty" + rowCount).val()) || 0;
            var gstPercent = parseFloat(gstPercent);
            var unitPrice = (priceWithTax / (100 + gstPercent)) * 100;
            var total = unitPrice * quantity;
            {{--  console.log(priceWithTax);  --}}
            document.getElementById("unitPrice" + rowCount).value = unitPrice.toFixed(2);
            document.getElementById("total" + rowCount).innerHTML = total.toFixed(2);
            {{--  console.log("total -"+total);  --}}
            var newTotal = (total * parseFloat(gstPercent) / 100).toFixed(2);
            {{--  console.log("newTotal-"+newTotal);  --}}
            $("#gst" + rowCount).html(newTotal);
            var newSTotal = total + newTotal;
            $("#stotal" + rowCount).html(newSTotal.toFixed(2));
            $("#total_hidden_" + rowCount).val(newSTotal.toFixed(2));
            calculateGrandTotal();
            calculateDiscount();
        }

        function calculateGrandTotal() {
            gTotal = 0;
            $(".sTotal").each(function() {
                gTotal += parseFloat($(this).text() || 0);
            });
            $("#grandTotalBold").html("Grand total : ₹" + gTotal.toFixed(2));
            $("#grand_total").val(gTotal.toFixed(2));
        }

        function calculateGSTAndTotal(rowNumber) {
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

        function calculateTotal(rowNumber) {
            var priceWithTax = parseFloat($("#priceWithTax" + rowNumber).val()) || 0;
            var productTax = parseFloat($("#product_tax" + rowNumber).val()) || 0;
            {{--  console.log(productTax);  --}}
            var quantity = parseFloat($("#productQty" + rowNumber).val()) || 0;
            var unitPrice = (priceWithTax / (100 + productTax)) * 100;
            var total = unitPrice * quantity;
            document.getElementById("unitPrice" + rowNumber).value = unitPrice.toFixed(2);
            document.getElementById("total" + rowNumber).innerHTML = total.toFixed(2);
            calculateGSTAndTotal(rowNumber);
            calculateGrandTotal();
            calculateDiscount();
            checkStock(rowNumber);
        }

        function checkStock(rowNumber) {
            var product = $("#product_id" + rowNumber).val();
            var qty = $("#productQty" + rowNumber).val();

            $.ajax({
                type: "get",
                url: "{{ route('checkStock') }}",
                data: {
                    product: product,
                    quantity: qty
                },
                success: function(res) {
                    // console.log(res);
                    if (res == true) {
                        stockOk = true;
                        if (document.getElementById("stockError" + rowNumber)) {
                            document.getElementById("stockError" + rowNumber).remove();
                        }
                    } else {
                        stockOk = false;
                        if (document.getElementById("stockError" + rowNumber)) {
                            document.getElementById("stockError" + rowNumber).innerHTML = "Out of stock";
                        } else {
                            var errorSmall = document.createElement("small");
                            errorSmall.setAttribute("id", "stockError" + rowNumber);
                            errorSmall.setAttribute("class", "text-danger");
                            errorSmall.innerHTML = "Out of stock";
                            document.getElementById("qtyTD" + rowNumber).appendChild(errorSmall);
                        }
                    }
                }
            });
        }

        function getGST(schedule) {
            if (schedule == "SCHEDULE 1") {
                $("#product_cgst").val('0');
                $("#product_sgst").val('0');
            } else if (schedule == "SCHEDULE 2") {
                $("#product_cgst").val('1.5');
                $("#product_sgst").val('1.5');
            } else if (schedule == "SCHEDULE 3") {
                $("#product_cgst").val('2.5');
                $("#product_sgst").val('2.5');
            } else if (schedule == "SCHEDULE 4") {
                $("#product_cgst").val('6');
                $("#product_sgst").val('6');
            } else if (schedule == "SCHEDULE 5") {
                $("#product_cgst").val('9');
                $("#product_sgst").val('9');
            } else if (schedule == "SCHEDULE 6") {
                $("#product_cgst").val('14');
                $("#product_sgst").val('14');
            } else if (schedule == '') {
                $("#product_cgst").val('');
                $("#product_sgst").val('');
            }
        }

        function deleteRow(row) {
            $("#row" + row).remove();
            $("#discount").val(0);
            calculateGrandTotal();
            tableRows = tableRows.filter(function(e) {
                return e !== row
            });
            // console.log(tableRows);
            selectedProducts[row] = null;
            enable_btn();
        }

        function addNewRow() {
            // console.log("Clicked add button");

            var newRow = document.createElement("tr");
            newRow.setAttribute("id", "row" + count);

            //Column1
            var newColumn1 = document.createElement("td");
            newColumn1.setAttribute("style", "max-width:150px;");
            newColumn1.setAttribute("id", "prod" + count);
            var newProductSel = document.createElement("select");
            newProductSel.setAttribute("class", "select2 products");
            newProductSel.setAttribute("style", "width: 100%");
            newProductSel.setAttribute("id", "productSelect" + count);
            newProductSel.setAttribute("name", "productSelect[]");
            newProductSel.setAttribute("onchange", "productSelected(this.value," + count + ")");

            $.ajax({
                type: "get",
                // url: "{{ route('getProductsInStock') }}",
                url : "../getProducts",
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    var newOption1 = document.createElement("option");
                    newOption1.setAttribute("value", "");
                    newOption1.innerHTML = "Select Product";
                    newProductSel.appendChild(newOption1);

                    for (var i = 0; i < response.length; i++) {
                        var newDynamicOption = document.createElement("option");
                        newDynamicOption.setAttribute("value", response[i].id);
                        newDynamicOption.innerHTML = response[i].product_name;
                        newProductSel.appendChild(newDynamicOption);
                        // console.log("Added option");
                    }
                }
            });
            newColumn1.appendChild(newProductSel);

            //Column 2
            var newColumn2 = document.createElement("td");
            var newSerial = document.createElement("input");
            newSerial.setAttribute("type", "text");
            newSerial.setAttribute("class", "form-control");
            newSerial.setAttribute("value", "");
            newSerial.setAttribute("id", "serial" + count);
            newSerial.setAttribute("name", "serial[]");
            newSerial.setAttribute("style", "width: 100%; text-transform: uppercase");
            newColumn2.appendChild(newSerial);

            //Column 3
            var newColumn3 = document.createElement("td");
            var newPriceWithTax = document.createElement("input");
            newPriceWithTax.setAttribute("type", "number");
            newPriceWithTax.setAttribute("step", ".01");
            newPriceWithTax.setAttribute("value", "");
            newPriceWithTax.setAttribute("class", "form-control");
            newPriceWithTax.setAttribute("id", "priceWithTax" + count);
            newPriceWithTax.setAttribute("onkeyup", "calculateTotal(" + count + ")");
            newPriceWithTax.setAttribute("onchange", "calculateTotal(" + count + ")");
            newPriceWithTax.setAttribute("style", "width:100%");
            newColumn3.appendChild(newPriceWithTax);

            //Column 10
            var newColumn10 = document.createElement("td");
            var newUnitPrice = document.createElement("input");
            newUnitPrice.setAttribute("type", "number");
            newUnitPrice.setAttribute("step", ".01");
            newUnitPrice.setAttribute("value", "");
            newUnitPrice.setAttribute("class", "form-control");
            newUnitPrice.setAttribute("id", "unitPrice" + count);
            newUnitPrice.setAttribute("name", "unitPrice[]");
            newUnitPrice.setAttribute("readonly", "readonly");
            newUnitPrice.setAttribute("onchange", "calculateTotal(" + count + ")");
            newUnitPrice.setAttribute("style", "width:100%");
            newColumn10.appendChild(newUnitPrice);

            //Column 4
            var newColumn4 = document.createElement("td");
            newColumn4.setAttribute("id", "qtyTD" + count);
            var newQty = document.createElement("input");
            newQty.setAttribute("type", "number");
            newQty.setAttribute("value", "1");
            newQty.setAttribute("class", "form-control");
            newQty.setAttribute("id", "productQty" + count);
            newQty.setAttribute("name", "productQty[]");
            newQty.setAttribute("min", "0");
            newQty.setAttribute("step", ".10");
            newQty.setAttribute("onkeyup", "calculateTotal(" + count + ")");
            newQty.setAttribute("onchange", "calculateTotal(" + count + ")");
            newQty.setAttribute("style", "width:100%");
            newColumn4.appendChild(newQty);

            //Column 5
            var newColumn5 = document.createElement("td");
            newColumn5.setAttribute("id", "total" + count);
            newColumn5.setAttribute("onchange", "calculateGSTAndTotal(" + count + ")");
            newColumn5.innerHTML = "₹0";

            //Column 6
            var newColumn6 = document.createElement("td");

            //Tax Select
            var taxSelect = document.createElement("select");
            taxSelect.setAttribute("class", "form-control");
            taxSelect.setAttribute("name", "productTax[]");
            taxSelect.setAttribute("id", "product_tax" + count);
            taxSelect.setAttribute("onchange", "calculateNewGST(this.value," + count + ")");

            var newOption1 = document.createElement("option");
            newOption1.setAttribute("value", "0");
            newOption1.setAttribute("id", "0Value_" + count);
            newOption1.innerHTML = 0;

            var newOption2 = document.createElement("option");
            newOption2.setAttribute("value", "3");
            newOption2.setAttribute("id", "3Value_" + count);
            newOption2.innerHTML = 3;

            var newOption3 = document.createElement("option");
            newOption3.setAttribute("value", "5");
            newOption3.setAttribute("id", "5Value_" + count);
            newOption3.innerHTML = 5;

            var newOption4 = document.createElement("option");
            newOption4.setAttribute("value", "12");
            newOption4.setAttribute("id", "12Value_" + count);
            newOption4.innerHTML = 12;

            var newOption5 = document.createElement("option");
            newOption5.setAttribute("value", "18");
            newOption5.setAttribute("id", "18Value_" + count);
            newOption5.innerHTML = 18;

            var newOption6 = document.createElement("option");
            newOption6.setAttribute("value", "28");
            newOption6.setAttribute("id", "28Value_" + count);
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
            newColumn8.setAttribute("id", "stotal" + count);
            newColumn8.setAttribute("class", "sTotal");
            newColumn8.setAttribute("style", "font-weight:bold");
            newColumn8.innerHTML = "₹0";

            //Column 9
            var newColumn9 = document.createElement("td");
            newColumn9.setAttribute("class", "text-danger");
            var deleteIcon = document.createElement("i");
            deleteIcon.setAttribute("class", "bx bx-trash");
            deleteIcon.setAttribute("id", "delete" + count);
            deleteIcon.setAttribute("onclick", "deleteRow(" + count + ")");
            newColumn9.appendChild(deleteIcon);

            //Hidden 1
            var stateGST = document.createElement("input");
            stateGST.setAttribute("type", "hidden");
            stateGST.setAttribute("name", "total[]");
            stateGST.setAttribute("id", "total_hidden_" + count);

            var tableBody = document.getElementById("purchaseTableBody");
            newRow.appendChild(newColumn1);
            newRow.appendChild(newColumn2);
            newRow.appendChild(newColumn3);
            newRow.appendChild(newColumn10);
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

        function clearTableFields(row) {
            document.getElementById("priceWithTax" + row).value = '';
            document.getElementById("productQty" + row).value = '';
            document.getElementById("total" + row).innerHTML = '';
            document.getElementById("gst" + row).innerHTML = '';
            document.getElementById("stotal" + row).innerHTML = '';
        }

        function productSelected(productValue, row) {
            if (productValue == "addProduct") {
                $("#addProductModal").modal("toggle");
                $("#addProductModal").modal("show");
                clearTableFields(row);
            } else {
                if (productValue != '') {
                    $.ajax({
                        type: "get",
                        url: "../getProductDetails",
                        dataType: "json",
                        data: {
                            product: productValue
                        },
                        success: function(response) {
                            if (productValue != 159) {
                                if (selectedProducts.includes(productValue)) {
                                    document.getElementById("alreadyAddedProduct").style.display = "block";
                                    deleteRow(row);
                                } else {
                                    document.getElementById("alreadyAddedProduct").style.display = "none";
                                    tableRows.push(row);
                                    // console.log(tableRows);
                                    {{--  console.log(response.stock_qty);  --}}
                                    document.getElementById("priceWithTax" + row).value = response
                                    .product_price;
                                    document.getElementById("productQty" + row).value = 1;
                                    document.getElementById("productQty" + row).max = response.stock_qty;
                                    var priceWithTax = response.product_price;
                                    var cgst = parseFloat((response.product_cgst * response.product_price) /
                                        100);
                                    var sgst = parseFloat((response.product_sgst * response.product_price) /
                                        100);
                                    var gst = parseFloat(response.product_cgst) + parseFloat(response
                                        .product_sgst);
                                    var unitPrice = (priceWithTax / (100 + gst)) * 100;
                                    {{--  console.log(unitPrice)  --}}
                                    document.getElementById("unitPrice" + row).value = unitPrice.toFixed(2);
                                    document.getElementById("total" + row).innerHTML = unitPrice.toFixed(2);
                                    var tax = parseFloat((gst * unitPrice) / 100);
                                    if (gst == 0) {
                                        document.getElementById("0Value_" + row).setAttribute("selected",
                                            "selected");
                                    } else if (gst == 3) {
                                        document.getElementById("3Value_" + row).setAttribute("selected", "");
                                    } else if (gst == 5) {
                                        document.getElementById("5Value_" + row).setAttribute("selected", "");
                                    } else if (gst == 12) {
                                        document.getElementById("12Value_" + row).setAttribute("selected", "");
                                    } else if (gst == 18) {
                                        document.getElementById("18Value_" + row).setAttribute("selected", "");
                                    } else if (gst == 28) {
                                        document.getElementById("28Value_" + row).setAttribute("selected", "");
                                    }
                                    selectedProducts[row] = productValue;
                                    // console.log(selectedProducts);
                                    document.getElementById("gst" + row).innerHTML = tax.toFixed(2);
                                    var stotal = parseFloat(unitPrice) + tax;
                                    document.getElementById("stotal" + row).innerHTML = stotal.toFixed(2);
                                    document.getElementById("total_hidden_" + row).value = stotal.toFixed(2);
                                    calculateGrandTotal();
                                }
                            }
                        }
                    });
                } else {
                    clearTableFields(row);
                }
            }
            enable_btn()
        }

        function getCustomerDetails(customerValue) {
            if (customerValue != '') {
                if (customerValue == "addNewCustomer") {
                    $("#newCustomerModal").modal("toggle");
                    $("#newCustomerModal").modal("show");
                } else {
                    $.ajax({
                        type: "get",
                        url: "{{ route('getCustomerDetails') }}",
                        data: {
                            customer: customerValue
                        },
                        success: function(res) {
                            // console.log(res);
                            if (res.gst_no) {
                                $("#gst_number").val(res.gst_no);
                                $("#GSTNo").removeAttr("checked");
                                $("#GSTYes").attr('checked', '');
                                showGSTNumber("Yes")
                            } else {
                                $("#gst_number").val('');
                                $("#GSTYes").removeAttr("checked");
                                $("#GSTNo").attr('checked', '');
                                showGSTNumber("No");
                            }
                            $("#customer_name").val(res.name);
                            $("#customer_phone").val(res.mobile);
                        }
                    });
                    enable_btn();
                }
            } else {
                showGSTNumber("No");
                $("#customer_name").val('');
                $("#customer_phone").val('');
                $("#gst_number").val('');
            }
        }

        function addCustomerDetails() {
            var customerNameFromModal = $("#name").val();
            var customerMobile = $("#mobile").val();
            var customerPlace = $("#place").val();
            var customerEmail = $("#customer_email").val();
            var customerGSTNumber = $("#gst_no").val();
            var isValid = true;

            if (customerNameFromModal == '') {
                document.getElementById("customerNameError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("customerNameError").style.display = "none";
            }

            if (customerMobile == '' || customerMobile.length != 10 || !/^\d{10}$/.test(customerMobile)) {
                document.getElementById("customerMobileError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("customerMobileError").style.display = "none";
            }
            if (isValid) {
                document.getElementById("addCustomer").disabled = true;
                document.getElementById("addCustomer").innerHTML = "Saving...";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('addNewCustomer') }}",
                    data: {
                        name: customerNameFromModal,
                        mobile: customerMobile,
                        place: customerPlace,
                        email: customerEmail,
                        gst_no: customerGSTNumber
                    },
                    success: function(response) {
                        console.log(response);
                        if (response != "Error") {
                            var newOption = "<option value='" + response.id + "'>" + response.name + ", " +
                                response.place + "</option>";
                            $("#customer_id").append(newOption);
                            $("#newCustomerModal").modal("toggle");
                            document.getElementById("addCustomer").disabled = false;
                            document.getElementById("addCustomer").innerHTML = "Save Details";
                        }
                    }
                });
            }
        }

        function enable_btn() {
            var pay_method = document.getElementById('pay_method').value;
            var customer_name = document.getElementById('customer_id').value;
            var sales_person = document.getElementById('sales_staff').value;
            var productSelects = document.getElementsByName('productSelect[]');
            var allEmpty = Array.from(productSelects).every(select => select.value === '');
            var requiredFieldsEmpty = pay_method === '' || customer_name === '' || sales_person === '';
            var shouldDisable = allEmpty || requiredFieldsEmpty;
            document.getElementById('sales_submit_btn').disabled = shouldDisable;
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

                                <form action="{{ route('directSales.store') }}" method="POST" enctype="multipart/form-data"
                                    id="salesForm" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="invoice_number">Invoice No</label>
                                                <input id="invoice_number" name="invoice_number" type="text"
                                                    class="form-control" value="{{ old('invoice_number') }}" readonly>
                                                <small class="text-danger" id="invoiceNumberError"
                                                    style="display: none">Invoice number cannot be empty</small>
                                                @error('invoice_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="sales_date">Sales Date</label>
                                                <input id="sales_date" name="sales_date" type="date" class="form-control"
                                                    value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}"
                                                    readonly>
                                                @error('sales_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="customer_phone" class="control-label">Customer Mobile</label>
                                                <input id="customer_phone" name="customer_phone" type="tel"
                                                    class="form-control" value="{{ old('customer_phone') }}"
                                                    pattern="[0-9]{10}">
                                                <small class="text-danger" id="mobileNumberError"
                                                    style="display: none">Mobile Number is invalid or empty</small>
                                                @error('customer_phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="control-label">GST Available</label>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label id="labelYes" class="control-label">YES</label>
                                                        <input for="labelYes" id="GSTYes" name="gst_available"
                                                            type="radio" value="Yes"
                                                            onclick="showGSTNumber(this.value)">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label id="labelNo" class="control-label">NO</label>
                                                        <input for="labelNo" id="GSTNo" name="gst_available"
                                                            type="radio" value="No" checked
                                                            onclick="showGSTNumber(this.value)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="control-label">Payment Method</label>
                                                <select class="form-control select2" name="pay_method" id="pay_method"
                                                    onchange="enable_btn()" required>
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="CASH">CASH</option>
                                                    <option value="ACCOUNT">ACCOUNT</option>
                                                    <option value="CREDIT">CREDIT</option>
                                                </select>
                                                @error('pay_method')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- <div class="mb-3 autocomplete">
                                                        <label class="control-label">Customer Name</label>
                                                        <input id="customer_name" name="customer_name" type="text" class="form-control" value="{{ old('customer_name') }}" style="text-transform: uppercase">
                                                        <small class="text-danger" id="customerNameError" style="display: none">Customer Name cannot be empty</small>
                                                        @error('customer_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div> --}}
                                            <div class="mb-3 autocomplete">
                                                <label class="control-label">Customer Name</label>
                                                <input id="customer_name" name="customer_name" type="hidden"
                                                    style="text-transform: uppercase">
                                                <select id="customer_id" name="customer_id" type="text"
                                                    class="form-control select2" style="text-transform: uppercase" required
                                                    onchange="getCustomerDetails(this.value)">
                                                    <option value="" selected disabled>Select Customer</option>
                                                    <option value="addNewCustomer">[Add Customer]</option>
                                                    @php
                                                        $customers = DB::table('customers')->get();
                                                    @endphp
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }},
                                                            {{ $customer->place }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="customerNameError1" style="display: none"
                                                    class="text-danger">Customer Name cannot be empty!</small>
                                                @error('customer_id')
                                                    <span class="text-danger">Customer is required. Please select a customer
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="sales_staff">Sales Person</label>
                                                <select id="sales_staff" name="sales_staff" class="form-control select2"
                                                    onchange="enable_btn()" required>
                                                    <option value="" selected disabled>Select Staff</option>
                                                    @php
                                                        $staffs = DB::table('staffs')->where('status', 'active')->get();
                                                    @endphp
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff->id }}">
                                                            {{ strtoupper($staff->staff_name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('sales_staff')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3" id="gstDiv" style="display: none">
                                                <label class="control-label">GST Number</label>
                                                <input id="gst_number" name="gst_number" type="text"
                                                    class="form-control" value="{{ old('gst_number') }}">
                                                <small class="text-danger" id="gstNumberError" style="display: none">GST
                                                    Number cannot be empty</small>
                                                @error('gst_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label>Products</label>
                                                <small class="text-danger" id="productsError"
                                                    style="display: none">Please add any products before saving</small>
                                                <div class="table-responsive">
                                                    <table class="table" id="productsTable" style="width: 100%;">
                                                        {{-- <colgroup>
                                                                    <col span="1" style="width: 25%">
                                                                    <col span="1" style="width: 20%">
                                                                    <col span="1" style="width: 10%">
                                                                    <col span="1" style="width: 9%">
                                                                    <col span="1" style="width: 8%">
                                                                    <col span="1" style="width: 8%">
                                                                    <col span="1" style="width: 7%">
                                                                    <col span="1" style="width: 8%">
                                                                    <col span="1" style="width: 5%">
                                                                </colgroup> --}}
                                                        <thead>
                                                            <th class="w-25">PRODUCT</th>
                                                            <th class="w-15">DESCRIPTION</th>
                                                            <th class="w-15">PRICE WITH TAX</th>
                                                            <th class="w-15">UNIT PRICE</th>
                                                            <th class="w-15">QTY</th>
                                                            <th class="w-10">TAXABLE</th>
                                                            <th class="w-15">TAX</th>
                                                            <th class="w-15">GST</th>
                                                            <th class="w-15">TOTAL</th>
                                                            <th class="w-10">DELETE</th>
                                                        </thead>
                                                        <tbody id="purchaseTableBody">
                                                            <small class="text-danger" id="alreadyAddedProduct"
                                                                style="display: none">Product Already added</small>
                                                            <tr id="row0">
                                                                <td id="prod0" style="max-width: 150px;">
                                                                    <select class="select2 products" style="width: 100%"
                                                                        id="productSelect0" name="productSelect[]"
                                                                        onchange="productSelected(this.value,0)">
                                                                        <option value="">Select Product</option>
                                                                        @php
                                                                            // $inStockProducts = DB::table('stocks')
                                                                            //     ->where('product_qty', '>', 0)
                                                                            //     ->get();

                                                                            $products = DB::table('products')->get();
                                                                        @endphp
                                                                        @foreach ($products as $product)
                                                                            {{-- @php
                                                                                $products = DB::table('products')
                                                                                    ->where('id', $product->product_id)
                                                                                    ->first();
                                                                                $stocks = DB::table('stocks')
                                                                                    ->where('product_id', $products->id)
                                                                                    ->first();
                                                                            @endphp --}}
                                                                            <option value="{{ $product->id }}">
                                                                                {{ $product->product_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><input class="form-control" type="text"
                                                                        value="" id="serial0" name="serial[]"
                                                                        style="width: 100%; text-transform: uppercase">
                                                                </td>
                                                                <td><input class="form-control" type="number"
                                                                        value="" id="priceWithTax0" step=".01"
                                                                        min="0" onkeyup="calculateTotal(0)"
                                                                        onchange="calculateTotal(0)" style="width: 100%">
                                                                </td>
                                                                {{--  <td><span id="unitPrice0" name="unitPrice[]" onchange="calculateTotal(0)">₹0</span></td>  --}}
                                                                <td><input class="form-control" type="number"
                                                                        value="" id="unitPrice0" name="unitPrice[]"
                                                                        step=".01" onchange="calculateTotal(0)"
                                                                        style="width: 100%" readonly></td>
                                                                <td id="qtyTD0"><input class="form-control"
                                                                        id="productQty0" name="productQty[]"
                                                                        type="number" step=".10" value="1"
                                                                        onkeyup="calculateTotal(0)" min="0"
                                                                        onchange="calculateTotal(0)" style="width: 100%">
                                                                </td>
                                                                <td id="total0" onchange="calculateGSTAndTotal(0)">₹0
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="productTax[]"
                                                                        id="product_tax0"
                                                                        onchange="calculateNewGST(this.value,0)"
                                                                        style="width:100%;">
                                                                        <option value="0" id="0Value_0">0</option>
                                                                        <option value="3" id="3Value_0">3</option>
                                                                        <option value="5" id="5Value_0">5</option>
                                                                        <option value="12" id="12Value_0">12</option>
                                                                        <option value="18" id="18Value_0">18</option>
                                                                        <option value="28" id="28Value_0">28</option>
                                                                    </select>
                                                                </td>
                                                                <td id="gst0">₹0</td>
                                                                <td style="font-weight:bold" id="stotal0"
                                                                    class="sTotal">₹0</td>
                                                                <td class="text-danger"><i class="bx bx-trash"
                                                                        id="delete0" onclick="deleteRow(0)"></i></td>
                                                                <input type="hidden" name="total[]" id="total_hidden_0">
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mb-3" style="text-align: right">
                                                <button class="btn btn-primary" type="button" id="addMoreButton"
                                                    onclick="addNewRow()">Add More&nbsp;<i
                                                        class="bx bx-plus"></i></button>
                                            </div>
                                            <h5>Enter Discount : </h5>
                                            <input type="number" class="mb-3 form-control" name="discount"
                                                id="discount" onkeyup="calculateDiscount()" placeholder="Discount"
                                                step="0.01" value="{{ old('discount') }}" style="width: 30%">
                                            <div class="mb-3" style="text-align: right">
                                                <h4 style="margin-right: 5%"><b id="grandTotalBold">Grand total : 0</b>
                                                </h4>
                                                <input type="hidden" name="grand_total" id="grand_total">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            id="sales_submit_btn" disabled>Save Details</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- end card-->
                    </div>
                </div>
                <!-- end row -->
                <!-- new customer modal -->
                <div id="newCustomerModal" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">New Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="customerForm">
                                    <div class="form-group mb-3">
                                        <label for="taskname" class="col-form-label">Customer Name</label>
                                        <div class="col-lg-12">
                                            <input id="name" name="name" type="text"
                                                class="form-control validate" placeholder="" value="">
                                            <small id="customerNameError" style="display: none"
                                                class="text-danger">Customer Name cannot be empty!</small>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="taskname" class="col-form-label">Customer Mobile</label>
                                        <div class="col-lg-12">
                                            <input id="mobile" name="mobile" type="text"
                                                class="form-control validate" placeholder=""
                                                Value="{{ old('mobile') }}">
                                            <small id="customerMobileError" style="display: none"
                                                class="text-danger">Mobile number must be 10 digits!</small>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="taskname" class="col-form-label">Customer Place</label>
                                        <div class="col-lg-12">
                                            <input id="place" name="place" type="text"
                                                class="form-control validate" placeholder=""
                                                Value="{{ old('place') }}">
                                            @error('place')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="taskname" class="col-form-label">Customer Email</label>
                                        <div class="col-lg-12">
                                            <input id="customer_email" name="customer_email" type="email"
                                                class="form-control validate" placeholder=""
                                                Value="{{ old('customer_email') }}" style="text-transform:lowercase;">
                                            @error('customer_email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="gst_no" class="col-form-label">GST No</label>
                                        <div class="col-lg-12">
                                            <input id="gst_no" name="gst_no" type="text"
                                                class="form-control validate" placeholder=""
                                                Value="{{ old('gst_no') }}">
                                            @error('gst_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mt-3 text-end">
                                            <button type="button" class="btn btn-primary" id="addCustomer"
                                                onclick="addCustomerDetails()">Save Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    @endsection
