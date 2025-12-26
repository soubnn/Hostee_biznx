@extends('layouts.layout')
@section('content')
    <script>
        $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
        });
    </script>
    <script>
        var count = 1;

        function add_row() {
            var newRow = document.createElement("tr");
            // newRow.setAttribute("id", "row" + count);

            //Column 1
            var newColumn1 = document.createElement("td");
            var daybook_service = document.createElement("input");
            daybook_service.setAttribute("type", "text");
            daybook_service.setAttribute("class", "form-control");
            daybook_service.setAttribute("id", "daybook_service" + count);
            daybook_service.setAttribute("name", "daybook_service[]");
            daybook_service.setAttribute("onkeyup", "this.value = this.value.toUpperCase()");
            newColumn1.appendChild(daybook_service);

            var service_table = document.getElementById("service_table");
            newRow.appendChild(newColumn1);
            service_table.appendChild(newRow);

            count++;
        }
    </script>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Date Wise Report</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="daybookForm" action="{{ route('store_daybook_summary') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th colspan="3">Opening Balance</th>
                                                </tr>
                                                <tr>
                                                    <th>Cash</th>
                                                    <th>Account</th>
                                                    @if ($status == 'not_empty')
                                                        @if ($daybook_summary->opening_ledger != '')
                                                            <th>Ledger</th>
                                                        @endif
                                                    @endif
                                                </tr>
                                                @if ($status == 'empty')
                                                    <tr>
                                                        <td class="text-danger">{{ $prev_closing_balance->cash_balance ?? 0 }}
                                                        </td>
                                                        <td class="text-danger">{{ $prev_closing_balance->account_balance ?? 0 }}
                                                        </td>
                                                        {{--  <td class="text-danger">{{ $prev_closing_balance->ledger_balance }}</td>  --}}
                                                    </tr>
                                                    <input type="hidden" name="opening_cash"
                                                        value="{{ $prev_closing_balance->cash_balance ?? 0 }}">
                                                    <input type="hidden" name="opening_account"
                                                        value="{{ $prev_closing_balance->account_balance ?? 0 }}">
                                                    <input type="hidden" name="opening_ledger"
                                                        value="{{ $prev_closing_balance->ledger_balance ?? 0 }}">
                                                @elseif($status == 'not_empty')
                                                    <tr>
                                                        <td class="text-danger">{{ $daybook_summary->opening_cash }}</td>
                                                        <td class="text-danger">{{ $daybook_summary->opening_account }}</td>
                                                        @if ($daybook_summary->opening_ledger != '')
                                                            <td class="text-danger">{{ $daybook_summary->opening_ledger }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-8 text-end">
                                            <h4 class="card-title mb-4">Date :
                                                {{ Carbon\carbon::parse($report_date)->format('d M,Y') }}</h4>
                                            <input type="hidden" name="date"
                                                value="{{ Carbon\carbon::parse($report_date)->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    {{-- <div class="table-responsive"> --}}
                                    <table class="table table-bordered table-striped table-nowrap mb-0"
                                        style="text-transform: uppercase;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Income</th>
                                                <th colspan="2">Expense</th>
                                            </tr>
                                        </thead>
                                        <tbody id="t_body">
                                            <tr>
                                                <td colspan="2">
                                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                                        <tr>
                                                            <th>Inv No.</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        @foreach ($get_income as $income)
                                                            <tr>
                                                                @if ($income->income_id == 'FROM_INVOICE')
                                                                    @php
                                                                        $sale_details = DB::table('direct_sales')
                                                                            ->where('invoice_number', $income->job)
                                                                            ->first();
                                                                    @endphp
                                                                    @if (empty($sale_details))
                                                                        <td>{{ $income->job }}({{ $income->accounts }})
                                                                        </td>
                                                                    @else
                                                                        @php
                                                                            $customer = DB::table('customers')
                                                                                ->where(
                                                                                    'id',
                                                                                    $sale_details->customer_id,
                                                                                )
                                                                                ->first();
                                                                            if ($income->accounts == 'LEDGER') {
                                                                                $account = 'L';
                                                                            } elseif ($income->accounts == 'ACCOUNT') {
                                                                                $account = 'A';
                                                                            } elseif ($income->accounts == 'CASH') {
                                                                                $account = 'C';
                                                                            }
                                                                        @endphp
                                                                        <td>{{ $income->job }}({{ $account }})<br>{{ substr($customer->name, 0, 20) }}
                                                                        </td>
                                                                    @endif
                                                                @elseif($income->income_id == 'INVESTOR_INVESTMENT')
                                                                    @php
                                                                        $investorDetails = DB::table('investors')
                                                                            ->where('id', $income->staff)
                                                                            ->first();
                                                                        if ($income->accounts == 'LEDGER') {
                                                                            $account = 'L';
                                                                        } elseif ($income->accounts == 'ACCOUNT') {
                                                                            $account = 'A';
                                                                        } elseif ($income->accounts == 'CASH') {
                                                                            $account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>INVESTMENT[{{ $investorDetails->name }}]({{ $account }})
                                                                    </td>
                                                                @elseif($income->income_id == 'WITHDRAW_BANK')
                                                                    @php
                                                                        $bankDetails = DB::table('banks')
                                                                            ->where('id', $income->staff)
                                                                            ->first();
                                                                        if ($income->accounts == 'LEDGER') {
                                                                            $account = 'L';
                                                                        } elseif ($income->accounts == 'ACCOUNT') {
                                                                            $account = 'A';
                                                                        } elseif ($income->accounts == 'CASH') {
                                                                            $account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>WITHDRAW IN BANK[{{ $bankDetails->bank_name }}]@if ($bankDetails->book_no) No:@endif{{ $bankDetails->book_no }}({{ $account }})
                                                                    </td>
                                                                @elseif ($income->income_id == 'PURCHASE_RETURN')
                                                                    @if (empty($sale_details))
                                                                        <td>{{ $income->job }}({{ $income->accounts }})
                                                                        </td>
                                                                    @else
                                                                        @php
                                                                            $purchase = DB::table('purchases')
                                                                                ->where(
                                                                                    'id',
                                                                                    $sale_details->purchase_id,
                                                                                )
                                                                                ->first();
                                                                            $seller = DB::table('sellers')
                                                                                ->where('id', $purchase->seller_details)
                                                                                ->first();
                                                                            if ($income->accounts == 'LEDGER') {
                                                                                $account = 'L';
                                                                            } elseif ($income->accounts == 'ACCOUNT') {
                                                                                $account = 'A';
                                                                            } elseif ($income->accounts == 'CASH') {
                                                                                $account = 'C';
                                                                            }
                                                                        @endphp
                                                                        <td>{{ $sale_details->invoice_number }}({{ $account }})<br>{{ substr($seller->seller_name, 0, 20) }}
                                                                        </td>
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $income_details = DB::table('incomes')
                                                                            ->where('id', $income->income_id)
                                                                            ->first();
                                                                        if ($income->accounts == 'LEDGER') {
                                                                            $account = 'L';
                                                                        } elseif ($income->accounts == 'ACCOUNT') {
                                                                            $account = 'A';
                                                                        } elseif ($income->accounts == 'CASH') {
                                                                            $account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $income_details->income_name }}({{ $account }})
                                                                    </td>
                                                                @endif
                                                                <td>{{ $income->amount }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                                <td colspan="2">
                                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                                        <tr>
                                                            <th>Descrption</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        @foreach ($get_expense as $expense)
                                                            <tr>
                                                                @if ($expense->expense_id == 'FOR_SUPPLIER')
                                                                    @php
                                                                        $supplierDetails = DB::table('sellers')
                                                                            ->where('id', $expense->job)
                                                                            ->first();
                                                                        if ($expense->accounts == 'LEDGER') {
                                                                            $exp_account = 'L';
                                                                        } elseif ($expense->accounts == 'ACCOUNT') {
                                                                            $exp_account = 'A';
                                                                        } elseif ($expense->accounts == 'CASH') {
                                                                            $exp_account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $supplierDetails->seller_name }}({{ $exp_account }})
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @elseif($expense->expense_id == 'SALE_RETURN')
                                                                    @php
                                                                        $supplierDetails = DB::table('sales_returns')
                                                                            ->where('invoice_number', $expense->job)
                                                                            ->first();
                                                                        $sales_details = DB::table('direct_sales')
                                                                            ->where('id', $supplierDetails->sale_id)
                                                                            ->first();
                                                                        $customer = DB::table('customers')
                                                                            ->where('id', $sales_details->customer_id)
                                                                            ->first();
                                                                        if ($expense->accounts == 'LEDGER') {
                                                                            $exp_account = 'L';
                                                                        } elseif ($expense->accounts == 'ACCOUNT') {
                                                                            $exp_account = 'A';
                                                                        } elseif ($expense->accounts == 'CASH') {
                                                                            $exp_account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $supplierDetails->invoice_number }}({{ $exp_account }})<br>{{ substr($customer->name, 0, 20) }}
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @elseif($expense->expense_id == 'INVESTOR_WITHDRAWAL')
                                                                    @php
                                                                        $investorDetails = DB::table('investors')
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
                                                                    <td>WITHDRAWAL[{{ $investorDetails->name }}]({{ $account }})
                                                                    </td>
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
                                                                    <td>DEPOSITED IN BANK[{{ $bankDetails->bank_name }}]@if ($bankDetails->book_no) No:@endif{{ $bankDetails->book_no }}({{ $account }})
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @elseif($expense->expense_id == 'staff_salary')
                                                                    @php
                                                                        $staffDetails = DB::table('staffs')
                                                                            ->where('id', $expense->staff)
                                                                            ->first();
                                                                        if ($expense->accounts == 'LEDGER') {
                                                                            $exp_account = 'L';
                                                                        } elseif ($expense->accounts == 'ACCOUNT') {
                                                                            $exp_account = 'A';
                                                                        } elseif ($expense->accounts == 'CASH') {
                                                                            $exp_account = 'C';
                                                                        }

                                                                        if ($expense->accounts == 'Salary Advance') {
                                                                            $description = 'ADV';
                                                                        } else {
                                                                            $description = 'SALARY';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $staffDetails->staff_name }}-{{ @$description }}({{ $exp_account }})
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @elseif($expense->expense_id == 'staff_incentive')
                                                                    @php
                                                                        $staffDetails = DB::table('staffs')
                                                                            ->where('id', $expense->staff)
                                                                            ->first();
                                                                        if ($expense->accounts == 'LEDGER') {
                                                                            $exp_account = 'L';
                                                                        } elseif ($expense->accounts == 'ACCOUNT') {
                                                                            $exp_account = 'A';
                                                                        } elseif ($expense->accounts == 'CASH') {
                                                                            $exp_account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $staffDetails->staff_name }}({{ $exp_account }})
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @else
                                                                    @php
                                                                        $expense_details = DB::table('expenses')
                                                                            ->where('id', $expense->expense_id)
                                                                            ->first();
                                                                        if ($expense->accounts == 'LEDGER') {
                                                                            $exp_account = 'L';
                                                                        } elseif ($expense->accounts == 'ACCOUNT') {
                                                                            $exp_account = 'A';
                                                                        } elseif ($expense->accounts == 'CASH') {
                                                                            $exp_account = 'C';
                                                                        }
                                                                    @endphp
                                                                    <td>{{ $expense_details->expense_name }}({{ $exp_account }})
                                                                    </td>
                                                                    <td>{{ $expense->amount }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th class="text-danger">{{ $total_income }}</th>
                                                <th>Total</th>
                                                <th class="text-danger">{{ $total_expense }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    {{-- </div> --}}
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th colspan="3">Cash Transfer</th>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @foreach ($get_transfer as $transfer)
                                                    <tr>
                                                        <td>{{ $transfer->description }}</td>
                                                        <td>{{ $transfer->amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th colspan="3">Closing Balance</th>
                                                </tr>
                                                <tr>
                                                    <th>Cash</th>
                                                    <th>Account</th>
                                                    @if ($status == 'not_empty')
                                                        @if ($daybook_summary->closing_ledger != '')
                                                            <th>Ledger</th>
                                                        @endif
                                                    @endif
                                                </tr>
                                                @if ($status == 'empty')
                                                    <tr>
                                                        <td class="text-danger">{{ $cur_closing_balance->cash_balance ?? 0 }}
                                                        </td>
                                                        <td class="text-danger">{{ $cur_closing_balance->account_balance ?? 0 }}
                                                        </td>
                                                        {{--  <td class="text-danger">{{ $cur_closing_balance->ledger_balance }}</td>  --}}
                                                    </tr>
                                                    <input type="hidden" name="closing_cash"
                                                        value="{{ $cur_closing_balance->cash_balance ?? 0 }}">
                                                    <input type="hidden" name="closing_account"
                                                        value="{{ $cur_closing_balance->account_balance ?? 0 }}">
                                                    <input type="hidden" name="closing_ledger"
                                                        value="{{ $cur_closing_balance->ledger_balance ?? 0 }}">
                                                @elseif ($status == 'not_empty')
                                                    <tr>
                                                        <td class="text-danger">{{ $daybook_summary->closing_cash }}</td>
                                                        <td class="text-danger">{{ $daybook_summary->closing_account }}
                                                        </td>
                                                        @if ($daybook_summary->closing_ledger != '')
                                                            <td class="text-danger">{{ $daybook_summary->closing_ledger }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            @php
                                                $totalAmount = 0;
                                            @endphp
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th colspan="3">Sales</th>
                                                </tr>
                                                <tr>
                                                    <th>Inv No</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @foreach ($sales as $sale)
                                                    @php
                                                        $amount = $sale->grand_total - $sale->discount;
                                                        $totalAmount += $amount;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $sale->invoice_number }}</td>
                                                        <td>{{ substr($sale->customer_detail->name, 0, 25) }}</td>
                                                        <td>{{ $amount }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="2" class="text-right">Total</th>
                                                    <th>{{ $totalAmount }}</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    @if ($status == 'empty')
                                        <div class="mt-3">
                                            @if (\App\Models\DaybookBalance::report_date() == Carbon\carbon::parse($report_date)->format('Y-m-d'))
                                                <button class="btn btn-primary">Save</button>
                                            @endif
                                        </div>
                                    @elseif ($status == 'not_empty')
                                        <div class="mt-3">
                                            <a href="{{ route('daybook.daily_report', $daybook_summary->date) }}"
                                                target="_blank">
                                                <button type="button" class="btn btn-primary">Print</button>
                                            </a>
                                        </div>
                                    @endif
                                </form>
                            </div>

                            <div class="modal fade" id="refreshModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger">Balance Mismatch</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>The latest Daybook Balance has changed. Please refresh the page before submitting.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" onclick="location.reload()">Refresh Page</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div> <!-- End Page-content -->

    <script>
    $('#daybookForm').on('submit', function(e){
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            method: "POST",
            data: formData,
            success: function(res){
                if (res.status === 'mismatch') {
                    $('#refreshModal').modal('show');
                } else {
                    window.location.href = "{{ route('daybook.index') }}";
                }
            }
        });
    });
    </script>

@endsection
