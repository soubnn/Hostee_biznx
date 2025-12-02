@extends('layouts.layout')
@section('content')
    <!--<script>-->
    <!--    $(function() {-->
    <!--            $("input[type='text']").keyup(function() {-->
    <!--                this.value = this.value.toLocaleUpperCase();-->
    <!--            });-->
    <!--            $('textarea').keyup(function() {-->
    <!--                this.value = this.value.toLocaleUpperCase();-->
    <!--            });-->
    <!--    });-->
    <!--</script>-->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Staff Edit</h4>

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


                                            <form method="POST" action="{{ route('updateStaff',$staff->id) }}">
                                                @csrf
                                                <div class="form-group row mb-4">
                                                    <label for="service-type" class="col-md-2 col-form-label">Categories</label>
                                                    <div class="col-md-10">
                                                        <select class="form-select validate" id="TaskStatus" name="category_id">
                                                            @foreach ( $categories as $category )
                                                            <option value="{{ $category->id }}" {{ old('category_id', ($staff->category_id == $category->id ? 'selected' : '')) }}>{{ $category->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-name" class="col-md-2 col-form-label">Name</label>
                                                    <div class="col-md-10">
                                                        <input id="taskname" name="staff_name" type="text" class="form-control validate" placeholder="" Value="{{$staff->staff_name}}" style="text-transform: uppercase;">
                                                        @error('staff_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-employee_code" class="col-md-2 col-form-label">Employee Code</label>
                                                    <div class="col-md-10">
                                                        <input id="taskemployee_code" name="employee_code" type="text" class="form-control validate" placeholder="" Value="{{$staff->employee_code}}" style="text-transform: uppercase;">
                                                        @error('employee_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-phone" class="col-md-2 col-form-label">Phone 1</label>
                                                    <div class="col-md-10">
                                                        <input id="phone1" name="phone1" type="text" class="form-control validate" placeholder="" Value="{{$staff->phone1}}">
                                                        @error('phone1')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-phone" class="col-md-2 col-form-label">Phone 2</label>
                                                    <div class="col-md-10">
                                                        <input id="phone2" name="phone2" type="text" class="form-control validate" placeholder="" Value="{{$staff->phone2}}">
                                                        @error('phone2')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="order-date" class="col-md-2 col-form-label">Date Of Birth</label>
                                                    <div class="col-md-10">
                                                        <div class="input-group" id="datepicker1">
                                                            <input class="form-control" max="{{ Carbon\carbon::now()->format('Y-m-d')}}" name="dob" type="date" value="{{ $staff->dob }}" id="example-date-input" >
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
                                                        <input type="email" name="email" class="form-control" id="billing-email-address" value="{{ $staff->email }}">
                                                        @error('email')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Monthly salary</label>
                                                    <div class="col-md-10">
                                                        <input type="number" name="salary" id="salary" class="form-control" placeholder="Enter Salary" value={{ $staff->salary }}>
                                                        @error('salary')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <label for="order-date" class="col-md-2 col-form-label">Date Of Join</label>
                                                    <div class="col-md-10">
                                                        <div class="input-group" id="datepicker1">
                                                            <input class="form-control" max="{{ Carbon\carbon::now()->format('Y-m-d')}}" name="join_date" type="date" value="{{ $staff->join_date }}" id="example-date-input" >
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('join_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="example-textarea" class="col-md-2 col-form-label">Remarks</label>
                                                    <div class="col-md-10">
                                                        <textarea id="taskdesc" class="form-control" name="remark" style="text-transform: uppercase;">{{ $staff->remark }}</textarea>
                                                        @error('remark')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- end col -->
                                                <div class="col-sm-12 mb-4" >
                                                    <div class="text-end"style="margin-right: 20px;">
                                                        <button type="submit" class="btn btn-success">Submit</button>
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
