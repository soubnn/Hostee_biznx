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
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Monthly Report</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('reports.generate_monthly_summary') }}" method="GET" target="_blank">
                                            <h4 class="card-title mb-4">Month-Wise Report</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Select Month & Year</label>
                                                    <div class="position-relative" id="datepicker4">
                                                        <input type="text" id="summary_date" name="summary_date" class="form-control" data-date-container='#datepicker4' data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1" data-date-start-view="2" value="{{ Carbon\carbon::now()->format('F Y') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3" style="margin-bottom: 100px;">
                                                <button type="submit" class="btn btn-primary">Generate Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @endsection





