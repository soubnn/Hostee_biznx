<!DOCTYPE html>
<html>

<head>
    <title>Individual Customer Report - Hostee the Planner</title>
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
        /* border-collapse:collapse;
        padding:7px 8px; */
    }

    table tr th {
        background: #F4F4F4;
        font-size: 14px;
    }

    table tr td {
        font-size: 12px;
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
</style>

<body>
    <div class="head-title">
        <h2 class="text-center m-0 p-0">HOSTEE THE PLANNER</h2>
        <h5 class="text-center m-0 p-0">GSTIN : 32ADNPO8730B1ZO</h5>
        <h5 class="text-center m-0 p-0">NEAR LANSOR CONSEPTS, CHERUSSOLA ROAD, SWAGATHAMAD</h5>
        <h4 class="text-center mt-10 p-0">CUSTOMER SALES REPORT</h4>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Customer Name : <span
                    class="gray-color">{{ strtoupper($customerDetails->name) }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Total Sale Amount : <span class="gray-color">RS.
                    {{ $totalPurchaseAmount }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Balance : <span class="gray-color">RS. {{ $balanceAmount }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">From : <span
                    class="gray-color">{{ $startDate }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To : <span
                    class="gray-color">{{ $endDate }}</span></p>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th class="w-50">Date</th>
                    <th class="w-50">Invoice No</th>
                    <th class="w-50">Debit</th>
                    <th class="w-50">Credit</th>
                    <th class="w-50">Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align:center">
                    <th colspan="4" style="text-align:right">Opening Balance</th>
                    <th>{{ round($openingBalance, 2) }}</th>
                </tr>
                @foreach ($combinedData as $data)
                    <tr style="text-align: center; @if ($data['invoiceNumber'] == 'INCOME') color: green @endif">
                        <td>{{ Carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                        <td>{{ $data['invoiceNumber'] }}</td>
                        <td>{{ $data['debit'] }}</td>
                        <td>{{ $data['credit'] }}</td>
                        <td>{{ $data['balance'] }}</td>
                    </tr>
                @endforeach
                <tr style="text-align:center">
                    <th colspan="2" style="text-align:right">Balance</th>
                    <th>{{ round($totalDebit, 2) }}</th>
                    <th>{{ round($totalCredit, 2) }}</th>
                    <th>{{ round($balanceAmount, 2) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
