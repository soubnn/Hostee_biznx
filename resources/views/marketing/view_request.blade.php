@extends('layouts.layout')
@section('content')
<script>
$(document).ready(function(){
    $("#datatable").dataTable({
        "pageLength" : 100
    });
});
</script>
<script>
function show_div(status){
    if(status == 'APPROVED'){
        $("#div_reply").css("display", "block");
        $("#div_payment").css("display", "block");
        $("#div_btn").css("display", "block");
    }
    else if(status == 'REJECTED'){
        $("#div_reply").css("display", "block");
        $("#div_payment").css("display", "none");
        $("#div_btn").css("display", "block");
    }
    else{
        $("#div_reply").css("display", "none");
        $("#div_payment").css("display", "none");
        $("#div_btn").css("display", "none");
    }
}
</script>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View Requests</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Marketing Requests</h4>
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Job Role</th>
                                            <th>Company Name</th>
                                            <th>Company Place</th>
                                            {{-- <th>KM to loaction</th> --}}
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($marketings as $marketings)
                                        <tr>
                                            <td data-sort="YYYYMMDD">{{ Carbon\carbon::parse($marketings->date)->format('d-m-Y') }}</td>
                                            <td>{{ $marketings->customer_name }}</td>
                                            <td>{{ $marketings->contact_no }}</td>
                                            <td>{{ $marketings->job_role }}</td>
                                            <td>{{ $marketings->company_name  }}</td>
                                            <td>{{ $marketings->company_place  }}</td>
                                            {{-- <td>{{ $marketings->km_to_location  }}</td> --}}
                                            @if( $marketings->status == 'pending')
                                                <td><button type="button" class="btn btn-light waves-effect text-info" data-bs-toggle="modal" data-bs-target="#view{{ $marketings->id }}">View</button><td>
                                            @else
                                                <td><a href="{{ route('marketing.show',$marketings->id) }}"><button type="button" class="btn btn-light waves-effect text-info">View</button></a></td>
                                            @endif
                                        </tr>
                                        <!-- Modal -->
                                        <div id="view{{ $marketings->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title add-task-title">View Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('marketing.update',$marketings->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="date">Date</label>
                                                                        <input type="text" class="form-control" value="{{ Carbon\carbon::parse($marketings->date)->format('d-m-Y') }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="customer_name">Customer Name</label>
                                                                        <input type="text" class="form-control upper-case" value="{{ $marketings->customer_name }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="contact_no">Contact Number</label>
                                                                        <input type="text" class="form-control upper-case" value="{{ $marketings->contact_no }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="job_role">Job role</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->job_role }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="company_name" class="col-form-label">Company Name</label>
                                                                        <input type="text" class="form-control upper-case validate" Value="{{ $marketings->company_name }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="company_category" class="col-form-label">Company Category</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->company_category }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="company_place" class="col-form-label">Company Place</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->company_place }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="mb-3">
                                                                        <label for="" class="col-form-label">KM to location</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->km_to_location }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="mb-3">
                                                                        <label for="petrol_amount" class="col-form-label">Petrol Amount</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->petrol_amount }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="mb-3">
                                                                        <label for="visit" class="col-form-label">Visit</label>
                                                                        <input type="text" class="form-control upper-case" Value="{{ $marketings->visit }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label for="" class="col-form-label">Remarks</label>
                                                                        <textarea class="form-control upper-case" readonly>{{ $marketings->remarks }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="mb-3">
                                                                        <label class="col-form-label">Status</label>
                                                                        <select class="select2 form-control" name="status" style="width:100%;" data-dropdown-parent="#view{{ $marketings->id }}" onchange="show_div(this.value)">
                                                                            <option selected disabled>SELECT</option>
                                                                            <option value="APPROVED">APPROVE</option>
                                                                            <option value="REJECTED">REJECT</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6" id="div_reply" style="display: none">
                                                                    <div class="mb-3">
                                                                        <label for="" class="col-form-label">Reply</label>
                                                                        <textarea class="form-control upper-case" name="reply">{{ old('reply') }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6" id="div_payment" style="display: none">
                                                                    <div class="mb-3">
                                                                        <label class="col-form-label">Payment Status</label>
                                                                        <select class="select2 form-control" name="payment_status" style="width:100%;" data-dropdown-parent="#view{{ $marketings->id }}">
                                                                            <option selected disabled>SELECT</option>
                                                                            <option value="PAID">PAID</option>
                                                                            <option value="NOT PAID">NOT PAID</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="div_btn" style="display: none">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" id="addtask">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
