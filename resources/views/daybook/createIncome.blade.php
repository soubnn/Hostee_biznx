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
<script type="text/javascript">
    var count = 1;
    var rowNumber = 0;
    var pendingCommission = 0;
    var jobCardNumber = 0;
    var rows = [];
    var cashBalance = 0;
    var accountBalance = 0;

    $(document).ready(function(){
        var now_date = "{{ \App\Models\DaybookBalance::report_date() }}";
        var today = new Date(now_date);
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        getOpeningBalance(date);
        checkNumbers();
    });

    function changeAccounts(type,row)
    {
        if(document.getElementById("amount" + row).classList.contains("cAmount"))
        {
            if(type == "ACCOUNT")
            {
                document.getElementById("amount" + row).classList.replace("cAmount","bAmount");
            }
        }
        else if(document.getElementById("amount" + row).classList.contains("bAmount"))
        {
            if(type == "CASH")
            {
                document.getElementById("amount" + row).classList.replace("bAmount","cAmount");
            }
        }
        getPrice();
    }

    function getPrice()
    {
        cTotal = 0;
        bTotal = 0;
        $(".cAmount").each(function(){
            cTotal +=parseFloat($(this).val() || 0);
        });
        $(".bAmount").each(function(){
            bTotal +=parseFloat($(this).val() || 0);
        });
        console.log("Ctot:" + cTotal);
        console.log("Btot:" + bTotal);
        var bAmount = parseFloat(accountBalance) + bTotal;
        var cAmount = parseFloat(cashBalance) + cTotal;
        $("#cashCBTD").html(cAmount.toFixed(2));
        $("#cashCB").val(cAmount.toFixed(2));
        $("#accountCBTD").html(bAmount.toFixed(2));
        $("#bankCB").val(bAmount.toFixed(2));
    }

    function getOpeningBalance(todayDate)
    {
        $("#transferDate").val(todayDate);
        $.ajax({
            type : "get",
            url : "{{ route('getOpeningBalance') }}",
            data : { date : todayDate},
            success : function (res)
            {
                console.log(res);
                $("#cashOB").html(res.cash_balance);
                $("#cashCBTD").html(res.cash_balance);
                $("#cashCB").val(res.cash_balance);
                cashBalance = res.cash_balance;
                $("#accountOB").html(res.account_balance);
                $("#accountCBTD").html(res.account_balance);
                $("#bankCB").val(res.account_balance);
                accountBalance = res.account_balance;
           }
        });
    }

    function checkInputs()
    {
        var rowCount = $("#daybookTable>tbody>tr").length;
        lastRow = rows[rows.length - 1];
        console.log(lastRow);
        if(checkData(lastRow))
        {
            document.getElementById("errorMessage").style.display = "none";
            document.getElementById("saveButton").disabled = true;
            document.getElementById("saveButton").innerHTML = "Saving";
            // console.log("SUBMITTING>>>>");
            document.getElementById("daybookForm").submit();
        }
        else
        {
            document.getElementById("errorMessage").style.display = "block";
            document.getElementById("saveButton").disabled = false;
        }
        // this.disabled=true;this.innerHTML='Saving..';this.form.submit();
    }

    function addNewRows()
    {
        var rowCount = $("#daybookTable>tbody>tr").length;
        lastRow = rows[rows.length - 1];
        if(rowCount == 0)
        {
            addnewrow();
        }
        else
        {
            if(checkData(lastRow))
            {
                addnewrow();
                document.getElementById("errorMessage").style.display = "none";
            }
            else
            {
                document.getElementById("errorMessage").style.display = "block";
            }
        }
    }

    function checkData(row)
    {
        var isErrorFree = true;
        if(document.getElementById("incomeSelect" + row).value == "")
        {
            isErrorFree = false;
        }
        if(document.getElementById("incomeSelect" + row).value == "add_income")
        {
            isErrorFree = false;
        }
        if(document.getElementById("amount" + row).value == 0)
        {
            isErrorFree = false;
        }
        return isErrorFree;
    }

    function checkNumbers()
    {
        var rowCount = $("#daybookTable>tbody>tr").length;
        console.log(rowCount);
        if(rowCount > 0)
        {
            document.getElementById("saveButton").style.display = "block";
        }
        else
        {
            document.getElementById("saveButton").style.display = "none";
        }
    }

    function removeCol(row) {

        document.getElementById("row"+row).remove();
        checkNumbers();
        rows = rows.filter(function(e) { return e !== row});
        getPrice();
    }
    // add new row

    function addnewrow()
    {

        console.log("Clicked add button");

        var newRow = document.createElement("tr");
        newRow.setAttribute("id", "row" + count);

        var newHidden = document.createElement("input");
        newHidden.setAttribute("type","hidden");
        newHidden.setAttribute("id","job_" + count);
        newHidden.setAttribute("name","job[]");
        newRow.appendChild(newHidden);

        var newHidden1 = document.createElement("input");
        newHidden1.setAttribute("type","hidden");
        newHidden1.setAttribute("id","staff_" + count);
        newHidden1.setAttribute("name","staff[]");
        newRow.appendChild(newHidden1);

        //Column1
        var newColumn1 = document.createElement("td");
        var newIncomeSelect = document.createElement("select");
        newIncomeSelect.setAttribute("class","select2 incomes");
        newIncomeSelect.setAttribute("style","width: 100%");
        newIncomeSelect.setAttribute("id","incomeSelect" + count);
        newIncomeSelect.setAttribute("name","income_id[]");
        newIncomeSelect.setAttribute("required","required");
        newIncomeSelect.setAttribute("onchange","incomeSelected(this.value,"+count+")");

        $.ajax({
            type : "get",
            url : "{{ route('get_income') }}",
            dataType : "json",
            success : function(response)
            {
                console.log(response);
                var newOption1 = document.createElement("option");
                newOption1.setAttribute("value","");
                newOption1.innerHTML = "Select Income";
                newIncomeSelect.appendChild(newOption1);
                var newOption2 = document.createElement("option");
                newOption2.setAttribute("value","add_income");
                newOption2.innerHTML = "Add New Income";
                newIncomeSelect.appendChild(newOption2);

                for(var i = 0; i < response.length; i++)
                {
                    var newDynamicOption = document.createElement("option");
                    newDynamicOption.setAttribute("value",response[i].id);
                    newDynamicOption.innerHTML = response[i].income_name;
                    newIncomeSelect.appendChild(newDynamicOption);
                    console.log("Added option");
                }
            }
        });
        newColumn1.appendChild(newIncomeSelect);

        //Column 2
        var newColumn2 = document.createElement("td");
        var newDescription = document.createElement("input");
        newDescription.setAttribute("class","form-control");
        newDescription.setAttribute("type","text");
        newDescription.setAttribute("value","");
        newDescription.setAttribute("id","description" + count);
        newDescription.setAttribute("name","description[]");
        newDescription.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
        newColumn2.appendChild(newDescription);

        //Column 3
        var newColumn3 = document.createElement("td");
        var newAmount = document.createElement("input");
        newAmount.setAttribute("class","form-control cAmount");
        newAmount.setAttribute("type","number");
        newAmount.setAttribute("value","0");
        newAmount.setAttribute("step","0.01");
        newAmount.setAttribute("onkeyup","getPrice(" + count + ")");
        newAmount.setAttribute("onchange","getPrice(" + count + ")");
        newAmount.setAttribute("id","amount" + count);
        newAmount.setAttribute("name","amount[]");
        newAmount.setAttribute("min","1");
        newAmount.setAttribute("required","required");
        newColumn3.appendChild(newAmount);

        //Column 4
        var newColumn4 = document.createElement("td");
        var accountsSel = document.createElement("select");
        accountsSel.setAttribute("class","form-control select2");
        accountsSel.setAttribute("id","acc" + count);
        accountsSel.setAttribute("name","accounts[]");
        accountsSel.setAttribute("onchange","changeAccounts(this.value," + count +")");
        accountsSel.setAttribute("style","width: 100%");

        var newAccOption2 = document.createElement("option");
        newAccOption2.setAttribute("value","CASH");
        newAccOption2.setAttribute("selected","");
        newAccOption2.innerHTML = "CASH";
        var newAccOption4 = document.createElement("option");
        newAccOption4.setAttribute("value","ACCOUNT");
        newAccOption4.innerHTML = "ACCOUNT";
        accountsSel.appendChild(newAccOption2);
        accountsSel.appendChild(newAccOption4);
        newColumn4.appendChild(accountsSel);

        //Column 5
        var newColumn5 = document.createElement("td");
        var removeBtn = document.createElement("button");
        removeBtn.setAttribute("type","button");
        removeBtn.setAttribute("class","btn btn-danger");
        removeBtn.setAttribute("id","bt_remove" + count);
        removeBtn.setAttribute("onclick","removeCol(" + count +")");
        removeBtn.innerHTML='Delete';
        newColumn5.appendChild(removeBtn);


        var tableBody = document.getElementById("tBody");
        newRow.appendChild(newColumn1);
        newRow.appendChild(newColumn2);
        newRow.appendChild(newColumn3);
        newRow.appendChild(newColumn4);
        newRow.appendChild(newColumn5);
        tableBody.appendChild(newRow);

        $("#incomeSelect" + count).select2();
        $("#acc" + count).select2();
        rows.push(count);
        console.log(rows);
        count++;
        checkNumbers();
    }

        // add income type modal invoke
        function incomeSelected(expenseValue, row)
        {
            rowNumber = row;
            if(expenseValue == "add_income")
            {
                $("#amount"+rowNumber).removeAttr("readonly");
                $("#add_income_modal").modal("toggle");
                $("#add_income_modal").modal("show");
            }
            else
            {
                $("#amount"+rowNumber).removeAttr("readonly");
            }

        }

        // add expense to database
        function resetFields()
        {
            $("#income_name").val('');

        }

        function registerIncome()
        {
            var income_name = $("#income_name").val();
            console.log(income_name);


            if(income_name == '')
            {
                document.getElementById("income_nameError").style.display="block";
            }
            else
            {
                document.getElementById("income_nameError").style.display="none";
                $.ajaxSetup({
	    			headers : {
	    				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	    			}
	    		});
                $.ajax({
                    type : "post",
                    url : "{{ route('income.store') }}",
                    dataType : "JSON",
                    data : {income_name : income_name },
                    success : function(response)
                    {
                        console.log(response);
                        if(response != "Error")
                        {
                            var newOption = "<option value='" + response.id + "' >" + response.income_name + "</option>";
                            $(".incomes").append(newOption);
                            $("#add_income_modal").modal("toggle");
                            resetFields();
                        }
                    }
                });
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
                                    <h4 class="mb-sm-0 font-size-18">Add Income</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <form method="POST" action="{{ route('daybook.store') }}" id="daybookForm">
                                            <input type="hidden" name="type" value="Income">
                                            @csrf
                                            <div class="row">

                                                <div class="col-xl col-sm-6">
                                                    <div class="form-group mt-3 mb-0">
                                                        <label>Date</label>
                                                        <input type="date" name="date" class="form-control" value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}" onchange="getOpeningBalance(this.value)" onkeyup="getOpeningBalance(this.value)" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl col-sm-6 align-self-end">
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cash_transfer_modal">Cash Transfer</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-4">
                                                <table class="table" style="width: 100%">
                                                    <tr>
                                                        <th colspan="3" style="text-align: center">Opening Balance</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Cash</th>
                                                        <th>Account</th>
                                                    </tr>
                                                    <tr>
                                                        <th id="cashOB"></th>
                                                        <th id="accountOB"></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table mb-0" id="daybookTable">
                                                    <colgroup>
                                                        <col span="1" style="width: 30%">
                                                        <col span="1" style="width: 25%">
                                                        <col span="1" style="width: 20%">
                                                        <col span="1" style="width: 15%">
                                                        <col span="1" style="width: 10%">
                                                    </colgroup>
                                                    <thead>
                                                        <tr>
                                                            <th>Income</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Acc / Cash</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tBody">

                                                    </tbody>
                                                </table>
                                                <p class="text-danger" id="errorMessage" style="display: none">Please check the data before saving!</p>
                                            </div>
                                            <div class="row">
                                                <div class="mt-3 col-md-2">
                                                    <button type="button" id="addrow" class="btn btn-primary w-md" onclick="addNewRows()">Add Income</button>
                                                </div>
                                                <div class="mt-3 col-md-2">
                                                    <button type="button" class="btn btn-success w-md" onclick="checkInputs()" id="saveButton" style="display:none;">Save</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-4">
                                                <table class="table" style="width: 100%">
                                                    <tr>
                                                        <th colspan="3" style="text-align: center">Closing Balance</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Cash</th>
                                                        <th>Account</th>
                                                    </tr>
                                                    <tr>
                                                        <th id="cashCBTD"></th>
                                                        <th id="accountCBTD"></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <input type="hidden" value="0" name="bankCB" id="bankCB">
                                            <input type="hidden" value="0" name="cashCB" id="cashCB">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @include('daybook.modal.add_income-modal')
                @include('daybook.modal.cash_transfer-modal')


@endsection
