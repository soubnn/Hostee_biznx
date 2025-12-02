@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $('input').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            "pageLength": 50,
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
                                    <h4 class="mb-sm-0 font-size-18">View Credit List</h4>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <a href="{{ route('customers.export.csv') }}" class="btn btn-primary">Generate Excel</a>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Credit List</h4>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Balance</th>
                                                <!--<th>Place</th>-->
                                                <th>Payment<br>Pending Days</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $customer)
                                                    @if($customer->sales_balance > 0)
                                                        <tr>
                                                            <td style="white-space: normal;">{{ $customer->name }}</td>
                                                            <td>{{ $customer->mobile }}</td>
                                                            <td>{{ $customer->sales_balance }}</td>
                                                            <!--<td>{{ $customer->place }}</td>-->
                                                            <td>{{ $customer->pending_days }}</td>
                                                            <td>
                                                                {{-- <a @if($customer->balance > 0) target="_blank" href="https://api.whatsapp.com/send/?phone=91{{ $customer->mobile }}&text={{ $customer->message }}" @else href="#" @endif data-original-title="whatsapp" rel="tooltip" data-placement="left" data-action="share/whatsapp/share">
                                                                    <button class="btn btn-success" title="Whatsapp"><i class="bx bxl-whatsapp"></i></button>
                                                                </a> --}}
                                                                <a class="btn btn-success"
                                                                    @if ($customer->balance > 0)
                                                                        href="{{ route('customers.credit_list', ['send' => $customer->id]) }}" onclick="disableBtn(this)"
                                                                    @else
                                                                        href="#"
                                                                    @endif>
                                                                    <i class="bx bxl-whatsapp"></i>
                                                                </a>
                                                                <a href="{{ route('customers.credit_sales',$customer->id) }}"><button class="btn btn-primary" title="View sales"><i class="mdi mdi-eye"></i></button></a>
                                                            </td>
                                                        </tr>
                                                    @endif
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

                <script>
                    function disableBtn(btn) {
                        btn.disabled = true;
                        btn.innerHTML = "...";
                        setTimeout(() => {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bx bxl-whatsapp"></i>';
                        }, 30000);
                    }
                </script>

@endsection
