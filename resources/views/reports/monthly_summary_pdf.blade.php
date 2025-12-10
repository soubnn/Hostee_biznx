<!DOCTYPE html>
<html>

<head>
    <title>Monthly Summary - Hostee the Planner</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-25 {
        margin-top: 25px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 45px;
        height: 45px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }

    .page-break {
        page-break-after: always;
    }

    .footer {
        position: fixed;
        bottom: 0px;
    }
</style>

<body>
    <div class="head-title">
        <h2 class="text-center m-0 p-0">HOSTEE THE PLANNER</h2>
        {{-- <h5 class="text-center m-0 p-0">GSTIN : 32ADNPO8730B1ZO</h5> --}}
        <h5 class="text-center m-0 p-0">NEAR LANSOR CONSEPTS, CHERUSSOLA ROAD, SWAGATHAMAD</h5>
        <h1 class="text-center m-0 p-0 mt-10">Monthly Summary - {{ $search_date }}</h1>
    </div>
    <div class="head-title">
        <h2 class="mt-25 p-0">Income</h2>
    </div>
    <div class="table-section bill-tbl w-100">
        <p class="m-0 pt-5 text-bold w-100">Invoice Amount By Sale(Generated in
            {{ Carbon\carbon::parse($search_date)->format('F') }}) : <span
                class="gray-color">{{ $total_sales_amount }}</span></p>
        {{-- <p class="m-0 pt-5 text-bold w-100">Invoice Amount By Jobcard(Generated in
            {{ Carbon\carbon::parse($search_date)->format('F') }}) : <span
                class="gray-color">{{ $total_job_amount }}</span></p> --}}
        <p class="m-0 pt-5 text-bold w-100">Total Amount(Generated in
            {{ Carbon\carbon::parse($search_date)->format('F') }}) : <span
                class="gray-color">{{ $total_sales_amount + $total_job_amount }}</span></p>
        <br>
        <p class="m-0 pt-5 text-bold w-100">Total Income(Recieved in
            {{ Carbon\carbon::parse($search_date)->format('F') }}) : <span class="gray-color">{{ $total_income }}</span>
        </p>
    </div>

    <div class="head-title">
        <h2 class="mt-25 p-0">Expense</h2>
    </div>
    <div class="table-section bill-tbl w-100">
        <p class="m-0 pt-5 text-bold w-100">Total Expense : <span
                class="gray-color">{{ round($total_expense, 2) }}</span></p>
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th class="w-50">Category</th>
                    <th class="w-50">Amount</th>
                    <th class="w-50">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align:center">
                    {{-- <td>Bank Deposit</td> --}}
                    {{-- <td>{{ $total_bank_deposit }}</td> --}}
                    @php
                        $current_expense_total = $total_expense;
                    @endphp
                    {{-- <td>{{ $current_expense_total - $total_bank_deposit }}</td> --}}
                    @php
                        $current_expense_total = $current_expense_total - $total_bank_deposit;
                    @endphp
                </tr>
                <tr style="text-align:center">
                    <td>To Sellers</td>
                    <td>{{ $total_amount_to_sellers }}</td>
                    <td>{{ $current_expense_total - $total_amount_to_sellers }}</td>
                    @php
                        $current_expense_total = $current_expense_total - $total_amount_to_sellers;
                    @endphp
                </tr>
                <tr style="text-align:center">
                    <td>To Salary</td>
                    <td>{{ $total_amount_to_salary }}</td>
                    <td>{{ $current_expense_total - $total_amount_to_salary }}</td>
                    @php
                        $current_expense_total = $current_expense_total - $total_amount_to_salary;
                    @endphp
                </tr>
                <tr style="text-align:center">
                    <td>To Incentives</td>
                    <td>{{ $total_amount_to_incentive }}</td>
                    <td>{{ $current_expense_total - $total_amount_to_incentive }}</td>
                    @php
                        $current_expense_total = $current_expense_total - $total_amount_to_incentive;
                    @endphp
                </tr>
                <tr style="text-align:center">
                    <th>Total</th>
                    <th>{{ round($total_of_top_expense, 2) }}</th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h4 class="mt-25">Profit Summary</h4>
    </div>
    <div class="table-section bill-tbl w-100">
        <table class="table w-50">
            <tr>
                <th></th>
                <th>Total</th>
            </tr>
            <tr>
                <th style="text-align: left">Total Income Against Invoice</th>
                <td>{{ $total_bill_amount }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Income Against Product</th>
                <td>{{ $total_rate_of_item }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Income/Profit Against Service</th>
                <td>{{ $total_service_charge }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Expense Against Product</th>
                <td>{{ $total_purchase_amount }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Profit Against Product</th>
                <td>{{ $total_profit_amount }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Profit</th>
                <th style="text-align: left">{{ $total_amount_to_techsoul }}</th>
            </tr>
        </table>
    </div>
    <div class="footer">
        @php
            $printed_by = Auth::user()->name;
            $printed_on = Carbon\carbon::now();
        @endphp
        <p style="font-size:10px;">generated by {{ $printed_by }} on {{ $printed_on }}</p>
    </div>
</body>

</html>
