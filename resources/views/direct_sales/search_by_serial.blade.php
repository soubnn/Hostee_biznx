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
                            <h4 class="mb-sm-0 font-size-18">Search By Serial</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="get" action="{{ route('search_by_serial_sale') }}">
                                    <h4 class="card-title mb-4">Search serial</h4>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Select serial</label>
                                            <select class="form-control select2" id="serial_select" name="sales_id">
                                                <option selected disabled value="">Select Serial</option>
                                                @foreach($serial_numbers as $serial)
                                                    <option value="{{ $serial->sales_id }}">{{ $serial->serial_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
                @if ($sale)
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                        <thead>
                                            <tr>
                                                <th>Invoice Date</th>
                                                <th>Invoice #</th>
                                                <th>Customer</th>
                                                <th>Place</th>
                                                <th>Sales Person</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td data-sort="" style="white-space:normal;">
                                                    {{ Carbon\carbon::parse($sale->sales_date)->format('d-m-Y')}}
                                                </td>
                                                <td style="white-space:normal;">
                                                    <a href="{{ route('directSales.show', $sale->id) }}">
                                                        {{ $sale->invoice_number }}
                                                    </a>
                                                </td>
                                                <td style="white-space:normal;">{{ $sale->customer_detail->name }}</td>
                                                <td style="white-space:normal;">{{$sale->customer_detail->place}}</td>
                                                <td style="white-space:normal;">{{$sale->staff_detail->staff_name}}</td>
                                                <td style="white-space:normal;">
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('directSales.show', $sale->id) }}" class="btn btn-light btn-sm waves-effect text-primary">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                @endif
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>



@endsection
