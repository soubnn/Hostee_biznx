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
                                        <h4 class="card-title mb-4">{{ $page_headline }}(<span style="color: rgb(247, 57, 57)">{{ $consignment_count }}</span>)</h4>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Job Card No</th>
                                                    <!--<th>Date</th>-->
                                                    <th>Phone</th>
                                                    <th>Engaged With</th>
                                                    {{-- <th>Service Type</th> --}}
                                                    <th>Product</th>
                                                    @if($page_headline == 'Approved Jobcards')
                                                        <th>Status</th>
                                                    @endif
                                                    <th>View</th>
                                                    @if($page_headline == 'Pending Jobcards' || $page_headline == 'Informed Jobcards')
                                                        <th>Approve</th>
                                                    @endif

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($consignments as $consignment)
                                                    <tr @if($consignment->status == 'pending') class="text-danger" @endif>
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
                                                        <td>{{ $consignment->jobcard_number }}</td>
                                                        <td>{{ $consignment->phone }}</td>
                                                        <td>{{ $consignment->add_by }}</td>
                                                        {{-- <td>{{ $consignment->service_type }}</td> --}}
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
                                                        @if($page_headline == 'Approved Jobcards')
                                                            @php
                                                                $get_chip = DB::table('chiplevels')->where('jobcard_id',$consignment->id)->first();
                                                            @endphp
                                                            @php
                                                                $get_warrenty = DB::table('warrenties')->where('jobcard_id',$consignment->id)->first();
                                                            @endphp
                                                            @if($get_chip)
                                                                @if($get_chip->status == 'active')
                                                                    <td>Chip Level :<br> {{ $get_chip->servicer_name }}</td>
                                                                @else
                                                                    <td>{{ $consignment->status }}</td>
                                                                @endif
                                                            @elseif($get_warrenty)
                                                                @if($get_warrenty->status == 'active')
                                                                    @php
                                                                        $get_sellers = DB::table('sellers')->where('id',$get_warrenty->shop_name)->first();
                                                                    @endphp
                                                                    <td>Warrenty :<br> {{ $get_sellers->seller_name }}</td>
                                                                @else
                                                                    <td>{{ $consignment->status }}</td>
                                                                @endif
                                                            @else
                                                                <td>{{ $consignment->status }}</td>
                                                            @endif
                                                        @endif
                                                            <td><a href="{{ route( 'consignment.show',$consignment->id ) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                                        @if($page_headline == 'Pending Jobcards')
                                                            @php
                                                                $consignment_assessment = App\Models\ConsignmentAssessment::where('consignment_id', $consignment->id)->first();
                                                            @endphp
                                                            @if ( $consignment_assessment )
                                                                <td>
                                                                    <a href="#!"><button type="button" class="btn btn-danger waves-effect" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#informed_modal{{ $consignment->id }}">Informed </button></a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <a href="#!"><button type="button" class="btn btn-warning waves-effect" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#assessment_modal{{ $consignment->id }}">Assessment </button></a>
                                                                </td>
                                                            @endif

                                                                <div id="informed_modal{{ $consignment->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Complaint Details</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                            <form method="POST" action="{{ route('inform_consignment',$consignment->id) }}">
                                                                            @csrf
                                                                                <div class="form-group mb-3">
                                                                                    <div class="col-lg-12">
                                                                                        <label class="col-form-label" style="float:left;">Complaint</label>
                                                                                        <textarea class="form-control" name="complaint_details" rows="4" style="text-transform:uppercase;">{{ $consignment->complaint_details }}</textarea>
                                                                                        @error('complaint_details')
                                                                                            <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <label class="col-form-label" style="float:left;">Estimate</label>
                                                                                        <input type="number" class="form-control" name="estimate" value="{{ $consignment->estimate }}">
                                                                                        @error('estimate')
                                                                                            <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 text-end">
                                                                                        <button type="submit" class="btn btn-primary" id="addtask">Inform Customer</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div><!-- /.modal-content -->
                                                                    </div><!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                                <div id="assessment_modal{{ $consignment->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Complaint Details</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                            <form method="POST" action="{{ route('assessment_consignment',$consignment->id) }}">
                                                                            @csrf
                                                                                <div class="form-group mb-3">
                                                                                    <div class="col-lg-12">
                                                                                        <label class="col-form-label required" style="float:left;">Complaint</label>
                                                                                        <textarea class="form-control" name="complaint_details" rows="4" style="text-transform:uppercase;" required></textarea>
                                                                                        @error('complaint_details')
                                                                                            <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 text-end">
                                                                                        <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            </div>
                                                                        </div><!-- /.modal-content -->
                                                                    </div><!-- /.modal-dialog -->
                                                                </div><!-- /.modal -->
                                                        @elseif ($page_headline == 'Informed Jobcards')
                                                            <td>
                                                                <a href="{{ route('approve_jobcard',$consignment->id) }}"><button type="button" class="btn btn-primary waves-effect">Approve</button></a>
                                                                <a href="{{ route('reject_jobcard',$consignment->id) }}"><button type="button" class="btn btn-danger waves-effect">Reject</button></a>
                                                            </td>
                                                        @endif
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
