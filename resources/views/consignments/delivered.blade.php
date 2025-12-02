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
                                    <h4 class="mb-sm-0 font-size-18">View Job Cards</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Delivered Job Cards</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Job Card No</th>
                                                <th>Customer Name</th>
                                                <!--<th>Date</th>-->
                                                <th>Phone</th>
                                                <th>Service Type</th>
                                                <th>Product</th>
                                                <th>View</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($consignments as $consignment)
                                                <tr>
                                                    <td data-sort="">{{ $consignment->jobcard_number }}</td>
                                                    @php
                                                        $customer = DB::table('customers')->where('id',$consignment->customer_name)->first();
                                                    @endphp
                                                    @php
                                                    $customer_name_length = strlen($customer->name);
                                                    @endphp
                                                    @if ($customer_name_length > 30 && $customer_name_length < 60)
                                                        @php
                                                            $customer_name1 = substr($customer->name,0,30);
                                                            $customer_name2 = substr($customer->name,30);
                                                        @endphp
                                                            <td>{{ $customer_name1 }}<br>{{ $customer_name2 }}</td>
                                                    @elseif($customer_name_length > 60)
                                                        @php
                                                            $customer_name1 = substr($customer->name,0,30);
                                                            $customer_name2 = substr($customer->name,30,30);
                                                            $customer_name3 = substr($customer->name,60);
                                                        @endphp
                                                            <td>{{ $customer_name1 }}<br>{{ $customer_name2 }}<br>{{ $customer_name3 }}</td>
                                                    @else
                                                        <td>{{ $customer->name }}</td>
                                                    @endif
                                                    <!--<td>{{  Carbon\carbon::parse($consignment->date)->format('d M Y') }}</td>-->
                                                    <td>{{ $consignment->phone }}</td>
                                                    <td>{{ $consignment->service_type }}</td>
                                                    @php
                                                    $name_length = strlen($consignment->product_name);
                                                    @endphp
                                                    @if ($name_length > 30 && $name_length < 60)
                                                        @php
                                                            $product_name1 = substr($consignment->product_name,0,30);
                                                            $product_name2 = substr($consignment->product_name,30);
                                                        @endphp
                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                    @elseif($name_length > 60)
                                                        @php
                                                            $product_name1 = substr($consignment->product_name,0,30);
                                                            $product_name2 = substr($consignment->product_name,30,30);
                                                            $product_name3 = substr($consignment->product_name,60);
                                                        @endphp
                                                            <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                    @else
                                                    <td>{{ $consignment->product_name }}</td>
                                                    @endif
                                                    <td><a href="{{ route( 'consignment.show',$consignment->id ) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
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
