@extends('utility.layout')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Purchase Management</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" class="mb-3">
                                    <label for="year" class="me-2">Select Year:</label>
                                    <select name="year" id="year" onchange="this.form.submit()"
                                        class="form-select w-auto d-inline-block">
                                        @for ($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                {{ $y }}</option>
                                        @endfor
                                    </select>
                                </form>
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100"
                                    style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>Seller Name</th>
                                            <th>No. of Items</th>
                                            <th>View</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        {{-- @php
                                            $purchases = DB::table('purchases')->get();
                                        @endphp
                                        @foreach ($purchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->invoice_no }}</td>
                                                <td>
                                                    @if ($purchase->invoice_date)
                                                        {{ Carbon\carbon::parse($purchase->invoice_date)->format('d-m-Y') }}
                                                    @endif
                                                </td>
                                                @php
                                                    $seller = DB::table('sellers')
                                                        ->where('id', $purchase->seller_details)
                                                        ->first();
                                                @endphp
                                                <td>{{ $seller->seller_name }}</td>
                                                @php
                                                    $purchaseCount = DB::table('purchase_items')
                                                        ->where('purchase_id', $purchase->id)
                                                        ->count();
                                                @endphp
                                                <td>{{ $purchaseCount }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('util_purchase_details', $purchase->id) }}"
                                                            class="btn btn-light waves-effect text-success">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-light waves-effect text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_{{ $purchase->id }}">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </div>
                                                </td> --}}
                                        @foreach ($purchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->invoice_no }}</td>
                                                <td>
                                                    @if ($purchase->invoice_date)
                                                        {{ Carbon\Carbon::parse($purchase->invoice_date)->format('d-m-Y') }}
                                                    @endif
                                                </td>
                                                <td>{{ $purchase->seller_name }}</td>
                                                <td>{{ $purchase->item_count }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('util_purchase_details', $purchase->id) }}"
                                                            class="btn btn-light waves-effect text-success">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-light waves-effect text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_{{ $purchase->id }}">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <div id="edit_{{ $purchase->id }}" class="modal fade bs-example-modal-lg"
                                                    tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title">Edit Purchase</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form"
                                                                    action="{{ route('purchase.update', $purchase->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group mb-3">
                                                                        <label for="invoice_date"
                                                                            class="col-form-label">Inovice
                                                                            Date</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="invoice_date" name="invoice_date"
                                                                                type="date" class="form-control"
                                                                                Value="{{ $purchase->invoice_date }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskname" class="col-form-label">Inovice
                                                                            No</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="taskname" name="invoice_no"
                                                                                type="text" class="form-control"
                                                                                Value="{{ $purchase->invoice_no }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="phone2" class="col-form-label">Invoice
                                                                            Image</label>
                                                                        <div class="col-lg-12">
                                                                            <input type="file" name="purchase_bill"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary"
                                                                                id="addtask"
                                                                                onclick="this.disabled=true;this.innerHTML='Updating...';this.form.submit();">Update
                                                                                Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $purchases->appends(['year' => $year])->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
@endsection
