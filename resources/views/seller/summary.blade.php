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
        "pageLength" : 100
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Summary</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <div class="row">
                            @if(count($summaries) != 0)
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
                                                <input type="hidden" name="seller" value="{{ $id }}">
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
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice No. / ID</th>
                                                <th>Credit</th>
                                                <th>Debit</th>
                                                <!--<th>Balance</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($summaries as $summary)
                                                    <tr @if($summary['type'] == "purchase") class="text-success" @else class="text-danger" @endif>
                                                        <td data-sort="">{{ Carbon\carbon::parse($summary['date'])->format('d-m-Y')}}</td>
                                                        <td>
                                                            @if ($summary['id'])
                                                                <a href="{{ route('purchase.show', $summary['id']) }}" >
                                                                    {{ $summary['invoice'] }}
                                                                </a>
                                                            @else
                                                                {{ $summary['invoice'] }}
                                                            @endif
                                                        </td>
                                                        @if($summary['type'] == "purchase")
                                                            <td>{{ $summary['amount'] }}</td>
                                                            <td></td>
                                                        @else
                                                            <td></td>
                                                            <td>{{ $summary['amount'] }}</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->




            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



@endsection
