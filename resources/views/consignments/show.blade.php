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
        $(window).keydown(function(event){
                if(event.keyCode == 13){
                    event.preventDefault();
                    return false;
                }
            });
        });
</script>
<style>
    .modal2{
        z-index: 1052 !important;
    }
    .modal2-backdrop.show {
        z-index: 1051 !important;
    }
</style>

<script>

    var c=0;

    // delete row
    function deleteRow(id)
    {
        document.getElementById('row_'+id).remove();
        items = items.filter(function(e){ return e !== id});
        console.log(items);
    }
    function calculateNewGST(gstPercent, rowCount)
    {
        var total = parseFloat($("#taxable" + rowCount).text());
        var newTotal = (total * parseFloat(gstPercent) / 100);
        $("#gst" + rowCount).html(newTotal);
        document.getElementById('gst_hidden'+ rowCount).value = newTotal;
        var newSTotal = total + newTotal;
        $("#total_" + rowCount).html(newSTotal.toFixed(2));
        document.getElementById('total_hidden'+ rowCount).value = newSTotal.toFixed(2);
        calculateTotal(rowCount)
    }
    function calculateGSTAndTotal(rowNumber)
    {
        var gstPercentage = $("#product_tax" + rowNumber).val();
        var gst = (parseFloat($("#taxable" + rowNumber).text()) * parseFloat(gstPercentage)) / 100;
        $("#gst" + rowNumber).html(gst.toFixed(2));
        document.getElementById('gst_hidden'+ rowNumber).value = gst.toFixed(2);
        var subTotal = gst + parseFloat($("#taxable" + rowNumber).text());
        $("#total_" + rowNumber).html(subTotal.toFixed(2));
        document.getElementById('total_hidden'+ rowNumber).value = subTotal.toFixed(2);
    }
    function calculateTotal(row)
    {
        var priceWithTax = parseFloat($("#priceWithTax_"+row).val());
        var productTax = parseFloat($("#product_tax"+row).val()) || 0;
        var qty = parseFloat($("#qty_"+row).val());
        console.log('qty is '+ qty +'productTax is '+ productTax);
        var unitPrice = ( priceWithTax / (100 + productTax )) *  100;
        if(priceWithTax <= 0 || qty <= 0)
        {
            var total = unitPrice * qty;
            $("#total_"+row).html(total.toFixed(2));
            document.getElementById('total_hidden'+row).value = total.toFixed(2);
            document.getElementById("negativeError").style.display="block";
        }
        else
        {
            {{--  console.log('123');  --}}
            var total = unitPrice * qty;
            {{--  console.log('taxable is '+total);  --}}
            $("#taxable"+row).html(total.toFixed(2));
            document.getElementById('price_'+row).value = unitPrice.toFixed(2);
            document.getElementById("negativeError").style.display="none";
            calculateGSTAndTotal(row);
        }
    }

    var count = 0;
    var items = [];
    function additem(){
        var productId = $("#productSelect").val();
        console.log(productId);
        if(productId == 'service'){

            var newRow = document.createElement("tr");
            newRow.setAttribute("id","row_"+count);

            var productIdHidden = document.createElement("input");
            // productIdHidden.setAttribute("id", "product_" + count);
            productIdHidden.setAttribute("type","hidden");
            productIdHidden.setAttribute("value",1);

            var productNameCell = document.createElement("td");
            // productNameCell.innerHTML = 'Service';
            var productNameInput = document.createElement("input");
            productNameInput.setAttribute("type","text");
            productNameInput.setAttribute("class","form-control");
            productNameInput.setAttribute("value",'SERVICE');
            productNameInput.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
            productNameInput.setAttribute("id","product_" + count);
            productNameInput.setAttribute("name","product_id[]");
            productNameCell.appendChild(productNameInput);

            var productSerialCell = document.createElement("td");
            var productSerialInput = document.createElement("input");
            productSerialInput.setAttribute("type","text");
            productSerialInput.setAttribute("class","form-control");
            productSerialInput.setAttribute("value",'');
            productSerialInput.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
            productSerialInput.setAttribute("id","serial_" + count);
            productSerialInput.setAttribute("name","serial[]");
            productSerialCell.appendChild(productSerialInput);

            var productPriceWithTaxCell = document.createElement("td");
            var productPriceWithTaxInput = document.createElement("input");
            productPriceWithTaxInput.setAttribute("id","priceWithTax_" + count);
            productPriceWithTaxInput.setAttribute("type","number");
            productPriceWithTaxInput.setAttribute("min","0");
            productPriceWithTaxInput.setAttribute("step",".50");
            productPriceWithTaxInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productPriceWithTaxInput.setAttribute("onchange","calculateTotal("+count+")");
            productPriceWithTaxInput.setAttribute("class","form-control");
            productPriceWithTaxInput.setAttribute("value",'0');
            productPriceWithTaxCell.appendChild(productPriceWithTaxInput);

            var productPriceCell = document.createElement("td");
            var productPriceInput = document.createElement("input");
            productPriceInput.setAttribute("id","price_" + count);
            productPriceInput.setAttribute("name","price[]");
            productPriceInput.setAttribute("type","number");
            productPriceInput.setAttribute("min","0");
            productPriceInput.setAttribute("step",".50");
            productPriceInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productPriceInput.setAttribute("onchange","calculateTotal("+count+")");
            productPriceInput.setAttribute('readonly', true);
            productPriceInput.setAttribute("class","form-control");
            productPriceInput.setAttribute("value",'0');
            productPriceCell.appendChild(productPriceInput);

            var productQtyCell = document.createElement("td");
            var productQtyInput = document.createElement("input");
            productQtyInput.setAttribute("type","number");
            productQtyInput.setAttribute("class","form-control");
            productQtyInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productQtyInput.setAttribute("onchange","calculateTotal("+count+")");
            productQtyInput.setAttribute("id","qty_" + count);
            productQtyInput.setAttribute("name","qty[]");
            productQtyInput.setAttribute("value","1");
            productQtyInput.setAttribute("min","0");
            productQtyInput.setAttribute("step",".50");
            // productQtyInput.setAttribute('readonly', true);
            productQtyCell.appendChild(productQtyInput);

            var productTaxableCell = document.createElement("td");
            productTaxableCell.setAttribute("id","taxable" + count);
            productTaxableCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
            productTaxableCell.innerHTML = '0';

            var productTaxCell = document.createElement("td");
            //Tax Select
            var taxSelect = document.createElement("select");
            taxSelect.setAttribute("class","form-control");
            taxSelect.setAttribute("name","tax[]");
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
            productTaxCell.appendChild(taxSelect);

            var productGSTCell = document.createElement("td");
            productGSTCell.setAttribute("id", "gst" + count);
            productGSTCell.innerHTML = "₹0";

            var productGSTHidden = document.createElement("input");
            productGSTHidden.setAttribute("id", "gst_hidden" + count);
            productGSTHidden.setAttribute("name", "gst[]");
            productGSTHidden.setAttribute("type","hidden");
            productGSTHidden.setAttribute("value",'0');

            var productTotalCell = document.createElement("td");
            productTotalCell.setAttribute("id","total_"+count);
            productTotalCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
            productTotalCell.innerHTML = '0';

            var productTotalHidden = document.createElement("input");
            productTotalHidden.setAttribute("id", "total_hidden" + count);
            productTotalHidden.setAttribute("name", "total[]");
            productTotalHidden.setAttribute("type","hidden");
            productTotalHidden.setAttribute("value",'0');

            var removeButtonCell = document.createElement("td");
            removeButtonCell.setAttribute("class","text-danger");
            var removeButton = document.createElement("i");
            removeButton.setAttribute("class","bx bx-trash");
            removeButton.setAttribute("onclick","deleteRow("+count+")");
            removeButtonCell.appendChild(removeButton);

            newRow.appendChild(productIdHidden);
            newRow.appendChild(productNameCell);
            newRow.appendChild(productSerialCell);
            newRow.appendChild(productPriceWithTaxCell);
            newRow.appendChild(productPriceCell);
            newRow.appendChild(productQtyCell);
            newRow.appendChild(productTaxableCell);
            newRow.appendChild(productTaxCell);
            newRow.appendChild(productGSTCell);
            newRow.appendChild(productGSTHidden);
            newRow.appendChild(productTotalCell);
            newRow.appendChild(productTotalHidden);
            newRow.appendChild(removeButtonCell);
            document.getElementById("tableBody").appendChild(newRow);

            items.push(count);
            count++;
            console.log(items);
            $("#productSelect").remove(productId);
        }
        else if(productId == 'service_without_charge'){

            var newRow = document.createElement("tr");
            newRow.setAttribute("id","row_"+count);

            var productIdHidden = document.createElement("input");
            productIdHidden.setAttribute("type","hidden");
            productIdHidden.setAttribute("value",1);

            var productNameCell = document.createElement("td");
            var productNameInput = document.createElement("input");
            productNameInput.setAttribute("type","text");
            productNameInput.setAttribute("class","form-control");
            productNameInput.setAttribute("value",'SERVICE WITHOUT CHARGE');
            productNameInput.setAttribute("style",'text-transform:uppercase;');
            productNameInput.setAttribute("id","product_" + count);
            productNameInput.setAttribute("name", "product_id[]");
            productNameInput.setAttribute('readonly', true);
            productNameCell.appendChild(productNameInput);

            var productSerialCell = document.createElement("td");
            var productSerialInput = document.createElement("input");
            productSerialInput.setAttribute("type","text");
            productSerialInput.setAttribute("class","form-control");
            productSerialInput.setAttribute("value",'');
            productSerialInput.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
            productSerialInput.setAttribute("id","serial_" + count);
            productSerialInput.setAttribute("name","serial[]");
            productSerialCell.appendChild(productSerialInput);

            var productPriceWithTaxCell = document.createElement("td");
            var productPriceWithTaxInput = document.createElement("input");
            productPriceWithTaxInput.setAttribute("id","priceWithTax_" + count);
            productPriceWithTaxInput.setAttribute("type","number");
            productPriceWithTaxInput.setAttribute("min","0");
            productPriceWithTaxInput.setAttribute("step",".50");
            productPriceWithTaxInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productPriceWithTaxInput.setAttribute("onchange","calculateTotal("+count+")");
            productPriceWithTaxInput.setAttribute("class","form-control");
            productPriceWithTaxInput.setAttribute("value",'0');
            productPriceWithTaxInput.setAttribute('readonly', true);
            productPriceWithTaxCell.appendChild(productPriceWithTaxInput);

            var productPriceCell = document.createElement("td");
            var productPriceInput = document.createElement("input");
            productPriceInput.setAttribute("id","price_" + count);
            productPriceInput.setAttribute("name","price[]");
            productPriceInput.setAttribute("type","number");
            productPriceInput.setAttribute("min","0");
            productPriceInput.setAttribute("step",".50");
            productPriceInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productPriceInput.setAttribute("onchange","calculateTotal("+count+")");
            productPriceInput.setAttribute("class","form-control");
            productPriceInput.setAttribute("value",'0');
            productPriceInput.setAttribute('readonly', true);
            productPriceCell.appendChild(productPriceInput);

            var productQtyCell = document.createElement("td");
            var productQtyInput = document.createElement("input");
            productQtyInput.setAttribute("type","number");
            productQtyInput.setAttribute("class","form-control");
            productQtyInput.setAttribute("onkeyup","calculateTotal("+count+")");
            productQtyInput.setAttribute("onchange","calculateTotal("+count+")");
            productQtyInput.setAttribute("id","qty_" + count);
            productQtyInput.setAttribute("name","qty[]");
            productQtyInput.setAttribute("value","1");
            productQtyInput.setAttribute("min","0");
            {{--  productQtyInput.setAttribute("disabled","disabled");  --}}
            productQtyCell.appendChild(productQtyInput);

            var productTaxableCell = document.createElement("td");
            productTaxableCell.setAttribute("id","taxable" + count);
            productTaxableCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
            productTaxableCell.innerHTML = '0';
            var productTaxCell = document.createElement("td");
            //Tax Select
            var taxSelect = document.createElement("select");
            taxSelect.setAttribute("class","form-control");
            taxSelect.setAttribute("name","tax[]");
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
            productTaxCell.appendChild(taxSelect);

            var productGSTCell = document.createElement("td");
            productGSTCell.setAttribute("id", "gst" + count);
            productGSTCell.innerHTML = "₹0";

            var productGSTHidden = document.createElement("input");
            productGSTHidden.setAttribute("id", "gst_hidden" + count);
            productGSTHidden.setAttribute("name", "gst[]");
            productGSTHidden.setAttribute("type","hidden");
            productGSTHidden.setAttribute("value",'0');

            var productTotalCell = document.createElement("td");
            productTotalCell.setAttribute("id","total_"+count);
            productTotalCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
            productTotalCell.innerHTML = '0';

            var productTotalHidden = document.createElement("input");
            productTotalHidden.setAttribute("id", "total_hidden" + count);
            productTotalHidden.setAttribute("name", "total[]");
            productTotalHidden.setAttribute("type","hidden");
            productTotalHidden.setAttribute("value",'0');

            var removeButtonCell = document.createElement("td");
            removeButtonCell.setAttribute("class","text-danger");

            var removeButton = document.createElement("i");
            removeButton.setAttribute("class","bx bx-trash");
            removeButton.setAttribute("onclick","deleteRow("+count+")");
            removeButtonCell.appendChild(removeButton);

            newRow.appendChild(productIdHidden);
            newRow.appendChild(productNameCell);
            newRow.appendChild(productSerialCell);
            newRow.appendChild(productPriceWithTaxCell);
            newRow.appendChild(productPriceCell);
            newRow.appendChild(productQtyCell);
            newRow.appendChild(productTaxableCell);
            newRow.appendChild(productTaxCell);
            newRow.appendChild(productGSTCell);
            newRow.appendChild(productGSTHidden);
            newRow.appendChild(productTotalCell);
            newRow.appendChild(productTotalHidden);
            newRow.appendChild(removeButtonCell);

            document.getElementById("tableBody").appendChild(newRow);

            items.push(count);
            count++;
            $("#productSelect").remove(productId);
        }
        else{
            $.ajax({
                type : "get",
                url : "{{ route('getProductDetailsFromStock') }}",
                dataType : "json",
                data : { productId : productId},
                success : function(response)
                {
                    console.log(response);

                    var newRow = document.createElement("tr");
                    newRow.setAttribute("id","row_"+count);

                    var productIdHidden = document.createElement("input");
                    productIdHidden.setAttribute("id", "product_" + count);
                    productIdHidden.setAttribute("name", "product_id[]");
                    productIdHidden.setAttribute("type","hidden");
                    productIdHidden.setAttribute("value",productId);

                    var productNameCell = document.createElement("td");
                    productNameCell.innerHTML = response.product_name;
                    productNameCell.setAttribute("id","product_name_" + count);
                    var stockDisplay = document.createElement("small");
                    stockDisplay.setAttribute("class","text-danger");
                    stockDisplay.innerHTML = "<br>(Max Quantity : " + response.max_qty +")";
                    productNameCell.appendChild(stockDisplay);

                    var productSerialCell = document.createElement("td");
                    var productSerialInput = document.createElement("input");
                    productSerialInput.setAttribute("type","text");
                    productSerialInput.setAttribute("class","form-control");
                    productSerialInput.setAttribute("value",'');
                    productSerialInput.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
                    productSerialInput.setAttribute("id","serial_" + count);
                    productSerialInput.setAttribute("name","serial[]");
                    productSerialCell.appendChild(productSerialInput);

                    var productPriceWithTaxCell = document.createElement("td");
                    var productPriceWithTax = document.createElement("input");
                    productPriceWithTax.setAttribute("id","priceWithTax_" + count);
                    productPriceWithTax.setAttribute("type","number");
                    productPriceWithTax.setAttribute("min","0");
                    productPriceWithTax.setAttribute("step",".50");
                    productPriceWithTax.setAttribute("onkeyup","calculateTotal("+count+")");
                    productPriceWithTax.setAttribute("onchange","calculateTotal("+count+")");
                    productPriceWithTax.setAttribute("class","form-control");
                    productPriceWithTax.setAttribute("value",response.product_price);
                    productPriceWithTaxCell.appendChild(productPriceWithTax);

                    var productPriceCell = document.createElement("td");
                    var productPriceInput = document.createElement("input");
                    productPriceInput.setAttribute("id","price_" + count);
                    productPriceInput.setAttribute("name","price[]");
                    productPriceInput.setAttribute("type","number");
                    productPriceInput.setAttribute("min","0");
                    productPriceInput.setAttribute("step",".50");
                    productPriceInput.setAttribute("onkeyup","calculateTotal("+count+")");
                    productPriceInput.setAttribute("onchange","calculateTotal("+count+")");
                    productPriceInput.setAttribute("readonly", "readonly");
                    productPriceInput.setAttribute("class","form-control");
                    productPriceInput.setAttribute("value",response.product_price);
                    productPriceCell.appendChild(productPriceInput);

                    var productQtyCell = document.createElement("td");
                    var productQtyInput = document.createElement("input");
                    productQtyInput.setAttribute("type","number");
                    productQtyInput.setAttribute("class","form-control");
                    productQtyInput.setAttribute("onkeyup","calculateTotal("+count+")");
                    productQtyInput.setAttribute("onchange","calculateTotal("+count+")");
                    productQtyInput.setAttribute("id","qty_" + count);
                    productQtyInput.setAttribute("name","qty[]");
                    productQtyInput.setAttribute("value","1");
                    productQtyInput.setAttribute("min","0");
                    productQtyInput.setAttribute("step",".50");
                    productQtyInput.setAttribute("max", response.max_qty);
                    productQtyCell.appendChild(productQtyInput);

                    var productTaxableCell = document.createElement("td");
                    productTaxableCell.setAttribute("id","taxable" + count);
                    productTaxableCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
                    productTaxableCell.innerHTML = response.product_price;

                    var productTaxCell = document.createElement("td");

                    //Tax Select
                    var taxSelect = document.createElement("select");
                    taxSelect.setAttribute("class","form-control");
                    taxSelect.setAttribute("name","tax[]");
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
                    productTaxCell.appendChild(taxSelect);

                    var productGSTCell = document.createElement("td");
                    productGSTCell.setAttribute("id", "gst" + count);
                    productGSTCell.innerHTML = "₹0";

                    var productGSTHidden = document.createElement("input");
                    productGSTHidden.setAttribute("id", "gst_hidden" + count);
                    productGSTHidden.setAttribute("name", "gst[]");
                    productGSTHidden.setAttribute("type","hidden");
                    productGSTHidden.setAttribute("value",'0');

                    var productTotalCell = document.createElement("td");
                    productTotalCell.setAttribute("id","total_"+count);
                    productTotalCell.setAttribute("onchange","calculateGSTAndTotal(" + count + ")");
                    productTotalCell.innerHTML = response.product_price;

                    var productTotalHidden = document.createElement("input");
                    productTotalHidden.setAttribute("id", "total_hidden" + count);
                    productTotalHidden.setAttribute("name", "total[]");
                    productTotalHidden.setAttribute("type","hidden");
                    productTotalHidden.setAttribute("value",response.product_price);

                    var removeButtonCell = document.createElement("td");
                    removeButtonCell.setAttribute("class","text-danger");
                    var removeButton = document.createElement("i");
                    removeButton.setAttribute("class","bx bx-trash");
                    removeButton.setAttribute("onclick","deleteRow("+count+")");
                    removeButtonCell.appendChild(removeButton);

                    newRow.appendChild(productIdHidden);
                    newRow.appendChild(productNameCell);
                    newRow.appendChild(productSerialCell);
                    newRow.appendChild(productPriceWithTaxCell);
                    newRow.appendChild(productPriceCell);
                    newRow.appendChild(productQtyCell);
                    newRow.appendChild(productTaxableCell);
                    newRow.appendChild(productTaxCell);
                    newRow.appendChild(productGSTCell);
                    newRow.appendChild(productGSTHidden);
                    newRow.appendChild(productTotalCell);
                    newRow.appendChild(productTotalHidden);
                    newRow.appendChild(removeButtonCell);
                    document.getElementById("tableBody").appendChild(newRow);

                    items.push(count);
                    count++;
                    console.log(items);
                    $("#productSelect").remove(productId);
                }
            });

        }

    }
    function printDiv() {

        $('#btnPrint').hide();
        $('.btn-light').hide();
        $('.not_print').hide();
        document.getElementById('t_head').style.display = 'block';

        var printContents = document.getElementById('printBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.location.reload();

    }
</script>
<script>

    function show_gstno(customer) {
        var customer_relation = $("#customer_relation").val();
        console.log(customer_relation);
        if(customer_relation == 'B2B'){
            document.getElementById('gst_div').style.display = 'block';
            $.ajax({
                type : "get",
                url : "{{ route('getCustomerDetails') }}",
                dataType : "json",
                data : { customer : customer},
                success : function(response)
                {
                    console.log(response);
                    document.getElementById('gst_no').value = response.customer_name;

                }
            });
        }
        else{
            document.getElementById('gst_div').style.display = 'none';
        }
    }
    function show_gst_modal(customer) {
        $('#gst_modal').modal('show');
        $.ajax({
            type: "get",
            url: "{{ route('getCustomerDetails') }}",
            dataType: "json",
            data: { customer: customer },
            success: function(response) {
                if (response.gst_no) {
                    $('#invoice_customer_relation').val('B2B').trigger('change');
                    $('#invoice_gst_div').show();
                    $('#invoice_gst_no').val(response.gst_no);
                } else {
                    $('#invoice_customer_relation').val('B2C').trigger('change');
                    $('#invoice_gst_div').hide();
                    $('#invoice_gst_no').val('');
                }
            },
            error: function() {
                console.log('Failed to retrieve customer details');
            }
        });
    }
    function show_invoice_gstno(customer) {
        var invoice_customer_relation = $("#invoice_customer_relation").val();
        console.log(invoice_customer_relation);
        if(invoice_customer_relation == 'B2B'){
            document.getElementById('invoice_gst_div').style.display = 'block';
            $.ajax({
                type : "get",
                url : "{{ route('getCustomerDetails') }}",
                dataType : "json",
                data : { customer : customer},
                success : function(response)
                {
                    console.log(response);
                    document.getElementById('invoice_gst_no').value = response.gst_no;

                }
            });
        }
        else{
            document.getElementById('invoice_gst_div').style.display = 'none';
        }
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
    function show_fields(service) {
        var chipServicerDiv = document.getElementById('chip_servicer_div');
        var warrentyServicerDiv = document.getElementById('warrenty_servicer_div');
        var servicerContactDiv = document.getElementById('servicer_contact_div');
        var staffDiv = document.getElementById('staff_div');
        var courierDeliveryDiv = document.getElementById('courier_delivery_div');

        if (service == 'chiplevel') {
            chipServicerDiv.style.display = 'block';
            warrentyServicerDiv.style.display = 'none';
        } else if (service == 'warrenty') {
            chipServicerDiv.style.display = 'none';
            warrentyServicerDiv.style.display = 'block';
        }

        servicerContactDiv.style.display = 'block';
        staffDiv.style.display = 'block';
        courierDeliveryDiv.style.display = 'block';
    }
    function show_courier_delivery_fields(courier) {
        var courierBillDiv = document.getElementById('courier_bill_div');
        var courierBillInput = document.getElementById('courier_bill');

        if (courier == 'Courier') {
            courierBillDiv.style.display = 'block';
            courierBillInput.setAttribute('required', 'required');
        } else {
            courierBillDiv.style.display = 'none';
            courierBillInput.removeAttribute('required');
            courierBillInput.value = '';
        }
    }
    function add_servicer(servicer){
        if(servicer == 'add_servicer'){
            document.getElementById('servicer_contact').value = '';
            $("#myModal2").modal("toggle");
            $("#myModal2").modal("show");
        }
        else{
            $.ajax({
                type : "get",
                url : "{{ route('get_servicer') }}",
                dataType : "json",
                data : { servicer : servicer},
                success : function(response)
                {
                    console.log(response);
                    document.getElementById('servicer_contact').value = response.seller_phone;

                }
            });
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

    function store_servicer()
        {
            var servicer_name = $("#servicer_name").val();
            console.log(servicer_name);
            var servicer_contact = $("#servicer_contact").val();
            console.log(servicer_contact);
            var servicer_place = $("#servicer_place").val();
            console.log(servicer_place);


            if(servicer_name == '')
            {
                document.getElementById("service_nameError").style.display="block";
            }


            // else
            // {
                // document.getElementById("service_nameError").style.display="none";
    //             $.ajaxSetup({
	   // 			headers : {
	   // 				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	   // 			}
	   // 		});
    //             $.ajax({
    //                 type : "post",
    //                 url : "{{ route('store_servicer') }}",
    //                 dataType : "JSON",
    //                 data : {servicer_name  : servicer_name , servicer_contact : servicer_contact , servicer_place : servicer_place  },
    //                 success : function(response)
    //                 {
    //                     console.log(response);
    //                     if(response != "Error")
    //                     {
    //                         var newOption = "<option value='" + response.servicer_name + "' >" + response.servicer_name + "</option>";
    //                         $("#chip_servicer_name").append(newOption);
    //                         $("#myModal2").modal("toggle");
    //                     }
    //                 }
    //             });
    //         }
        }
        function delete_accessories(sale_id){
            $.ajaxSetup({
	    			headers : {
	    				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	    			}
	    		});
                $.ajax({
                    type : "post",
                    url : "{{ route('delete_accessories') }}",
                    dataType : "JSON",
                    data : { sale_id  : sale_id },
                    success : function(response)
                    {
                        console.log(response);
                        if(response != "Error")
                        {
                            $("#confirm_modal"+sale_id).modal("toggle");
                            $("#accessories_div").load(" #accessories_div");
                        }
                    }
                });
        }
        function get_seller_contact(seller_id){
            $.ajax({
                type : "get",
                url : "{{ route('get_seller') }}",
                dataType : "json",
                data : { seller : seller_id },
                success : function(response)
                {
                    console.log(response);
                    document.getElementById('servicer_contact').value = response.seller_mobile;

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
                                    <h4 class="mb-sm-0 font-size-18">Job Card Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-3">
                                                @php
                                                    $customer = DB::table('customers')->where('id',$consignments->customer_name)->first();
                                                @endphp
                                                <h4 class="card-title mb-4" style="text-transform:uppercase">{{ $customer->name }}</h4>
                                            </div>
                                            <div class="col-3">
                                                @if ($consignments->status=='pending')
                                                    <h4 class="card-title mb-4 text-danger">Status : Pending</h4>
                                                @elseif ($consignments->status=='informed')
                                                    <h4 class="card-title mb-4 text-info" >Status : Processing</h4>
                                                @elseif ($consignments->status=='returned')
                                                    <h4 class="card-title mb-4 text-danger">Status : Returned</h4>
                                                @elseif ($consignments->status=='delivered')
                                                    <h4 class="card-title mb-4 text-success">Status : Delivered - <span style="color:rgb(247, 58, 58);">Not Printed</span></h4>
                                                @elseif ($consignments->status=='printed')
                                                    <h4 class="card-title mb-4 text-success">Status : Delivered - Printed</h4>
                                                @endif

                                            </div>
                                           <div class="col-4">
                                                @php
                                                    $get_chip = DB::table('chiplevels')->where('jobcard_id',$consignments->id)->first();
                                                @endphp
                                                @php
                                                    $get_warrenty = DB::table('warrenties')->where('jobcard_id',$consignments->id)->first();
                                                @endphp
                                                @if($get_chip)
                                                    @if($get_chip->status == 'active')
                                                        @php
                                                            $get_chip_name = DB::table('sellers')->where('id',$get_chip->servicer_name)->first();
                                                        @endphp
                                                        <h4 class="card-title mb-4 text-warning">Chip Level : {{ $get_chip_name->seller_name }}</h4>
                                                    @endif
                                                @elseif($get_warrenty)
                                                    @if($get_warrenty->status == 'active')
                                                        @php
                                                            $get_sellers = DB::table('sellers')->where('id',$get_warrenty->shop_name)->first();
                                                        @endphp
                                                        <h4 class="card-title mb-4 text-warning">Warrenty : {{ $get_sellers->seller_name }}</h4>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-2 text-end">
                                                <a href="{{ route('consignment.print_details',$consignments->id) }}" target="_blank">
                                                    <button type="button" class="btn btn-success">
                                                        <i class="fa fa-print"></i><span style="margin-left: 10px;">Print</span>
                                                    </button>
                                                </a>
                                            </div>

                                        </div>

                                        <div class="table-responsive" id="printBody">
                                            <!--<div class="text-center mb-3" id="t_head" style="display: none;">-->
                                            <!--    <h2 class="text-center m-0 p-0">TECHSOUL CYBER SOLUTIONS</h2>-->
                                            <!--    <h5 class="text-center m-0 p-0">GSTIN : 32ADNPO8730B1ZO</h5>-->
                                            <!--    <h5 class="text-center m-0 p-0">OPP.TRUST HOSPITAL ROOM NO: 20/792, RM-VENTURES, RANDATHANI.PO</h5>-->
                                            <!--    <h5 class="text-center m-0 p-0">MALAPPURAM-KERALA Tel:+918891989842</h5>-->
                                            <!--</div>-->
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                            <tbody>

                                                <tr>
                                                    <th class="text-nowrap" scope="row">Job Number</th>
                                                    <td colspan="7">{{ $consignments->jobcard_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Date</th>
                                                    <td colspan="7">{{ $consignments->date }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Branch</th>
                                                    <td colspan="7">{{ $consignments->branch }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Name Of Customer</th>
                                                    @php
                                                        $customer = DB::table('customers')->where('id',$consignments->customer_name)->first();
                                                    @endphp
                                                    <td colspan="7">{{ $customer->name }}</td>
                                                </tr>
                                                {{-- modal start --}}
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Add by</th>
                                                    <td colspan="7">{{ $consignments->add_by }}</td>
                                                </tr>
                                                <div id="name_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Customer Name</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_name',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Customer Name</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="customer_name" value="{{ $consignments->customer_name }}" placeholder="Enter Customer Name" style="text-transform:uppercase;">
                                                                        @error('customer_name')
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
                                                    <th class="text-nowrap" scope="row">Phone</th>
                                                    <td colspan="6">{{ $consignments->phone }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#phone_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="phone_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Customer Phone</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_phone',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Customer Phone</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="phone" value="{{ $consignments->phone }}" placeholder="Enter Customer Phone">
                                                                        @error('phone')
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
                                                    <th class="text-nowrap" scope="row">Place Of Customer</th>
                                                    <td colspan="6">{{ $consignments->customer_place }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#place_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="place_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Customer Place</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_place',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Customer Place</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="customer_place" value="{{ $consignments->customer_place }}" placeholder="Enter Customer Phone" style="text-transform:uppercase;">
                                                                        @error('customer_place')
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
                                                    <th class="text-nowrap" scope="row">Email</th>
                                                    <td colspan="6">{{ $consignments->email }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#email_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="email_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Customer Email</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_email',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Customer Email</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="email" class="form-control" name="email" value="{{ $consignments->email }}" placeholder="Enter Customer Email">
                                                                        @error('email')
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
                                                    <th class="text-nowrap" scope="row">Customer Type</th>
                                                    <td colspan="6">{{ $consignments->customer_type }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#customer_type_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif

                                                </tr>
                                                {{-- modal start --}}

                                                <div id="customer_type_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Customer Type</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body" style="position: static;">
                                                            <form method="POST" action="{{ route('jobcard_edit_customer_type',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Customer Type</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control select2" data-dropdown-parent="#customer_type_modal" name="customer_type" id='customer_type' style="width:100%;">
                                                                            <option value="End User" @if ($consignments->customer_type == 'End User') selected @endif >End User</option>
                                                                            <option value="Dealer" @if ($consignments->customer_type == 'Dealer') selected @endif >Dealer</option>
                                                                        </select>
                                                                        @error('customer_type')
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
                                                    <th class="text-nowrap" scope="row">Work Location</th>
                                                    <td colspan="6"> {{ $consignments->work_location }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#work_location_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="work_location_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Work Location</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_work_location',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Work Location</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control select2" data-dropdown-parent="#work_location_modal" name="work_location" id='work_location' style="width:100%;">
                                                                            <option value="On Site" @if ($consignments->work_location == 'On Site') selected @endif>On Site</option>
                                                                            <option value="Direct" @if ($consignments->work_location == 'Direct') selected @endif>Direct</option>
                                                                            <option value="Van" @if ($consignments->work_location == 'Van') selected @endif>Van</option>
                                                                            <option value="Courier" @if ($consignments->work_location == 'Courier') selected @endif>Courier</option>
                                                                        </select>
                                                                        @error('work_location')
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
                                                    <th class="text-nowrap" scope="row">Service Type</th>
                                                    <td colspan="6">{{ $consignments->service_type }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#service_type_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="service_type_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Service Type</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_service_type',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Service Type</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control select2" data-dropdown-parent="#service_type_modal" name="service_type" id='service_type' style="width:100%;">
                                                                            <option value="New" @if ($consignments->service_type == 'New') selected @endif>New</option>
                                                                            <option value="AMC" @if ($consignments->service_type == 'AMC') selected @endif>AMC</option>
                                                                            <option value="Re Repair" @if ($consignments->service_type == 'Re Repair') selected @endif>Re Repair</option>
                                                                            <option value="Installation" @if ($consignments->service_type == 'Installation') selected @endif>Installation</option>
                                                                            <option value="Warrenty" @if ($consignments->service_type == 'Warrenty') selected @endif>Warrenty</option>
                                                                        </select>
                                                                        @error('service_type')
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
                                                    <td colspan="6">{{ $consignments->product_name }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#product_name_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                    {{-- modal start --}}

                                                    <div id="product_name_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Product Name</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('jobcard_edit_product_name',$consignments->id) }}">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label" style="float:left;">Product Name</label>
                                                                        <div class="col-lg-12">
                                                                            <input type="text" class="form-control" name="product_name" value="{{ $consignments->product_name }}" style="text-transform: uppercase;">
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
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Serial No.</th>
                                                    <td colspan="6">{{ $consignments->serial_no }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#serial_num_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="serial_num_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Serial No.</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_serial_num',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Serial No.</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="serial_no" value="{{ $consignments->serial_no }}" placeholder="Enter Serial No." style="text-transform:uppercase;">
                                                                        @error('serial_no')
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
                                                    <th class="text-nowrap" scope="row">Complaints</th>
                                                    <td colspan="6">{{ $consignments->complaints }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#complaint_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="complaint_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Complaints</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_complaints',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Complaints</label>
                                                                    <div class="col-lg-12">
                                                                        <textarea class="form-control" name="complaints" rows="3" placeholder="Enter complaints" style="text-transform:uppercase;">{{ $consignments->complaints }}</textarea>
                                                                        @error('complaints')
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
                                                    <th class="text-nowrap" scope="row">Components</th>
                                                    <td colspan="6">{{ $consignments->components }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#components_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="components_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Components</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_components_recieved',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Components</label>
                                                                    <div class="col-lg-12">
                                                                        <textarea class="form-control" name="components" rows="4" placeholder="Enter Components Recieved" style="text-transform:uppercase;">{{ $consignments->components }}</textarea>
                                                                        @error('components')
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
                                                    <th class="text-nowrap" scope="row">Remarks</th>
                                                    <td colspan="6">{{ $consignments->remarks }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#remark_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="remark_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Remarks</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_remarks',$consignments->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Remarks</label>
                                                                    <div class="col-lg-12">
                                                                        <textarea class="form-control" name="remarks" rows="4" placeholder="Enter remarks" style="text-transform:uppercase;">{{ $consignments->remarks }}</textarea>
                                                                        @error('remarks')
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
                                                    <th class="text-nowrap" scope="row">Advance Paid</th>
                                                    @if ($consignments->advance)
                                                        <td colspan="6">₹{{ $consignments->advance }}</td>
                                                    @else
                                                            @php
                                                                $consignments->advance = 0;
                                                            @endphp
                                                        <td colspan="6">₹{{ $consignments->advance }}</td>
                                                    @endif
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#advance_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="advance_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Advance Paid</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('jobcard_edit_advance',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Advance Paid</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="advance" value="{{ $consignments->advance }}" >
                                                                        @error('advance')
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
                                                    <th class="text-nowrap" scope="row">Accessories Used</th>
                                                    <td colspan="6">
                                                    @php
                                                        $getSales = DB::table('sales')->where('job_card_id',$consignments->id)->get();
                                                        $grandTotal = 0;
                                                    @endphp
                                                    @foreach ($getSales as $sales)
                                                        @php
                                                            $getProduct = DB::table('products')->where('id',$sales->product_id)->first();
                                                        @endphp
                                                        @if($getProduct == Null)
                                                            {{ $sales->product_id }} ( {{$sales->total}})<br>
                                                        @else
                                                            {{$getProduct->product_name}} - {{ $sales->qty }} (₹ {{$sales->total}})<br>
                                                        @endif
                                                        @php
                                                            $grandTotal = $grandTotal + $sales->total;
                                                        @endphp

                                                    @endforeach
                                                    </td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#accessories_modal">
                                                                <i class="mdi mdi-pencil font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Grand Total</th>
                                                    <td colspan="6">₹{{ $grandTotal }}</td>

                                                </tr>
                                                @php
                                                    $get_chiplevel_count = DB::table('chiplevels')->where('jobcard_id',$consignments->id)->count();
                                                @endphp
                                                @if($get_chiplevel_count > 0)
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Chip Level Servicer</th>
                                                    @php
                                                        $get_chiplevel = DB::table('chiplevels')->where('jobcard_id',$consignments->id)->first();
                                                    @endphp
                                                    <td colspan="6">{{ $get_chiplevel->servicer_name }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#chip_modal">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="chip_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Chip-Level Service Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Date</label>
                                                                        <input type="date" name="service_date" class="form-control" value="{{ $get_chiplevel->service_date }}" readonly>
                                                                    </div>
                                                                    @php
                                                                        $seller = DB::table('sellers')->where('id',$get_chiplevel->servicer_name)->first();
                                                                    @endphp
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Servicer/Shop Name</label>
                                                                        <input type="text" class="form-control" name="servicer_name" value="{{ $seller->seller_name }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Contact Number</label>
                                                                        <input type="text" class="form-control" name="servicer_contact" value="{{ $get_chiplevel->servicer_contact }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Staff Name</label>
                                                                        @php
                                                                            $get_staff = DB::table('staffs')->where('id',$get_chiplevel->staff_name )->first();
                                                                        @endphp
                                                                        <input type="text" class="form-control" name="staff_name" value="{{$get_staff->staff_name }}" readonly >
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Chip Level Complaint</label>
                                                                        <textarea class="form-control" rows="3" name="chiplevel_complaint" readonly>{{ $get_chiplevel->chiplevel_complaint  }}</textarea>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Service Charge(₹)</label>
                                                                        <input type="text" class="form-control" name="service_charge" value="₹{{ $get_chiplevel->service_charge  }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Return Date</label>
                                                                        <input type="date" class="form-control" name="return_date" value="{{ $get_chiplevel->return_date  }}" readonly >
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Hand Over To</label>
                                                                        @php
                                                                            $get_staff = DB::table('staffs')->where('id',$get_chiplevel->handover_staff )->first();
                                                                        @endphp
                                                                        @if ($get_staff)
                                                                            <input type="text" class="form-control" name="handover_staff" value="{{ $get_staff->staff_name  }}" readonly >
                                                                        @else
                                                                            <input type="text" class="form-control" name="handover_staff" value="" readonly >
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Courier or Delivery</label>
                                                                        <input type="text" class="form-control" name="return_date" value="{{ $get_chiplevel->courier_delivery  }}" readonly >
                                                                    </div>
                                                                    @if ($get_chiplevel->courier_bill)
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Courier Bill : </label>
                                                                            <div>
                                                                                <a href="{{ asset('storage/courier_bills/'.$get_chiplevel->courier_bill) }}" target="_blank">
                                                                                    <img src="{{ asset('storage/courier_bills/'.$get_chiplevel->courier_bill) }}" alt="" style="height: 100px;margin-left: 10px !important;margin: 10px" class="img-fluid mx-auto jobcard-images">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                {{-- modal end --}}
                                                @endif
                                                @php
                                                    $get_warrenty_count = DB::table('warrenties')->where('jobcard_id',$consignments->id)->count();
                                                @endphp
                                                @if($get_warrenty_count > 0)
                                                <tr class="not_print">
                                                    <th class="text-nowrap" scope="row">Warrenty Servicer</th>
                                                    @php
                                                        $get_warrenty = DB::table('warrenties')->where('jobcard_id',$consignments->id)->first();
                                                    @endphp
                                                    @php
                                                        $get_seller = DB::table('sellers')->where('id',$get_warrenty->shop_name )->first();
                                                    @endphp
                                                    <td colspan="6">{{ $get_seller->seller_name }}</td>
                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                        <td>
                                                            <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#warrenty_modal">
                                                                <i class="mdi mdi-eye font-size-18"></i>
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="warrenty_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Warrenty Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Date</label>
                                                                        <input type="date" name="service_date" class="form-control" value="{{ $get_warrenty->service_date }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Servicer/Shop Name</label>
                                                                        @php
                                                                            $get_seller = DB::table('sellers')->where('id',$get_warrenty->shop_name )->first();
                                                                        @endphp
                                                                        <input type="text" class="form-control" name="warrenty_servicer_name" value="{{ $get_seller->seller_name }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Contact Number</label>
                                                                        <input type="text" class="form-control" name="servicer_contact" value="{{ $get_warrenty->servicer_contact }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Staff Name</label>
                                                                        @php
                                                                            $get_staff = DB::table('staffs')->where('id',$get_warrenty->staff_name )->first();
                                                                        @endphp
                                                                        <input type="text" class="form-control" name="staff_name" value="{{$get_staff->staff_name }}" readonly >
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Complaint</label>
                                                                        <textarea class="form-control" rows="3" name="warrenty_complaint" readonly>{{ $get_warrenty->warrenty_complaint  }}</textarea>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Service Charge()</label>
                                                                        <input type="text" class="form-control" name="service_charge" value="₹{{ $get_warrenty->service_charge  }}" readonly>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Return Date</label>
                                                                        <input type="date" class="form-control" name="return_date" value="{{ $get_warrenty->return_date  }}" readonly >
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        @if($get_warrenty->handover_staff)
                                                                        <label class="col-form-label" style="float:left;">Hand Over To</label>
                                                                            @php
                                                                                $get_staff = DB::table('staffs')->where('id',$get_warrenty->handover_staff )->first();
                                                                            @endphp
                                                                            <input type="text" class="form-control" name="handover_staff" value="{{ $get_staff->staff_name  }}" readonly >
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Courier or Delivery</label>
                                                                        <input type="text" class="form-control" name="return_date" value="{{ $get_warrenty->courier_delivery  }}" readonly >
                                                                    </div>
                                                                    @if ($get_warrenty->courier_bill)
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Courier Bill : </label>
                                                                            <div>
                                                                                <a href="{{ asset('storage/courier_bills/'.$get_warrenty->courier_bill) }}" target="_blank">
                                                                                    <img src="{{ asset('storage/courier_bills/'.$get_warrenty->courier_bill) }}" alt="" style="height: 100px;margin-left: 10px !important;margin: 10px" class="img-fluid mx-auto jobcard-images">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                {{-- modal end --}}
                                                @endif

                                                <tr class="not_print">
                                                    <th class="text-nowrap" scope="row">Images</th>
                                                    <td colspan="7">
                                                        @if($consignments->image1 != Null)
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <a href="{{ asset('storage/images/'.$consignments->image1) }}" target="_blank">
                                                                        <img src="{{ asset('storage/images/'.$consignments->image1) }}" alt="" class="img-fluid mx-auto jobcard-images">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="text-sm-end mt-4 mt-sm-0">
                                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                                        <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#image_modal1">
                                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                                        </button>
                                                                    @endif
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="image_modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                            <form method="POST" action="{{ route('jobcard_edit_image1',$consignments->id) }}" enctype="multipart/form-data">
                                                                                    @csrf

                                                                                <div class="modal-body">
                                                                                    <input class="form-control" name="image1" type="file">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Upadte</button>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($consignments->image2 != Null)
                                                        <hr>
                                                        <div class="d-flex mt-3">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <a href="{{ asset('storage/images/'.$consignments->image2) }}" target="_blank">
                                                                        <img src="{{ asset('storage/images/'.$consignments->image2) }}" alt="" class="img-fluid mx-auto jobcard-images">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="text-sm-end mt-4 mt-sm-0">
                                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                                        <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#image_modal2">
                                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                                        </button>
                                                                    @endif
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="image_modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                            <form method="POST" action="{{ route('jobcard_edit_image2',$consignments->id) }}" enctype="multipart/form-data">
                                                                                @csrf

                                                                                <div class="modal-body">
                                                                                    <input class="form-control" name="image2" type="file">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Upadte</button>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($consignments->image3 != Null)
                                                        <hr>
                                                        <div class="d-flex mt-3">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <a href="{{ asset('storage/images/'.$consignments->image3) }}" target="_blank">
                                                                        <img src="{{ asset('storage/images/'.$consignments->image3) }}" alt="" class="img-fluid mx-auto jobcard-images">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="text-sm-end mt-4 mt-sm-0">
                                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                                        <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#image_modal3">
                                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                                        </button>
                                                                    @endif
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="image_modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                            <form method="POST" action="{{ route('jobcard_edit_image3',$consignments->id) }}" enctype="multipart/form-data">
                                                                                    @csrf

                                                                                <div class="modal-body">
                                                                                    <input class="form-control" name="image3" type="file">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Upadte</button>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($consignments->image4 != Null)
                                                        <hr>
                                                        <div class="d-flex mt-3">
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <a href="{{ asset('storage/images/'.$consignments->image4) }}" target="_blank">
                                                                        <img src="{{ asset('storage/images/'.$consignments->image4) }}" alt="" class="img-fluid mx-auto jobcard-images">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="text-sm-end mt-4 mt-sm-0">
                                                                    @if($consignments->status == 'pending' || $consignments->status == 'informed')
                                                                        <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#image_modal4">
                                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                                        </button>
                                                                    @endif
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="image_modal4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                            <form method="POST" action="{{ route('jobcard_edit_image4',$consignments->id) }}" enctype="multipart/form-data">
                                                                                    @csrf

                                                                                <div class="modal-body">
                                                                                    <input class="form-control" name="image4" type="file">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Upadte</button>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if( $consignments->complaint_details != Null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Complaint Details</th>
                                                        <td colspan="6">{{ $consignments->complaint_details }}</td>
                                                    </tr>
                                                @endif
                                                @if( $consignments->estimate != Null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Estimate</th>
                                                        <td colspan="6">{{ $consignments->estimate }}</td>
                                                    </tr>
                                                @endif
                                                @if($consignments->informed_staff != null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Informed</th>
                                                        <td colspan="7">
                                                            <h6 class="m-0">
                                                                <strong>{{ $consignments->informed_staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignments->informed_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($consignments->approved_staff != null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Approved</th>
                                                        <td colspan="7">
                                                            <h6 class="m-0">
                                                                <strong>{{ $consignments->approved_staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignments->approved_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $consignmentAssessments = App\Models\ConsignmentAssessment::where('consignment_id',$consignments->id)->get();
                                                @endphp
                                                @if($consignmentAssessments && $consignmentAssessments->isNotEmpty())
                                                    <tr class="not_print">
                                                        <th colspan="8" class="text-nowrap" scope="row">Assessments</th>
                                                    </tr>
                                                    <tr class="not_print">
                                                        <th  class="text-nowrap" scope="row">Staff</th>
                                                        <th colspan="7" class="text-nowrap" scope="row">Complaint Details</th>
                                                    </tr>
                                                    @foreach ( $consignmentAssessments as $consignmentAssessment )
                                                        <tr class="not_print">
                                                            <td>
                                                                <strong>{{ $consignmentAssessment->staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignmentAssessment->date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </td>
                                                            <td colspan="7">{{ $consignmentAssessment->description }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if($consignments->rejected_staff != null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Returned</th>
                                                        <td colspan="7">
                                                            <h6 class="m-0">
                                                                <strong>{{ $consignments->rejected_staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignments->rejected_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($consignments->return_staff != null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Returned</th>
                                                        <td colspan="7">
                                                            <h6 class="m-0">
                                                                <strong>{{ $consignments->return_staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignments->return_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($consignments->delivered_staff != null)
                                                    <tr class="not_print">
                                                        <th class="text-nowrap" scope="row">Delivered</th>
                                                        <td colspan="7">
                                                            <h6 class="m-0">
                                                                <strong>{{ $consignments->delivered_staff }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($consignments->delivered_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>

                                        </div>
                                        {{-- modal start --}}
                                        <div id="accessories_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Accessories Used</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form method="POST" action="">
                                                    @csrf
                                                        <div class="table-responsive mb-3" id="accessories_div">
                                                            <table class="table align-middle mb-0 table-nowrap">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Product</th>
                                                                        <th>Price</th>
                                                                        <th>Qty</th>
                                                                        <th>Tax(%)</th>
                                                                        <th>GST</th>
                                                                        <th>Total</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $get_sales_details = DB::table('sales')->where('job_card_id',$consignments->id)->get();
                                                                    @endphp
                                                                    @foreach ( $get_sales_details as $get_sale)
                                                                        <tr>
                                                                            {{-- <input type="hidden" name="sale_id"  value="{{ $get_sale->id }}"> --}}
                                                                            @php
                                                                                $get_product = DB::table('products')->where('id',$get_sale->product_id)->first();
                                                                            @endphp
                                                                            @if($get_product == Null)
                                                                                <td>{{ $get_sale->product_id }}</td>
                                                                            @else
                                                                                <td>{{ $get_product->product_name }}</td>
                                                                            @endif
                                                                            <td>{{ $get_sale->price }}</td>
                                                                            <td>{{ $get_sale->qty }}</td>
                                                                            <td>{{ $get_sale->tax }}</td>
                                                                            <td>{{ $get_sale->gst }}</td>
                                                                            <td>{{ $get_sale->total }}</td>
                                                                            <td>
                                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#confirm_modal{{$get_sale->id}}" class="btn btn-danger">
                                                                                    <span><i class="mdi mdi-trash-can"></i></span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Delete Modal -->
                                                                        <div id="confirm_modal{{$get_sale->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content" style="background-color: rgb(189, 206, 212)">

                                                                                    <div class="modal-body">
                                                                                        <form method="Post" action="">
                                                                                            @csrf
                                                                                            <div class="form-group mb-3">
                                                                                                <div class="col-lg-12 text-center">
                                                                                                    <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                                                                                    <h4>Are You Sure ??</h4>
                                                                                                    <p style="font-weight: 300px;font-size:18px;">You can't be revert this!</p>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-lg-12 text-end">
                                                                                                    <button type="button" class="btn btn-info" onclick="delete_accessories({{ $get_sale->id }});">Yes, delete</button>
                                                                                                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> --}}

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
                                                        <div class="row">
                                                            <div class="col-lg-12 text-end">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        {{-- modal end --}}


                                            <div class="button-items mt-4" style="float:right;">
                                                @if ($consignments->status == 'rejected')
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#return_modal">
                                                        <i class="bx bx-block font-size-16 align-middle me-2"></i> Returned
                                                    </button>
                                                    <div id="return_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Customer Relationship Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('return_consignment',$consignments->id) }}">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Customer Relationship</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#return_modal" name="customer_relation" id='customer_relation' onchange="show_gstno($consignments->customer_name)" style="width:100%;">
                                                                                <option value="B2C">B2C</option>
                                                                                <option value="B2B">B2B</option>
                                                                            </select>
                                                                            @error('customer_relation')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-lg-12" id="gst_div" style="display:none;">
                                                                            <label class="col-form-label" style="float:left;">GST NUMBER</label>
                                                                            <input type="text" class="form-control" name="gst_no" id="gst_no" value="{{ old('gst_no') }}" style="text-transform: uppercase;">
                                                                            @error('gst_no')
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
                                                @endif
                                                @if ($consignments->status == 'pending' || $consignments->status == 'informed')
                                                    <button type="button" class="btn btn-warning waves-effect waves-light" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#assessment_modal{{ $consignments->id }}">Assessment </button>

                                                    <div id="assessment_modal{{ $consignments->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Complaint Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('assessment_consignment',$consignments->id) }}">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label required" style="float:left;">Complaint</label>
                                                                            <textarea class="form-control" name="complaint_details" rows="4" style="text-transform:uppercase;" required></textarea>
                                                                            @error('complaint_details')
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

                                                    <!--<button type="button" class="btn btn-danger waves-effect waves-light" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#return_modal">-->
                                                    <!--    <i class="bx bx-block font-size-16 align-middle me-2"></i> Returned-->
                                                    <!--</button>-->
                                                    {{-- modal start --}}
                                                    <a href="{{ route('reject_jobcard',$consignments->id) }}">
                                                        <button type="button" class="btn btn-danger waves-effect">
                                                            <i class="bx bx-block font-size-16 align-middle me-2"></i> Reject
                                                        </button>
                                                    </a>

                                                    <div id="return_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Customer Relationship Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                <form method="POST" action="{{ route('return_consignment',$consignments->id) }}">
                                                                @csrf
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Customer Relationship</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#return_modal" name="customer_relation" id='customer_relation' onchange="show_gstno($consignments->customer_name)" style="width:100%;">
                                                                                <option value="B2C">B2C</option>
                                                                                <option value="B2B">B2B</option>
                                                                            </select>
                                                                            @error('customer_relation')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-lg-12" id="gst_div" style="display:none;">
                                                                            <label class="col-form-label" style="float:left;">GST NUMBER</label>
                                                                            <input type="text" class="form-control" name="gst_no" id="gst_no" value="{{ old('gst_no') }}" style="text-transform: uppercase;">
                                                                            @error('gst_no')
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
                                                    @if($get_chiplevel_count > 0)
                                                    <button type="button" class="btn btn-info waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#chiplevel_details_modal">
                                                        <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i> Chip-Level Status
                                                    </button>
                                                    {{-- modal start --}}

                                                    <div id="chiplevel_details_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Chip-Level/Warrenty Status</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('chiplevel.update',$get_chiplevel->id) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                            <div class="form-group mb-3">

                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Complaint</label>
                                                                                    <textarea class="form-control" rows="3" name="chiplevel_complaint" style="text-transform:uppercase;">{{ $get_chiplevel->chiplevel_complaint }}</textarea>
                                                                                    @error('chiplevel_complaint')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Service Charge(₹)</label>
                                                                                    <input type="number" class="form-control" name="service_charge" value="{{ $get_chiplevel->service_charge }}" required>
                                                                                    @error('service_charge')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Return Date</label>
                                                                                    <input type="date" class="form-control" name="return_date" value="{{ $get_chiplevel->return_date }}" required>
                                                                                    @error('return_date')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Hand Overed To</label>
                                                                                    <select class="form-control select2" data-dropdown-parent="#chiplevel_details_modal" name="handover_staff" style="width:100%;" required>
                                                                                        <option selected disabled>Select</option>
                                                                                        @php
                                                                                            $get_staff = DB::table('staffs')->where('status','active')->get();
                                                                                        @endphp
                                                                                        @foreach ( $get_staff as $staff)
                                                                                            <option value="{{ $staff->id }}" @if ($get_chiplevel->handover_staff == $staff->id ) selected @endif>{{ $staff->staff_name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('handover_staff')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    @elseif($get_warrenty_count > 0)
                                                    <button type="button" class="btn btn-warning waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#warrenty_details_modal">
                                                        <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i>Warrenty Status
                                                    </button>
                                                    {{-- modal start --}}

                                                    <div id="warrenty_details_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Warrenty Status</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('update_warrenty',$get_warrenty->id) }}">
                                                                        @csrf
                                                                            <div class="form-group mb-3">

                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Complaint</label>
                                                                                    <textarea class="form-control" rows="3" name="warrenty_complaint" style="text-transform:uppercase;">{{ $get_warrenty->warrenty_complaint }}</textarea>
                                                                                    @error('warrenty_complaint')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Service Charge(₹)</label>
                                                                                    <input type="number" class="form-control" name="service_charge" value="{{ $get_warrenty->service_charge }}">
                                                                                    @error('service_charge')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Return Date</label>
                                                                                    <input type="date" class="form-control" name="return_date" value="{{ $get_warrenty->return_date }}">
                                                                                    @error('return_date')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <label class="col-form-label" style="float:left;">Hand Overed To</label>
                                                                                    <select class="form-control select2" data-dropdown-parent="#warrenty_details_modal" name="handover_staff" style="width:100%;">
                                                                                        <option selected disabled>Select</option>
                                                                                        @php
                                                                                            $get_staff = DB::table('staffs')->where('status','active')->get();
                                                                                        @endphp
                                                                                        @foreach ( $get_staff as $staff)
                                                                                            <option value="{{ $staff->id }}" @if ($get_warrenty->handover_staff == $staff->id ) selected @endif>{{ $staff->staff_name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('handover_staff')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                    {{-- modal end --}}
                                                @else
                                                    @if($consignments->status != 'pending')
                                                        <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#chiplevel_modal">
                                                            <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i> Chip-Level/Warrenty Service
                                                        </button>
                                                    @endif
                                                @endif
                                                {{-- modal start --}}

                                                <div id="chiplevel_modal" class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Chip-Level/Warrenty Service Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('service_store', $consignments->id) }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group mb-3">
                                                                        <!-- Date Input -->
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Date</label>
                                                                            <input type="date" name="service_date" class="form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" max="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                                                            @error('service_date')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Service Type Dropdown -->
                                                                        <div class="col-lg-12">
                                                                            <label class="col-form-label" style="float:left;">Service Type</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#chiplevel_modal" name="product_service_type" id="product_service_type" onchange="show_fields(this.value)" style="width:100%;" required>
                                                                                <option selected disabled>Select</option>
                                                                                <option value="chiplevel">Chip-level</option>
                                                                                <option value="warrenty">Warrenty</option>
                                                                            </select>
                                                                            @error('product_service_type')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Conditional Fields -->
                                                                        <div class="col-lg-12" id="chip_servicer_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Chip Level Servicer/Shop Name</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#chiplevel_modal" name="chip_servicer_name" id="chip_servicer_name" onchange="add_servicer(this.value)" style="width:100%;" required>
                                                                                <option selected disabled>Select</option>
                                                                                <!--<option value="add_servicer">Add New Servicer</option>-->
                                                                                @php
                                                                                    $get_servicer = DB::table('sellers')->get();
                                                                                @endphp
                                                                                @foreach ($get_servicer as $servicer)
                                                                                    <option value="{{ $servicer->id }}">{{ $servicer->seller_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('chip_servicer_name')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-lg-12" id="warrenty_servicer_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Warrenty Servicer/Shop Name</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#chiplevel_modal" name="warrenty_servicer_name" onchange="get_seller_contact(this.value)" style="width:100%;" required>
                                                                                <option selected disabled>Select</option>
                                                                                @php
                                                                                    $get_seller = DB::table('sellers')->get();
                                                                                @endphp
                                                                                @foreach ($get_seller as $seller)
                                                                                    <option value="{{ $seller->id }}">{{ $seller->seller_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('warrenty_servicer_name')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-lg-12" id="servicer_contact_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Contact Number</label>
                                                                            <input type="text" class="form-control" name="servicer_contact" id="servicer_contact" value="{{ old('servicer_contact') }}" required>
                                                                            @error('servicer_contact')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-lg-12" id="staff_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Staff Name</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#chiplevel_modal" name="staff_name" style="width:100%;" required>
                                                                                <option selected disabled>Select</option>
                                                                                @php
                                                                                    $get_staff = DB::table('staffs')->where('status','active')->get();
                                                                                @endphp
                                                                                @foreach ($get_staff as $staff)
                                                                                    <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('staff_name')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-lg-12" id="courier_delivery_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Courier or Delivery</label>
                                                                            <select class="form-control select2" data-dropdown-parent="#chiplevel_modal" name="courier_delivery" id="courier_delivery" onchange="show_courier_delivery_fields(this.value)" style="width:100%;" required>
                                                                                <option selected disabled>Select</option>
                                                                                <option value="Courier">Courier</option>
                                                                                <option value="Shop-Delivery">Shop-Delivery</option>
                                                                                <option value="Bus-Delivery">Bus-Delivery</option>
                                                                            </select>
                                                                            @error('courier_delivery')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-lg-12" id="courier_bill_div" style="display: none;">
                                                                            <label class="col-form-label" style="float:left;">Courier Bill</label>
                                                                            <input class="form-control mt-4" name="courier_bill" id="courier_bill" type="file">
                                                                            @error('courier_bill')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                {{-- modal start --}}
                                                <div class="modal fade" id="myModal2">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add New Servicer</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Servicer Name</label>
                                                                        <input type="text" class="form-control" name="servicer_name" id="servicer_name" value="{{ old('servicer_name') }}" style="text-transform:uppercase;">
                                                                        @error('servicer_name')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Servicer Contact</label>
                                                                        <input type="text" class="form-control" name="servicer_contact" id="servicer_contact" value="{{ old('servicer_contact') }}">
                                                                        @error('servicer_contact')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Servicer Place</label>
                                                                        <input type="text" class="form-control" name="servicer_place" id="servicer_place" value="{{ old('servicer_place') }}" style="text-transform:uppercase;">
                                                                        @error('servicer_place')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask" onclick="store_servicer()">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- modal end --}}


                                                @if ($consignments->approve_status != 'approved')
                                                    {{-- <a href="https://wa.me/91{{$consignments->phone}}" target="__blank"> --}}
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#informed_modal">
                                                            <i class="bx bx-smile font-size-16 align-middle me-2"></i> Informed to Customer
                                                        </button>
                                                    {{-- </a> --}}
                                                @endif
                                                {{-- modal start --}}

                                                <div id="informed_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Complaint Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('inform_consignment',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Complaint</label>
                                                                        <textarea class="form-control" name="complaint_details" rows="4" style="text-transform:uppercase;">{{ $consignments->complaint_details }}</textarea>
                                                                        @error('complaint_details')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Estimate</label>
                                                                        <input type="number" class="form-control" name="estimate" value="{{ $consignments->estimate }}">
                                                                        @error('estimate')
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
                                                @php
                                                    $service_without_count = DB::table('sales')->where('job_card_id',$consignments->id)->where('product_id','SERVICE WITHOUT CHARGE')->count();
                                                @endphp
                                                @if( $consignments->status == 'informed' && $service_without_count == 0 && $consignments->approve_status == 'approved')
                                                    @if($get_chip)
                                                        @if($get_chip->status != 'active')
                                                            <button type="button" class="btn btn-warning waves-effect waves-light" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#items_modal">
                                                            <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i> Add Accessories
                                                            </button>
                                                        @endif
                                                    @elseif($get_warrenty)
                                                        @if($get_warrenty->status != 'active')
                                                            <button type="button" class="btn btn-warning waves-effect waves-light" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#items_modal">
                                                            <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i> Add Accessories
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button type="button" class="btn btn-warning waves-effect waves-light" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#items_modal">
                                                        <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i> Add Accessories
                                                        </button>
                                                    @endif
                                                @endif
                                                {{-- modal start --}}

                                                <div id="items_modal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Add Accessories</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                                                            @csrf
                                                                <div class="row">
                                                                    <div class="form-group mb-3 col-lg-8">
                                                                        {{-- <label class="col-form-label" style="float:left;">Select Accessories</label>
                                                                        <div class="col-lg-12"> --}}
                                                                            <select class="form-control select2" name="productSelect" id="productSelect" onchange="additem()" data-dropdown-parent="#items_modal" style="width:100%;">
                                                                                <option selected disabled>Select Accessories</option>
                                                                                <option value="service">Service</option>
                                                                                <option value="service_without_charge">Service Without Charge</option>
                                                                                @php
                                                                                    $stockProducts = DB::table('stocks')->where('product_qty','>',0)->get();
                                                                                @endphp
                                                                                @foreach ( $stockProducts as $product)
                                                                                    @php
                                                                                        $productDetails = DB::table('products')->where('id',$product->product_id)->first();
                                                                                    @endphp
                                                                                    <option value="{{ $productDetails->id }}">{{ $productDetails->product_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        {{-- </div> --}}
                                                                    </div>
                                                                    <div class="table-responsive">
                                                                        <table class="table align-middle mb-0 table-nowrap" id="stockTable">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th>Product</th>
                                                                                    <th>Serial</th>
                                                                                    <th>PriceWithTax</th>
                                                                                    <th>Price</th>
                                                                                    <th>Qty</th>
                                                                                    <th>Taxable</th>
                                                                                    <th>Tax</th>
                                                                                    <th>GST</th>
                                                                                    <th>Total</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tableBody">
                                                                            </tbody>
                                                                        </table>
                                                                        <input type="hidden" name="job_card_id" value="{{ $consignments->id }}">
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col-lg-6 text-start">
                                                                            <h6 class="text-danger" id="negativeError" style="display: none">Error : Values cannot be negative or zero</h6>
                                                                        </div>
                                                                        <div class="col-lg-6 text-end">
                                                                            <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Confirming...';this.form.submit();" id="addtask">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                {{-- modal end --}}
                                                @endif
                                                @if ($consignments->status == 'delivered' || $consignments->status == 'printed')
                                                <a href="{{ route('rework',$consignments->id) }}">
                                                <button type="button" class="btn btn-primary waves-effect waves-light">
                                                    <i class="bx bx-reset font-size-16 align-middle me-2"></i> Re-Work
                                                </button>
                                                </a>
                                                @endif
                                                @if($consignments->status == 'returned' || $consignments->status == 'delivered' || $consignments->status == 'printed')
                                                @if ( $consignments->invoice_no != '')
                                                    <a href="{{ route('view_invoice',$consignments->id) }}">
                                                        <button type="button" class="btn btn-success waves-effect waves-light">
                                                            <i class="bx bx-check-double font-size-16 align-middle me-2"></i> View Invoice
                                                        </button>
                                                    </a>
                                                @endif
                                                @elseif($consignments->status == 'informed')
                                                    @php
                                                        $get_job_sales = DB::table('sales')->where('job_card_id',$consignments->id)->first();
                                                    @endphp
                                                    @if($get_job_sales)
                                                        @php
                                                            $service_without_count = DB::table('sales')->where('job_card_id',$consignments->id)->where('product_id','SERVICE WITHOUT CHARGE')->count();
                                                        @endphp
                                                        @if ($service_without_count == 0)
                                                            <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" onclick="show_gst_modal('{{ $consignments->customer_name }}')">
                                                            <!--<button type="button" class="btn btn-success waves-effect waves-light" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#gst_modal">-->
                                                                <i class="bx bx-check-double font-size-16 align-middle me-2"></i> Delivered
                                                            </button>
                                                        @else
                                                            <a href="{{ route('deliver_without_invoice',$consignments->id) }}">
                                                                <button type="button" class="btn btn-success waves-effect waves-light">
                                                                    <i class="bx bx-check-double font-size-16 align-middle me-2"></i> Delivered Without Invoice
                                                                </button>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                                {{-- modal start --}}

                                                <div id="gst_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Customer Relationship Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('invoice',$consignments->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Customer Relationship</label>
                                                                        <select class="form-control select2" data-dropdown-parent="#gst_modal" name="customer_relation" id='invoice_customer_relation' onchange="show_invoice_gstno({{ $consignments->customer_name }})" style="width:100%;">
                                                                            <option value="B2C">B2C</option>
                                                                            <option value="B2B">B2B</option>
                                                                        </select>
                                                                        @error('customer_relation')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12" id="invoice_gst_div" style="display:none;">
                                                                        <label class="col-form-label" style="float:left;">GST NUMBER</label>
                                                                        <input type="text" class="form-control" name="gst_no" id="invoice_gst_no" value="{{ old('gst_no') }}" style="text-transform: uppercase;">
                                                                        @error('gst_no')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="col-form-label" style="float:left;">Payment Status</label>
                                                                        <select class="form-control select2" data-dropdown-parent="#gst_modal" name="payment_status" id='payment_status' onchange="show_method()" style="width:100%;">
                                                                            <option value="not paid">Not Paid</option>
                                                                            <option value="paid">Paid</option>
                                                                        </select>
                                                                        @error('payment_status')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-lg-12" id="method_div" style="display:none;">
                                                                        <label class="col-form-label" style="float:left;">Payment Method</label>
                                                                        <select class="form-control select2" data-dropdown-parent="#gst_modal" name="payment_method" id='payment_method' style="width:100%;">
                                                                            <option value="cash">Cash</option>
                                                                            <option value="account">Account</option>
                                                                        </select>
                                                                        @error('payment_method')
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
                                            </div>




                                    </div>
                                </div>
                            </div> <!-- end col -->


                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
