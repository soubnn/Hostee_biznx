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
    function enable_btn(){
        var customer_name = document.getElementById('customer_name').value;
        var customer_phone = document.getElementById('phone').value;
        customer_phone_length = customer_phone.length;
        if(customer_phone_length > 0){
            if(customer_name == '' || customer_phone_length<=9){
                document.getElementById('submit_btn').disabled = true;
            }
            else{
                document.getElementById('submit_btn').disabled = false;
            }
        }
        else{
            if(customer_name == ''){
                document.getElementById('submit_btn').disabled = true;
            }
            else{
                document.getElementById('submit_btn').disabled = false;
            }
        }
    }
    function set_name_select(customer){
        if(customer == 'New Customer'){
            $("#customer_name_select").css("display", "none");
            $("#customer_name").css("display", "block");
            $("#reload_customer").css("display", "block");
            document.getElementById('customer_name').value='';
            document.getElementById('phone').value='';
        }
        else{
            $.ajax({
                type : "get",
                url : "{{ route('getCustomerDetails') }}",
                data : { customer : customer },
                success : function(res)
                {
                    console.log(res);
                    $("#customer_name").val(res.name);
                    $("#place").val(res.place);
                    $("#phone").val(res.mobile);
                    enable_btn();
                }
            });
        }
    }
    function reload_customer(){
        $("#customer_name").css("display", "none");
        $("#reload_customer").css("display", "none");
        $("#customer_name_select").css("display", "block");
        document.getElementById('customer_name').value='';
        document.getElementById('phone').value='';
    }
    function getCustomer(contact) {
        if (contact.length < 3) {
            document.getElementById('customer-results').innerHTML = '';
            return;
        }

        $.ajax({
            type: "get",
            url: "{{ route('field.getCustomers') }}",
            data: { contact: contact },
            success: function (res) {
                let resultsDiv = document.getElementById('customer-results');
                resultsDiv.innerHTML = '';

                if (res.length > 0) {
                    res.forEach(customer => {
                        let customerElement = document.createElement('div');
                        customerElement.className = 'customer-item';
                        customerElement.innerHTML = `
                            <div class="p-2 border rounded mb-1">
                                <strong>${customer.name}</strong><br>
                                ${customer.mobile}
                            </div>`;
                        customerElement.onclick = () => selectCustomer(customer);
                        resultsDiv.appendChild(customerElement);
                    });
                } else {
                    resultsDiv.innerHTML = '<div class="text-muted">No customers found.</div>';
                }
            },
            error: function () {
                alert('Unable to fetch customers. Please try again.');
            }
        });
    }

    function selectCustomer(customer) {
        document.getElementById('customer_mobile').value = customer.mobile;
        document.getElementById('customer_name').value   = customer.name;
        document.getElementById('customer_id').value     = customer.id;
        document.getElementById('phone').value   = customer.mobile;
        document.getElementById('place').value   = customer.place;
        document.getElementById('customer-results').innerHTML = '';
    }
    function showModal(message) {
        document.getElementById('alertMessage').textContent = message;
        $('#alertModal').modal('show');
    }

    function checkForm() {
        let date = document.getElementById('date');
        let customer_name = document.getElementById('customer_name');
        let phone = document.getElementById('phone');
        let place = document.getElementById('place');
        let work = document.getElementById('work');
        let fieldForm = document.getElementById('fieldForm');

        if (date.value == "") {
            showModal("The Date field is required.");
            return;
        } else if (customer_name.value == "") {
            showModal("The Customer Name field is required.");
            return;
        } else if (phone.value == "") {
            showModal("The Phone field is required.");
            return;
        } else if (place.value == "") {
            showModal("The Place field is required.");
            return;
        } else if (work.value == "") {
            showModal("The Work field is required.");
            return;
        } else {
            fieldForm.submit();
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
                        <h4 class="mb-sm-0 font-size-18">Field Works</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Create New Work</h4>
                            <form id="fieldForm" method="post" action="{{ route('field.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <label for="projectname" class="col-form-label col-lg-2">Date & Time</label>
                                    <div class="col-lg-10">
                                        <input type="datetime-local" id="date" name="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d H:i') }}">
                                        @error('date')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-form-label col-lg-2">Select Customer</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="customer_mobile" placeholder="Customer Number" onkeyup="getCustomer(this.value)" />
                                        <div class="text-end mt-1 mb-1">
                                            <a href="#!" data-bs-toggle="modal" data-bs-target="#newCustomerModal">Add New Customer</a>
                                        </div>
                                        <div id="customer-results" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="projectname" class="col-form-label col-lg-2">Customer Name</label>
                                    <div class="col-lg-10">
                                        {{-- @php
                                            $customers = DB::table('customers')->get();
                                        @endphp
                                        <div id="customer_name_select">
                                            <select class="select2 form-control" onchange="set_name_select(this.value)">
                                                <option selected disabled>Select</option>
                                                <option value="New Customer">New Customer</option>
                                                @foreach ( $customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}, {{ $customer->place }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" value="" readonly>
                                        <input type="hidden" class="form-control" name="customer" id="customer_id" value="">
                                        <i class="bx bx-repost text-success" onclick="reload_customer()" id="reload_customer" style="display: none;font-size: 18px;"></i>
                                        @error('customer')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="billing-phone" class="col-md-2 col-form-label">Phone</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter Phone no." readonly>
                                        @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label  class="col-md-2 col-form-label">Place</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="place" id="place" value="{{ old('place') }}" placeholder="Enter Place" readonly>
                                        @error('place')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-form-label col-lg-2">Work Description</label>
                                    <div class="col-lg-10">
                                        {{-- <input name="work" type="text" placeholder="Enter Work" class="form-control" value="{{ old('work') }}"> --}}
                                        <textarea class="form-control" id="work" name="work" rows="4">{{ old('work') }}</textarea>
                                        @error('work')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-lg-10">
                                        <button type="button" class="btn btn-primary" id="submit_btn" onclick="checkForm()">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            @include('field.modals.alert-modal')
            @include('field.modals.customer-add')
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection



