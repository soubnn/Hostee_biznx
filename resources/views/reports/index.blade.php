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
                                        <form action="{{ route('generateMonthlyReport') }}" method="GET">
                                            <div class="row">
                                                <h6>Generate Report</h6>
                                                <br><br>
                                                <div class="col-md-3 mt-3">
                                                    <select class="select2 form-control" style="width: 100%" name="year">
                                                        <option value="">Select Year</option>
                                                        @for ($year = now()->year; $year >= 2010; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-3">
                                                    <select class="select2 form-control" style="width: 100%" name="month">
                                                        <option value="">Select Month</option>
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mt-3">
                                                    <button type="submit" class="form-control btn btn-success">
                                                        <span style="text-align: left; margin-right:3px">Generate</span>
                                                        <i class="bx bx-right-arrow-alt"></i>
                                                    </button>
                                                </div>
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





