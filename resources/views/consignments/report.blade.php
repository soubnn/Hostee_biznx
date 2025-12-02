@extends('layouts.layout')
@section('content')
<script>
    function start_limit(){
        var start_date = document.getElementById('start_date').value;

        document.getElementById('end_date').value = start_date;
        // document.getElementById('end_date').data-date-start-date = start_date;
        // $("#end_date").datepicker({

        //     format: 'dd MM yyyy',
        //     class: 'form-control',
        //     orientation: 'bottom auto',
        //     weekStart: 1,
        //     todayBtn: 0,
        //     autoclose: 0,
        //     todayHighlight: 0,
        //     startView: 2,

        // });

        // $("#end_date").datepicker('setStartDate', start_date);

    }
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Job Card Report</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Generate Report</h4>
                                        <div class="row">
                                            <form method="get" action="{{ route('jobcard_report_view') }}">
                                                <div class="col-md-4">
                                                    <div class="form-group mt-3 mb-0">
                                                        <label>Start Date</label>
                                                        <input type="text" name="start_date" id="start_date" onchange="start_limit()" class="form-control" placeholder="Select date"  data-date-format="dd MM yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mt-3 mb-0">
                                                        <label>End Date</label>
                                                        <input type="text" name="end_date" id="end_date" class="form-control" placeholder="Select date" data-date-format="dd MM yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true" required>
                                                        @error('end_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <button type="submit" class="btn btn-info" style="margin-top: 25px;">Generate Report</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->



@endsection
