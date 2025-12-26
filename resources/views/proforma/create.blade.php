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

        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        })
    </script>
    <script>
        var count = 1;
        let gst_status = 'no';

        function showGSTNumber(decision) {
            var gstDiv = document.getElementById("gstDiv");
            var elements = document.getElementsByClassName("gstTD");

            if (decision == "Yes") {
                gstDiv.style.display = "block";
                for (var i = 0; i < elements.length; i++) {
                    elements[i].style.display = "table-cell";
                }
                gst_status = 'yes';
                loadInvoiceNumber(decision);
            } else if (decision == "No") {
                gstDiv.style.display = "none";
                for (var i = 0; i < elements.length; i++) {
                    elements[i].style.display = "none";
                }
                gst_status = 'no';
                loadInvoiceNumber(decision);
            }
        }

        function set_date(valid_date) {
            document.getElementById('system_valid_upto').value = valid_date;
        }

        function set_name(customer_name) {
            document.getElementById('system_customer_name').value = customer_name;
            enable_btn();
        }

        function set_phone(customer_phone) {
            document.getElementById('system_customer_phone').value = customer_phone;
            enable_btn();
        }

        //for system estimate
        function system_calculateTotal(rowNumber) {
            var unitPrice = $("#system_unit_price" + rowNumber).val();
            console.log(unitPrice);

            var quantity = $("#system_product_qty" + rowNumber).val();
            var total = unitPrice * quantity;
            console.log(total);

            document.getElementById("system_total" + rowNumber).innerHTML = total.toFixed(2);
            document.getElementById("system_total_hidden" + rowNumber).value = total.toFixed(2);


            system_calculateGrandTotal();
        }

        function system_calculateGrandTotal() {
            var gTotal = 0;
            $(".System_total").each(function() {
                gTotal += parseFloat($(this).text() || 0);
            });
            $("#system_grand_total").html("Grand total : ₹" + gTotal.toFixed(2));
            document.getElementById("system_grand_total_hidden").value = gTotal.toFixed(2);

        }

        function clearSystemTableFields(row) {
            document.getElementById("warrenty" + row).innerHTML = '';
            document.getElementById("unitPrice" + row).value = '';
            document.getElementById("productQty" + row).value = '';
            document.getElementById("total" + row).innerHTML = '';
            system_calculateGrandTotal();
        }

        function system_reload_div(row_number) {
            console.log(row_number + 'new reload button clicked');
            $("#system_product_name_new" + row_number).removeAttr("name");
            $("#system_product_name" + row_number).attr('name', 'system_product_name[]');
            $("#system_product_name_new" + row_number).remove();
            $("#system_reload" + row_number).remove();


            var text_td = document.getElementById('td_text' + row_number)
            var select_td = document.getElementById('td_select' + row_number)
            select_td.style.display = 'block';
            text_td.style.display = 'none';
        }

        function get_system_product_details(product_id, row) {
            if (product_id == 'new product') {
                console.log('new product');


                var text_td = document.getElementById('td_text' + row)
                var select_td = document.getElementById('td_select' + row)


                $("#system_product_name" + row).removeAttr("name");
                select_td.style.display = 'none';
                text_td.style.display = 'block';

                var new_product_name = document.createElement("input");
                new_product_name.setAttribute("type", "text");
                new_product_name.setAttribute("class", "form-control");
                new_product_name.setAttribute("id", "system_product_name_new" + row);
                new_product_name.setAttribute("name", "system_product_name[]");
                new_product_name.setAttribute("onkeyup", "this.value = this.value.toUpperCase()");
                new_product_name.setAttribute("style", "width:100%");

                var new_div_reload = document.createElement("i");
                new_div_reload.setAttribute("class", "text-success bx bx-repost");
                new_div_reload.setAttribute("id", "system_reload" + row);
                new_div_reload.setAttribute("style", "float:right; font-size:18px;");
                new_div_reload.setAttribute("onclick", "system_reload_div(" + row + ")");

                text_td.appendChild(new_product_name);
                text_td.appendChild(new_div_reload);
            } else if (product_id != '' && product_id != 'new product') {
                $.ajax({
                    type: "get",
                    url: "{{ route('getProductDetails') }}",
                    dataType: "json",
                    data: {
                        product: product_id
                    },
                    success: function(response) {

                        console.log(row);
                        document.getElementById("system_unit_price" + row).value = response.product_price;
                        document.getElementById("system_product_qty" + row).value = 1;
                        document.getElementById("system_total" + row).innerHTML = response.product_price;
                        document.getElementById("system_total_hidden" + rowNumber).value = response
                            .product_price;


                        system_calculateGrandTotal();

                    }
                });
            } else {
                clearSystemTableFields(row);
            }

        }


        //for product estimate

        function calculateNewGST(gstPercent, rowCount) {
            var total = parseFloat($("#total" + rowCount).text());
            var newTotal = (total * parseFloat(gstPercent) / 100);
            $("#gst" + rowCount).html(newTotal);
            var newSTotal = total + newTotal;
            $("#stotal" + rowCount).html(newSTotal.toFixed(2));
            $("#total_hidden" + rowCount).val(newSTotal.toFixed(2));
            calculateGrandTotal();
        }

        function calculateGSTAndTotal(rowNumber) {
            console.log("working " + rowNumber);
            var gstPercentage = $("#product_tax" + rowNumber).val();
            console.log('gst_perc ' + gstPercentage);
            var gst = (parseFloat($("#total" + rowNumber).text()) * parseFloat(gstPercentage)) / 100;
            $("#gst" + rowNumber).html(gst.toFixed(2));
            var subTotal = gst + parseFloat($("#total" + rowNumber).text());
            $("#stotal" + rowNumber).html(subTotal.toFixed(2));
            $("#total_hidden" + rowNumber).val(subTotal.toFixed(2));
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            var gTotal = 0;
            $(".sTotal").each(function() {
                gTotal += parseFloat($(this).text() || 0);
            });
            $("#grandTotalBold").html("Grand total : ₹" + gTotal.toFixed(2));
            $("#grand_total_hidden").val(gTotal.toFixed(2));
        }

        function calculateTotal(rowNumber) {
            console.log('total function working')
            var unitPrice = $("#unitPrice" + rowNumber).val();
            var quantity = $("#productQty" + rowNumber).val();
            var total = unitPrice * quantity;
            console.log('total ' + total);

            document.getElementById("total" + rowNumber).innerHTML = total.toFixed(2);
            document.getElementById("total_hidden" + rowNumber).value = total.toFixed(2);
            calculateGSTAndTotal(rowNumber);
            calculateGrandTotal();
        }




        function deleteRow(row) {
            $("#row" + row).remove();
            calculateGrandTotal();
            tableRows = tableRows.filter(function(e) {
                return e !== row
            });
            // console.log(tableRows);
        }


        function add_new_row() {
            var newRow = document.createElement("tr");
            newRow.setAttribute("id", "row" + count);

            //Column1
            var newColumn1 = document.createElement("td");
            newColumn1.setAttribute("id", "td_product_select" + count);
            newColumn1.setAttribute("style", "max-width : 150px");
            var newProductSel = document.createElement("select");
            newProductSel.setAttribute("class", "select2 products");
            newProductSel.setAttribute("style", "width: 100%");
            newProductSel.setAttribute("id", "estimate_product" + count);
            newProductSel.setAttribute("name", "estimate_product[]");
            newProductSel.setAttribute("onchange", "get_product_details(this.value," + count + ")");

            $.ajax({
                type: "get",
                url: "{{ route('getProducts') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    newProductSel.innerHTML = '';
                    var newOption1 = document.createElement("option");
                    newOption1.setAttribute("value", "");
                    newOption1.innerHTML = "Select Product";
                    newProductSel.appendChild(newOption1);
                    var newOption2 = document.createElement("option");
                    newOption2.setAttribute("value", "new product");
                    newOption2.innerHTML = "{ New Product }";
                    newProductSel.appendChild(newOption2);

                    for (var i = 0; i < response.length; i++) {
                        var newDynamicOption = document.createElement("option");
                        newDynamicOption.setAttribute("value", response[i].id);
                        newDynamicOption.innerHTML = response[i].product_name;
                        newProductSel.appendChild(newDynamicOption);
                        console.log("Added option");
                    }
                }
            });
            newColumn1.appendChild(newProductSel);

            //Column product td hidden
            var new_product_hidden = document.createElement("td");
            new_product_hidden.setAttribute("id", "td_product_text" + count);
            new_product_hidden.setAttribute("style", "display:none");


            //Column 2
            // var newColumn2 = document.createElement("td");
            // var warrenty_col = document.createElement("input");
            // warrenty_col.setAttribute("type","text");
            // warrenty_col.setAttribute("value","1 YEAR");
            // warrenty_col.setAttribute("class","form-control");
            // warrenty_col.setAttribute("id","warrenty" + count);
            // warrenty_col.setAttribute("name","warrenty[]");
            // warrenty_col.setAttribute("style","width:100%");
            // newColumn2.appendChild(warrenty_col);

            //Column 3
            var newColumn3 = document.createElement("td");
            var newUnitPrice = document.createElement("input");
            newUnitPrice.setAttribute("type", "number");
            newUnitPrice.setAttribute("step", "1");
            newUnitPrice.setAttribute("value", "0");
            newUnitPrice.setAttribute("class", "form-control");
            newUnitPrice.setAttribute("id", "unitPrice" + count);
            newUnitPrice.setAttribute("name", "unitPrice[]");
            newUnitPrice.setAttribute("onkeyup", "calculateTotal(" + count + ")");
            newUnitPrice.setAttribute("onchange", "calculateTotal(" + count + ")");
            newUnitPrice.setAttribute("style", "width:100%");
            newColumn3.appendChild(newUnitPrice);

            //Column 4
            var newColumn4 = document.createElement("td");
            var newQty = document.createElement("input");
            newQty.setAttribute("type", "number");
            newQty.setAttribute("value", "1");
            newQty.setAttribute("class", "form-control");
            newQty.setAttribute("id", "productQty" + count);
            newQty.setAttribute("name", "qty[]");
            newQty.setAttribute("min", "0");
            newQty.setAttribute("step", "1");
            newQty.setAttribute("onkeyup", "calculateTotal(" + count + ")");
            newQty.setAttribute("onchange", "calculateTotal(" + count + ")");
            newQty.setAttribute("style", "width:100%");
            newColumn4.appendChild(newQty);


            //Column 5
            var newColumn5 = document.createElement("td");
            newColumn5.setAttribute("id", "total" + count);
            newColumn5.setAttribute("class", "gstTD");
            if (gst_status == 'no') {
                newColumn5.setAttribute("style", "display:none");
            }
            newColumn5.setAttribute("onchange", "calculateGSTAndTotal(" + count + ")");
            newColumn5.innerHTML = "₹0";

            //Column 6
            var newColumn6 = document.createElement("td");
            newColumn6.setAttribute("class", "gstTD");
            if (gst_status == 'no') {
                newColumn6.setAttribute("style", "display:none");
            }

            //Tax Select
            var taxSelect = document.createElement("select");
            taxSelect.setAttribute("class", "form-control");
            taxSelect.setAttribute("name", "product_tax[]");
            taxSelect.setAttribute("id", "product_tax" + count);
            taxSelect.setAttribute("onchange", "calculateNewGST(this.value," + count + ")");

            var newOption1 = document.createElement("option");
            newOption1.setAttribute("value", "0");
            newOption1.setAttribute("selected", "selected");
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
            newColumn7.setAttribute("class", "gstTD");
            if (gst_status == 'no') {
                newColumn7.setAttribute("style", "display:none");
            }
            newColumn7.innerHTML = "0";

            //Column 8
            var newColumn8 = document.createElement("td");
            newColumn8.setAttribute("id", "stotal" + count);
            newColumn8.setAttribute("class", "sTotal");
            newColumn8.setAttribute("style", "font-weight:bold");
            newColumn8.innerHTML = "0";

            //Column hidden
            var hidden_total = document.createElement("input");
            hidden_total.setAttribute("type", "hidden");
            hidden_total.setAttribute("name", "total[]");
            hidden_total.setAttribute("id", "total_hidden" + count);
            hidden_total.setAttribute("value", "0");


            //Column 9
            var newColumn9 = document.createElement("td");
            newColumn9.setAttribute("class", "text-danger");
            var deleteIcon = document.createElement("i");
            deleteIcon.setAttribute("class", "bx bx-trash");
            deleteIcon.setAttribute("id", "delete" + count);
            deleteIcon.setAttribute("onclick", "deleteRow(" + count + ")");
            newColumn9.appendChild(deleteIcon);

            var tableBody = document.getElementById("product_table_body");
            newRow.appendChild(newColumn1);
            newRow.appendChild(new_product_hidden);
            // newRow.appendChild(newColumn2);
            newRow.appendChild(newColumn3);
            newRow.appendChild(newColumn4);
            newRow.appendChild(newColumn5);
            newRow.appendChild(newColumn6);
            newRow.appendChild(newColumn7);
            newRow.appendChild(newColumn8);
            newRow.appendChild(newColumn9);
            newRow.appendChild(hidden_total);
            tableBody.appendChild(newRow);

            $("#estimate_product" + count).select2();
            count++;
        }

        function clearTableFields(row) {
            document.getElementById("warrenty" + row).innerHTML = '';
            document.getElementById("unitPrice" + row).value = '';
            document.getElementById("productQty" + row).value = '';
            document.getElementById("total" + row).innerHTML = '';

        }

        function reload_div(row_number) {
            console.log(row_number + 'new reload button clicked');
            $("#estimate_product_new" + row_number).removeAttr("name");
            $("#estimate_product" + row_number).attr('name', 'estimate_product[]');
            $("#estimate_product_new" + row_number).remove();
            $("#reload" + row_number).remove();


            var td_product_text = document.getElementById('td_product_text' + row_number)
            var td_product_select = document.getElementById('td_product_select' + row_number)
            td_product_select.style.display = 'block';
            td_product_text.style.display = 'none';
        }

        function get_product_details(product_id, row) {
            if (product_id == 'new product') {
                console.log('new product ' + row);


                var td_product_text = document.getElementById('td_product_text' + row)
                var td_product_select = document.getElementById('td_product_select' + row)


                $("#estimate_product" + row).removeAttr("name");
                td_product_select.style.display = 'none';
                td_product_text.style.display = 'block';

                var new_product_name = document.createElement("input");
                new_product_name.setAttribute("type", "text");
                new_product_name.setAttribute("class", "form-control");
                new_product_name.setAttribute("id", "estimate_product_new" + row);
                new_product_name.setAttribute("name", "estimate_product[]");
                new_product_name.setAttribute("onkeyup", "this.value = this.value.toUpperCase()");
                new_product_name.setAttribute("style", "width:100%");

                var new_div_reload = document.createElement("i");
                new_div_reload.setAttribute("class", "text-success bx bx-repost");
                new_div_reload.setAttribute("id", "reload" + row);
                new_div_reload.setAttribute("style", "float:right; font-size:18px;");
                new_div_reload.setAttribute("onclick", "reload_div(" + row + ")");


                td_product_text.appendChild(new_product_name);
                td_product_text.appendChild(new_div_reload);
            } else {
                if (product_id != '') {
                    $.ajax({
                        type: "get",
                        url: "{{ route('getProductDetails') }}",
                        dataType: "json",
                        data: {
                            product: product_id
                        },
                        success: function(response) {

                            console.log(row);
                            document.getElementById("unitPrice" + row).value = response.product_price;
                            document.getElementById("productQty" + row).value = 1;
                            // document.getElementById("total"+row).innerHTML = response.product_price;
                            // document.getElementById("total_hidden"+row).value = response.product_price;

                            calculateTotal(row);
                            calculateGrandTotal();

                        }
                    });
                } else {
                    clearTableFields(row);
                }
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

        function enable_btn() {
            var customer_name = document.getElementById('customer_name').value;
            var customer_phone = document.getElementById('customer_phone').value;
            customer_phone_length = customer_phone.length;
            if (customer_phone_length > 0) {
                if (customer_name == '' || customer_phone_length <= 9) {
                    document.getElementById('btn_submit_product').disabled = true;
                } else {
                    document.getElementById('btn_submit_product').disabled = false;
                }
            } else {
                if (customer_name == '') {
                    document.getElementById('btn_submit_product').disabled = true;
                } else {
                    document.getElementById('btn_submit_product').disabled = false;
                }
            }
        }

        // function set_name_select(customer) {
        //     if (customer == 'New Customer') {
        //         $("#customer_name_select").css("display", "none");
        //         $("#customer_name").css("display", "block");
        //         $("#reload_customer").css("display", "block");
        //         document.getElementById('customer_name').value = '';
        //         document.getElementById('system_customer_name').value = '';
        //         document.getElementById('customer_phone').value = '';
        //     } else {
        //         $.ajax({
        //             type: "get",
        //             url: "{{ route('getCustomerDetails') }}",
        //             data: {
        //                 customer: customer
        //             },
        //             success: function(res) {
        //                 // console.log(res);
        //                 $("#customer_name").val(res.name);
        //                 $("#system_customer_name").val(res.name);
        //                 $("#customer_phone").val(res.mobile);
        //                 $("#system_customer_phone").val(res.mobile);
        //                 $("#gst_number").val(res.gst_no);

        //                 enable_btn();
        //             }
        //         });
        //     }
        // }

        // function reload_customer() {
        //     $("#customer_name").css("display", "none");
        //     $("#reload_customer").css("display", "none");
        //     $("#customer_name_select").css("display", "block");
        //     document.getElementById('customer_name').value = '';
        //     document.getElementById('system_customer_name').value = '';
        //     document.getElementById('customer_phone').value = '';
        // }
    </script>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Proforma Invoice</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Invoice Information</h4>
                                <p class="card-title-desc">Fill all information below</p>

                                <form action="{{ route('proforma.store') }}" method="POST" target="_blank">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="invoice_number">Invoice No</label>
                                                <input id="invoice_number" name="invoice_number" type="text"
                                                    class="form-control" value="{{ old('invoice_number') }}">
                                                <small class="text-danger" id="invoiceNumberError"
                                                    style="display: none">Invoice number cannot be empty</small>
                                                @error('invoice_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="invoice_date">Date</label>
                                                <input id="invoice_date" name="invoice_date" type="date"
                                                    class="form-control"
                                                    value="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                                                @error('invoice_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="customer_name">Customer Name</label>
                                                @php
                                                    $customers = DB::table('customers')->get();
                                                @endphp
                                                <div>
                                                    <select class="select2 form-control" name="customer_name" id="customer_name"
                                                        onchange="getCustomerDetails(this.value)">
                                                        <option selected disabled>Select Customer</option>
                                                        {{-- <option value="New Customer"
                                                            {{ old('customer_name') === 'New Customer' ? 'selected' : '' }}>
                                                            New Customer</option> --}}
                                                        <option value="addNewCustomer">[Add Customer]</option>
                                                        @foreach ($customers as $customer)
                                                            <option
                                                                value="{{ $customer->id }}"{{ old('customer_name') == $customer->name ? 'selected' : '' }}>
                                                                {{ $customer->name }}, {{ $customer->place }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <input type="text" class="form-control" name="customer_name"
                                                    id="customer_name" placeholder="Customer Name" value=""
                                                    onkeyup="set_name(this.value);" onkeypress="set_name(this.value);"
                                                    style="display: none;">
                                                <i class="bx bx-repost text-success" onclick="reload_customer()"
                                                    id="reload_customer" style="display: none;font-size: 18px;"></i> --}}
                                                @error('customer_name')
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
                                                <label for="valid_upto">Customer Phone</label>
                                                <input type="number" name="customer_phone" id="customer_phone"
                                                    class="form-control" placeholder="Customer Phone"
                                                    value="{{ old('customer_phone') }}" onkeyup="set_phone(this.value);"
                                                    onkeypress="set_phone(this.value);">
                                                @error('customer_phone')
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


                                        {{-- -----------------------------------------product div--------------------------- --}}
                                        <div class="col-sm-12" id="product_div">
                                            <div class="mb-3">
                                                <table class="table" id="productsTable" style="width: 100%">
                                                    <thead>
                                                        <th class="w-25">PRODUCT</th>
                                                        {{-- <th class="w-15">WARRENTY</th> --}}
                                                        <th class="w-15">UNIT PRICE</th>
                                                        <th class="w-15">QTY</th>
                                                        <th class="w-15 gstTD" style="display: none">TAXABLE</th>
                                                        <th class="w-15 gstTD" style="display: none">TAX</th>
                                                        <th class="w-15 gstTD" style="display: none">GST</th>
                                                        <th class="w-15">TOTAL</th>
                                                        <th class="w-15">DELETE</th>
                                                    </thead>
                                                    <tbody id="product_table_body">
                                                        <tr id="row0">
                                                            <td id="td_product_select0" style="max-width: 150px;">
                                                                <select class="form-control select2"
                                                                    name="estimate_product[]" id='estimate_product0'
                                                                    onchange="get_product_details(this.value,0)"
                                                                    style="width: 100%">
                                                                    <option value="">Select Product</option>
                                                                    <option
                                                                        value="new product"{{ old('estimate_product.0') === 'new product' ? 'selected' : '' }}>
                                                                        { New Product }</option>
                                                                    @php
                                                                        $products = DB::table('products')->get();
                                                                    @endphp
                                                                    @foreach ($products as $product)
                                                                        <option
                                                                            value="{{ $product->id }}"{{ old('estimate_product.0') == $product->id ? 'selected' : '' }}>
                                                                            {{ $product->product_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td id="td_product_text0" style="display:none;">
                                                            </td>
                                                            {{-- <td><input class="form-control" type="text" value="1 Year" id="warrenty0" name="warrenty[]" style="width: 100%"></td> --}}
                                                            <td><input class="form-control" type="number" value="0"
                                                                    id="unitPrice0" name="unitPrice[]" step=".50"
                                                                    onkeyup="calculateTotal(0)"
                                                                    onchange="calculateTotal(0)" style="width: 100%"></td>
                                                            <td><input class="form-control" id="productQty0"
                                                                    name="qty[]" type="number" step="1"
                                                                    value="1" onkeyup="calculateTotal(0)"
                                                                    min="0" onchange="calculateTotal(0)"
                                                                    style="width: 100%"></td>
                                                            <td id="total0" class="Total gstTD" style="display: none"
                                                                onchange="calculateGSTAndTotal(0)">₹0</td>
                                                            <td style="display: none" class="gstTD">
                                                                <select class="form-control" name="product_tax[]"
                                                                    id="product_tax0"
                                                                    onchange="calculateNewGST(this.value,0)"
                                                                    style="width:100%;">
                                                                    <option value="0" id="0Value_0" selected>0
                                                                    </option>
                                                                    <option value="3" id="3Value_0">3</option>
                                                                    <option value="5" id="5Value_0">5</option>
                                                                    <option value="12" id="12Value_0">12</option>
                                                                    <option value="18" id="18Value_0">18</option>
                                                                    <option value="28" id="28Value_0">28</option>
                                                                </select>
                                                            </td>
                                                            <td id="gst0" style="display: none" class="gstTD">0
                                                            </td>
                                                            <td style="font-weight:bold" id="stotal0" class="sTotal">0
                                                            </td>
                                                            <input type="hidden" name="total[]" id="total_hidden0">
                                                            <td class="text-danger"><i class="bx bx-trash" id="delete0"
                                                                    onclick="deleteRow(0)"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mb-3" style="text-align: right">
                                                <button class="btn btn-primary" type="button" id="addMoreButton"
                                                    onclick="add_new_row()">Add More<i class="bx bx-plus"></i></button>
                                            </div>
                                            <div class="mb-3" style="text-align: right">
                                                <h4 style="margin-right: 5%"><b id="grandTotalBold">Grand total : ₹0</b>
                                                </h4>
                                                <input type="hidden" id="grand_total_hidden" name="grand_total"
                                                    value="0">
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" id="btn_submit_product"
                                                    class="btn btn-primary waves-effect waves-light"
                                                    onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();"
                                                    disabled>Save Details</button>
                                            </div>
                                        </div>
                                </form>
                                {{-- ---------------------------------system div----------------------------------------------------- --}}

                            </div>
                        </div>

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
                                                        Value="{{ old('customer_email') }}"
                                                        style="text-transform:lowercase;">
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

                        <!-- end card-->


                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    @endsection
