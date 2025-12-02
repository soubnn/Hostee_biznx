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
    function show_period(type){
        if(type == 'month_wise'){
            $('#date_div').css("display","none");
            $('#month_div').css("display","block");
        }
        else if(type == 'date_wise'){
            $('#month_div').css("display","none");
            $('#date_div').css("display","block");
        }
        else{
            $('#month_div').css("display","none");
            $('#date_div').css("display","none");
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
                                    <h4 class="mb-sm-0 font-size-18">Profit Summary</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('reports.generate_profit_summary') }}" method="get" target="_blank">
                                            <div class="row">
                                                <h6>Generate Report</h6>
                                                <div class="col-md-12 mt-3">
                                                    <div class="mb-3">
                                                        <label for="">Select Period Type</label>
                                                        <select class="select2 form-control" onchange="show_period(this.value)" style="width:30%;">
                                                            <option selected disabled>Select</option>
                                                            <option value="month_wise">Month Wise</option>
                                                            <option value="date_wise">Date Wise</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="month_div" style="display: none;">
                                                    <div class="mb-3">
                                                        <label for="">Select Month & Year</label>
                                                        <div class="position-relative" id="datepicker4">
                                                            <input type="text" id="summary_date" name="summary_date" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-start-view="2" value="{{ Carbon\carbon::now()->format('F Y') }}" style="width:30%;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="date_div1" style="display: none;">
                                                    <div class="mb-3">
                                                        <label for="">Start Date</label>
                                                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}" style="width:50%;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="date_div2" style="display: none;">
                                                    <div class="mb-3">
                                                        <label for="">End Date</label>
                                                        <div class="position-relative" id="datepicker4">
                                                            <input type="text" id="end_date" name="end_date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}" style="width:50%;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="button_div" style="margin-bottom: 100px;">
                                                    <button type="submit" class="form-control btn btn-success">
                                                        <span style="text-align: left; margin-right:3px">Generate Report</span>
                                                        <i class="bx bx-right-arrow-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Period Type</label>
                                                <select class="select2 form-control" onchange="show_period(this.value)">
                                                    <option selected disabled>Select</option>
                                                    <option value="month_wise">Month Wise</option>
                                                    <option value="date_wise">Date Wise</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3" id="month_div" style="display: none;margin-bottom:100px;">
                                            <form action="{{ route('reports.month.generate_profit_summary') }}" method="get" target="_blank">
                                                <h4 class="card-title mb-4">Month-Wise Report</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Select Month & Year</label>
                                                        <div class="position-relative" id="datepicker4">
                                                            <input type="text" id="summary_date" name="summary_date" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-start-view="2" value="{{ Carbon\carbon::now()->format('F Y') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="mt-3" id="date_div" style="display: none;">
                                            <form method="get" action="{{ route('reports.date.generate_profit_summary') }}" target="_blank">
                                                @csrf
                                                <h4 class="card-title mb-4">Date-Wise Report</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Start Date</label>
                                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>End Date</label>
                                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                                        @error('end_date')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @endsection





