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
                            <h4 class="mb-sm-0 font-size-18">Staff Registration</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">

                    <div class="col-xl-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">


                                            <h4 class="card-title">Personal information</h4>
                                            <p class="card-title-desc">Fill all information below</p>


                                            <form method="POST" action="{{ route('staff.store') }}">
                                                @csrf
                                                <div class="form-group row mb-4">
                                                    @php
                                                        $categories = DB::table('employee_categories')->get();
                                                    @endphp
                                                    <label for="service-type" class="col-md-2 col-form-label">Categories</label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" style="width:100%;" id="category_id" name="category_id" value={{ old('category_id') }}>
                                                            @foreach ( $categories as $category )
                                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                @error('category_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <div class="form-group row mb-4">
                                                    <label for="billing-name" class="col-md-2 col-form-label">Name</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="staff_name" placeholder="Enter name" name="staff_name" value="{{ old('staff_name') }}" style="text-transform: uppercase;">
                                                        @error('staff_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-employee_code" class="col-md-2 col-form-label">Employee Code</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="employee_code" placeholder="Enter Employee Code" name="employee_code" value="{{ old('employee_code') }}" style="text-transform: uppercase;">
                                                        @error('employee_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-phone" class="col-md-2 col-form-label">Phone 1</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="phone1" placeholder="Enter Phone no." name="phone1" value={{ old('phone1') }}>
                                                        @error('phone1')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-phone" class="col-md-2 col-form-label">Phone 2</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="phone2" placeholder="Enter Phone no." name="phone2" value={{ old('phone2') }}>
                                                        @error('phone2')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="order-date" class="col-md-2 col-form-label">Date Of Birth</label>
                                                    <div class="col-md-10">
                                                        <div class="input-group" id="datepicker1">
                                                            <input type="text" name="dob" id="dob" class="form-control" data-date-end-date="{{ Carbon\carbon::now()->format('d M Y')}}" placeholder="Select date" data-date-format="dd M yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true" value="{{ old('dob')}}" >
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('dob')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Email Address</label>
                                                    <div class="col-md-10">
                                                        <input type="email" name="email" id="email" class="form-control" id="billing-email-address" placeholder="Enter email" value="{{ old('email') }}" style="text-transform: lowercase;">
                                                        @error('email')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Monthly salary</label>
                                                    <div class="col-md-10">
                                                        <input type="number" name="salary" id="salary" class="form-control" placeholder="Enter Salary" value={{ old('salary') }}>
                                                        @error('salary')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Join Date</label>
                                                    <div class="col-md-10">
                                                        <input type="date" name="join_date" id="join_date" class="form-control"  value={{ old('join_date') }}>
                                                        @error('join_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="address" class="col-md-2 col-form-label">Address</label>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter full address" style="text-transform: uppercase;">{{ old('address') }}</textarea>
                                                        @error('address')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-0">
                                                    <label for="example-textarea" class="col-md-2 col-form-label">Remarks</label>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="remark" id="remark" rows="3" placeholder="Write some remarks.." style="text-transform: uppercase;">{{ old('remark') }}</textarea>
                                                        @error('remark')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end col -->
                                            <div class="col-sm-12 mb-4" >
                                                <div class="text-end"style="margin-right: 20px;">

                                                    <input type="submit" value="Add Staff" onclick="this.disabled=true;this.value='Adding...';this.form.submit();" class="btn btn-success">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- container-fluid -->

                            <!-- End Page-content -->

@endsection
