@extends('layouts.layout')
@section('content')
<script>
    function printDiv1() {

        $('#btnPrint1').hide();


        var printContents = document.getElementById('totalBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.location.reload();

    }

</script>
            <div class="main-content" >

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

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">Job Card Report</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">From : {{ Carbon\carbon::parse($start_date)->format('d M Y') }}</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="card-title mb-4">To : {{ Carbon\carbon::parse($end_date)->format('d M Y'); }}</h4>
                                            </div>
                                            <div class="col-3 text-end">
                                                <button type="button" class="btn btn-success" id="btnPrint1" onclick="printDiv1();">
                                                    <i class="fa fa-print"></i><span style="margin-left: 10px;">Print</span>
                                                </button>
                                            </div>

                                        </div>

                                        <div class="table-responsive" id="totalBody">
                                            <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                                <thead>
                                                    <tr style="font-size: 16px;">
                                                        <th>From : {{ Carbon\carbon::parse($start_date)->format('d M Y') }}</th>
                                                        <th>To : {{ Carbon\carbon::parse($end_date)->format('d M Y'); }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">No. Of Job Cards</th>
                                                        <td colspan="6">{{ $jobcard_count }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">No. Of Product Sold</th>
                                                        <td colspan="6">{{ $sales_count }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">No. Of Services Done</th>
                                                        <td colspan="6">{{ $service_count }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">Total Service Charge</th>
                                                        <td colspan="6">₹{{ $total_service_charge }}</td>
                                                    </tr>

                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">Total Sales Amount</th>
                                                        <td colspan="6">₹{{ $total_sales_charge }}</td>
                                                    </tr>
                                                    <tr style="font-size: 14px;">
                                                        <th class="text-nowrap" scope="row">Grand Total Amount</th>
                                                        <td colspan="6">₹{{ $total_amount }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->

                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection

