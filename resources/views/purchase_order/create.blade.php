@extends('layouts.layout')
@section('content')
    <style>
        .w-100{
            width: 100%;
        }
        .w-85{
            width:85%;
        }
        .w-50{
            width:50%;
        }
        .w-25{
            width:25%;
        }
        .w-15{
            width:15%;
        }
    </style>
    <script>
         var count= 1;
        $(function() {
                $("input[type='text']").keyup(function() {
                    this.value = this.value.toLocaleUpperCase();
                });
                $('textarea').keyup(function() {
                    this.value = this.value.toLocaleUpperCase();
                });
        });
        function get_product_details(product_id,row){
            if(product_id == 'new product'){


                var td_product_text = document.getElementById('td_product_text'+ row)
                var td_product_select = document.getElementById('td_product_select'+ row)


                $("#order_product"+row).removeAttr("name");
                td_product_select.style.display = 'none';
                td_product_text.style.display = 'block';

                var new_product_name = document.createElement("input");
                new_product_name.setAttribute("type","text");
                new_product_name.setAttribute("class","form-control");
                new_product_name.setAttribute("id","order_product_new" + row);
                new_product_name.setAttribute("name","order_product[]");
                new_product_name.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
                new_product_name.setAttribute("style","width:350px");

                var new_div_reload = document.createElement("i");
                new_div_reload.setAttribute("class","text-success bx bx-repost");
                new_div_reload.setAttribute("id", "reload" + row);
                new_div_reload.setAttribute("style", "float:right; font-size:18px;");
                new_div_reload.setAttribute("onclick", "reload_div(" + row +")");


                td_product_text.appendChild(new_product_name);
                td_product_text.appendChild(new_div_reload);
            }
            else{
                if(product_id != '')
                {
                    $.ajax({
                        type : "get",
                        url : "{{ route('getProductDetails') }}",
                        dataType : "json",
                        data : {product : product_id},
                        success : function(response)
                        {

                            console.log(row);
                            document.getElementById("unitPrice"+row).value = response.product_price;
                            document.getElementById("productQty"+row).value = 1;
                            // document.getElementById("total"+row).innerHTML = response.product_price;
                            // document.getElementById("total_hidden"+row).value = response.product_price;

                            calculateTotal(row);
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
        function deleteRow(row)
        {
            $("#row"+row).remove();
            calculateGrandTotal();
            tableRows = tableRows.filter(function(e){ return e !== row});
            // console.log(tableRows);
            selectedProducts[row] = null;
        }


        function reload_div(row_number){
            console.log(row_number+'new reload button clicked');
            $("#order_product_new"+row_number).removeAttr("name");
            $("#order_product"+row_number).attr('name', 'order_product[]');
            $("#order_product_new"+row_number).remove();
            $("#reload"+row_number).remove();


            var td_product_text = document.getElementById('td_product_text'+ row_number)
            var td_product_select = document.getElementById('td_product_select'+ row_number)
            td_product_select.style.display = 'block';
            td_product_text.style.display = 'none';
        }




        function calculateTotal(rowNumber)
        {
            var unitPrice = $("#unitPrice" + rowNumber).val();
            var quantity = $("#productQty" + rowNumber).val();
            var total = unitPrice * quantity;
            document.getElementById("total" + rowNumber).innerHTML = total.toFixed(2);
            $("#total_hidden" + rowNumber).val(total.toFixed(2));
            calculateGrandTotal();
            checkStock(rowNumber);
        }


        function calculateGrandTotal() {
            var gTotal = 0;
            $(".Total").each(function() {
                gTotal += parseFloat($(this).text().replace("₹", "") || 0);
            });
            $("#grand_total").val(gTotal.toFixed(2));
            $("#grandTotalBold").html("Grand total : ₹" + gTotal.toFixed(2));
        }


        function add_new_row()
        {
            var newRow = document.createElement("tr");
            newRow.setAttribute("id", "row" + count);

            //Column1
            var newColumn1 = document.createElement("td");
            newColumn1.setAttribute("id","td_product_select" + count);
            newColumn1.setAttribute("style","max-width: 350px");
            var newProductSel = document.createElement("select");
            newProductSel.setAttribute("class","select2 products");
            newProductSel.setAttribute("style","width: 350px");
            newProductSel.setAttribute("id","order_product" + count);
            newProductSel.setAttribute("name","order_product[]");
            newProductSel.setAttribute("onchange","get_product_details(this.value,"+count+")");

            $.ajax({
                type : "get",
                url : "{{ route('getProducts') }}",
                dataType : "json",
                success : function(response)
                {
                    console.log(response);
                    newProductSel.innerHTML = '';
                    var newOption1 = document.createElement("option");
                    newOption1.setAttribute("value","");
                    newOption1.innerHTML = "Select Product";
                    newProductSel.appendChild(newOption1);
                    var newOption2 = document.createElement("option");
                    newOption2.setAttribute("value","new product");
                    newOption2.innerHTML = "{ New Product }";
                    newProductSel.appendChild(newOption2);

                    for(var i = 0; i < response.length; i++)
                    {
                        var newDynamicOption = document.createElement("option");
                        newDynamicOption.setAttribute("value",response[i].id);
                        newDynamicOption.innerHTML = "[" + response[i].product_code +"]" + response[i].product_name;
                        newProductSel.appendChild(newDynamicOption);
                        console.log("Added option");

                    }
                }
            });
            newColumn1.appendChild(newProductSel);

            //Column product td hidden
            var new_product_hidden = document.createElement("td");
            new_product_hidden.setAttribute("id","td_product_text" + count);
            new_product_hidden.setAttribute("style","display:none");

            //Column 2
            var newColumn2 = document.createElement("td");
            var newQty = document.createElement("input");
            newQty.setAttribute("type","number");
            newQty.setAttribute("value","1");
            newQty.setAttribute("class","form-control");
            newQty.setAttribute("id","productQty" + count);
            newQty.setAttribute("name","qty[]");
            newQty.setAttribute("min","0");
            newQty.setAttribute("step","1");
            newQty.setAttribute("onkeyup","calculateTotal(" + count + ")");
            newQty.setAttribute("onchange","calculateTotal(" + count + ")");
            newQty.setAttribute("style","width:100%");
            newColumn2.appendChild(newQty);

            //Column 3
            var newColumn3 = document.createElement("td");
            var newUnitPrice = document.createElement("input");
            newUnitPrice.setAttribute("type","number");
            newUnitPrice.setAttribute("step","1");
            newUnitPrice.setAttribute("value","0");
            newUnitPrice.setAttribute("class","form-control");
            newUnitPrice.setAttribute("id","unitPrice" + count);
            newUnitPrice.setAttribute("name","unitPrice[]");
            newUnitPrice.setAttribute("onkeyup","calculateTotal(" + count +")");
            newUnitPrice.setAttribute("onchange","calculateTotal(" + count +")");
            newUnitPrice.setAttribute("style","width:100%");
            newColumn3.appendChild(newUnitPrice);

            //Column 4
            var newColumn4 = document.createElement("td");
            newColumn4.setAttribute("id","total" + count);
            newColumn4.setAttribute("class","Total");
            newColumn4.setAttribute("onchange","calculateTotal(" + count + ")");
            newColumn4.innerHTML = "₹0";

            //Column hidden
            var hidden_total = document.createElement("input");
            hidden_total.setAttribute("type","hidden");
            hidden_total.setAttribute("name","total[]");
            hidden_total.setAttribute("id","total_hidden" + count);
            hidden_total.setAttribute("value","0");


            //Column 5
            var newColumn5 = document.createElement("td");
            newColumn5.setAttribute("class", "text-danger");
            var deleteIcon = document.createElement("i");
            deleteIcon.setAttribute("class","bx bx-trash");
            deleteIcon.setAttribute("id", "delete" + count);
            deleteIcon.setAttribute("onclick", "deleteRow(" + count +")");
            newColumn5.appendChild(deleteIcon);

            var tableBody = document.getElementById("product_table_body");
            newRow.appendChild(newColumn1);
            newRow.appendChild(new_product_hidden);
            newRow.appendChild(newColumn2);
            newRow.appendChild(newColumn3);
            newRow.appendChild(newColumn4);
            newRow.appendChild(newColumn5);
            newRow.appendChild(hidden_total);
            tableBody.appendChild(newRow);

            $("#order_product" + count).select2();
            count++;
        }
        function enable_btn(){
            console.log('button clicked');
            var seller_name = document.getElementById('seller_name').value;
            var seller_name_select = document.getElementById('seller_name_sel').value;
            console.log('seller_name '+seller_name);
            console.log('seller_name_select '+seller_name_select);
            if( seller_name == ''){
                if(seller_name_select == '' || seller_name_select == 'New Seller'){
                    document.getElementById('sales_submit_btn').disabled = true;
                }
                else{
                    document.getElementById('sales_submit_btn').disabled = false;
                }
            }
            else{
                document.getElementById('sales_submit_btn').disabled = false;
            }
        }

        function set_phone(seller_mobile){
            document.getElementById('system_seller_mobile').value=seller_mobile;
            enable_btn();
        }
        function set_name_select(seller){
            if(seller == 'New Seller'){
                $("#seller_name_select").css("display", "none");
                $("#seller_name").css("display", "block");
                $("#reload_seller").css("display", "block");
                enable_btn();
            }
            else{
                $.ajax({
                    type : "get",
                    url : "{{ route('getSellerDetails') }}",
                    data : { seller : seller },
                    success : function(res)
                    {
                        console.log(res);
                        $("#seller_mobile").val(res.seller_mobile);
                        $("#seller_name").val(res.seller_name);
                        enable_btn();
                    }
                });
            }
        }
        function reload_seller(){
            $("#seller_name").css("display", "none");
            $("#seller_name_select").css("display", "block");
            document.getElementById('seller_name').value='';
            document.getElementById('seller_mobile').value='';
            enable_btn();
        }
    </script>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Purchase Order</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Purchase Order Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>
                                        <form action="{{ route('purchase_order.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="purchase_order_number">Purchase Order No</label>
                                                        <input id="purchase_order_number" name="purchase_order_number" type="text" class="form-control" value="{{ $newOrderNumber }}" readonly>
                                                        <small class="text-danger" id="purchase_orderNumberError" style="display: none">Purchase Order number cannot be empty</small>
                                                        @error('purchase_order_number')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_name">Seller Name</label>
                                                        @php
                                                            $sellers = DB::table('sellers')->get();
                                                        @endphp
                                                        <div id="seller_name_select">
                                                            <select class="select2 form-control" id="seller_name_sel" onchange="set_name_select(this.value)">
                                                                <option selected disabled>Select</option>
                                                                <option value="New Seller">New Seller</option>
                                                                @foreach ($sellers as $seller)
                                                                    <option value="{{ $seller->id }}">{{ $seller->seller_name }} , {{ $seller->seller_city }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control" name="seller_name" id="seller_name" placeholder="Seller Name" value="" onkeyup="enable_btn();" onkeypress="enable_btn();" style="display: none;">
                                                        <i class="bx bx-repost text-success" onclick="reload_seller()" id="reload_seller" style="display: none;font-size: 18px;"></i>
                                                        @error('seller_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="purchase_order_date">Order Date</label>
                                                        <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}" min="{{ Carbon\carbon::now()->format('Y-m-d') }}" readonly>
                                                        @error('purchase_order_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="valid_upto" class="control-label">Seller Mobile</label>
                                                        <input type="number" name="seller_mobile" id="seller_mobile" class="form-control" placeholder="Phone Number" value="{{ old('seller_mobile') }}" onkeyup="set_phone(this.value);" onkeypress="set_phone(this.value);">
                                                        <small class="text-danger" id="mobileNumberError" style="display: none">Mobile Number is invalid or empty</small>
                                                        @error('seller_mobile')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label>Products</label>
                                                        <small class="text-danger" id="productsError" style="display: none">Please add any products before saving</small>
                                                        <div class="table-responsive">
                                                            <table class="table" id="productsTable" style="width: 100%;">
                                                                <thead>
                                                                    <th class="w-25">PRODUCT</th>
                                                                    <th class="w-15">QTY</th>
                                                                    <th class="w-15">UNIT PRICE</th>
                                                                    <th class="w-15">TOTAL</th>
                                                                    <th class="w-15">DELETE</th>
                                                                </thead>
                                                                <tbody id="product_table_body">
                                                                    <tr id="row0">
                                                                        <td id="td_product_select0" style="max-width: 230px;">
                                                                            <select class="form-control select2" name="order_product[]" id='order_product0' onchange="get_product_details(this.value,0)" style="width: 100%">
                                                                                <option value="">Select Product</option>
                                                                                <option value="new product">{ New Product }</option>
                                                                                @php
                                                                                    $products = DB::table('products')->get();
                                                                                @endphp
                                                                                @foreach ($products as $product)
                                                                                    <option value="{{ $product->id }}">[{{ $product->product_code }}] {{ $product->product_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td id="td_product_text0"  style="display:none;"></td>
                                                                        <td><input class="form-control" id="productQty0" name="qty[]" type="number" step="1" value="1" onkeyup="calculateTotal(0)" min="0" onchange="calculateTotal(0)" style="min-width: 80px; "></td>
                                                                        <td><input class="form-control" type="number" value="0" id="unitPrice0" name="unitPrice[]" step=".50" onkeyup="calculateTotal(0)" onchange="calculateTotal(0)" style="min-width: 80px;"></td>
                                                                        <td id="total0" class="Total" onchange="calculateTotal(0)">₹0</td>
                                                                        <input type="hidden" name="total[]" id="total_hidden0">
                                                                        <td class="text-danger"><i class="bx bx-trash" id="delete0" onclick="deleteRow(0)"></i></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" style="text-align: right">
                                                        <button class="btn btn-primary" type="button" id="addMoreButton" onclick="add_new_row()">Add More&nbsp;<i class="bx bx-plus"></i></button>
                                                    </div>
                                                    <div class="mb-3" style="text-align: right">
                                                        <h4 style="margin-right: 5%"><b id="grandTotalBold">Grand total : ₹0</b></h4>
                                                        <input type="hidden" name="grand_total" id="grand_total">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="sales_submit_btn" disabled>Save Details</button>
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

@endsection
