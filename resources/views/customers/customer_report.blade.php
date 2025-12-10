<!DOCTYPE html>
<html>

<head>
    <title>Individual Customer Report - Hostee the Planner</title>
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 100%;
            padding: 0;
            position: relative;
        }

        .brand-header {
            text-align: right;
            padding: 15px 20px 10px 20px;
            border: 1px solid #000;
            border-bottom: none
        }

        .info-section {
            border-bottom: 1px solid #000;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 13px;
        }

        .info-section .label {
            width: 123px;
            font-weight: normal;
        }

        .info-section .value {
            font-weight: bold;
        }

        .table-header table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header td {
            border: 1px solid #000;
            border-bottom: none;
            border-top: none;
            padding: 5px;
            font-size: 13px;
            font-weight: normal;
        }

        .table-header .label {
            width: 123px;
            font-weight: bold;
        }

        .table-header .main-header {
            font-weight: bold;
            text-align: left;
        }

        .data-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-section td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
        }

        .data-section .date-col {
            width: 123px;
            text-align: right;
        }

        .data-section .desc-col {
            text-align: left;
        }

        .data-section .amount-col {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Brand Header -->
        <div class="brand-header">
            <img src="{{ public_path('assets/images/invoice/logo.png') }}" style="width: 170px; margin: auto;">
        </div>

        <!-- Customer Info Section -->
        <div class="info-section">
            <table>
                <tr>
                    <td class="label">Customer Name</td>
                    <td class="value" colspan="3">{{ strtoupper($customerDetails->name) }}</td>
                </tr>
                <tr>
                    <td class="label">A/C Opening Date</td>
                    <td class="value" style="font-weight: normal;" colspan="3">{{ $startDate }}</td>
                </tr>
                <tr>
                    <td class="label">Total Sales</td>
                    <td class="value" colspan="3">{{ $totalPurchaseAmount }}</td>
                </tr>
                <tr>
                    <td class="label">Total Income</td>
                    <td class="value" colspan="3">{{ $totalCredit }}</td>
                </tr>
                <tr>
                    <td class="label">Balance</td>
                    <td class="value" colspan="3">{{ $balanceAmount }}</td>
                </tr>
                <tr>
                    <td class="label">Ledger From To</td>
                    <td class="value" style="font-weight: normal;" colspan="3">{{ $startDate }} - {{ $endDate }}</td>
                </tr>
                <tr>
                    <td class="label" rowspan="2"></td>
                    <td class="value" rowspan="2" style="font-weight: normal;" colspan="3"></td>
                </tr>
            </table>
        </div>

        <!-- Table Header -->
        <div class="table-header">
            <table>
                <tr>
                    <td class="label" >Date</td>
                    <td class="main-header" colspan="3">Invoice Number and Description</td>
                    <td class="main-header" style="width: 12%">Debit</td>
                    <td class="main-header" style="width: 12%">Credit</td>
                    <td class="main-header" style="width: 10%">Balance</td>
                </tr>
            </table>
        </div>

        <!-- Data Section -->
        <div class="data-section">
            <table>
                <tr>
                    <td class="label" style="text-align: right; font-weight: bolder" colspan="6">Opening Balance</td>
                    <td class="value" style="font-weight: bolder; text-align: right">{{ round($openingBalance, 2) }}</td>
                </tr>
                @foreach ($combinedData as $data)
                    <tr>
                        <td class="date-col">{{ Carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                        <td class="desc-col" colspan="3">{{ $data['invoiceNumber'] }}</td>
                        <td class="amount-col" style="width: 12%">{{ $data['debit'] ? $data['debit'] : '' }}</td>
                        <td class="amount-col" style="width: 12%">{{ $data['credit'] ? $data['credit'] : '' }}</td>
                        <td class="amount-col" style="width: 10%">{{ $data['balance'] }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4"></td>
                    <td class="amount-col">{{ round($totalDebit, 2) }}</td>
                    <td class="amount-col">{{ round($totalCredit, 2) }}</td>
                    <td class="amount-col">{{ round($balanceAmount, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
