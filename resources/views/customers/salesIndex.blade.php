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

        @if(session('receiptChoice'))
            if(confirm("Do you want a reciept for the payment?"))
            {
                $("#recieptForm").submit();
            }
        @endif

    });
</script>
<script>
    function whatsappInvoice(saleId) {
        var website = $("#hiddenURL_" + saleId).val();
        window.open(website, '_blank');
        document.getElementById("downloadInvoiceForm_" + saleId).submit();
    }
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
                                    <h4 class="mb-sm-0 font-size-18">View Sales</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>Grand Total</th>
                                                    <th>Paid</th>
                                                    <th>Balance</th>
                                                    <th>Days From<br>Bill</th>
                                                    <th>Actions</th>
                                                    <th>Reciept</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($sales as $sale)
                                                <tr>
                                                    <td data-sort="">
                                                        @if($sale->print_status != "cancelled")
                                                            <a href="{{ route('directSales.show', $sale->id) }}">{{ $sale->invoice_number }}</a>
                                                        @else
                                                        {{ $sale->invoice_number }}
                                                            <br><span class="text-danger">(Cancelled Invoice)</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}</td>
                                                    <td>{{$sale->amount}}</td>
                                                    <td>{{$sale->paidAmount}}</td>
                                                    <td>{{ $sale->balance }}</td>
                                                    <td>{{$sale->pending_days}} Days</td>
                                                    <td>
                                                        @if($sale->print_status != "cancelled")
                                                            <button class="btn btn-success" title="Whatsapp" onclick="whatsappInvoice({{ $sale->id }})">
                                                                <i class="bx bxl-whatsapp font-size-18"></i>
                                                            </button>
                                                            <a href="{{ route('salesInvoice', $sale->id) }}" target="_blank" class="btn btn-info btn-sm waves-effect">
                                                                <i class="mdi mdi-printer font-size-18"></i>
                                                            </a>
                                                            <button class="btn btn-warning" type="button" href="#" id="payMonet" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#payModal{{$sale->id}}" @if( $sale->balance == 0) disabled @endif title="Pay">
                                                                <i class="bx bx-rupee font-size-18"></i>
                                                            </button>
                                                            {{-- <input type="hidden" id="hiddenURL_{{ $sale->id }}" value="https://api.whatsapp.com/send/?phone=91{{ $sale->mobile_no }}&text={{ $sale->message }}"> --}}
                                                            @if (isset($sale->consolidate_bill))
                                                                <form action="{{ route('WhatsappConsolidateInvoice',$sale->id) }}" id="downloadInvoiceForm_{{ $sale->id }}">
                                                                </form>
                                                            @else
                                                                <form action="{{ route('WhatsappInvoice',$sale->id) }}" id="downloadInvoiceForm_{{ $sale->id }}">
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($sale->print_status != "cancelled")
                                                            <form action="{{ route('generateReciept') }}" method="post" target="__blank">
                                                                @csrf
                                                                <input type="hidden" name="invoiceNumber" value="{{ $sale->invoice_number }}">
                                                                <button type="submit" class="btn btn-primary" @if($sale->amount == $sale->balance ) disabled @endif><i class="bx bx-file font-size-16"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            @if(count($sales) != 0)
                                                <div class="col-md-2 mt-3">
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#single_payment_modal">Single Payment</button>
                                                </div>
                                                <!--<div class="col-md-3 mt-3">-->
                                                <!--    <form method="POST" action="{{ route('generateCompleteCustomerReport') }}">-->
                                                <!--        @csrf-->
                                                <!--        <input type="hidden" name="customer" value="{{ $sales[0]->customer_id }}">-->
                                                <!--        <button type="submit" class="btn btn-success" formtarget="_blank">Complete Report</button>-->
                                                <!--    </form>-->
                                                <!--</div>-->
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (count($sales_returns) != 0)
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Invoice #</th>
                                                            <th>Invoice Date</th>
                                                            <th>Grand Total</th>
                                                            <th>Paid</th>
                                                            <th>Balance</th>
                                                            {{-- <th>Days From<br>Bill</th> --}}
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ( $sales_returns as $sales_return )
                                                            <tr>
                                                                <td data-sort="">
                                                                    <a href="{{ route('utility.sales.credit_note',$sales_return->id) }}" target="_blank">{{ $sales_return->invoice_number }}</a>
                                                                </td>
                                                                <td>{{ $sales_return->return_date }}</td>
                                                                <td>{{ $sales_return->total }}</td>
                                                                <td>{{ $sales_return->sales_return_paidAmount }}</td>
                                                                <td>{{round($sales_return->balance_sales_return,2)}}</td>
                                                                <td>
                                                                    <button class="btn btn-success" type="button" href="#" id="returnPayMonet" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#returnPayModal{{$sales_return->id}}" @if(round($sales_return->balance_sales_return,2) == 0) disabled @endif title="Pay">
                                                                        <i class="bx bx-rupee font-size-18"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(count($sales) != 0)
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Statement</h4><br>
                                            <form method="POST" action="{{ route('generateCustomerReport') }}" autocomplete="off">
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
                                                <input type="hidden" name="customer" value="{{ $sales[0]->customer_id }}">
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
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        @foreach ( $sales_returns as $sales_return )
                            @include('customers.modals.sales_return_payment-customer')
                        @endforeach
                        @foreach($sales as $sale)
                            @include('customers.modals.payment-customer')
                        @endforeach
                        @include('customers.modals.single_payment-customer')
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <form action="{{ route('generateReciept') }}" method="post" id="recieptForm">
            @csrf
            <input type="hidden" name="invoiceNumber" value="{{ session()->get('receiptChoice') }}">
        </form>


@endsection
