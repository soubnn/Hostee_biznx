@extends('layouts.layout')
@section('content')
        <div class="main-content">
             <div class="page-content">
                 <div class="container-fluid">
                     <!-- start page title -->
                     <div class="row">
                         <div class="col-12">
                             <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                 <h4 class="mb-sm-0 font-size-18">Request Details</h4>
                             </div>
                         </div>
                     </div>
                     <!-- end page title -->
                     <div class="row">
                         <div class="col-12">
                             <div class="card">
                                 <div class="card-body">
                                     <div class="table-responsive">
                                         <table class="table table-bordered table-striped table-nowrap mb-0" style="text-transform: uppercase;">
                                             <tbody>
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Date</th>
                                                 <td colspan="6">{{ $marketings->date }}</td>
                                             </tr>
                                             <tr>
                                                <th class="text-nowrap" scope="row">Customer Name</th>
                                                <td colspan="6">{{ $marketings->customer_name }}</td>
                                                @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#name_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="name_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Customer Name</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_name',$marketings->id) }}">
                                                         @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">Customer Name</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="customer_name" value="{{ $marketings->customer_name }}" placeholder="Enter Customer Name">
                                                                     @error('customer_name')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Contact Number</th>
                                                 <td colspan="6">{{ $marketings->contact_no }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#contact_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="contact_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Customer Contact</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_contact',$marketings->id) }}">
                                                         @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">marketings Model</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="contact_no" value="{{ $marketings->contact_no }}" placeholder="Enter Contact No.">
                                                                     @error('contact_no')
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
                                             {{-- modal end --}}
                                             <tr>
                                                <th class="text-nowrap" scope="row">Job Role</th>
                                                <td colspan="6">{{ $marketings->job_role }}</td>
                                                @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#jobrole_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="jobrole_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Job Role</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_job_role',$marketings->id) }}">
                                                             @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">Job Role</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="job_role" value="{{ $marketings->job_role }}" placeholder="Enter Job Role">
                                                                     @error('job_role')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Company Name</th>
                                                 <td colspan="6">{{ $marketings->company_name }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#company_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="company_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Company Name</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_company_name',$marketings->id) }}">
                                                             @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">Company Name</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="company_name" value="{{ $marketings->company_name }}" placeholder="Enter Company Name">
                                                                     @error('company_name')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Company Category</th>
                                                 <td colspan="6"> {{ $marketings->company_category }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#company_cat_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="company_cat_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Company Category</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_company_category',$marketings->id) }}">
                                                             @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">Company Category</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="company_category" value="{{ $marketings->company_category }}" placeholder="Enter Company Category">
                                                                     @error('company_category')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Company Place</th>
                                                 <td colspan="6">{{ $marketings->company_place }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#rcval_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="rcval_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Company Place</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_company_place',$marketings->id) }}">
                                                             @csrf
                                                             <div class="form-group mb-3">
                                                                 <label for="profilename" class="col-form-label" style="float:left;">Company Place</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="text" class="form-control" name="company_place" value="{{ $marketings->company_place }}" placeholder="Enter Company Place">
                                                                     @error('company_place')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">KM to location</th>
                                                 <td colspan="6">{{ $marketings->km_to_location }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#ins_number_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="ins_number_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit KM to location</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_km_to_location',$marketings->id) }}">
                                                         @csrf
                                                             <div class="form-group mb-3">
                                                                 <label class="col-form-label" style="float:left;">KM to location</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="number" class="form-control" name="km_to_location" value="{{ $marketings->km_to_location }}" placeholder="Enter KM to location">
                                                                     @error('km_to_location')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Petrol Amount</th>
                                                 <td colspan="6">{{ $marketings->petrol_amount }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#ins_val_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="ins_val_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Petrol Amount</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_petrol_amount',$marketings->id) }}">
                                                         @csrf
                                                             <div class="form-group mb-3">
                                                                 <label class="col-form-label" style="float:left;">Petrol Amount</label>
                                                                 <div class="col-lg-12">
                                                                     <input type="number" class="form-control" name="petrol_amount" value="{{ $marketings->petrol_amount }}" >
                                                                     @error('petrol_amount')
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
                                             {{-- modal end --}}
                                             <tr>
                                                 <th class="text-nowrap" scope="row">Visit</th>
                                                 <td colspan="6">{{ $marketings->visit }}</td>
                                                 @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#visit_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                 @endif
                                             </tr>
                                             {{-- modal start --}}
                                             <div id="visit_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title">Edit Visit</h5>
                                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                         </div>
                                                         <div class="modal-body">
                                                         <form method="POST" action="{{ route('marketing_edit_visit',$marketings->id) }}">
                                                         @csrf
                                                             <div class="form-group mb-3">
                                                                 <label class="col-form-label" style="float:left;">Visit</label>
                                                                 <div class="col-lg-12">
                                                                    <select class="select2 form-control" name="visit" style="width:100%;" data-dropdown-parent="#visit_modal">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                    @error('visit')
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
                                             {{-- modal end --}}
                                            <tr>
                                                <th class="text-nowrap" scope="row">Remarks</th>
                                                <td colspan="6">{{ $marketings->remarks }}</td>
                                                @if($marketings->status == 'pending')
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#pollution_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- modal start --}}
                                            <div id="pollution_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Remarks</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form method="POST" action="{{ route('marketing_edit_remarks',$marketings->id) }}">
                                                        @csrf
                                                            <div class="form-group mb-3">
                                                                <label class="col-form-label" style="float:left;">Remarks</label>
                                                                <div class="col-lg-12">
                                                                    <textarea class="form-control upper-case" name="remarks">{{ $marketings->remarks }}</textarea>
                                                                    @error('remarks')
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
                                            {{-- modal end --}}
                                            @if($marketings->status == 'APPROVED' || $marketings->status == 'REJECTED')
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Reply</th>
                                                    <td colspan="6">{{ $marketings->reply }}</td>
                                                </tr>
                                            @endif
                                            @if($marketings->status == 'APPROVED')
                                                <tr>
                                                    <th class="text-nowrap" scope="row">Payment Status</th>
                                                    <td colspan="6">{{ $marketings->payment_status }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                         </table>
                                     </div>
                                     <div class="button-items mt-4" style="float:right;">
                                     </div>
                                 </div>
                             </div>
                         </div> <!-- end col -->
                     </div> <!-- end row -->
                 </div> <!-- container-fluid -->
             </div>
             <!-- End Page-content -->

@endsection
