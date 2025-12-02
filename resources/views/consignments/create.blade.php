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

    function check_limit() {
        var advance_value = document.getElementById('advance').value;
        var service_value = document.getElementById('service_charge').value;
        var parts_value = document.getElementById('parts_charge').value;
        var total_value = parseInt(service_value) + parseInt(parts_value);
        console.log(total_value);
        if(advance_value > total_value){
            document.getElementById('advance_Error').style.display = "block";
        }
        else{
            document.getElementById('advance_Error').style.display = "none";
        }
    }
    function active_next(){
       var customer_name = document.getElementById('customer_name').value;
       var phone = document.getElementById('phone').value;
        console.log(customer_name+','+phone);
        if( customer_name !=''  && phone != ''){
            document.getElementById('next_1').disabled = false;
        }
        else{
            document.getElementById('next_1').disabled = true;
        }
    }

    function goto_next1(){
        console.log('button clicked');
        $('#v-pills-shipping').removeClass('active');
        $('#v-pills-shipping-tab').removeClass('active');
        $('#v-pills-payment').addClass('active');
        $('#v-pills-payment-tab').addClass('active');
    }
    function goto_next2(){
        $('#v-pills-payment').removeClass('active');
        $('#v-pills-payment-tab').removeClass('active');
        $('#v-pills-confir').addClass('active');
        $('#v-pills-confir-tab').addClass('active');
    }
    function goto_prev1(){
        $('#v-pills-confir').removeClass('active');
        $('#v-pills-confir-tab').removeClass('active');
        $('#v-pills-payment').addClass('active');
        $('#v-pills-payment-tab').addClass('active');
    }
    function goto_prev2(){
        $('#v-pills-payment').removeClass('active');
        $('#v-pills-payment-tab').removeClass('active');
        $('#v-pills-shipping').addClass('active');
        $('#v-pills-shipping-tab').addClass('active');
    }
    function getCustomerDetails(customerValue)
    {
        if(customerValue != '')
        {
            if(customerValue == "addNewCustomer")
            {
                $("#newCustomerModal").modal("toggle");
                $("#newCustomerModal").modal("show");
            }
            else
            {
                console.log("Customer is " + customerValue);
                $.ajax({
                    type : "get",
                    url : "{{ route('getCustomerDetails') }}",
                    data : { customer : customerValue},
                    success : function(res)
                    {
                        console.log(res);
                        $("#phone").val(res.mobile);
                        $("#email").val(res.email);
                        $("#customer_place").val(res.place);

                        active_next();
                    }
                });
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
        var isValid = true;

        if (customerNameFromModal == '') {
            document.getElementById("customerNameError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("customerNameError").style.display = "none";
        }

        if (customerMobile == '' || customerMobile.length != 10 || !/^\d{10}$/.test(customerMobile)) {
            document.getElementById("customerMobileError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("customerMobileError").style.display = "none";
        }
        if (isValid)
        {
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
                        $("#customer_name").append(newOption);
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
                                    <h4 class="mb-sm-0 font-size-18">Add Job Card</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="checkout-tabs">
                                <div class="row">
                                    <div class="col-xl-2 col-sm-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link active" id="v-pills-shipping-tab" data-bs-toggle="pill" href="#v-pills-shipping" role="tab" aria-controls="v-pills-shipping" aria-selected="true">
                                                <i class= "bx bxs-user-detail d-block check-nav-icon mt-4 mb-2"></i>
                                                <p class="fw-bold mb-4">Personal Info</p>
                                            </a>
                                            <a class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill" href="#v-pills-payment" role="tab" aria-controls="v-pills-payment" aria-selected="false">
                                                <i class= "bx bx-laptop d-block check-nav-icon mt-4 mb-2"></i>
                                                <p class="fw-bold mb-4">Service Info</p>
                                            </a>
                                            <a class="nav-link" id="v-pills-confir-tab" data-bs-toggle="pill" href="#v-pills-confir" role="tab" aria-controls="v-pills-confir" aria-selected="false">
                                                <i class= "bx bx-badge-check d-block check-nav-icon mt-4 mb-2"></i>
                                                <p class="fw-bold mb-4">Confirmation</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-10 col-sm-9">
                                        <form action="{{ route('consignment.store') }}" method="POST" enctype="multipart/form-data" autocapitalize="characters">
                                        @csrf

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="tab-content" id="v-pills-tabContent">
                                                    <div class="tab-pane show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                                        <div>
                                                            <h4 class="card-title">Personal information</h4>
                                                            <p class="card-title-desc">Fill all information below</p>
                                                                @php

                                                                    $job_get = DB::table('consignments')->orderBy('jobcard_number', 'desc')->first();

                                                                    if($job_get == Null){

                                                                        $new_jobcard_number = 'J101';
                                                                    }
                                                                    else{
                                                                        $old_jobcard_number = $job_get->jobcard_number;

                                                                        if (str_starts_with($old_jobcard_number, 'J')) {
                                                                            $old_number = intval(substr($old_jobcard_number, 1));
                                                                        } else {
                                                                            $old_number = intval($old_jobcard_number);
                                                                        }

                                                                        $new_jobcard_number = 'J' . ($old_number + 1);
                                                                    }
                                                                @endphp

                                                                <div class="form-group row mb-4">
                                                                    <label for="job-id" class="col-md-2 col-form-label">Job Card Number</label>
                                                                    <div class="col-md-10">
                                                                        <input type="text" class="form-control" name="jobcard_number" value="{{ $new_jobcard_number }}" style="color:red;border:none;background:#fff;" readonly>
                                                                        {{-- @error('consignment_number')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror --}}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-4">
                                                                    <label for="billing-branch" class="col-md-2 col-form-label">Branch</label>
                                                                    <div class="col-md-10">
                                                                        <input type="text" class="form-control" name="branch" id="branch" value="Randathani" placeholder="Enter Branch" style="text-transform: uppercase;">
                                                                        @error('branch')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row mb-4">
                                                                    <label for="order-date" class="col-md-2 col-form-label">Date</label>
                                                                    <div class="col-md-10">
                                                                        <input type="text" name="date" id="job_card_date" class="form-control" data-date-end-date="{{ Carbon\carbon::now()->format('d M Y')}}" data-date-start-date="{{ Carbon\carbon::now()->format('d M Y')}}" placeholder="Select date" data-date-format="dd M yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true" value="{{ Carbon\carbon::now()->format('d M Y')}}" >
                                                                        @error('date')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if ($job_id != 0)
                                                                    @php
                                                                        $jobcard = DB::table('consignments')->where('id',$job_id)->get();
                                                                    @endphp

                                                                    @foreach ( $jobcard as $jobcard)
                                                                        <div class="form-group row mb-4">
                                                                            <label for="billing-name" class="col-md-2 col-form-label">Name</label>
                                                                            <div class="col-md-10">
                                                                                {{-- <input type="text" class="form-control" name="customer_name" value="{{ $jobcard->customer_name }}" onkeyup="active_next()" onkeypress="active_next()" placeholder="Enter name" style="text-transform: uppercase;"> --}}
                                                                                <select id="customer_name" name="customer_name" type="text" class="form-control select2" required onchange="getCustomerDetails(this.value)" style="width:100%;">
                                                                                    <option selected disabled>Select Customer</option>
                                                                                    <option value="addNewCustomer">[Add Customer]</option>
                                                                                    @php
                                                                                        $customers = DB::table('customers')->get();
                                                                                    @endphp
                                                                                    @foreach ($customers as $customer)
                                                                                        <option value="{{ $customer->id }}" @if($jobcard->customer_name == $customer->id) selected @endif>{{ $customer->name }}, {{ $customer->place }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('customer_name')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="billing-email-address" class="col-md-2 col-form-label">Email Address</label>
                                                                            <div class="col-md-10">
                                                                                <input type="email" id="email" class="form-control" name="email" value="{{ $jobcard->email }}" placeholder="Enter email" style="text-transform:lowercase;">
                                                                                @error('email')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="billing-phone" class="col-md-2 col-form-label">Phone</label>
                                                                            <div class="col-md-10">
                                                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ $jobcard->phone }}" onkeyup="active_next()" onkeypress="active_next()" placeholder="Enter Phone no.">
                                                                                @error('phone')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label  class="col-md-2 col-form-label">Place</label>
                                                                            <div class="col-md-10">
                                                                                <input type="text" class="form-control" name="customer_place" id="customer_place" value="{{ $jobcard->customer_place }}" placeholder="Enter Place" style="text-transform: uppercase;">
                                                                                @error('customer_place')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label for="customer-type" class="col-md-2 col-form-label">Customer Type</label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="customer_type" id='customer_type' style="width:100%;text-transform: uppercase;">
                                                                                    <option value="End User" @if ($jobcard->customer_type == 'End User') selected @endif >End User</option>
                                                                                    <option value="Dealer" @if ($jobcard->customer_type == 'Dealer') selected @endif >Dealer</option>
                                                                                </select>
                                                                                @error('customer_type')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 mt-5">

                                                                            <div class="text-end">

                                                                                <button id="next_1" type="button" class="btn btn-success" onclick="goto_next1()">
                                                                                    Next<i class="bx bx-right-arrow" style="height:15px;width:15px;"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                                                                    <div>
                                                                        <h4 class="card-title">Service information</h4>
                                                                        <p class="card-title-desc">Fill all information below</p>

                                                                            <div class="form-group row mb-4">
                                                                                <label for="work-location" class="col-md-2 col-form-label">work location</label>
                                                                                <div class="col-md-10">
                                                                                    <select class="form-control select2" name="work_location" id='work_location' style="width:100%;text-transform: uppercase;">
                                                                                        <option value="On Site" @if ($jobcard->work_location == 'On Site') selected @endif>On Site</option>
                                                                                        <option value="Direct" @if ($jobcard->work_location == 'Direct') selected @endif>Direct</option>
                                                                                        <option value="Van" @if ($jobcard->work_location == 'Van') selected @endif>Van</option>
                                                                                        <option value="Courier" @if ($jobcard->work_location == 'Courier') selected @endif>Courier</option>
                                                                                    </select>
                                                                                    @error('work_location')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label class="col-md-2 col-form-label">Service Type</label>
                                                                                <div class="col-md-10">
                                                                                    <select class="form-control select2" name="service_type" id='service_type' style="width:100%;text-transform: uppercase;">
                                                                                        <option value="New" @if ($jobcard->service_type == 'New') selected @endif>New</option>
                                                                                        <option value="AMC" @if ($jobcard->service_type == 'AMC') selected @endif>AMC</option>
                                                                                        <option value="Re Repair" @if ($jobcard->service_type == 'Re Repair') selected @endif>Re Repair</option>
                                                                                        <option value="Installation" @if ($jobcard->service_type == 'Installation') selected @endif>Installation</option>
                                                                                        <option value="Warrenty" @if ($jobcard->service_type == 'Warrenty') selected @endif>Warrenty</option>
                                                                                    </select>
                                                                                    @error('service_type')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label class="col-md-2 col-form-label">Product Name</label>
                                                                                <div class="col-md-10">
                                                                                    <input type="text" class="form-control" name="product_name" value="{{ $jobcard->product_name }}" placeholder="Enter Product Name" style="text-transform:uppercase;">
                                                                                    @error('product_name')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label class="col-md-2 col-form-label">Serial No.</label>
                                                                                <div class="col-md-10">
                                                                                    <input type="text" class="form-control" name="serial_no" value="{{ $jobcard->serial_no }}" placeholder="Enter Serial No." style="text-transform:uppercase;">
                                                                                    @error('serial_no')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                    @endforeach

                                                                @elseif ($job_id == 0)
                                                                    <div class="form-group row mb-4">
                                                                        <label for="billing-name" class="col-md-2 col-form-label">Name <span style="color: red">*</span></label>
                                                                        <div class="col-md-10">
                                                                            {{-- <input type="text" class="form-control" name="customer_name" value="{{ $jobcard->customer_name }}" onkeyup="active_next()" onkeypress="active_next()" placeholder="Enter name" style="text-transform: uppercase;"> --}}
                                                                            <select id="customer_name" name="customer_name" type="text" class="form-control select2" required onchange="getCustomerDetails(this.value)" style="width:100%;">
                                                                                <option selected disabled>Select Customer</option>
                                                                                <option value="addNewCustomer">[Add Customer]</option>
                                                                                @php
                                                                                    $customers = DB::table('customers')->get();
                                                                                @endphp
                                                                                @foreach ($customers as $customer)
                                                                                    <option value="{{ $customer->id }}">{{ $customer->name }}, {{ $customer->place }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('customer_name')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Email Address</label>
                                                                        <div class="col-md-10">
                                                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" style="text-transform:lowercase;">
                                                                            @error('email')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label for="billing-phone" class="col-md-2 col-form-label">Phone <span style="color: red">*</span></label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" onkeyup="active_next()" onkeypress="active_next()" placeholder="Enter Phone no." required>
                                                                            @error('phone')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label  class="col-md-2 col-form-label">Place</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control" name="customer_place" id="customer_place" value="{{ old('customer_place') }}" placeholder="Enter Place" style="text-transform: uppercase;">
                                                                            @error('customer_place')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-4">
                                                                        <label for="customer-type" class="col-md-2 col-form-label">Customer Type</label>
                                                                        <div class="col-md-10">
                                                                            <select class="form-control select2" name="customer_type" id='customer_type' style="width:100%;text-transform: uppercase;" >
                                                                                <option value="End User">End User</option>
                                                                                <option value="Dealer">Dealer</option>
                                                                            </select>
                                                                            @error('customer_type')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 mt-5">

                                                                        <div class="text-end">

                                                                            <button id="next_1" type="button" class="btn btn-success" onclick="goto_next1()" disabled>
                                                                                Next<i class="bx bx-right-arrow" style="height:15px;width:15px;"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                                                                <div>
                                                                    <h4 class="card-title">Service information</h4>
                                                                    <p class="card-title-desc">Fill all information below</p>

                                                                        <div class="form-group row mb-4">
                                                                            <label for="work-location" class="col-md-2 col-form-label">work location <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="work_location" id='work_location' style="width:100%;text-transform: uppercase;">
                                                                                    <option value="" selected>Select</option>
                                                                                    <option value="On Site">On Site</option>
                                                                                    <option value="Direct">Direct</option>
                                                                                    <option value="Van">Van</option>
                                                                                    <option value="Courier">Courier</option>
                                                                                </select>
                                                                                @error('work_location')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Service Type <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="service_type" id='service_type' style="width:100%;text-transform: uppercase;">
                                                                                    <option value="" selected>Select</option>
                                                                                    <option value="New">New</option>
                                                                                    <option value="AMC">AMC</option>
                                                                                    <option value="Re Repair">Re Repair</option>
                                                                                    <option value="Installation">Installation</option>
                                                                                    <option value="Warrenty">Warrenty</option>
                                                                                </select>
                                                                                @error('service_type')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Device Type <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="product_name" id="device_type" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="" selected>Select</option>
                                                                                    <option value="Laptop">Laptop</option>
                                                                                    <option value="Desktop">Desktop</option>
                                                                                    <option value="All_in_One_PC">All-in-One PC</option>
                                                                                    <option value="Printer">Printer</option>
                                                                                    <option value="Scanner">Scanner</option>
                                                                                    <option value="Monitor">Monitor</option>
                                                                                    <option value="CCTV_DVR_NVR">CCTV DVR/NVR</option>
                                                                                    <option value="CCTV_Camera">CCTV Camera</option>
                                                                                    <option value="Router">Router</option>
                                                                                    <option value="Switch_Hub">Switch/Hub</option>
                                                                                    <option value="Network_Storage">Network Storage (NAS)</option>
                                                                                    <option value="Projector">Projector</option>
                                                                                    <option value="Smart_TV">Smart TV</option>
                                                                                    <option value="UPS_Inverter">UPS/Inverter</option>
                                                                                    <option value="Gaming_Console">Gaming Console</option>
                                                                                    <option value="External_Hard_Drive">External Hard Drive</option>
                                                                                    <option value="Keyboard">Keyboard</option>
                                                                                    <option value="Mouse">Mouse</option>
                                                                                    <option value="Motherboard">Motherboard</option>
                                                                                    <option value="SMPS_Power_Supply">SMPS/Power Supply</option>
                                                                                    <option value="Speaker_Sound System">Speaker/Sound System</option>
                                                                                    <option value="Biometric_Device">Biometric Device</option>
                                                                                    <option value="POS_Machine">POS Machine</option>
                                                                                    <option value="Cash_Drawer_Billing Machine">Cash Drawer/Billing Machine</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('product_name')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Brand Name <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="brand" id="brand" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="" selected>Select</option>
                                                                                    <option value="Dell">Dell</option>
                                                                                    <option value="HP">HP</option>
                                                                                    <option value="Lenovo">Lenovo</option>
                                                                                    <option value="Asus">Asus</option>
                                                                                    <option value="Acer">Acer</option>
                                                                                    <option value="Apple">Apple</option>
                                                                                    <option value="Samsung">Samsung</option>
                                                                                    <option value="Toshiba">Toshiba</option>
                                                                                    <option value="Sony">Sony</option>
                                                                                    <option value="MSI">MSI</option>
                                                                                    <option value="Microsoft">Microsoft</option>
                                                                                    <option value="Canon">Canon</option>
                                                                                    <option value="Epson">Epson</option>
                                                                                    <option value="Brother">Brother</option>
                                                                                    <option value="Ricoh">Ricoh</option>
                                                                                    <option value="Xerox">Xerox</option>
                                                                                    <option value="Huawei">Huawei</option>
                                                                                    <option value="Realme">Realme</option>
                                                                                    <option value="Xiaomi">Xiaomi</option>
                                                                                    <option value="OnePlus">OnePlus</option>
                                                                                    <option value="Oppo">Oppo</option>
                                                                                    <option value="Vivo">Vivo</option>
                                                                                    <option value="Motorola">Motorola</option>
                                                                                    <option value="LG">LG</option>
                                                                                    <option value="Panasonic">Panasonic</option>
                                                                                    <option value="Zebronics">Zebronics</option>
                                                                                    <option value="TP-Link">TP-Link</option>
                                                                                    <option value="D-Link">D-Link</option>
                                                                                    <option value="Hikvision">Hikvision</option>
                                                                                    <option value="Dahua">Dahua</option>
                                                                                    <option value="CP Plus">CP Plus</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('brand')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Model <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <input type="text" class="form-control" name="model" value="{{ old('model') }}" placeholder="Enter Model" style="text-transform:uppercase;">
                                                                                @error('model')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Serial No. <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <input type="text" class="form-control" name="serial_no" value="{{ old('serial_no') }}" placeholder="Enter Serial No." style="text-transform:uppercase;">
                                                                                @error('serial_no')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Warranty Type <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="warranty_type" id="warranty_type" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="" selected>Select</option>
                                                                                    <option value="In Warranty">In Warranty</option>
                                                                                    <option value="Out of Warranty">Out of Warranty</option>
                                                                                    <option value="AMC Contract">AMC Contract</option>
                                                                                    <option value="Free Service">Free Service</option>
                                                                                    <option value="Unknown">Unknown</option>
                                                                                </select>
                                                                                @error('warranty_type')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Accessories Received <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="accessories[]" id="accessories" multiple="multiple" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="Nothing Recieved">Nothing Recieved</option>
                                                                                    <option value="Charger/Adapter">Charger/Adapter</option>
                                                                                    <option value="Power Cable">Power Cable</option>
                                                                                    <option value="Mouse">Mouse</option>
                                                                                    <option value="Keyboard">Keyboard</option>
                                                                                    <option value="Bag">Bag</option>
                                                                                    <option value="Battery">Battery</option>
                                                                                    <option value="USB Dongle">USB Dongle</option>
                                                                                    <option value="External Hard Drive">External Hard Drive</option>
                                                                                    <option value="Pen Drive">Pen Drive</option>
                                                                                    <option value="Monitor Cable (VGA/HDMI)">Monitor Cable (VGA/HDMI)</option>
                                                                                    <option value="Printer Cable">Printer Cable</option>
                                                                                    <option value="Toner/Cartridge">Toner/Cartridge</option>
                                                                                    <option value="Paper Tray">Paper Tray</option>
                                                                                    <option value="Remote Control">Remote Control</option>
                                                                                    <option value="Mounting Stand">Mounting Stand</option>
                                                                                    <option value="Cover/Case">Cover/Case</option>
                                                                                    <option value="SIM Card">SIM Card</option>
                                                                                    <option value="Memory Card">Memory Card</option>
                                                                                    <option value="Power Supply Cable">Power Supply Cable</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('accessories')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Physical Condition</label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="physical_condition[]" id="physical_condition" multiple="multiple" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="Good Condition">Good Condition</option>
                                                                                    <option value="Minor Scratches">Minor Scratches</option>
                                                                                    <option value="Heavy Scratches">Heavy Scratches</option>
                                                                                    <option value="Cracked Screen">Cracked Screen</option>
                                                                                    <option value="Broken Hinge">Broken Hinge</option>
                                                                                    <option value="Dents on Body">Dents on Body</option>
                                                                                    <option value="Missing Keys/Buttons">Missing Keys/Buttons</option>
                                                                                    <option value="Display Flickering">Display Flickering</option>
                                                                                    <option value="Water Damage">Water Damage</option>
                                                                                    <option value="Burn Marks">Burn Marks</option>
                                                                                    <option value="Power Issue">Power Issue</option>
                                                                                    <option value="No Display">No Display</option>
                                                                                    <option value="Sound Issue">Sound Issue</option>
                                                                                    <option value="Camera Fault">Camera Fault</option>
                                                                                    <option value="Port Damaged">Port Damaged</option>
                                                                                    <option value="Touch Not Working">Touch Not Working</option>
                                                                                    <option value="Battery Swollen">Battery Swollen</option>
                                                                                    <option value="Body Loose">Body Loose</option>
                                                                                    <option value="Not Powering On">Not Powering On</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('physical_condition')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Reported Problems <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="complaints[]" id="complaints" multiple="multiple" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="No Power">No Power</option>
                                                                                    <option value="Not Booting">Not Booting</option>
                                                                                    <option value="Slow Performance">Slow Performance</option>
                                                                                    <option value="No Display">No Display</option>
                                                                                    <option value="Blue Screen/Error">Blue Screen/Error</option>
                                                                                    <option value="Overheating">Overheating</option>
                                                                                    <option value="Auto Restart">Auto Restart</option>
                                                                                    <option value="No Sound">No Sound</option>
                                                                                    <option value="Keyboard Not Working">Keyboard Not Working</option>
                                                                                    <option value="Touchpad Not Working">Touchpad Not Working</option>
                                                                                    <option value="Battery Not Charging">Battery Not Charging</option>
                                                                                    <option value="Broken Screen">Broken Screen</option>
                                                                                    <option value="Wi-Fi Not Connecting">Wi-Fi Not Connecting</option>
                                                                                    <option value="USB Port Not Working">USB Port Not Working</option>
                                                                                    <option value="OS Crash">OS Crash</option>
                                                                                    <option value="Software Not Loading">Software Not Loading</option>
                                                                                    <option value="Printer Not Printing">Printer Not Printing</option>
                                                                                    <option value="Paper Jam">Paper Jam</option>
                                                                                    <option value="Lines on Print">Lines on Print</option>
                                                                                    <option value="Network Issue">Network Issue</option>
                                                                                    <option value="Camera Not Working">Camera Not Working</option>
                                                                                    <option value="No Signal on Monitor">No Signal on Monitor</option>
                                                                                    <option value="Display Flickering">Display Flickering</option>
                                                                                    <option value="Data Recovery Required">Data Recovery Required</option>
                                                                                    <option value="Virus/Malware Issue">Virus/Malware Issue</option>
                                                                                    <option value="OS Installation Required">OS Installation Required</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('complaints')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row mb-4">
                                                                            <label class="col-md-2 col-form-label">Initial Check Remarks <span style="color: red">*</span></label>
                                                                            <div class="col-md-10">
                                                                                <select class="form-control select2" name="remarks[]" id="remarks" multiple="multiple" style="width:100%;text-transform: uppercase;">
                                                                                    <option value="Software Issue">Software Issue</option>
                                                                                    <option value="Hardware Issue">Hardware Issue</option>
                                                                                    <option value="Faulty Motherboard">Faulty Motherboard</option>
                                                                                    <option value="Faulty Power Supply">Faulty Power Supply</option>
                                                                                    <option value="Faulty RAM">Faulty RAM</option>
                                                                                    <option value="Faulty HDD/SSD">Faulty HDD/SSD</option>
                                                                                    <option value="Virus Infection">Virus Infection</option>
                                                                                    <option value="OS Corrupted">OS Corrupted</option>
                                                                                    <option value="Physical Damage">Physical Damage</option>
                                                                                    <option value="Display Panel Fault">Display Panel Fault</option>
                                                                                    <option value="Keyboard Replacement Needed">Keyboard Replacement Needed</option>
                                                                                    <option value="Battery Replacement Needed">Battery Replacement Needed</option>
                                                                                    <option value="Charger Faulty">Charger Faulty</option>
                                                                                    <option value="Port Damaged">Port Damaged</option>
                                                                                    <option value="Printer Cartridge Issue">Printer Cartridge Issue</option>
                                                                                    <option value="Not Repaired (Customer Declined)">Not Repaired (Customer Declined)</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                                @error('remarks')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="work_desc" class="col-md-2 col-form-label">Work Description / Action Taken</label>
                                                                            <div class="col-md-10">
                                                                                <textarea class="form-control" name="work_desc" rows="3" placeholder="Enter Work Description / Action Taken" text-transform: uppercase;>{{ old('work_desc') }}</textarea>
                                                                                @error('work_desc')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="estimate" class="col-md-2 col-form-label">Estimated Service Cost (final amount may vary based on parts and labour)</label>
                                                                            <div class="col-md-10">
                                                                                <input type="number" class="form-control" id="estimate" name="estimate" value="{{ old('estimate') }}" onkeyup="check_limit()" onkeypress="check_limit()" rows="3" placeholder="Enter Estimated Service Cost">
                                                                                {{-- <small id="estimate_Error" style="display:none" class="text-danger">estimate is greater than other charges</small> --}}
                                                                                @error('estimate')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                             </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="advance" class="col-md-2 col-form-label">Advance Paid (₹)</label>
                                                                            <div class="col-md-10">
                                                                                <input type="number" class="form-control" id="advance" name="advance" value="{{ old('advance') }}" onkeyup="check_limit()" onkeypress="check_limit()" rows="3" placeholder="Enter advance">
                                                                                <small id="advance_Error" style="display:none" class="text-danger">Advance is greater than other charges</small>
                                                                                @error('advance')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                             </div>
                                                                        </div>
                                                                        <div class="form-group row mb-4">
                                                                            <label for="estimate_delivery" class="col-md-2 col-form-label">Estimated Delivery Date</label>
                                                                            <div class="col-md-10">
                                                                                <input type="date" class="form-control" id="estimate_delivery" name="estimate_delivery" value="{{ old('estimate_delivery') }}" placeholder="Select estimated delivery date">
                                                                                @error('estimate_delivery')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-12 mt-5">
                                                                            <div class="text-end">
                                                                                <button id="prev_2" type="button" class="btn btn-secondary" onclick="goto_prev2()">
                                                                                    <i class="bx bx-left-arrow" style="height:15px;width:15px;"></i> Prev
                                                                                </button>
                                                                                <button id="next_2" type="button" class="btn btn-success" onclick="goto_next2()">
                                                                                     Next<i class="bx bx-right-arrow" style="height:15px;width:15px;"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            <div class="tab-pane" id="v-pills-confir" role="tabpanel" aria-labelledby="v-pills-confir-tab">
                                                                <div class="card shadow-none border mb-0">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <h4 class="card-title">Upload Photos <span style="font-weight: lighter">(add atleast 1 Photo)</span></h4>
                                                                                <div>
                                                                                    <input class="form-control mt-4" name="image1" type="file" required>
                                                                                    @error('image1')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                    <input class="form-control mt-4" name="image2" type="file">
                                                                                    @error('image2')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                    <input class="form-control mt-4" name="image3" type="file">
                                                                                    @error('image3')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                    <input class="form-control mt-4" name="image4" type="file">
                                                                                    @error('image4')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                    <input class="form-control mt-4" name="image5" type="file">
                                                                                    @error('image5')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-sm-12 mt-5">
                                                                                    <div class="text-end">
                                                                                        <button id="prev_1" type="button" class="btn btn-secondary" onclick="goto_prev1()">
                                                                                            <i class="bx bx-left-arrow" style="height:15px;width:15px;"></i> Prev
                                                                                        </button>
                                                                                        <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.innerHTML='Confirming...';this.form.submit();">
                                                                                        <i class="bx bx-check-double" style="height:15px;width:15px;"></i> Confirm Consignment </button>
                                                                                    </div>
                                                                                </div> <!-- end col -->



                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                            <input id="name" name="name" type="text" class="form-control validate" placeholder="" value="" required>
                                            <small id="customerNameError" style="display: none" class="text-danger">Customer Name cannot be empty!</small>
                                            @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="taskname" class="col-form-label">Customer Mobile</label>
                                        <div class="col-lg-12">
                                            <input id="mobile" name="mobile" type="text" class="form-control validate" placeholder="" Value="{{ old('mobile') }}" required>
                                            <small id="customerMobileError" style="display: none" class="text-danger">Mobile number must be 10 digits!</small>
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



