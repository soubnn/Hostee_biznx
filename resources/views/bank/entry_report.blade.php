<!DOCTYPE html>
<html>
<head>
    <title>Bank Entry Report - Techsoul Cyber Solutions</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table, th, td {
        border: 1px solid #d2d2d2;
    }
    th, td {
        padding: 8px;
        text-align: center;
    }
    th {
        background: #F4F4F4;
    }
    .text-bold{
        font-weight: bold;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .table-success {
        background-color: #d4edda; /* Light green for investments */
    }
    .table-danger {
        background-color: #f8d7da; /* Light red for withdrawals */
    }
</style>
<body>
    <div class="head-title">
        <h2 class="text-center">TECHSOUL CYBER SOLUTIONS</h2>
        <h5 class="text-center">Bank Entry Report</h5>
    </div>
    <div class="details">
        <p class="text-bold">Bank Type: <span class="gray-color">{{ strtoupper($bank->type) }}</span></p>
        <p class="text-bold">Bank Name: <span class="gray-color">{{ strtoupper($bank->bank_name) }}</span></p>
        <p class="text-bold">Bank Book No: <span class="gray-color">{{ strtoupper($bank->book_no) }}</span></p>
        <p class="text-bold">Account No: <span class="gray-color">{{ strtoupper($bank->acc_no) }}</span></p>
        <p class="text-bold">Biller Name: <span class="gray-color">{{ strtoupper($bank->biller_name) }}</span></p>
        <p class="text-bold">Total Deposit: <span class="gray-color">RS. {{ $investSum }}</span></p>
        <p class="text-bold">Total Withdrawals: <span class="gray-color">RS. {{ $withdrawSum }}</span></p>
        <p class="text-bold">Opening Balance: <span class="gray-color">RS. {{ $openingBalance }}</span></p>
        <p class="text-bold">Net Balance: <span class="gray-color">RS. {{ $netAmount }}</span></p>
        <p class="text-bold">Report Period: <span class="gray-color">{{ $startDate }} - {{ $endDate }}</span></p>
    </div>
    <div class="table-section">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Accounts</th>
                    <th>Withdrawal</th>
                    <th>Deposit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $entry)
                    @php
                        $rowClass = $entry->income_id === 'WITHDRAW_BANK' ? 'table-danger' : ($entry->expense_id === 'INVEST_BANK' ? 'table-success' : '');
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>{{ Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
                        <td>{{ $entry->description }}</td>
                        <td>{{ $entry->accounts }}</td>
                        @if($entry->expense_id == 'INVEST_BANK')
                            <td></td>
                            <td>{{ $entry->amount }}</td>
                        @else
                            <td>{{ $entry->amount }}</td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
