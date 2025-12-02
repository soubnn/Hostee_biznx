@extends('layouts.layout')
@section('content')
@push('indian-state-script')
    <script src=" {{ asset('assets/js/indian-states.js') }} "></script>
@endpush
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
    function getBankDetails(ifsc)
    {
        if(ifsc.length == 11)
        {
            var url = "https://ifsc.razorpay.com/" + ifsc;
            $.ajax({
                type : "get",
                url : url,
                dataType : "json",
                success : function(response)
                {
                    console.log(response);
                    $("#sellerBankName").val(response.BANK);
                    $("#sellerBankBranch").val(response.BRANCH);
                }
            });
        }
        else
        {
            $("#sellerBankName").val('');
            $("#sellerBankBranch").val('');
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
                                    <h4 class="mb-sm-0 font-size-18">Seller Registration</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Basic Information</h4>
                                        <p class="card-title-desc">Fill all information below</p>

                                        <form action="../storeSeller" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="seller_name">Name</label>
                                                        <input id="seller_name" name="seller_name" type="text" class="form-control" value="{{ old('seller_name') }}" style="text-transform:uppercase;">
                                                        @error('seller_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_phone">Phone</label>
                                                        <input id="seller_phone" name="seller_phone" type="text" class="form-control" value="{{ old('seller_phone') }}" >
                                                        @error('seller_phone')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Place</label>
                                                        <input id="seller_city" name="seller_city" type="text" class="form-control" value="{{ old('seller_city') }}" style="text-transform:uppercase;">
                                                        @error('seller_city')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input class="form-control" id="seller_email" name="seller_email" type="email" value="{{ old('seller_email') }}">
                                                        @error('seller_email')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="seller_opening_balance">Opening Balance</label>
                                                        <input id="seller_opening_balance" name="seller_opening_balance" type="number" class="form-control validate" placeholder="" Value="{{ old('seller_opening_balance') > 0 ? old('seller_opening_balance') : 0}}" >
                                                        @error('seller_opening_balance')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_mobile">Mobile</label>
                                                        <input id="seller_mobile" name="seller_mobile" class="form-control validate" value="{{ old('seller_mobile') }}">
                                                        @error('seller_mobile')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_area">City</label>
                                                        <input id="seller_area" name="seller_area" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_area') }}" style="text-transform:uppercase;">
                                                        @error('seller_area')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_pincode">Pincode</label>
                                                        <input id="seller_pincode" name="seller_pincode" type="number" class="form-control validate" placeholder="" Value="{{ old('seller_pincode') }}">
                                                        @error('seller_pincode')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="mb-3">
                                                                <label for="seller_state">State</label>
                                                                <select class="select2 form-control" name="seller_state" id="seller_state" onchange="getDistrict(this.value)">
                                                                    <option value="">Select State</option>
                                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                                    <option value="Assam">Assam</option>
                                                                    <option value="Bihar">Bihar</option>
                                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                                    <option value="Goa">Goa</option>
                                                                    <option value="Gujarat">Gujarat</option>
                                                                    <option value="Haryana">Haryana</option>
                                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                                    <option value="Jharkhand">Jharkhand</option>
                                                                    <option value="Karnataka">Karnataka</option>
                                                                    <option value="Kerala">Kerala</option>
                                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                                    <option value="Maharashtra">Maharashtra</option>
                                                                    <option value="Manipur">Manipur</option>
                                                                    <option value="Meghalaya">Meghalaya</option>
                                                                    <option value="Mizoram">Mizoram</option>
                                                                    <option value="Nagaland">Nagaland</option>
                                                                    <option value="Odisha">Odisha</option>
                                                                    <option value="Punjab">Punjab</option>
                                                                    <option value="Rajasthan">Rajasthan</option>
                                                                    <option value="Sikkim">Sikkim</option>
                                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                                    <option value="Telangana">Telangana</option>
                                                                    <option value="Tripura">Tripura</option>
                                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                                    <option value="West Bengal">West Bengal</option>
                                                                    <option value="Andaman and Nicobar">Andaman and Nicobar</option>
                                                                    <option value="Chandigarh">Chandigarh</option>
                                                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                                    <option value="Ladakh">Ladakh</option>
                                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                                    <option value="Puducherry">Puducherry</option>
                                                                    <option value="Capital Territory of Delhi">Capital Territory of Delhi</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mb-3">
                                                                <label>District</label>
                                                                <select id="sellerDistrict" name="seller_district" type="text" class="form-control select2">
                                                                    <option value="">Select District</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mb-3">
                                                                <label>State Code</label>
                                                                <input id="sellerStateCode" name="seller_state_code" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_state_code') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><h6 style="font-weight: bold">Bank Account Details</h6>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="seller_bank_acc_no">Account Number</label>
                                                        <input id="seller_bank_acc_no" name="seller_bank_acc_no" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_bank_acc_no') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_bank_name">Bank</label>
                                                        <input id="sellerBankName" name="seller_bank_name" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_bank_name') }}" style="text-transform:uppercase;">
                                                        @error('seller_bank_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="seller_bank_ifsc">IFSC Code</label>
                                                        <input id="seller_bank_ifsc" name="seller_bank_ifsc" type="text" class="form-control validate" placeholder="" Value="" onkeyup="getBankDetails(this.value);">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_bank_branch">Branch</label>
                                                        <input id="sellerBankBranch" name="seller_bank_branch" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_bank_branch') }}" style="text-transform:uppercase;">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Other Details</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="seller_gst">GST Number</label>
                                                        <input id="seller_gst" name="seller_gst" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_gst') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_tin">TIN Number</label>
                                                        <input id="seller_tin" name="seller_tin" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_tin') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="seller_pan">PAN Number</label>
                                                        <input id="seller_pan" name="seller_pan" type="text" class="form-control validate" placeholder="" Value="{{ old('seller_pan') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="seller_status">Status</label>
                                                        <input id="seller_status" name="seller_status" type="text" class="form-control validate" placeholder="" Value="Active" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Courier Address</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Address</label>
                                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Place</label>
                                                        <input type="text" class="form-control" name="courier_place" value="{{ old('courier_place') }}" placeholder="Enter Place">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Post Office, PIN</label>
                                                        <input type="text" class="form-control" name="post_office_pin" value="{{ old('post_office_pin') }}" placeholder="Enter Post Office, PIN">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">District, State</label>
                                                        <input type="text" class="form-control" name="district_state" value="{{ old('district_state') }}" placeholder="Enter District, State">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Phone Number</label>
                                                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Phone Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Save Detals</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                {{-- <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Product Images</h4>

                                        <form action="https://themesbrand.com/" method="post" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>

                                            <div class="dz-message needsclick">
                                                <div class="mb-3">
                                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                </div>

                                                <h4>Drop files here or click to upload.</h4>
                                            </div>

                                        </form>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Image</button>
                                        </div>
                                    </div>


                                </div>  --}}
                                <!-- end card-->


                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
