@extends('utility.layout')
@section('content')
<script>
    $(document).ready(function(){
        $("#datatable").dataTable({
            "pageLength" : 100,
            "bPaginate" : false
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
                            <h4 class="mb-sm-0 font-size-18">Sales Management</h4>
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
                                    <select name="year" id="year" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                                        @for ($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ (isset($year) && $year == $y) ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </form>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Invoice Date</th>
                                        <th>Customer Name</th>
                                        <th>No. of Items</th>
                                        <th>Amount</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td style="white-space:normal;" data-sort="">
                                                    <a href="{{ route('util_sales_details', $sale->id) }}">{{ $sale->invoice_number }}</a>
                                                </td>
                                                <td style="white-space:normal;">
                                                    @if ($sale->sales_date)
                                                        {{ Carbon\Carbon::parse($sale->sales_date)->format('d-m-Y') }}
                                                    @endif
                                                </td>
                                                <td style="white-space:normal;">{{ $sale->customer_name ?? 'N/A' }}</td>
                                                @php
                                                    $purchaseCount = $sale->item_count ?? 0;
                                                    $amount = $sale->discount ? ((float)$sale->grand_total - (float)$sale->discount) : (float)$sale->grand_total;
                                                @endphp
                                                <td style="white-space:normal;">{{ $purchaseCount }}</td>
                                                <td style="white-space:normal;">{{ number_format($amount, 2, '.', '') }}</td>
                                                <td>
                                                    @if($purchaseCount > 0)
                                                        <a class="btn btn-light waves-effect text-success" href="{{ route('util_sales_details.cancel', $sale->id) }}">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-light waves-effect text-success" disabled>
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {!! $sales->appends(request()->query())->links() !!}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@endsection
