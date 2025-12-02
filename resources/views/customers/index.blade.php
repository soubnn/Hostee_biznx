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
        $(document).ready(function() {
            $('#datatable').DataTable({
                "pageLength": 50,
            });
        });
    </script>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View Customers</h4>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Customers</h4>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
                                    Add New
                                </button>
                                <br><br>
                                <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Place</th>
                                            <th>Balance</th>
                                            <th>Days From<br>Bill</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td style="white-space: normal;">{{ $customer->name }}</td>
                                                <td>{{ $customer->mobile }}</td>
                                                <td>{{ $customer->place }}</td>
                                                <td>{{ $customer->sales_balance }}</td>
                                                <td>{{ $customer->pending_days }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-success" @if ($customer->balance > 0) target="_blank" href="https://api.whatsapp.com/send/?phone=91{{ $customer->mobile }}&text={{ $customer->message }}" @else href="#" @endif>
                                                        <i class="bx bxl-whatsapp"></i>
                                                    </a> --}}
                                                    <a class="btn btn-success"
                                                        @if ($customer->sales_balance > 0)
                                                            href="{{ route('customers.index', ['send' => $customer->id]) }}"
                                                        @else
                                                            href="#"
                                                        @endif>
                                                        <i class="bx bxl-whatsapp"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#edit_customer_{{ $customer->id }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    <a class="btn btn-primary" href="{{ route('getCustomerSales', $customer->id) }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
                @foreach ($customers as $customer)
                    @include('customers.modals.edit-customer')
                @endforeach
                @include('customers.modals.new-customer')
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    @endsection
