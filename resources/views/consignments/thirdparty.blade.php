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
$(document).ready(function () {
    $('#datatable').DataTable({
        order: [[0, 'desc']],
        "pageLength": 100,
        order: [[1, 'desc']],
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
                                    <h4 class="mb-sm-0 font-size-18">View Job Cards</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">{{ $page_headline }}</h4>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Third-Party</th>
                                                    <th>Customer Name</th>
                                                    <th>Job Card No</th>
                                                    <th>Phone</th>
                                                    <th>Product</th>
                                                    <th>Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chiplevels as $chiplevel)
                                                    <tr @if($chiplevel->status == 'pending') class="text-danger" @endif>
                                                        @php
                                                            $seller = DB::table('sellers')->where('id',$chiplevel->servicer_name)->first();
                                                        @endphp
                                                        <td>
                                                            Chiplevel<br>[{{ $seller->seller_name }}]
                                                        </td>
                                                        @php
                                                            $customer = DB::table('customers')->where('id',$chiplevel->customer_name)->first();
                                                        @endphp
                                                        <td style="white-space: normal;">{{ $customer->name }}</td>
                                                        <td>{{ $chiplevel->jobcard_number }}</td>
                                                        <td>{{ $chiplevel->phone }}</td>
                                                        <td style="white-space: normal;">{{ $chiplevel->product_name }}</td>
                                                        <td>{{ $chiplevel->status }}</td>
                                                        <td><a href="{{ route( 'consignment.show',$chiplevel->id ) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($warrenties as $warrenty)
                                                    <tr @if($warrenty->status == 'pending') class="text-danger" @endif>
                                                        @php
                                                            $seller = DB::table('sellers')->where('id',$warrenty->shop_name)->first();
                                                        @endphp
                                                        <td>
                                                            warrenty<br>[{{ $seller->seller_name }}]
                                                        </td>
                                                        @php
                                                            $customer = DB::table('customers')->where('id',$warrenty->customer_name)->first();
                                                        @endphp
                                                        <td style="white-space: normal;">{{ $customer->name }}</td>
                                                        <td>{{ $warrenty->jobcard_number }}</td>
                                                        <td>{{ $warrenty->phone }}</td>
                                                        <td style="white-space: normal;">{{ $warrenty->product_name }}</td>
                                                        <td>{{ $warrenty->status }}</td>
                                                        <td><a href="{{ route( 'consignment.show',$warrenty->id ) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                                    </tr>
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
