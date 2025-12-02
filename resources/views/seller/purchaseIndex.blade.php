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
$(document).ready(function(){
    $("#datatable").dataTable({
        "pageLength" : 50
    });
});
</script>
<script>
    function toggleDateRange() {
        const reportType = document.getElementById('report_type').value;
        const startDateRow = document.getElementById('start_date_row');
        const endDateRow = document.getElementById('end_date_row');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        if (reportType === 'select_date_range') {
            startDateRow.style.display = 'block';
            endDateRow.style.display = 'block';
            startDateInput.required = true;
            endDateInput.required = true;
        } else {
            startDateRow.style.display = 'none';
            endDateRow.style.display = 'none';
            startDateInput.required = false;
            endDateInput.required = false;
        }
    }
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            @if(count($purchases) != 0)
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Statement</h4><br>
                                            <form method="POST" action="{{ route('generateSellerReport') }}" autocomplete="off">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="report_type">Type</label>
                                                        <select id="report_type" class="form-control select2" name="report_type" required onchange="toggleDateRange()">
                                                            <option value="current_month">Current Month</option>
                                                            <option value="current_financial_year">Current Financial Year</option>
                                                            <option value="last_financial_year">Last Financial Year</option>
                                                            <option value="complete">Complete</option>
                                                            <option value="select_date_range">Select Date Range</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3" id="start_date_row" style="display: none;">
                                                        <label>Start Date</label>
                                                        <input type="date" class="form-control" id="startDate" name="startDate">
                                                    </div>
                                                    <div class="col-md-3" id="end_date_row" style="display: none;">
                                                        <label>End Date</label>
                                                        <input type="date" class="form-control" id="endDate" name="endDate">
                                                        @error('endDate')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <input type="hidden" name="seller" value="{{ $purchases[0]->seller_details }}">
                                                <div class="row mt-4">
                                                    <div class="col-md-2">
                                                        <button class="btn btn-success" type="submit" name="type" value="PDF" formtarget="_blank">Generate Report</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-success" type="submit" name="type" value="EXCEL" formtarget="_blank">Generate Excel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- start page title -->
                                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                            <h4 class="mb-sm-0 font-size-18">View Purchases</h4>
                                        </div>
                                        <!-- end page title -->
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>No. of items</th>
                                                    <th>Grand Total</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($purchases as $purchase)
                                            <tr>
                                                <td data-sort="">{{ $purchase->invoice_no }}</td>
                                                <td>
                                                    @if ($purchase->invoice_date)
                                                    {{ Carbon\carbon::parse($purchase->invoice_date)->format('d-m-Y')}}
                                                    @endif
                                                </td>
                                                @php
                                                    $seller=DB::table('sellers')->where('id',$purchase->seller_details)->first();
                                                    $count = DB::table('purchase_items')->where('purchase_id',$purchase->id)->count();
                                                @endphp
                                                <td>{{ $count }}</td>
                                                @if ($purchase->grand_total)
                                                    @if($purchase->discount)
                                                        <td>₹{{$purchase->grand_total - $purchase->discount}}</td>
                                                    @else
                                                        <td>₹{{$purchase->grand_total}}</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                                @php
                                                    $paidAmount = DB::table('daybooks')->where('type','Expense')->where('expense_id','SALE_RETURN')->where('job',$purchase->invoice_no)->sum('amount');
                                                    if($purchase->discount)
                                                    {
                                                        $balanceAmount = ((float) $purchase->grand_total) - ((float) $purchase->discount) - ((float) $paidAmount);
                                                    }
                                                    else
                                                    {
                                                        $balanceAmount = ((float) $purchase->grand_total) - ((float) $paidAmount);
                                                    }
                                                @endphp
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('purchase.show', $purchase->id) }}" class="btn btn-light waves-effect text-success">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            @if (count($purchase_returns) != 0)
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                <h4 class="mb-sm-0 font-size-18">View Purchase Returns</h4>
                                            </div>
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice #</th>
                                                        <th>Old Invoice #</th>
                                                        <th>Returned Date</th>
                                                        <th>Seller Name</th>
                                                        <th>No. of<br>Returned Items</th>
                                                        <th>View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ( $purchase_returns as $purchase_return )
                                                        <tr>
                                                            <td data-sort="">
                                                                <a href="{{ route('utility.purchase.debit_note', $purchase_return->id) }}" target="_blank">{{ $purchase_return->invoice_number }}</a>
                                                            </td>
                                                            <td>{{ $purchase_return->old_invoice_number }}</td>
                                                            <td>{{ Carbon\carbon::parse($purchase_return->return_date)->format('d-m-Y')}}</td>
                                                            <td>{{ $purchase_return->seller }}</td>
                                                            <td>{{ $purchase_return->items }}</td>
                                                            <td>
                                                                <a href="{{ route('purchase.returned_items', $purchase_return->id) }}">
                                                                    <button type="button" class="btn btn-light waves-effect text-success">
                                                                        <i class="mdi mdi-eye font-size-18"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
@endsection
