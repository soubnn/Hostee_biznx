@extends('utility.layout')
@section('content')
    <style>
        .select2-container--open {
            z-index: 999999 !important;
        }
    </style>
    <script>
        $(document).ready(function(){
            $("#datatable").dataTable({
                "pageLength" : 100,
                "bPaginate" : false
            });
        });
        function deleteConfirmation(id) {
            if (confirm("Are you sure you want to delete this Daybook entry?")) {
                window.location.href = "{{ route('util_delete_daybook') }}?id=" + id;
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
                            <h4 class="mb-sm-0 font-size-18">DATE WISE REPORT</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tr>
                                                <th colspan="3" class="bg-light fw-bold">Opening Balance</th>
                                            </tr>
                                            <tr>
                                                <th>Cash</th>
                                                <th>Account</th>
                                                @if ($status == 'not_empty' && !empty($daybook_summary->opening_ledger))
                                                    <th>Ledger</th>
                                                @endif
                                            </tr>
                                            @if ($status == 'empty')
                                                <tr>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($prev_closing_balance->cash_balance ?? 0), 2, '.', '') }}</td>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($prev_closing_balance->account_balance ?? 0), 2, '.', '') }}</td>
                                                </tr>
                                            @elseif($status == 'not_empty')
                                                <tr>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($daybook_summary->opening_cash ?? 0), 2, '.', '') }}</td>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($daybook_summary->opening_account ?? 0), 2, '.', '') }}</td>
                                                    @if (!empty($daybook_summary->opening_ledger))
                                                        <td class="text-danger fw-semibold">{{ number_format((float)$daybook_summary->opening_ledger, 2, '.', '') }}</td>
                                                    @endif
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <form method="GET" action="{{ route('util_daybooks.edit') }}" id="dateFilterForm" class="d-inline-flex align-items-center justify-content-end gap-2">
                                            <h4 class="card-title mb-0 me-2">Date :</h4>
                                            <input type="date" name="date" value="{{ Carbon\Carbon::parse($report_date)->format('Y-m-d') }}" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
                                        </form>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="bg-soft-success text-success font-size-15">Income</th>
                                                <th colspan="2" class="bg-soft-danger text-danger font-size-15">Expense</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!-- Income Section -->
                                                <td colspan="2" style="width: 50%; vertical-align: top;" class="p-0">
                                                    <table class="table table-bordered table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>INV NO. / DESCRIPTION</th>
                                                                <th>AMOUNT</th>
                                                                <th style="width: 80px;" class="text-center">ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($get_income as $income)
                                                                <tr>
                                                                    @php
                                                                        $account = ($income->accounts == 'LEDGER') ? 'L' : (($income->accounts == 'ACCOUNT') ? 'A' : 'C');
                                                                    @endphp
                                                                    @if ($income->income_id == 'FROM_INVOICE')
                                                                        @php
                                                                            $sale_details = DB::table('direct_sales')->where('invoice_number', $income->job)->first();
                                                                        @endphp
                                                                        @if (empty($sale_details))
                                                                            <td>{{ $income->job }}({{ $account }})</td>
                                                                        @else
                                                                            @php
                                                                                $customer = DB::table('customers')->where('id', $sale_details->customer_id)->first();
                                                                            @endphp
                                                                            <td>
                                                                                {{ $income->job }}({{ $account }})<br>
                                                                                <span style="font-size: 11px; color: #666; font-weight: normal; display: block; line-height: 1.1;">
                                                                                    {{ substr($customer->name ?? '', 0, 25) }}
                                                                                </span>
                                                                            </td>
                                                                        @endif
                                                                    @elseif($income->income_id == 'INVESTOR_INVESTMENT')
                                                                        @php
                                                                            $investorDetails = DB::table('investors')->where('id', $income->staff)->first();
                                                                        @endphp
                                                                        <td>INVESTMENT[{{ $investorDetails->name ?? '' }}]({{ $account }})</td>
                                                                    @elseif($income->income_id == 'WITHDRAW_BANK')
                                                                        @php
                                                                            $bankDetails = DB::table('banks')->where('id', $income->staff)->first();
                                                                        @endphp
                                                                        <td>WITHDRAW IN BANK[{{ $bankDetails->bank_name ?? '' }}]@if (!empty($bankDetails->book_no)) No:{{ $bankDetails->book_no }}@endif({{ $account }})</td>
                                                                    @else
                                                                        @php
                                                                            $income_details = DB::table('incomes')->where('id', $income->income_id)->first();
                                                                        @endphp
                                                                        <td>{{ $income_details->income_name ?? $income->income_id }}({{ $account }})</td>
                                                                    @endif
                                                                    <td class="fw-semibold">{{ number_format((float)$income->amount, 2, '.', '') }}</td>
                                                                    <td class="text-center">
                                                                        <div class="d-flex gap-1 justify-content-center">
                                                                            <button class="btn btn-light waves-effect text-primary btn-sm p-1" data-bs-toggle="modal" data-bs-target="#editDaybookModal_{{ $income->id }}" title="Edit">
                                                                                <i class="mdi mdi-pencil font-size-15"></i>
                                                                            </button>
                                                                            <button class="btn btn-light waves-effect text-danger btn-sm p-1" onclick="deleteConfirmation({{ $income->id }})" title="Delete">
                                                                                <i class="mdi mdi-trash-can font-size-15"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>

                                                <!-- Expense Section -->
                                                <td colspan="2" style="width: 50%; vertical-align: top;" class="p-0">
                                                    <table class="table table-bordered table-striped mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>DESCRIPTION</th>
                                                                <th>AMOUNT</th>
                                                                <th style="width: 80px;" class="text-center">ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($get_expense as $expense)
                                                                <tr>
                                                                    @php
                                                                        $exp_account = ($expense->accounts == 'LEDGER') ? 'L' : (($expense->accounts == 'ACCOUNT') ? 'A' : 'C');
                                                                    @endphp
                                                                    @if ($expense->expense_id == 'FOR_SUPPLIER')
                                                                        @php
                                                                            $supplierDetails = DB::table('sellers')->where('id', $expense->job)->first();
                                                                        @endphp
                                                                        <td>{{ $supplierDetails->seller_name ?? 'SUPPLIER' }}({{ $exp_account }})</td>
                                                                    @elseif($expense->expense_id == 'SALE_RETURN')
                                                                        @php
                                                                            $supplierDetails = DB::table('sales_returns')->where('invoice_number', $expense->job)->first();
                                                                            $sales_details = $supplierDetails ? DB::table('direct_sales')->where('id', $supplierDetails->sale_id)->first() : null;
                                                                            $customer = $sales_details ? DB::table('customers')->where('id', $sales_details->customer_id)->first() : null;
                                                                        @endphp
                                                                        <td>
                                                                            {{ $supplierDetails->invoice_number ?? $expense->job }}({{ $exp_account }})<br>
                                                                            <span style="font-size: 11px; color: #666; font-weight: normal; display: block; line-height: 1.1;">
                                                                                {{ substr($customer->name ?? '', 0, 25) }}
                                                                            </span>
                                                                        </td>
                                                                    @elseif($expense->expense_id == 'staff_salary')
                                                                        @php
                                                                            $staffDetails = DB::table('staffs')->where('id', $expense->staff)->first();
                                                                            $description = ($expense->accounts == 'Salary Advance' || stripos($expense->description, 'Advance') !== false) ? 'SAL-ADVANCE' : 'SALARY';
                                                                        @endphp
                                                                        <td>{{ $staffDetails->staff_name ?? 'STAFF' }}-{{ $description }}({{ $exp_account }})</td>
                                                                    @elseif($expense->expense_id == 'staff_incentive')
                                                                        @php
                                                                            $staffDetails = DB::table('staffs')->where('id', $expense->staff)->first();
                                                                        @endphp
                                                                        <td>INCENTIVE[{{ $staffDetails->staff_name ?? '' }}]({{ $exp_account }})</td>
                                                                    @else
                                                                        @php
                                                                            $expense_details = DB::table('expenses')->where('id', $expense->expense_id)->first();
                                                                        @endphp
                                                                        <td>{{ $expense_details->expense_name ?? $expense->expense_id }}({{ $exp_account }})</td>
                                                                    @endif
                                                                    <td class="fw-semibold">{{ number_format((float)$expense->amount, 2, '.', '') }}</td>
                                                                    <td class="text-center">
                                                                        <div class="d-flex gap-1 justify-content-center">
                                                                            <button class="btn btn-light waves-effect text-primary btn-sm p-1" data-bs-toggle="modal" data-bs-target="#editDaybookModal_{{ $expense->id }}" title="Edit">
                                                                                <i class="mdi mdi-pencil font-size-15"></i>
                                                                            </button>
                                                                            <button class="btn btn-light waves-effect text-danger btn-sm p-1" onclick="deleteConfirmation({{ $expense->id }})" title="Delete">
                                                                                <i class="mdi mdi-trash-can font-size-15"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="bg-light">TOTAL INCOME</th>
                                                <th class="text-danger font-size-14 fw-bold bg-light">{{ number_format((float)$total_income, 2, '.', '') }}</th>
                                                <th class="bg-light">TOTAL EXPENSE</th>
                                                <th class="text-danger font-size-14 fw-bold bg-light">{{ number_format((float)$total_expense, 2, '.', '') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th colspan="3" class="bg-light fw-bold">Cash Transfer</th>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th style="width: 80px;" class="text-center">Action</th>
                                            </tr>
                                            @foreach ($get_transfer as $transfer)
                                                <tr>
                                                    <td>{{ $transfer->description ?? 'Cash Transfer' }}</td>
                                                    <td class="fw-semibold">{{ number_format((float)$transfer->amount, 2, '.', '') }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex gap-1 justify-content-center">
                                                            <button class="btn btn-light waves-effect text-primary btn-sm p-1" data-bs-toggle="modal" data-bs-target="#editDaybookModal_{{ $transfer->id }}" title="Edit">
                                                                <i class="mdi mdi-pencil font-size-15"></i>
                                                            </button>
                                                            <button class="btn btn-light waves-effect text-danger btn-sm p-1" onclick="deleteConfirmation({{ $transfer->id }})" title="Delete">
                                                                <i class="mdi mdi-trash-can font-size-15"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th colspan="3" class="bg-light fw-bold">Closing Balance</th>
                                            </tr>
                                            <tr>
                                                <th>Cash</th>
                                                <th>Account</th>
                                                @if ($status == 'not_empty' && !empty($daybook_summary->closing_ledger))
                                                    <th>Ledger</th>
                                                @endif
                                            </tr>
                                            @if ($status == 'empty')
                                                <tr>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($cur_closing_balance->cash_balance ?? 0), 2, '.', '') }}</td>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($cur_closing_balance->account_balance ?? 0), 2, '.', '') }}</td>
                                                </tr>
                                            @elseif ($status == 'not_empty')
                                                <tr>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($daybook_summary->closing_cash ?? 0), 2, '.', '') }}</td>
                                                    <td class="text-danger fw-semibold">{{ number_format((float)($daybook_summary->closing_account ?? 0), 2, '.', '') }}</td>
                                                    @if (!empty($daybook_summary->closing_ledger))
                                                        <td class="text-danger fw-semibold">{{ number_format((float)$daybook_summary->closing_ledger, 2, '.', '') }}</td>
                                                    @endif
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        @php
                                            $totalSalesAmount = 0;
                                        @endphp
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th colspan="3" class="bg-light fw-bold">Sales</th>
                                            </tr>
                                            <tr>
                                                <th>Inv No</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                            </tr>
                                            @foreach ($sales as $sale)
                                                @php
                                                    $amount = $sale->grand_total - $sale->discount;
                                                    $totalSalesAmount += $amount;
                                                    $customerObj = DB::table('customers')->where('id', $sale->customer_id)->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $sale->invoice_number }}</td>
                                                    <td>{{ substr($customerObj->name ?? '', 0, 30) }}</td>
                                                    <td class="fw-semibold">{{ number_format((float)$amount, 2, '.', '') }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="2" class="text-end">Total Sales</th>
                                                <th class="text-danger font-size-14">{{ number_format((float)$totalSalesAmount, 2, '.', '') }}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>

        <!-- Edit Daybook Modals -->
        @php
            $allEntries = $get_income->merge($get_expense)->merge($get_transfer);
        @endphp
        @foreach ($allEntries as $entry)
            <div id="editDaybookModal_{{ $entry->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Daybook Entry #{{ $entry->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <form action="{{ route('utility_update_daybook') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $entry->id }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ $entry->date }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Transaction Type</label>
                                        <select name="type" class="form-select" required>
                                            <option value="Expense" {{ $entry->type == 'Expense' ? 'selected' : '' }}>Expense</option>
                                            <option value="Income" {{ $entry->type == 'Income' ? 'selected' : '' }}>Income</option>
                                            <option value="Transfer" {{ $entry->type == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                        </select>
                                    </div>
                                     <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Expense Category</label>
                                        <select name="expense_id" class="form-select select2" data-dropdown-parent="#editDaybookModal_{{ $entry->id }}" style="width: 100%;">
                                            <option value="" disabled {{ !$entry->expense_id ? 'selected' : '' }}>Select Expense Category</option>
                                            @foreach($expenses as $expItem)
                                                <option value="{{ $expItem->id }}" {{ $entry->expense_id == $expItem->id ? 'selected' : '' }}>
                                                    {{ $expItem->expense_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Income Category</label>
                                        <select name="income_id" class="form-select select2" data-dropdown-parent="#editDaybookModal_{{ $entry->id }}" style="width: 100%;">
                                            <option value="" disabled {{ !$entry->income_id ? 'selected' : '' }}>Select Income Category</option>
                                            @foreach($incomes as $incItem)
                                                <option value="{{ $incItem->id }}" {{ $entry->income_id == $incItem->id ? 'selected' : '' }}>
                                                    {{ $incItem->income_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Job / Invoice / Ref</label>
                                        <input type="text" name="job" class="form-control" value="{{ $entry->job }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Description</label>
                                        <input type="text" name="description" class="form-control" value="{{ $entry->description }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Amount (₹)</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ $entry->amount }}" required min="0">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Payment Account</label>
                                        <select name="accounts" class="form-select" required>
                                            <option value="CASH" {{ $entry->accounts == 'CASH' ? 'selected' : '' }}>CASH</option>
                                            <option value="ACCOUNT" {{ $entry->accounts == 'ACCOUNT' ? 'selected' : '' }}>ACCOUNT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Updating...';this.form.submit();">Update Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End Page-content -->
@endsection
