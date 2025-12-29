<!DOCTYPE html>
<html>
<head>
    <title>Income Expense Report - Hostee the Planner</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .mt-25{
        margin-top:25px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
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
    <h5 class="text-center m-0 p-0">NEAR LANCOR CONCEPTS, CHERUSHOLA ROAD, SWAGATHAMAD</h5>
    <h1 class="text-center m-0 p-0">Income - Expense Report</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">From : <span class="gray-color">{{ $startDate }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To : <span class="gray-color">{{ $endDate }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Total Income : <span class="gray-color">{{ round($totalIncomeInPeriod,2) }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Total Expense : <span class="gray-color">{{ round($totalExpenseInPeriod,2) }}</span></p>
        <!--<p class="m-0 pt-5 text-bold w-100">Balance : <span class="gray-color">{{ round($balanceAmountInPeriod,2) }}</span></p>-->
    </div>
    <div style="clear: both;"></div>
</div>
<div class="head-title">
    <h2 class="mt-25 p-0">Income</h2>
</div>
<div class="table-section bill-tbl w-100">
    <table class="table w-100">
        <thead>
            <tr>
                <th class="w-50">Category</th>
                <th class="w-50">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomeTypeDetails as $incomeType)
                <tr style="text-align:center">
                    <td>{{ $incomeType['name'] }}</td>
                    <td>{{ round($incomeType['amount'],2) }}</td>
                </tr>
            @endforeach
            <tr style="text-align:center">
                <th>Grand Total</th>
                <th>{{ round($totalIncomeInPeriod,2) }}</th>
            </tr>
        </tbody>
    </table>
</div>
<div class="head-title">
    <h2 class="mt-10 p-0">Expense</h2>
</div>
<div class="table-section bill-tbl w-100">
    <table class="table w-100">
        <thead>
            <tr>
                <th class="w-50">Category</th>
                <th class="w-50">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenseTypeDetails as $expenseType)
                <tr style="text-align:center">
                    <td>{{ $expenseType['name'] }}</td>
                    <td>{{ round($expenseType['amount'],2) }}</td>
                </tr>
            @endforeach
            <tr style="text-align:center">
                <th>Grand Total</th>
                <th>{{ round($totalExpenseInPeriod,2) }}</th>
            </tr>
        </tbody>
    </table>
</div>
<div class="head-title">
    <h2 class="mt-10 p-0">Transfer</h2>
</div>
<div class="table-section bill-tbl w-100">
    <table class="table w-100">
        <thead>
            <tr>
                <th class="w-50">Category</th>
                <th class="w-50">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transferTypeDetails as $transferType)
                <tr style="text-align:center">
                    <td>{{ $transferType['name'] }}</td>
                    <td>{{ round($transferType['amount'],2) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
<!--<div class="page-break"></div>-->
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <thead>
            <tr>
                <th class="w-50">Date</th>
                <th class="w-50">Particular</th>
                <th class="w-50">Description</th>
                <th class="w-50">Debit</th>
                <th class="w-50">Credit</th>
                <th class="w-50">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center">
                <th colspan="5" style="text-align:right">Opening Balance</th>
                <th>{{ round($openingBalance,2) }}</th>
            </tr>
            @foreach ($tableData as $data)
                <tr style="text-align:center">
                    <td>{{ carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['description'] }}</td>
                    <td>{{ round(floatval($data['debit']), 2) }}</td>
                    <td>{{ round(floatval($data['credit']), 2) }}</td>
                    <td>{{ round(floatval($data['balance']), 2) }}</td>
                </tr>
            @endforeach
            <tr style="text-align:center">
                <th colspan="5" style="text-align:right">Closing Balance</th>
                <th>{{ round($balance,2) }}</th>
            </tr>
        </tbody>
    </table>
    @php
        $printed_by = Auth::user()->name;
        $printed_on = Carbon\carbon::now();
    @endphp
    <div class="footer">
        <p style="font-size:10px;">generated by {{ $printed_by }} on {{ $printed_on }}</p>
    </div>
</div>
</html>
