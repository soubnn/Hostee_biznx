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
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Invoice</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Invoice</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th>Phone</th>
                                                    <th>Added On</th>
                                                    <th>GST</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($invoices as $invoice)
                                                    <tr>
                                                        <td style="white-space: normal;" data-sort="">{{ $invoice->invoice_number }}</td>
                                                        <td style="white-space: normal;">
                                                            <a href="{{ route('generate_invoice',$invoice->id) }}" target="_blank">
                                                                {{ $invoice->customer_name }}
                                                            </a>
                                                        </td>
                                                        <td style="white-space: normal;">{{ $invoice->customer_phone }}</td>
                                                        <td style="white-space: normal;">{{  Carbon\carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
                                                        <td style="white-space: normal;">{{ $invoice->gst_available }}</td>
                                                        {{-- <td>

                                                            <a href="{{ route('generate_invoice',$invoice->id) }}">
                                                                <button class="btn btn-light text-primary">
                                                                    <i class="mdi mdi-printer"></i>
                                                                </button>
                                                            </a>
                                                        </td> --}}
                                                    </tr>
                                                    {{-- enable modal start --}}
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
