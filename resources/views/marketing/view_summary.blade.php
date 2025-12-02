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
    function show_div(status,summary_id){
        console.log(summary_id);
        if(status == 'APPROVED'){
            $("#div_reply"+summary_id).css("display", "block");
            $("#div_payment"+summary_id).css("display", "block");
            $("#div_btn"+summary_id).css("display", "block");
        }
        else if(status == 'REJECTED'){
            $("#div_reply"+summary_id).css("display", "block");
            $("#div_payment"+summary_id).css("display", "none");
            $("#div_btn"+summary_id).css("display", "block");
        }
        else{
            $("#div_reply"+summary_id).css("display", "none");
            $("#div_payment"+summary_id).css("display", "none");
            $("#div_btn"+summary_id).css("display", "none");
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
                                    <h4 class="mb-sm-0 font-size-18">View Summary</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-4">Marketing Summary</h4>


                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Total Customer</th>
                                                    <th>Fuel Amount</th>
                                                    <th>Total KM</th>
                                                    <th>Image</th>
                                                    <th>View</th>
                                                    @if(Auth::user()->role == 'admin')
                                                        <th>Approve</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($summaries as $summary)
                                                <tr>
                                                    <td data-sort="YYYYMMDD")">{{ Carbon\carbon::parse($summary->date)->format('d-m-Y') }}</td>
                                                    <td>{{ $summary->no_of_customers }}</td>
                                                    <td>{{ $summary->total_fuel_amount }}</td>
                                                    <td>{{ $summary->total_km }}</td>
                                                    @if($summary->image)
                                                    <td><a href="{{ asset('storage/marketing/'.$summary->image) }}" target="_blank">View</a></td>
                                                    @else
                                                    <td>No Image</td>
                                                    @endif
                                                    @if(Auth::user()->username == 'fawaz')
                                                        <td><a href="{{ route('marketing.view_all_datewise_request',$summary->date) }}"><button type="button" class="btn btn-light waves-effect text-info">View All</button></a></td>
                                                    @endif
                                                    @if(Auth::user()->role == 'marketing')
                                                        <td><a href="{{ route('marketing.view_datewise_request',$summary->date) }}"><button type="button" class="btn btn-light waves-effect text-info">View All</button></a></td>
                                                    @endif
                                                    @if(Auth::user()->role == 'admin')
                                                        <td><a href="{{ route('marketing.view_all_datewise_request',$summary->date) }}"><button type="button" class="btn btn-light waves-effect text-info">View All</button></a></td>
                                                        @if($summary->status == 'pending')
                                                            <td><button type="button" class="btn btn-light waves-effect text-info" data-bs-toggle="modal" data-bs-target="#view{{ $summary->id }}">Approve</button></td>
                                                        @elseif ($summary->status == 'approved')
                                                            <td class="text-success">APPROVED</td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                <div id="view{{ $summary->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title">Approve Request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('marketing.approve',$summary->id) }}">
                                                                @csrf
                                                                {{-- @method('PATCH') --}}
                                                                    <div class="row">

                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label">Status</label>
                                                                                <select class="select2 form-control" name="status" style="width:100%;" data-dropdown-parent="#view{{ $summary->id }}" onchange="show_div(this.value,{{ $summary->id }})">
                                                                                    <option selected disabled>SELECT</option>
                                                                                    <option value="APPROVED">APPROVE</option>
                                                                                    <option value="REJECTED">REJECT</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6" id="div_reply{{ $summary->id }}" style="display: none">
                                                                            <div class="mb-3">
                                                                                <label for="" class="col-form-label">Reply</label>
                                                                                <textarea class="form-control upper-case" name="reply">{{ old('reply') }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6" id="div_payment{{ $summary->id }}" style="display: none">
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label">Payment Status</label>
                                                                                <select class="select2 form-control" name="payment_status" style="width:100%;" data-dropdown-parent="#view{{ $summary->id }}">
                                                                                    <option selected disabled>SELECT</option>
                                                                                    <option value="PAID">PAID</option>
                                                                                    <option value="NOT PAID">NOT PAID</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" id="div_btn{{ $summary->id }}" style="display: none">
                                                                            <div class="col-lg-12 text-end">
                                                                                <button type="submit" class="btn btn-primary" id="addtask">Save</button>
                                                                            </div>
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
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->





@endsection
