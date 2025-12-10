@extends('layouts.layout')
@section('content')
<script>
    function getCustomerDetails(customerValue)
    {
        if(customerValue != '')
        {
            if(customerValue == "addNewCustomer")
            {
                $("#newCustomerModal").modal("toggle");
                $("#newCustomerModal").modal("show");
            }
        }
    }
    function addCustomerDetails()
    {
        var customerNameFromModal = $("#name").val();
        var customerMobile = $("#mobile").val();
        var customerPlace = $("#place").val();
        var customerEmail = $("#customer_email").val();
        var customerGSTNumber = $("#gst_no").val();
        if(customerNameFromModal == '')
        {
            document.getElementById("customerNameError").style.display = "block";
        }
        else if(customerNameFromModal == null)
        {
            document.getElementById("customerNameError").style.display = "block";
        }
        else
        {
            document.getElementById("customerNameError").style.display = "none";
            document.getElementById("addCustomer").disabled = true;
            document.getElementById("addCustomer").innerHTML = "Saving...";
            $.ajaxSetup({
	        	headers : {
	        		'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
	        	}
	        });
            $.ajax({
                type : "post",
                url : "{{ route('addNewCustomer') }}",
                data : {name : customerNameFromModal, mobile : customerMobile, place : customerPlace, email : customerEmail, gst_no : customerGSTNumber},
                success : function(response)
                {
                    console.log(response);
                    if(response != "Error")
                    {
                        var newOption = "<option value='" + response.id + "'>" + response.name + "</option>";
                        $("#customer").append(newOption);
                        $("#newCustomerModal").modal("toggle");
                        document.getElementById("addCustomer").disabled = false;
                        document.getElementById("addCustomer").innerHTML = "Save Details";
                    }
                }
            });
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
                        <h4 class="mb-sm-0 font-size-18">Create New</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">project/<a href="{{ route('project.create') }}">create project</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Create New Project</h4>
                            <form method="post" action="{{ route('project.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row mb-4">
                                    <label for="projectname" class="col-form-label col-lg-2">Project Name</label>
                                    <div class="col-lg-10">
                                        <input id="project_name" name="project_name" type="text" class="form-control" placeholder="Enter Project Name..." value="{{ old('project_name') }}">
                                        @error('project_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="projectname" class="col-form-label col-lg-2">Customer Name</label>
                                    <div class="col-lg-10">
                                        <select id="customer" name="customer" type="text" class="form-control select2" required onchange="getCustomerDetails(this.value)" style="width:100%;">
                                            <option selected disabled>Select Customer</option>
                                            <option value="addNewCustomer">[Add Customer]</option>
                                            @php
                                                $customers = DB::table('customers')->get();
                                            @endphp
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}, {{ $customer->place }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row mb-4">
                                    <label for="projectdesc" class="col-form-label col-lg-2">Project Given By</label>
                                    <div class="col-lg-10">
                                        <select class="select2 form-control" id="given_by" name="given_by">
                                            <option selected disabled>Select</option>
                                            <option value="Kochi">Kochi</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Randathani">Randathani</option>
                                            <option value="UAE">UAE</option>
                                        </select>
                                        @error('given_by')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="row mb-4">
                                    <label for="projectdesc" class="col-form-label col-lg-2">Project Description</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name="project_description" rows="3" placeholder="Enter Project Description...">{{ old('project_description') }}</textarea>
                                        @error('project_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-form-label col-lg-2">Project Date</label>
                                    <div class="col-lg-10">
                                        <div class="input-daterange input-group" id="project-date-inputgroup" data-provide="datepicker" data-date-format="dd M, yyyy"  data-date-container='#project-date-inputgroup' data-date-autoclose="true">
                                            <input type="text" class="form-control" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" />
                                            <input type="text" class="form-control" placeholder="End Date" name="end_date" value="{{ old('end_date') }}" />
                                        </div>
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="projectbudget" class="col-form-label col-lg-2">Budget</label>
                                    <div class="col-lg-10">
                                        <input id="projectbudget" name="budget" type="text" placeholder="Enter Project Budget..." class="form-control" value="{{ old('budget') }}">
                                        @error('budget')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="projectbudget" class="col-form-label col-lg-2">Team Leader</label>
                                    <div class="col-lg-10">
                                        <select class="form-control select2" name="team_leader">
                                            <option selected disabled>Select</option>
                                            @foreach ( $staffs as $staff )
                                                <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('team_leader')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="projectbudget" class="col-form-label col-lg-2">Team Members</label>
                                    <div class="col-lg-10">
                                        <select class="select2 form-control select2-multiple" name="team_members[]" multiple="multiple" data-placeholder="Choose ...">
                                            @foreach ( $staffs as $staff )
                                                <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="projectbudget" class="col-form-label col-lg-2">Project Report</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" name="attachment1" type="file">
                                        @error('attachment1')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row mb-4">
                                    <label for="projectbudget" class="col-form-label col-lg-2">Attachments</label>
                                    <div class="col-lg-10">
                                        <input class="form-control mt-4" name="attachment2" type="file">
                                        @error('attachment2')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input class="form-control mt-4" name="attachment3" type="file">
                                        @error('attachment3')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input class="form-control mt-4" name="attachment4" type="file">
                                        @error('attachment4')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="row justify-content-end">
                                    <div class="col-lg-10">
                                        <button type="submit" class="btn btn-primary">Create Project</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <!-- new customer modal -->
    <div id="newCustomerModal" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title add-task-title">New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customerForm">
                        <div class="form-group mb-3">
                            <label for="taskname" class="col-form-label">Customer Name</label>
                            <div class="col-lg-12">
                                <input id="name" name="name" type="text" class="form-control validate" placeholder="" value="">
                                <small id="customerNameError" style="display: none" class="text-danger">Customer Name cannot be empty!</small>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="taskname" class="col-form-label">Customer Mobile</label>
                            <div class="col-lg-12">
                                <input id="mobile" name="mobile" type="text" class="form-control validate" placeholder="" Value="{{ old('mobile') }}">
                                @error('mobile')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="taskname" class="col-form-label">Customer Place</label>
                            <div class="col-lg-12">
                                <input id="place" name="place" type="text" class="form-control validate" placeholder="" Value="{{ old('place') }}">
                                @error('place')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="taskname" class="col-form-label">Customer Email</label>
                            <div class="col-lg-12">
                                <input id="customer_email" name="customer_email" type="email" class="form-control validate" placeholder="" Value="{{ old('customer_email') }}" style="text-transform:lowercase;">
                                @error('customer_email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gst_no" class="col-form-label">GST No</label>
                            <div class="col-lg-12">
                                <input id="gst_no" name="gst_no" type="text" class="form-control validate" placeholder="" Value="{{ old('gst_no') }}">
                                @error('gst_no')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-3 text-end">
                                <button type="button" class="btn btn-primary" id="addCustomer" onclick="addCustomerDetails()">Save Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection



