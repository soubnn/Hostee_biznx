@extends('layouts.layout')
@section('content')

<script type="text/javascript">

    let exp_count = 1;
    let inc_count = 1;
    let row_count = 0;

    var cashBalance = 0;
    var ledgerBalance = 0;
    var accountBalance = 0;

    //opening and closing balance functions

    $(document).ready(function()
    {
        let today = new Date();
        let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        getOpeningBalance(date);

    });
    function getOpeningBalance(todayDate)
    {
        $.ajax({
            type : "get",
            url : "{{ route('getPrevOpeningBalance') }}",
            data : { date : todayDate},
            success : function (res)
            {
                console.log(res);
                $("#cashOB").html(res.cash_balance);
                $("#cashCBTD").html(res.cash_balance);
                $("#cashCB").val(res.cash_balance);
                cashBalance = res.cash_balance;
                $("#ledgerOB").html(res.ledger_balance);
                $("#ledgerCBTD").html(res.ledger_balance);
                $("#ledgerCB").val(res.ledger_balance);
                ledgerBalance = res.ledger_balance;
                $("#accountOB").html(res.account_balance);
                $("#accountCBTD").html(res.account_balance);
                $("#bankCB").val(res.account_balance);
                accountBalance = res.account_balance;
           }
        });
    }
    function getBalance()
    {
        let cExpTotal = 0;
        let lExpTotal = 0;
        let bExpTotal = 0;

        let cIncTotal = 0;
        let lIncTotal = 0;
        let bIncTotal = 0;

        $(".cExpenseAmount").each(function(){
            cExpTotal +=parseFloat($(this).val() || 0);
        });
        $(".lExpenseAmount").each(function(){
            lExpTotal +=parseFloat($(this).val() || 0);
        });
        $(".bExpenseAmount").each(function(){
            bExpTotal +=parseFloat($(this).val() || 0);
        });

        $(".cIncomeAmount").each(function(){
            cIncTotal +=parseFloat($(this).val() || 0);
        });
        $(".lIncomeAmount").each(function(){
            lIncTotal +=parseFloat($(this).val() || 0);
        });
        $(".bIncomeAmount").each(function(){
            bIncTotal +=parseFloat($(this).val() || 0);
        });

        let cBalance = parseFloat(cashBalance) - cExpTotal + cIncTotal;
        let lBalance = parseFloat(ledgerBalance) - lExpTotal + lIncTotal;
        let bBalance = parseFloat(accountBalance) - bExpTotal + bIncTotal;

        $("#cashCBTD").html(cBalance.toFixed(2));
        $("#cashCB").val(cBalance.toFixed(2));
        $("#accountCBTD").html(bBalance.toFixed(2));
        $("#bankCB").val(bBalance.toFixed(2));
        $("#ledgerCBTD").html(lBalance.toFixed(2));
        $("#ledgerCB").val(lBalance.toFixed(2));
    }

    function changeExpenseAccounts(type,row)
    {
        if(document.getElementById("expense_amount" + row).classList.contains("cExpenseAmount"))
        {
            if(type == "LEDGER")
            {
                document.getElementById("expense_amount" + row).classList.replace("cExpenseAmount","lExpenseAmount");
            }
            if(type == "ACCOUNT")
            {
                document.getElementById("expense_amount" + row).classList.replace("cExpenseAmount","bExpenseAmount");
            }
        }
        else if(document.getElementById("expense_amount" + row).classList.contains("lExpenseAmount"))
        {
            if(type == "CASH")
            {
                document.getElementById("expense_amount" + row).classList.replace("lExpenseAmount","cExpenseAmount");
            }
            if(type == "ACCOUNT")
            {
                document.getElementById("expense_amount" + row).classList.replace("lExpenseAmount","bExpenseAmount");
            }
        }
        else if(document.getElementById("expense_amount" + row).classList.contains("bExpenseAmount"))
        {
            if(type == "CASH")
            {
                document.getElementById("expense_amount" + row).classList.replace("bExpenseAmount","cExpenseAmount");
            }
            if(type == "LEDGER")
            {
                document.getElementById("expense_amount" + row).classList.replace("bExpenseAmount","lExpenseAmount");
            }
        }
        getBalance();
    }
    function changeIncomeAccounts(type,row)
    {
        if(document.getElementById("income_amount" + row).classList.contains("cIncomeAmount"))
        {
            if(type == "LEDGER")
            {
                document.getElementById("income_amount" + row).classList.replace("cIncomeAmount","lIncomeAmount");
            }
            if(type == "ACCOUNT")
            {
                document.getElementById("income_amount" + row).classList.replace("cIncomeAmount","bIncomeAmount");
            }
        }
        else if(document.getElementById("income_amount" + row).classList.contains("lIncomeAmount"))
        {
            if(type == "CASH")
            {
                document.getElementById("income_amount" + row).classList.replace("lIncomeAmount","cIncomeAmount");
            }
            if(type == "ACCOUNT")
            {
                document.getElementById("income_amount" + row).classList.replace("lIncomeAmount","bIncomeAmount");
            }
        }
        else if(document.getElementById("income_amount" + row).classList.contains("bIncomeAmount"))
        {
            if(type == "CASH")
            {
                document.getElementById("income_amount" + row).classList.replace("bIncomeAmount","cIncomeAmount");
            }
            if(type == "LEDGER")
            {
                document.getElementById("income_amount" + row).classList.replace("bIncomeAmount","lIncomeAmount");
            }
        }
        getBalance();
    }
    //expense functions

    function removeExpenseCol(row) {

        document.getElementById("row"+row).remove();

        row_count = row_count - 1;
        if(row_count > 0)
        {
            document.getElementById('saveButton').disabled = false;
        }
        else
        {
            document.getElementById('saveButton').disabled = true;
        }

        getBalance();
    }

    // add new row
    function addExpenseRow(){
        // if(exp_count > 1){
        //     let prev_expense = document.getElementById('expense'+(exp_count-1)).value;
        //     let prev_expense_amount = document.getElementById('expense_amount'+(exp_count-1)).value;
        //     if(prev_expense == '' && prev_expense_amount == ''){
        //         document.getElementById('expErrorMessage').style.display = 'block';
        //     }
        //     else{
        //         document.getElementById('expErrorMessage').style.display = 'none';
        //         add_expenserow();
        //     }
        // }
        // else{
        //     document.getElementById('expErrorMessage').style.display = 'none';
        //     add_expenserow();
        // }
        add_expenserow();

    }
    function add_expenserow()
    {
        var newRow = document.createElement("tr");
        newRow.setAttribute("id", "row" + exp_count);

        //Column 1
        var newColumn1 = document.createElement("td");
        var newExpense = document.createElement("input");
        newExpense.setAttribute("class","form-control");
        newExpense.setAttribute("type","text");
        newExpense.setAttribute("value","");
        newExpense.setAttribute("id","expense" + exp_count);
        newExpense.setAttribute("name","expense[]");
        newExpense.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
        newColumn1.appendChild(newExpense);

        //Column 2
        var newColumn2 = document.createElement("td");
        var newAmount = document.createElement("input");
        newAmount.setAttribute("class","form-control cExpenseAmount");
        newAmount.setAttribute("type","number");
        newAmount.setAttribute("value","0");
        newAmount.setAttribute("step","0.01");
        newAmount.setAttribute("onkeyup","getBalance()");
        newAmount.setAttribute("onchange","getBalance()");
        newAmount.setAttribute("id","expense_amount" + exp_count);
        newAmount.setAttribute("name","expense_amount[]");
        newAmount.setAttribute("min","1");
        newAmount.setAttribute("required","required");
        newColumn2.appendChild(newAmount);

        //Column 3
        var newColumn3 = document.createElement("td");
        var accountsSel = document.createElement("select");
        accountsSel.setAttribute("class","form-control select2");
        accountsSel.setAttribute("id","exp_acc" + exp_count);
        accountsSel.setAttribute("name","expense_accounts[]");
        accountsSel.setAttribute("onchange","changeExpenseAccounts(this.value," + exp_count +")");
        accountsSel.setAttribute("style","width: 100%");

        var newAccOption2 = document.createElement("option");
        newAccOption2.setAttribute("value","CASH");
        newAccOption2.setAttribute("selected","");
        newAccOption2.innerHTML = "CASH";
        var newAccOption3 = document.createElement("option");
        newAccOption3.setAttribute("value","LEDGER");
        newAccOption3.innerHTML = "LEDGER";
        var newAccOption4 = document.createElement("option");
        newAccOption4.setAttribute("value","ACCOUNT");
        newAccOption4.innerHTML = "ACCOUNT";
        accountsSel.appendChild(newAccOption2);
        accountsSel.appendChild(newAccOption4);
        accountsSel.appendChild(newAccOption3);
        newColumn3.appendChild(accountsSel);

        //Column 4
        var newColumn4 = document.createElement("td");
        var removeBtn = document.createElement("button");
        removeBtn.setAttribute("type","button");
        removeBtn.setAttribute("class","btn btn-danger");
        removeBtn.setAttribute("id","bt_remove" + exp_count);
        removeBtn.setAttribute("onclick","removeExpenseCol(" + exp_count +")");
        let delete_icon = document.createElement('i');
        delete_icon.setAttribute('class', 'bx bx-trash');
        removeBtn.appendChild(delete_icon);
        newColumn4.appendChild(removeBtn);

        var tableBody = document.getElementById("tBodyExpense");
        newRow.appendChild(newColumn1);
        newRow.appendChild(newColumn2);
        newRow.appendChild(newColumn3);
        newRow.appendChild(newColumn4);
        tableBody.appendChild(newRow);

        document.getElementById('saveButton').disabled = false;
        $("#exp_acc" + exp_count).select2();
        exp_count++;
        row_count++;
    }


    //income functions

    function removeIncomeCol(row) {
        document.getElementById("row"+row).remove();

        row_count = row_count - 1;
        if(row_count > 0)
        {
            document.getElementById('saveButton').disabled = false;
        }
        else
        {
            document.getElementById('saveButton').disabled = true;
        }

        getBalance();
    }

    // add new row

    function add_incomerow(){

        var newRow = document.createElement("tr");
        newRow.setAttribute("id", "row" + inc_count);

        //Column 1
        var newColumn1 = document.createElement("td");
        var newIncome = document.createElement("input");
        newIncome.setAttribute("class","form-control");
        newIncome.setAttribute("type","text");
        newIncome.setAttribute("value","");
        newIncome.setAttribute("id","income" + inc_count);
        newIncome.setAttribute("name","income[]");
        newIncome.setAttribute("onkeyup","this.value = this.value.toUpperCase()");
        newColumn1.appendChild(newIncome);

        //Column 2
        var newColumn2 = document.createElement("td");
        var newAmount = document.createElement("input");
        newAmount.setAttribute("class","form-control cIncomeAmount");
        newAmount.setAttribute("type","number");
        newAmount.setAttribute("value","0");
        newAmount.setAttribute("step","0.01");
        newAmount.setAttribute("onkeyup","getBalance()");
        newAmount.setAttribute("onchange","getBalance()");
        newAmount.setAttribute("id","income_amount" + inc_count);
        newAmount.setAttribute("name","income_amount[]");
        newAmount.setAttribute("min","1");
        newAmount.setAttribute("required","required");
        newColumn2.appendChild(newAmount);

        //Column 3
        var newColumn3 = document.createElement("td");
        var accountsSel = document.createElement("select");
        accountsSel.setAttribute("class","form-control select2");
        accountsSel.setAttribute("id","inc_acc" + inc_count);
        accountsSel.setAttribute("name","income_accounts[]");
        accountsSel.setAttribute("onchange","changeIncomeAccounts(this.value," + inc_count +")");
        accountsSel.setAttribute("style","width: 100%");

        var newAccOption2 = document.createElement("option");
        newAccOption2.setAttribute("value","CASH");
        newAccOption2.setAttribute("selected","");
        newAccOption2.innerHTML = "CASH";
        var newAccOption3 = document.createElement("option");
        newAccOption3.setAttribute("value","LEDGER");
        newAccOption3.innerHTML = "LEDGER";
        var newAccOption4 = document.createElement("option");
        newAccOption4.setAttribute("value","ACCOUNT");
        newAccOption4.innerHTML = "ACCOUNT";
        accountsSel.appendChild(newAccOption2);
        accountsSel.appendChild(newAccOption4);
        accountsSel.appendChild(newAccOption3);
        newColumn3.appendChild(accountsSel);

        //Column 4
        var newColumn4 = document.createElement("td");
        var removeBtn = document.createElement("button");
        removeBtn.setAttribute("type","button");
        removeBtn.setAttribute("class","btn btn-danger");
        removeBtn.setAttribute("id","bt_remove" + inc_count);
        removeBtn.setAttribute("onclick","removeIncomeCol(" + inc_count +")");
        let delete_icon = document.createElement('i');
        delete_icon.setAttribute('class', 'bx bx-trash');
        removeBtn.appendChild(delete_icon);
        newColumn4.appendChild(removeBtn);


        var tableBody = document.getElementById("tBodyIncome");
        newRow.appendChild(newColumn1);
        newRow.appendChild(newColumn2);
        newRow.appendChild(newColumn3);
        newRow.appendChild(newColumn4);
        tableBody.appendChild(newRow);

        document.getElementById('saveButton').disabled = false;
        $("#inc_acc" + inc_count).select2();
        inc_count++;
        row_count++;
    }

    //form submit and check inputs
    function checkInputs()
    {
        document.getElementById("saveButton").disabled = true;
        document.getElementById("saveButton").innerHTML = "Saving";
        document.getElementById("prevDaybookForm").submit();
    }
</script>

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Add Accounts</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <form method="POST" action="{{ route('daybook_prev.store') }}" id="prevDaybookForm">
                                            @csrf
                                            <div class="row">

                                                <div class="col-xl col-sm-6">
                                                    <div class="form-group mt-3 mb-0">
                                                        <label>Date</label>
                                                        <input type="date" name="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d')}}" onchange="getOpeningBalance(this.value)" onkeyup="getOpeningBalance(this.value)">
                                                    </div>
                                                </div>
                                                <div class="col-xl col-sm-6 align-self-end">
                                                    <div class="mt-3">
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
                                                        <th>Ledger</th>
                                                    </tr>
                                                    <tr>
                                                        <th id="cashOB"></th>
                                                        <th id="accountOB"></th>
                                                        <th id="ledgerOB"></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="card-title mt-5">Add Income</h5>
                                                    <div class="table-responsive mt-4">
                                                        <table class="table mb-3" id="daybookTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Income</th>
                                                                    <th>Amount</th>
                                                                    <th>Type</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tBodyIncome">

                                                            </tbody>
                                                        </table>
                                                        <p class="text-danger" id="errorMessage" style="display: none">Please check the data before saving!</p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mt-3 col-md-2">
                                                            <button type="button" id="addrow" class="btn btn-primary w-md" onclick="add_incomerow()">Add Income</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h5 class="card-title mt-5">Add Expense</h5>
                                                    <div class="table-responsive mt-4">
                                                        <table class="table mb-3" id="daybookTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Expense</th>
                                                                    <th>Amount</th>
                                                                    <th>Type</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tBodyExpense">

                                                            </tbody>
                                                        </table>
                                                        <p class="text-danger" id="expErrorMessage" style="display: none">Please check the data before saving!</p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mt-3 col-md-2">
                                                            <button type="button" id="addrow" class="btn btn-primary w-md" onclick="addExpenseRow()">Add Expense</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mt-5">
                                                    <button type="button" class="btn btn-success w-md mt-5" onclick="checkInputs()" id="saveButton" disabled>Save Accounts</button>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <table class="table" style="width: 100%">
                                                        <tr>
                                                            <th colspan="3" style="text-align: center">Closing Balance</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Cash</th>
                                                            <th>Account</th>
                                                            <th>Ledger</th>
                                                        </tr>
                                                        <tr>
                                                            <th id="cashCBTD"></th>
                                                            <th id="accountCBTD"></th>
                                                            <th id="ledgerCBTD"></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <input type="hidden" value="0" name="ledgerCB" id="ledgerCB">
                                                <input type="hidden" value="0" name="bankCB" id="bankCB">
                                                <input type="hidden" value="0" name="cashCB" id="cashCB">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
