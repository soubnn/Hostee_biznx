@extends('layouts.layout')
@section('content')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Work Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <tbody>
                                                <tr>
                                                    <th style="border-right: none;">Basic Information</th>
                                                    <th class="text-end" style="border-left: none;">
                                                        @if ( $work->status == 'pending' || $work->invoice == '' )
                                                            <button class="btn btn-light text-success" data-bs-toggle="modal" data-bs-target="#edit_modal">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Date</th>
                                                    <td>{{ Carbon\carbon::parse($work->date)->format('d-m-Y h:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Customer</th>
                                                    @php
                                                        $customer = DB::table('customers')->where('id',$work->customer)->first();
                                                    @endphp
                                                    <td>
                                                        @if($customer)
                                                            {{ $customer->name }}
                                                        @else
                                                            {{ $work->customer }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Phone</th>
                                                    <td>{{ $work->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Place</th>
                                                    <td>{{ $work->place }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Work</th>
                                                    <td>{{ $work->work }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Add By</th>
                                                    <td>{{ $work->add_by }}</td>
                                                </tr>
                                                @if ($work->delivered_staff)
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">
                                                            @if ($work->status == 'canceled')
                                                                Canceled
                                                            @else
                                                                Delivered
                                                            @endif
                                                        </th>
                                                        <td>
                                                            <strong>{{ $work->delivered_staff }}</strong>
                                                            @if ($work->delivered_date)
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($work->delivered_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    @php
                                                        $estimate_details = DB::table('estimates')->where('id',$work->estimate)->first();
                                                    @endphp
                                                    <th class="text-nowrap" scope="row">Estimate</th>
                                                    @if ($work->estimate == '')
                                                        <td>No Document</td>
                                                    @else
                                                        <td><a href="{{ route('estimate_report',$work->estimate) }}">{{ $estimate_details->id }},[ {{ $estimate_details->customer_name }} ]</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Invoice</th>
                                                    <td>
                                                        @if ($work->invoice)
                                                            @if ($work->invoice_date)
                                                                <strong>{{ $work->invoice_add_by }}</strong>
                                                                <span class="text-muted">
                                                                    [{{ \Carbon\Carbon::parse($work->invoice_date)->format('d M Y, h:i A') }}]
                                                                </span>
                                                            @endif
                                                            <a href="{{ route('salesInvoice', $work->invoice ) }}">
                                                                {{ $work->sales_detail->invoice_number }},
                                                                Amount - {{ $work->sales_detail->grand_total - $work->sales_detail->discount }}
                                                                ({{ \Carbon\Carbon::parse($work->sales_detail->sales_date)->format('d-m-Y') }})
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @php
                                        $purchase = DB::table('field_purchases')->where('field_id',$work->id)->get();
                                    @endphp
                                    @if ($purchase)
                                        <div class="row mt-5">
                                            <div class="col-12">
                                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                    <h4 class="mb-sm-0 font-size-18">Purchase Details</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-nowrap" scope="row">Date</th>
                                                        <th class="text-nowrap" scope="row">Product</th>
                                                        <th class="text-nowrap" scope="row">Seller</th>
                                                        <th class="text-nowrap" scope="row">Bill Amount</th>
                                                        <th class="text-nowrap" scope="row">Qty</th>
                                                        <th class="text-nowrap" scope="row">Bill</th>
                                                        <th class="text-nowrap" scope="row">Add By</th>
                                                        <th class="text-nowrap" scope="row">Edit</th>
                                                    </tr>
                                                    @foreach ( $purchase as $purchase )
                                                        <tr>
                                                            <td>{{ $purchase->date }}</td>
                                                            <td style="white-space: normal;">{{ $purchase->product }}</td>
                                                            <td>{{ $purchase->seller }}</td>
                                                            <td>{{ $purchase->amount }}</td>
                                                            <td>{{ $purchase->qty }}</td>
                                                            <td>
                                                                @if($purchase->bill == '')
                                                                    No Document
                                                                @else
                                                                    <a href="{{ asset('storage/field/'.$purchase->bill) }}" target="_blank">
                                                                        purchase bill
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($purchase->add_by)
                                                                    <strong>{{ $purchase->add_by }}</strong>
                                                                    <span class="text-muted">
                                                                        [{{ \Carbon\Carbon::parse($purchase->add_date)->format('d M Y, h:i A') }}]
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-light text-success" data-bs-toggle="modal" data-bs-target="#purchase_edit_modal{{ $purchase->id }}">
                                                                    <i class="bx bx-pencil"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Purchase Edit Modal -->
                                                        <div id="purchase_edit_modal{{ $purchase->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title add-task-title">Edit Purchases</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('field.update_purchase',$purchase->id) }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                            <div class="row mb-4">
                                                                                <label for="projectname" class="col-form-label col-lg-2">Date</label>
                                                                                <div class="col-lg-10">
                                                                                    <input type="date" name="date" class="form-control" value="{{ Carbon\carbon::parse($purchase->date)->format('Y-m-d')}}" >
                                                                                    @error('date')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <label for="projectname" class="col-form-label col-lg-2">Product</label>
                                                                                <div class="col-lg-10">
                                                                                    <textarea name="product" class="form-control" rows="3" onkeyup="this.value = this.value.toUpperCase()">{{ $purchase->product }}</textarea>
                                                                                    @error('product')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <label for="projectname" class="col-form-label col-lg-2">Purchase From</label>
                                                                                <div class="col-lg-10">
                                                                                    <input type="text" name="seller" class="form-control" value="{{ $purchase->seller }}">
                                                                                    @error('seller')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <label for="projectdesc" class="col-form-label col-lg-2">Bill Amount</label>
                                                                                <div class="col-lg-10">
                                                                                    <input type="number" class="form-control" name="amount" value="{{ $purchase->amount }}">
                                                                                    @error('amount')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <label class="col-form-label col-lg-2">qty</label>
                                                                                <div class="col-lg-10">
                                                                                    <input type="number" class="form-control" name="qty" value="{{ $purchase->qty }}">
                                                                                    @error('qty')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <label for="projectbudget" class="col-form-label col-lg-2">Bill</label>
                                                                                <div class="col-lg-10">
                                                                                    <input class="form-control" name="bill" type="file">
                                                                                    @error('bill')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary" id="addtask">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    @if($work->status == 'pending')
                                        <div class="button-items mt-4" style="float:right;">
                                            <button type="button" class="btn btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#purchase_modal">
                                                <i class="bx bx-file font-size-16 align-middle me-2"></i> Add Purchases
                                            </button>
                                            {{--  <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#invoice_modal">
                                                <i class="bx bx-file font-size-16 align-middle me-2"></i> Add Invoice
                                            </button>  --}}
                                            @if ($work->invoice)
                                                <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#invoice_modal">
                                                    <i class="bx bx-file font-size-16 align-middle me-2"></i> Edit Invoice
                                                </button>
                                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#deliver_modal">
                                                    <i class="bx bx-check-double font-size-16 align-middle me-2"></i> Deliver
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#invoice_modal">
                                                    <i class="bx bx-file font-size-16 align-middle me-2"></i> Add Invoice
                                                </button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#cancel_modal">
                                                    <i class="bx bx-trash font-size-16 align-middle me-2"></i> Cancel
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                    <!-- Purchase Modal -->
                                    <div id="purchase_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title add-task-title">Add Purchases</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('field.store_purchase',$work->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="row mb-4">
                                                            <label for="projectname" class="col-form-label col-lg-2">Date</label>
                                                            <div class="col-lg-10">
                                                                <input type="date" name="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d')}}" >
                                                                @error('date')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label for="projectname" class="col-form-label col-lg-2">Product</label>
                                                            <div class="col-lg-10">
                                                                <textarea name="product" class="form-control" rows="3" onkeyup="this.value = this.value.toUpperCase()">{{ old('product') }}</textarea>
                                                                @error('product')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label for="projectname" class="col-form-label col-lg-2">Purchase From</label>
                                                            <div class="col-lg-10">
                                                                <input type="text" name="seller" class="form-control" value="{{ old('seller') }}">
                                                                @error('seller_details')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label for="projectdesc" class="col-form-label col-lg-2">Bill Amount</label>
                                                            <div class="col-lg-10">
                                                                <input type="number" class="form-control" name="amount" value="{{ old('amount') }}">
                                                                @error('amount')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label class="col-form-label col-lg-2">qty</label>
                                                            <div class="col-lg-10">
                                                                <input type="number" class="form-control" name="qty" value="{{ old('qty') }}">
                                                                @error('qty')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label for="projectbudget" class="col-form-label col-lg-2">Bill</label>
                                                            <div class="col-lg-10">
                                                                <input class="form-control" name="bill" type="file">
                                                                @error('bill')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-end">
                                                                <button type="submit" class="btn btn-primary" id="addtask">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!-- Deliver Modal -->
                                    <div id="deliver_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form method="Post" action="{{ route('field.deliver',$work->id ) }}">
                                                    @csrf
                                                        <div class="form-group mb-3">
                                                            <div class="col-lg-12 text-center">
                                                                <i class="dripicons-checkmark text-success" style="font-size: 50px;"></i>
                                                                <h4>Are You Sure ??</h4>
                                                                <p style="font-weight: 300px;font-size:18px;">Complete the field work...</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-end">
                                                                <button type="submit" class="btn btn-info" id="addtask">Yes, confirm</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    @include('field.modals.edit-fields')
                    @include('field.modals.add-invoice')
                    @include('field.modals.cancel-work')
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

@endsection
