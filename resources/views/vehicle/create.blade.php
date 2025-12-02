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
                                    <h4 class="mb-sm-0 font-size-18">Vehicle Registration</h4>

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

                                        <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_number">Vehicle Number</label>
                                                        <input id="vehicle_number" name="vehicle_number" type="text" class="form-control" value="{{ old('vehicle_number') }}">
                                                        @error('vehicle_number')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_name">Vehicle Name</label>
                                                        <input id="vehicle_name" name="vehicle_name" type="text" class="form-control" value="{{ old('vehicle_name') }}">
                                                        @error('vehicle_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_model">Vehicle Model</label>
                                                        <input id="vehicle_model" name="vehicle_model" type="text" class="form-control" value="{{ old('vehicle_model') }}">
                                                        @error('vehicle_model')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="engine_number" class="col-form-label">Engine Number</label>
                                                        <input id="engine_number" name="engine_number" type="text" class="form-control validate" placeholder="" Value="{{ old('engine_number') }}">
                                                        @error('engine_number')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="chasis_number" class="col-form-label">Chasis Number</label>
                                                        <input id="chasis_number" name="chasis_number" type="text" class="form-control validate" placeholder="" Value="{{ old('chasis_number') }}">
                                                        @error('chasis_number')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">RC Details</h6>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="rc_owner">RC Owner</label>
                                                        <input id="rc_owner" name="rc_owner" type="text" class="form-control validate" placeholder="" Value="{{ old('rc_owner') }}">
                                                        @error('rc_owner')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="mb-3">
                                                        <label for="reg_validity">RC Validity</label>
                                                        <input id="reg_validity" name="reg_validity" type="date" class="form-control validate" placeholder="" Value="{{ old('reg_validity') }}">
                                                        @error('reg_validity')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="product_image">RC Document</label>
                                                        <input class="form-control" name="rc_doc" type="file">
                                                        @error('rc_doc')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Insurance Details</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="insurance_number">Insurance Policy No</label>
                                                        <input id="insurance_number" name="insurance_number" type="text" class="form-control validate" placeholder="" Value="{{ old('insurance_number') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="insurance_validity" class="col-form-label">Insurance Validity</label>
                                                        <input id="insurance_validity" name="insurance_validity" type="date" class="form-control validate" placeholder="" Value="{{ old('insurance_validity') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="product_image">Insurance Document</label>
                                                        <input class="form-control" name="insurance_doc" type="file">
                                                        @error('insurance_doc')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Pollution Details</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="pollution_validity">Pollution Validity</label>
                                                        <input id="pollution_validity" name="pollution_validity" type="date" class="form-control validate" placeholder="" Value="{{ old('pollution_validity') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="pollution_doc">Pollution Document</label>
                                                        <input class="form-control" name="pollution_doc" type="file">
                                                        @error('pollution_doc')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br><h6 style="font-weight: bold">Permit Details</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="permit_validity">Permit Validity</label>
                                                        <input id="permit_validity" name="permit_validity" type="date" class="form-control validate" placeholder="" Value="{{ old('permit_validity') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="permit_doc">Permit Document</label>
                                                        <input class="form-control" name="permit_doc" type="file">
                                                        @error('permit_doc')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Save Detals</button>
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


@endsection
