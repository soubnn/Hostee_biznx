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
                                    <h4 class="mb-sm-0 font-size-18">Seller Details</h4>

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
                                                    <th class="text-nowrap" scope="row">Seller Name </th>
                                                    <td colspan="6">{{ $seller->seller_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_name_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_name_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_name',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Seller Name</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_name" value="{{ $seller->seller_name }}" placeholder="Enter Seller Name">
                                                                        @error('seller_name')
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
                                                    <th class="text-nowrap" scope="row">Seller Phone</th>
                                                    <td colspan="6">{{ $seller->seller_phone }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_phone_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_phone_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_phone',$seller->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Seller Phone</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_phone" value="{{ $seller->seller_phone }}" placeholder="Enter Seller Phone">
                                                                        @error('seller_phone')
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
                                                    <th class="text-nowrap" scope="row">Seller Mobile</th>
                                                    <td colspan="6">{{ $seller->seller_mobile }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_mobile_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_mobile_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_mobile',$seller->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">Seller Mobile</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_mobile" value="{{ $seller->seller_mobile }}" placeholder="Enter Mobile">
                                                                        @error('seller_mobile')
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
                                                    <th class="text-nowrap" scope="row">Place</th>
                                                    <td colspan="6"> {{ $seller->seller_city }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_city_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_city_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_city',$seller->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Seller Place</label>
                                                                    <input type="text" class="form-control" name="seller_city" value="{{ $seller->seller_city }}" placeholder="Enter Place">
                                                                    <div class="col-lg-12">
                                                                        @error('seller_city')
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
                                                    <th class="text-nowrap" scope="row">City</th>
                                                    <td colspan="6">{{ $seller->seller_area }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_area_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_area_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_area',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">City</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="seller_area" type="text" placeholder="Enter City" value="{{ $seller->seller_area }}">
                                                                        @error('seller_area')
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
                                                    <th class="text-nowrap" scope="row">Seller Email</th>
                                                    <td colspan="6" style="text-transform: lowercase;">{{ $seller->seller_email }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_email_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_email_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_email',$seller->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" style="float:left;">Seller Email</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="seller_email" type="email" value="{{ $seller->seller_email }}" placeholder="Enter email">
                                                                        @error('seller_email')
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
                                                    <th class="text-nowrap" scope="row">Pincode</th>
                                                        <td colspan="6">{{ $seller->seller_pincode }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_pincode_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_pincode_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_pincode',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Pincode</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" type="number" name="seller_pincode" value="{{ $seller->seller_pincode }}">
                                                                        @error('seller_pincode')
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
                                                    <th class="text-nowrap" scope="row">District & State</th>
                                                    <td colspan="6">{{ $seller->seller_district }}, {{ $seller->seller_state}} [{{$seller->seller_state_code}}]</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#seller_state_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="seller_state_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_state',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">State</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" data-dropdown-parent="#seller_state_modal" name="seller_state" id="seller_state" onchange="getDistrict(this.value)">
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
                                                                        @error('seller_state')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                        <input type="hidden" name="seller_state_code" id="sellerStateCode" value="">
                                                                    </div>
                                                                    <label style="float:left;" class="mt-3">District</label>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" data-dropdown-parent="#seller_state_modal" name="seller_district" id="sellerDistrict">
                                                                            <option value="">Select District</option>
                                                                        </select>
                                                                        @error('seller_district')
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
                                                    @if($seller->seller_bank_acc_no && $seller->seller_bank_name && $seller->seller_bank_branch && $seller->seller_bank_ifsc)
                                                    <th class="text-nowrap" scope="row">Account Details</th>
                                                    <td colspan="6">{{ $seller->seller_bank_acc_no }}
                                                    <br>{{ $seller->seller_bank_name }}
                                                    <br>{{ $seller->seller_bank_branch }}
                                                    <br>{{ $seller->seller_bank_ifsc }}</td>
                                                    @else
                                                    <th class="text-nowrap" scope="row">Account Details</th>
                                                    <td colspan="6" class="text-danger">No Account Details</td>
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#account_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="account_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_account',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Account Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_bank_acc_no" value="{{ $seller->seller_bank_acc_no }}" >
                                                                        @error('seller_bank_acc_no')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">IFSC Code</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_bank_ifsc" value="{{ $seller->seller_bank_ifsc }}" onkeyup="getBankDetails(this.value);">
                                                                        @error('seller_bank_ifsc')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Bank Name</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_bank_name" id="sellerBankName" value="{{ $seller->seller_bank_name }}" >
                                                                        @error('seller_bank_ifsc')
                                                                            <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Branch</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_bank_branch" id="sellerBankBranch" value="{{ $seller->seller_bank_branch }}" >
                                                                        @error('seller_bank_ifsc')
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
                                                    <th class="text-nowrap" scope="row">BALANCE</th>
                                                    <td colspan="6">{{ $seller->seller_opening_balance }}</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <th class="text-nowrap" scope="row">GST Number</th>
                                                    <td colspan="6">{{ $seller->seller_gst }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#gst_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="gst_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_gst',$seller->id) }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="profilename" class="col-form-label" style="float:left;">GST Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input class="form-control" name="seller_gst" type="text" placeholder="Enter GST" value="{{ $seller->seller_gst }}">
                                                                        @error('seller_gst')
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
                                                    <th class="text-nowrap" scope="row">PAN Number</th>
                                                    <td colspan="6">{{ $seller->seller_pan }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#pan_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="pan_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_pan',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">PAN Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="text" class="form-control" name="seller_pan" value="{{ $seller->seller_pan }}" placeholder="Enter PAN Number">
                                                                        @error('seller_pan')
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

                                                <tr>
                                                    <th class="text-nowrap" scope="row">TIN Number</th>
                                                    <td colspan="6">
                                                        {{ $seller->seller_tin }}
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#tin_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                <div id="tin_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('seller_edit_tin',$seller->id) }}">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">TIN Number</label>
                                                                    <div class="col-lg-12">
                                                                        <input  class="form-control" name="seller_tin" type="text" value="{{ $seller->seller_tin }}">
                                                                        @error('seller_tin')
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
                                                    <th class="text-nowrap" scope="row">Courier Address</th>
                                                    @php
                                                        $address_parts = explode('\ ', $seller->courier_address);
                                                    @endphp
                                                    <td colspan="6">
                                                        @foreach($address_parts as $part)
                                                            {{ $part }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#courier_address_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modal start --}}

                                                {{-- <tr>
                                                    <th class="text-nowrap" scope="row">Image</th>
                                                    <td colspan="6">
                                                        @if ($product->product_image)

                                                            <img src="{{ asset('storage/products/' . $product->product_image) }}" width="20%">
                                                        @else
                                                        {{ $product->product_image }}
                                                        @endif
                                                    <td>
                                                        <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target="#image_modal">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </button>
                                                    </td>
                                                </tr> --}}
                                                {{-- modal start --}}

                                                {{-- <div id="image_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                            <form method="POST" action="{{ route('product_edit_image',$product->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label" style="float:left;">Image</label>
                                                                    <div class="col-lg-12">
                                                                        <input type="file" class="form-control" name="product_image" rows="4">
                                                                        @error('product_image')
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
                                                </div><!-- /.modal --> --}}

                                                {{-- modal end --}}



                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        
                        <div id="courier_address_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Seller Courier Address</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('seller_edit_courier_address', $seller->id) }}">
                                                                    @csrf
                                                                    {{--  <div class="form-group mb-3">
                                                                        <label class="col-form-label">Company Name</label>
                                                                        <input type="text" class="form-control" name="company_name" value="" placeholder="Enter Company Name">
                                                                        @error('company_name')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>  --}}
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Address</label>
                                                                        <input type="text" class="form-control required" name="address" required value="{{ old('address', $address_parts[0] ?? '') }}" placeholder="Enter Address">
                                                                        @error('address')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Place</label>
                                                                        <input type="text" class="form-control required" required name="place" value="{{ old('place', $address_parts[1] ?? '') }}" placeholder="Enter Place">
                                                                        @error('place')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Post Office, PIN</label>
                                                                        <input type="text" class="form-control required" required name="post_office_pin" value="{{ old('post_office_pin', $address_parts[2] ?? '') }}" placeholder="Enter Post Office, PIN">
                                                                        @error('post_office_pin')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">District, State</label>
                                                                        <input type="text" class="form-control required" required name="district_state" value="{{ old('district_state', $address_parts[3] ?? '') }}" placeholder="Enter District, State">
                                                                        @error('district_state')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Phone Number</label>
                                                                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $address_parts[4] ?? '') }}" placeholder="Enter Phone Number">
                                                                        @error('phone_number')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary">Update Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
