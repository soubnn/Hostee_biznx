@extends('layouts.layout')
@section('content')
<script>
    $(function() {
        $("input[type='text']").keyup(function() {
            this.value = this.value.toUpperCase();
        });
        $('textarea').keyup(function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Investor</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered nowrap w-100">
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                </tr>
                                <tr>
                                    <td>{{ $investor->name }}</td>
                                    <td>{{ $investor->designation }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <th>Balance</th>
                                </tr>
                                <tr>
                                    <td>{{ $investor->phone_number }}</td>
                                    <td style="color: {{ $netAmount <= 0 ? 'red' : 'green' }};">{{ $netAmount }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <button class="btn btn-success" type="button" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#investment">Investment <i class="bx bx-rupee"></i></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#withdrawal">Withdrawal <i class="bx bx-money-withdraw"></i></button>
                                    </td>
                                </tr>
                            </table>
                            <h4>Statement</h4><br>
                            <form method="POST" action="{{ route('generateInvestorReport') }}" autocomplete="off">
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
                                <input type="hidden" name="investor" value="{{ $investor->id }}">
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
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
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
                                    @foreach($investments as $investment)
                                        @php
                                            $rowClass = $investment->income_id === 'INVESTOR_INVESTMENT' ? 'table-success' : ($investment->expense_id === 'INVESTOR_WITHDRAWAL' ? 'table-danger' : '');
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td data-sort="" style="white-space:normal;">{{ $investment->date }}</td>
                                            <td style="white-space:normal;">{{ $investment->description }}</td>
                                            <td style="white-space:normal;">{{ $investment->accounts }}</td>
                                            @if($investment->expense_id == 'INVESTOR_WITHDRAWAL')
                                                <td style="white-space:normal;"></td>
                                                <td style="white-space:normal;">{{ $investment->amount }}</td>
                                            @else
                                                <td style="white-space:normal;">{{ $investment->amount }}</td>
                                                <td style="white-space:normal;"></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End col -->
            </div> <!-- End row -->
            @include('investment.modals.investment-modal')
            @include('investment.modals.withdrawal-modal')
        </div> <!-- End container-fluid -->
    </div> <!-- End Page-content -->
</div>
<script>
    function toggleDateRange() {
        let reportType = document.getElementById('report_type').value;
        let startDateRow = document.getElementById('start_date_row');
        let endDateRow = document.getElementById('end_date_row');

        if (reportType === 'select_date_range') {
            startDateRow.style.display = 'block';
            endDateRow.style.display = 'block';
        } else {
            startDateRow.style.display = 'none';
            endDateRow.style.display = 'none';
        }
    }
</script>
@endsection
