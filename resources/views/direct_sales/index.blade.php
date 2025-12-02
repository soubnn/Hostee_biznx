@extends('layouts.layout')
@section('content')
    <script>
        $(document).ready(function(){
            $("#datatable").dataTable({
                "pageLength" : 50
            });
        });
    </script>
        <script>
            function whatsappInvoice(saleId) {
                var website = $("#hiddenURL_" + saleId).val();
                window.open(website, '_blank');
                document.getElementById("downloadInvoiceForm_" + saleId).submit();
            }
        </script>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Sales</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Generate GST Sales Report</h4>
                                        <br>
                                        <form action="{{ route('generateSalesGSTReport') }}" method="get">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Start Date</label>
                                                    <input type="date" class="form-control" required name="startDate">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>End Date</label>
                                                    <input type="date" class="form-control" required name="endDate">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Include Service?</label>
                                                    <select class="form-control select2" name="service">
                                                        <option value="YES" selected>Yes</option>
                                                        <option value="NO">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success mt-4" value="PDF" name="output">Generate PDF</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success mt-4" value="EXCEL" name="output">Generate Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice #</th>
                                                    <th>Customer</th>
                                                    <th>Sales Person</th>
                                                    <th>No. of Items</th>
                                                    <th>Total Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sales as $sale)
                                                    <tr>
                                                        <td data-sort="" style="white-space:normal;">
                                                            {{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}
                                                        </td>
                                                        <td style="white-space:normal;">
                                                            @if ( $sale->payment_status == 'cancelled' )
                                                                {{ $sale->invoice_number }}
                                                                <span class="text-danger">(Cancelled)</span>
                                                            @else
                                                                <a href="{{ route('directSales.show', $sale->id) }}">
                                                                    {{ $sale->invoice_number }}
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td style="white-space:normal;">{{ $sale->customer_detail->name }}</td>
                                                        <td style="white-space:normal;">{{$sale->staff_detail->staff_name}}</td>
                                                        <td style="white-space:normal;">{{$sale->salesCount}}</td>
                                                        <td style="white-space:normal;">{{$sale->total_amount}}</td>
                                                        <td style="white-space:normal;">
                                                            @if ( $sale->payment_status != 'cancelled' )
                                                                <div class="d-flex gap-3">
                                                                    <a href="{{ route('directSales.show', $sale->id) }}" class="btn btn-light btn-sm waves-effect text-primary">
                                                                        <i class="mdi mdi-eye font-size-18"></i>
                                                                    </a>
                                                                    @if (isset($sale->consolidate_bill))
                                                                        <a href="{{ route('consolidates_invoice', $sale->id) }}" target="_blank" class="btn btn-light btn-sm waves-effect text-primary">
                                                                            <i class="mdi mdi-printer font-size-18"></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('salesInvoice', $sale->id) }}" target="_blank" class="btn btn-light btn-sm waves-effect text-primary">
                                                                            <i class="mdi mdi-printer font-size-18"></i>
                                                                        </a>
                                                                    @endif
                                                                    <a href="#!">
                                                                        <button class="btn btn-light btn-sm text-success" onclick="window.location.href='{{ route('WhatsappInvoice', $sale->id) }}'">
                                                                            <i class="mdi mdi-whatsapp font-size-18"></i>
                                                                        </button>
                                                                    </a>
                                                                    {{-- <a href="#!">
                                                                        <button class="btn btn-light btn-sm waves-effect text-success" title="Whatsapp"  onclick="whatsappInvoice({{ $sale->id }})">
                                                                            <i class="mdi mdi-whatsapp font-size-18"></i>
                                                                        </button>
                                                                    </a> --}}
                                                                </div>
                                                                <input type="hidden" id="hiddenURL_{{ $sale->id }}" value="https://api.whatsapp.com/send/?phone=91{{ $sale->customer_detail->mobile }}&text={{ $sale->message }}">
                                                                @if (isset($sale->consolidate_bill))
                                                                    <form action="{{ route('WhatsappConsolidateInvoice',$sale->id) }}" id="downloadInvoiceForm_{{ $sale->id }}">
                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('WhatsappInvoice',$sale->id) }}" id="downloadInvoiceForm_{{ $sale->id }}">
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
            </div>

            @if(session('whatsapp_sent'))
            <script>
                var whatsappModal = new bootstrap.Modal(document.getElementById('whatsappSuccessModal'));
                whatsappModal.show();
            </script>
            @endif

@endsection
