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
        function whatsappInvoice() {
            var website = $("#hiddenURL").val();
            window.open(website, '_blank');
            document.getElementById("downloadInvoiceForm").submit();
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
                                <div class="row">
                                    <div class="col mb-2 text-end">
                                        <a href="{{ route('direct_sales.consolidate', $salesItems[0]->sales_id) }}">
                                            <button type="button" class="btn btn-success waves-effect waves-light me-1"
                                                id="btnPrint">
                                                <span class="me-2" style="font-weight:500;">Consolidate Invoice</span><i
                                                    class="fa fa-receipt"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label>Invoice Number</label>
                                        <input type="text" value="{{ $salesDetails->invoice_number }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Sales Date</label>
                                        <input type="text"
                                            value="{{ carbon\Carbon::parse($salesDetails->sales_date)->format('d-m-Y') }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Customer</label>
                                        <input type="text"
                                            value="{{ $salesDetails->customer_detail->name }}, {{ $salesDetails->customer_detail->place }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Sales Person</label>
                                        <input type="text" value="{{ $salesDetails->staff_detail->staff_name }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Total</label>
                                        <input type="text" value="{{ $salesDetails->grand_total }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Discount</label>
                                        <input type="number" value="{{ $salesDetails->discount ?? '0.00' }}" class="form-control"
                                            disabled>
                                    </div>
                                    @php
                                        $total = $salesDetails->grand_total - $salesDetails->discount;
                                    @endphp
                                    <div class="col-md-3 mb-3">
                                        <label>Grand Total</label>
                                        <input type="number" value="{{ $total }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100"
                                    style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>GST Percentage</th>
                                            <th>Sales Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($salesItems as $item)
                                            <tr>
                                                <td style="white-space:normal">{{ $item->product_name }}</td>
                                                <td style="white-space:normal">
                                                    {{ $item->product_detail->category_details->category_name }}</td>
                                                <td style="white-space:normal">₹ {{ $item->unit_price }}</td>
                                                <td style="white-space:normal">{{ $item->product_quantity }}</td>
                                                <td style="white-space:normal">{{ $item->gst_percent }} %</td>
                                                <td style="white-space:normal">₹ {{ $item->sales_price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br>
                                @if ($salesCount > 0)
                                    <div class="row">
                                        @if (isset($consolidate_bill))
                                            <div class="col-md-2 mt-3">
                                                <a href="{{ route('consolidates_invoice', $salesItems[0]->sales_id) }}"
                                                    target="_blank"><button type="button"
                                                        class="btn btn-success waves-effect waves-light me-1"
                                                        id="btnPrint"><i class="fa fa-print"></i>
                                                        <span style="font-weight:500;">Print Consolidate</span>
                                                    </button></a>
                                            </div>
                                        @endif
                                        <div class="col-md-2 mt-3">
                                            <a href="{{ route('salesInvoice', $salesItems[0]->sales_id) }}"
                                                target="_blank"><button type="button"
                                                    class="btn btn-success waves-effect waves-light me-1" id="btnPrint"><i
                                                        class="fa fa-print"></i>
                                                    <span style="font-weight:500;">Print Invoice</span>
                                                </button></a>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light me-1"
                                                onclick="window.location.href='{{ route('WhatsappInvoice', $salesDetails->id) }}'"><i
                                                    class="bx bxl-whatsapp"></i>
                                                <span style="font-weight:500;">Whatsapp</span>
                                            </button>
                                        </div>
                                        {{-- <div class="col-md-2 mt-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light me-1" onclick="whatsappInvoice()"><i class="bx bxl-whatsapp"></i>
                                                <span style="font-weight:500;">Whatsapp</span>
                                            </button>
                                        </div> --}}
                                        {{-- <div class="col-md-2 mt-3">
                                            <a href="{{ route('sendInvoiceSMS', $salesDetails->id) }}">
                                                <button type="button"
                                                    class="btn btn-success waves-effect waves-light me-1"><i
                                                        class="fa fa-comment"></i>
                                                    <span style="font-weight:500;">SMS</span>
                                                </button>
                                            </a>
                                        </div> --}}
                                    </div>
                                    <input type="hidden" id="hiddenURL" value="{{ $url }}">
                                    @if (isset($consolidate_bill))
                                        <form action="{{ route('WhatsappConsolidateInvoice', $salesDetails->id) }}"
                                            id="downloadInvoiceForm">
                                        </form>
                                    @else
                                        <form action="{{ route('WhatsappInvoice', $salesDetails->id) }}"
                                            id="downloadInvoiceForm">
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="modal fade" id="whatsappSuccessModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                    <h5 class="modal-title text-success">Message Sent</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>The invoice has been sent to customer's WhatsApp successfully.</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

    @if (session('whatsapp_sent'))
        <script>
            var whatsappModal = new bootstrap.Modal(document.getElementById('whatsappSuccessModal'));
            whatsappModal.show();
        </script>
    @endif

@endsection
