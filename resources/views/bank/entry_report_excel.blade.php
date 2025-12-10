<table>
    <thead>
        <tr>
            <th colspan="5" style="text-align:center;">HOSTEE THE PLANNER</th>
        </tr>
        <tr>
            <th colspan="5" style="text-align:center;">Bank Entry Report</th>
        </tr>
        <tr><td colspan="5"></td></tr>
        <tr><td><b>Bank Name:</b></td><td>{{ $bank->bank_name }}</td></tr>
        <tr><td><b>Account No:</b></td><td>{{ $bank->acc_no }}</td></tr>
        <tr><td><b>Book No:</b></td><td>{{ $bank->book_no }}</td></tr>
        <tr><td><b>Biller Name:</b></td><td>{{ $bank->biller_name }}</td></tr>
        <tr><td><b>Total Deposit:</b></td><td>RS. {{ $investSum }}</td></tr>
        <tr><td><b>Total Withdrawals:</b></td><td>RS. {{ $withdrawSum }}</td></tr>
        <tr><td><b>Opening Balance:</b></td><td>RS. {{ $openingBalance }}</td></tr>
        <tr><td><b>Net Balance:</b></td><td>RS. {{ $netAmount }}</td></tr>
        <tr><td><b>Period:</b></td><td>{{ $startDate }} to {{ $endDate }}</td></tr>
        <tr><td colspan="5"></td></tr>
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
            <tr>
                <td>{{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->accounts }}</td>
                <td>{{ $entry->income_id == 'WITHDRAW_BANK' ? $entry->amount : '' }}</td>
                <td>{{ $entry->expense_id == 'INVEST_BANK' ? $entry->amount : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
