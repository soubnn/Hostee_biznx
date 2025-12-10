<!DOCTYPE html>
<html>
<head>
    <title>Investor Report - Hostee the Planner</title>
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
        <h2 class="text-center">HOSTEE THE PLANNER</h2>
        <h5 class="text-center">Investor Report</h5>
    </div>
    <div class="details">
        <p class="text-bold">Investor Name: <span class="gray-color">{{ strtoupper($investor->name) }}</span></p>
        <p class="text-bold">Total Investment: <span class="gray-color">RS. {{ $investmentSum }}</span></p>
        <p class="text-bold">Total Withdrawals: <span class="gray-color">RS. {{ $withdrawalSum }}</span></p>
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
                    <th>Investment</th>
                    <th>Withdrawal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $investment)
                    @php
                        $rowClass = $investment->income_id === 'INVESTOR_INVESTMENT' ? 'table-success' : ($investment->expense_id === 'INVESTOR_WITHDRAWAL' ? 'table-danger' : '');
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>{{ Carbon\Carbon::parse($investment->date)->format('d-m-Y') }}</td>
                        <td>{{ $investment->description }}</td>
                        <td>{{ $investment->accounts }}</td>
                        @if($investment->expense_id == 'INVESTOR_WITHDRAWAL')
                            <td></td>
                            <td>{{ $investment->amount }}</td>
                        @else
                            <td>{{ $investment->amount }}</td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
