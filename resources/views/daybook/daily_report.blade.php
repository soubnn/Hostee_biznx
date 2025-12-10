<!DOCTYPE html>
<html>
<head>
    <title>Daily Report - Hostee the Planner</title>
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
    .mt-5{
        margin-top:5px;
    }
    .mt-8{
        margin-top:8px;
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
    .w-45{
        width:45%;
    }
    .w-30{
        width:30%;
    }
    .w-35{
        width:35%;
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
        padding:6px 7px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:12px;
    }
    table tr td{
        font-size:10px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:8px;
    }
    .float-left{
        float:left;
    }
    .float-right{
        float:right;
    }
    .total-part{
        font-size:12px;
        line-height:9px;
    }
    .total-right p{
        padding-right:20px;
    }
    .page-break {
        page-break-after: always;
    }
    .font_red{
        color:red;
    }
    .normal_table{
        padding:0 !important;
        margin:0 !important;
        border:1px !important;
    }
    .footer {
        position: fixed;
        bottom: 0px;
    }
    #leftbox {
        float:left;
        width:33%;
        top: 0px;
    }
    #middlebox{
        float:left;
        width:33%;
        top: 0px;

    }
    #rightbox{
        float:right;
        width:33%;
        top: 0px;
    }

</style>
<body>
    <div class="head-title">
        <h4 class="text-center" style="margin-top: -30px;">HOSTEE DAILY ACCOUNT</h4>
    </div>
    <div class="add-detail mt-8">
        <div class="w-50 float-left mt-5">
            <table class="table w-100">
                <tr>
                    @if ( $daybook_summary->opening_ledger != '')
                        <th colspan="3">Opening Balance</th>
                    @else
                        <th colspan="2">Opening Balance</th>
                    @endif
                </tr>
                <tr>
                    <th>Cash</th>
                    <th>Account</th>
                    @if ( $daybook_summary->opening_ledger != '')
                        <th>Ledger</th>
                    @endif
                </tr>
                <tr class="text-center">
                    <td class="font_red">{{ $daybook_summary->opening_cash }}</td>
                    <td class="font_red">{{ $daybook_summary->opening_account }}</td>
                    @if ( $daybook_summary->opening_ledger != '')
                        <td class="font_red">{{ $daybook_summary->opening_ledger }}</td>
                    @endif
                </tr>
            </table>
        </div>
        <div class="w-20 float-right">
            <h5>Date : {{ Carbon\carbon::parse($report_date)->format('d M,Y') }}</h5>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="mt-10" style="width: 742px;">
        <div style="float: left; width: 232px;">
            <table style="width:100%">
                <tr>
                    <th colspan="2">Income</th>
                </tr>
                <tr>
                    <th>Inv No.</th>
                    <th>Amount</th>
                </tr>
                @foreach ( $get_income as $income)
                    <tr>
                        @if($income->income_id == 'FROM_INVOICE')
                            @php
                                // $sale_details = DB::table('direct_sales')->where('invoice_number',$income->job)->first();
                            @endphp
                            @if(!$income->sales_detail)
                                <td>{{ $income->job }}({{ $income->accounts }})</td>
                            @else
                                @php
                                    // $customer = DB::table('customers')->where('id',$sale_details->customer_id)->first();
                                    if($income->accounts == 'LEDGER'){
                                        $account = 'L';
                                    }
                                    elseif ($income->accounts == 'ACCOUNT') {
                                        $account = 'A';
                                    }
                                    elseif ($income->accounts == 'CASH') {
                                        $account = 'C';
                                    }
                                @endphp
                                <td>{{ $income->job }}({{ $account }})<br>{{substr($income->sales_detail->customer_detail->name, 0, 20)}}</td>
                            @endif
                        @elseif ($income->income_id == 'PURCHASE_RETURN')
                            @if(!$income->purchase_return_detail)
                                <td>{{ $income->job }}({{ $income->accounts }})</td>
                            @else
                                @php
                                    // $purchase = DB::table('purchases')->where('id',$sale_details->purchase_id)->first();
                                    // $seller = DB::table('sellers')->where('id',$purchase->seller_details)->first();
                                    if($income->accounts == 'LEDGER'){
                                        $account = 'L';
                                    }
                                    elseif ($income->accounts == 'ACCOUNT') {
                                        $account = 'A';
                                    }
                                    elseif ($income->accounts == 'CASH') {
                                        $account = 'C';
                                    }
                                @endphp
                                <td>DN-{{ $income->job }}-{{ $year }}({{ $account }})<br>{{substr($income->purchase_return_detail->purchase_details->seller_detail->seller_name, 0, 20)}}</td>
                            @endif
                        @elseif ($income->income_id == 'INVESTOR_INVESTMENT')
                            @php
                                if($income->accounts == 'LEDGER'){
                                    $account = 'L';
                                }
                                elseif ($income->accounts == 'ACCOUNT') {
                                    $account = 'A';
                                }
                                elseif ($income->accounts == 'CASH') {
                                    $account = 'C';
                                }
                            @endphp
                            <td>INVESTOR INVESTMENT ({{ $account }})<br>{{substr($income->investor_detail->name, 0, 20)}}</td>
                        @else
                            @php
                                // $income_details = DB::table('incomes')->where('id',$income->income_id)->first();
                                if($income->accounts == 'LEDGER'){
                                    $account = 'L';
                                }
                                elseif ($income->accounts == 'ACCOUNT') {
                                    $account = 'A';
                                }
                                elseif ($income->accounts == 'CASH') {
                                    $account = 'C';
                                }
                            @endphp
                            <td>{{ $income->incomes_detail->income_name }}({{ $account }})</td>
                        @endif
                        <td>{{ $income->amount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <th>{{ $total_income }}</th>
                </tr>
            </table>
        </div>
        <div style="float: left; width: 232px;">
            <table style="width:100%">
                <tr>
                    <th colspan="2">Expense</th>
                </tr>
                <tr>
                    <th>Descrption</th>
                    <th>Amount</th>
                </tr>

                @foreach ( $get_expense as $expense)
                    <tr>
                        @if($expense->expense_id == "FOR_SUPPLIER")
                            @php
                                // $supplierDetails = DB::table('sellers')->where('id',$expense->job)->first();
                                if($expense->accounts == 'LEDGER'){
                                    $exp_account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $exp_account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $exp_account = 'C';
                                }
                            @endphp
                            <td>{{ $expense->sellers_detail->seller_name }}({{ $exp_account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @elseif($expense->expense_id == "SALE_RETURN")
                            @php
                                $sales_return = DB::table('sales_returns')->where('invoice_number',$expense->job)->first();
                                $direct_sale = DB::table('direct_sales')->where('id',$sales_return->sale_id)->first();
                                $customer = DB::table('customers')->where('id',$direct_sale->customer_id)->first();
                                if($expense->accounts == 'LEDGER'){
                                    $exp_account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $exp_account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $exp_account = 'C';
                                }
                            @endphp
                            <td>{{ $customer->name }}({{ $exp_account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @elseif($expense->expense_id == "staff_salary")
                            @php
                                // $staffDetails = DB::table('staffs')->where('id',$expense->staff)->first();
                                if($expense->accounts == 'LEDGER'){
                                    $exp_account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $exp_account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $exp_account = 'C';
                                }
                                if ($expense->accounts == 'Salary Advance') {
                                    $description = 'ADV';
                                } else {
                                    $description = 'SALARY';
                                }
                            @endphp
                            <td>{{ $expense->staffs_detail->staff_name }}-{{ @$description }}({{ $exp_account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @elseif($expense->expense_id == "staff_incentive")
                            @php
                                // $staffDetails = DB::table('staffs')->where('id',$expense->staff)->first();
                                if($expense->accounts == 'LEDGER'){
                                    $exp_account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $exp_account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $exp_account = 'C';
                                }
                            @endphp
                            <td>{{ $expense->staffs_detail->staff_name }}({{ $exp_account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @elseif ($expense->expense_id == 'INVESTOR_WITHDRAWAL')
                            @php
                                if($expense->accounts == 'LEDGER'){
                                    $account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $account = 'C';
                                }
                            @endphp
                            <td>INVESTOR WITHDRAWAL ({{ $account }})<br>{{substr($expense->investor_detail->name, 0, 20)}}</td>
                            <td>{{ $expense->amount }}</td>
                        @elseif($expense->expense_id == 'INVEST_BANK')
                            @php
                                $bankDetails = DB::table('banks')
                                    ->where('id', $expense->staff)
                                    ->first();
                                if ($expense->accounts == 'LEDGER') {
                                    $account = 'L';
                                } elseif ($expense->accounts == 'ACCOUNT') {
                                    $account = 'A';
                                } elseif ($expense->accounts == 'CASH') {
                                    $account = 'C';
                                }
                            @endphp
                            <td>DEPOSITED IN BANK[{{ $bankDetails->bank_name }}]@if ($bankDetails->book_no) No:@endif{{ $bankDetails->book_no }}({{ $account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @else
                            @php
                                // $expense_details = DB::table('expenses')->where('id',$expense->expense_id)->first();
                                if($expense->accounts == 'LEDGER'){
                                    $exp_account = 'L';
                                }
                                elseif ($expense->accounts == 'ACCOUNT') {
                                    $exp_account = 'A';
                                }
                                elseif ($expense->accounts == 'CASH') {
                                    $exp_account = 'C';
                                }
                            @endphp
                            <td>{{ $expense->expenses_detail->expense_name }}({{ $exp_account }})</td>
                            <td>{{ $expense->amount }}</td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <th>{{ $total_expense }}</th>
                </tr>
            </table>
        </div>
        <div style="float: left; width: 232px;">
            <table class="table" style="width:100%">
                <tr>
                    <th>Service</th>
                </tr>
                <tr>
                    <th>Name of service</th>
                </tr>
                @foreach ($daybook_services as $service)
                    <tr>
                        <td>
                            @php
                                $customer = DB::table('customers')->where('id',$service->daybook_service)->first();
                            @endphp
                            @if($customer)
                                {{ $customer->name }} - {{ $customer->place }}
                            @else
                                {{ $service->daybook_service }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <br style="clear: left;"/>
    </div>

    <div class="add-detail mt-5">
        <div class="w-45 float-left mt-5">
            <table class="table w-100">
                <tr>
                    <th colspan="2">Cash Transfer</th>
                </tr>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                @foreach ( $get_transfer as $transfer)
                    <tr>
                        <td>{{ $transfer->description }}</td>
                        <td>{{ $transfer->amount }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="w-45 float-right mt-5">
            <table class="table w-100">
                <tr>
                    @if ( $daybook_summary->closing_ledger != '')
                        <th colspan="3">Closing Balance</th>
                    @else
                        <th colspan="2">Closing Balance</th>
                    @endif
                </tr>
                <tr>
                    <th>Cash</th>
                    <th>Account</th>
                    @if ( $daybook_summary->closing_ledger != '')
                        <th>Ledger</th>
                    @endif
                </tr>
                <tr class="text-center">
                    <td class="font_red">{{ $daybook_summary->closing_cash }}</td>
                    <td class="font_red">{{ $daybook_summary->closing_account }}</td>
                    @if ( $daybook_summary->closing_ledger != '')
                        <td class="font_red">{{ $daybook_summary->closing_ledger }}</td>
                    @endif
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>
        <div class="w-100 float-right mt-5">
            <table class="table w-100">
                <tr>
                    <th colspan="3">Sales</th>
                </tr>
                <tr>
                    <th>Inv No</th>
                    <th>Customer</th>
                    <th>Amount</th>
                </tr>
                @foreach ( $sales as $sale)
                    <tr>
                        <td>
                            @php
                                $salesItems = \App\Models\SalesItems::where('sales_id', $sale->id)->get();
                            @endphp
                            @if ($salesItems->isNotEmpty())
                                <a href="{{ route('salesInvoice', $salesItems[0]->sales_id) }}" target="_blank" style="text-decoration: none">
                                    {{ $sale->invoice_number }}
                                </a>
                            @else
                                {{ $sale->invoice_number }}
                            @endif
                        </td>
                        <td>{{ $sale->customer_detail->name }}</td>
                        <td>{{ $sale->grand_total - $sale->discount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $sales_grand_total }}</th>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>
        <div class="w-100 float-right mt-10">
            <table class="table w-100">
                <tr>
                    <th>Done By</th>
                    <th>Verified By</th>
                    <th>Finance Officer</th>
                </tr>
                <tr class="text-center">
                    <td style="font-weight: 600px;text-transform:uppercase;">{{ $daybook_summary->added_by }}</td>
                    <td style="font-weight: 600px;">{{ 'ADMIN' }}</td>
                    <td style="font-weight: 600px;"></td>
                </tr>
            </table>
        </div>
        @if ($sms == 'yes')
            <div style="clear: both;"></div>
            <div class="w-100 float-right mt-10">
                <table class="table w-100">
                    <tr>
                        <th>Total Sales</th>
                        <th>Sales/Profit</th>
                    </tr>
                    <tr class="text-center">
                        <td style="font-weight: 600px;">Previous Month ({{ $previousMonth->format('M Y') }}) </td>
                        <td style="font-weight: 600px;">
                            {{ number_format($previousMonthSalesTotal, 2) }} / {{ number_format($previousMonthSalesTotalProfit, 2) }} (
                            @if( number_format($previousMonthSalesTotalProfit - 150000, 2) > 0)
                                <b class="text-success">{{ number_format($previousMonthSalesTotalProfit - 150000, 2) }}</b>
                            @else
                                <b class="text-danger">{{ number_format($previousMonthSalesTotalProfit - 150000, 2) }}</b>
                            @endif
                            )
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td style="font-weight: 600px;">Current Month ({{ $currentMonthStartDate->format('M Y') }})</td>
                        <td style="font-weight: 600px;">
                            {{ number_format($currentMonthSalesTotal, 2) }} / {{ number_format($currentMonthSalesTotalProfit, 2) }} (
                                @if( number_format($currentMonthSalesTotalProfit - 150000, 2) > 0)
                                    <b class="text-success">{{ number_format($currentMonthSalesTotalProfit - 150000, 2) }}</b>
                                @else
                                    <b class="text-danger">{{ number_format($currentMonthSalesTotalProfit - 150000, 2) }}</b>
                                @endif
                                )
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td style="font-weight: 600px;">Current Week ({{ $startOfWeekDate->format('d M Y') }} - {{ $today->format('d M Y') }})</td>
                        <td style="font-weight: 600px;">
                            {{ number_format($weekSalesTotal, 2) }} / {{ number_format($weekSalesTotalProfit, 2) }} (
                                @if( number_format($weekSalesTotalProfit - 35000, 2) > 0)
                                    <b class="text-success">{{ number_format($weekSalesTotalProfit - 35000, 2) }}</b>
                                @else
                                    <b class="text-danger">{{ number_format($weekSalesTotalProfit - 35000, 2) }}</b>
                                @endif
                                )

                        </td>
                    </tr>
                    <tr class="text-center">
                        <td style="font-weight: 600px;">Today ({{ $today->format('d M Y') }})</td>
                        <td style="font-weight: 600px;">
                            {{ number_format($todaySalesTotal, 2) }} / {{ number_format($todaySalesTotalProfit, 2) }} (
                                @if( number_format($todaySalesTotalProfit - 5000, 2) > 0)
                                    <b class="text-success">{{ number_format($todaySalesTotalProfit - 5000, 2) }}</b>
                                @else
                                    <b class="text-danger">{{ number_format($todaySalesTotalProfit - 5000, 2) }}</b>
                                @endif
                                )
                        </td>
                    </tr>
                </table>
            </div>
        @endif

        <div class="footer">
            <p style="font-size:10px;">generated by {{ $printed_by }} on {{ $printed_on }}:{{ $profit }}: cr {{ $total_sales_balance }}: spl {{ $seller_balance }}: stk {{ $stock_balance }}</p>
        </div>
    </div>
</body>
</html>
