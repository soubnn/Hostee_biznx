@extends('layouts.layout')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Merketing Data</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('marketing.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="date">Date</label>
                                                <input name="date" type="date" class="form-control" value="{{ Carbon\carbon::now()->format('Y-m-d') }}" max="{{ Carbon\carbon::now()->format('Y-m-d') }}" min="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                                                @error('date')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="customer_name">Customer Name</label>
                                                <input id="customer_name" name="customer_name" type="text" class="form-control upper-case" value="{{ old('customer_name') }}">
                                                @error('customer_name')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="contact_no">Contact Number</label>
                                                <input id="contact_no" name="contact_no" type="text" class="form-control upper-case" value="{{ old('contact_no') }}">
                                                @error('contact_no')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="job_role">Job role</label>
                                                <input id="job_role" name="job_role" type="text" class="form-control upper-case validate" Value="{{ old('job_role') }}">
                                                @error('job_role')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="company_name" class="col-form-label">Company Name</label>
                                                <input id="company_name" name="company_name" type="text" class="form-control upper-case validate" placeholder="" Value="{{ old('company_name') }}">
                                                @error('company_name')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="company_category" class="col-form-label">Company Category</label>
                                                <input id="company_category" name="company_category" type="text" class="form-control upper-case validate" placeholder="" Value="{{ old('company_category') }}">
                                                @error('company_category')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="company_place" class="col-form-label">Company Place</label>
                                                <input id="company_place" name="company_place" type="text" class="form-control upper-case validate" placeholder="" Value="{{ old('company_place') }}">
                                                @error('company_place')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label for="" class="col-form-label">KM to location</label>
                                                <input id="km_to_location" name="km_to_location" type="number" class="form-control upper-case validate" placeholder="" Value="{{ old('km_to_location') }}">
                                                @error('km_to_location')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label for="petrol_amount" class="col-form-label">Petrol Amount</label>
                                                <input id="petrol_amount" name="petrol_amount" type="number" class="form-control upper-case validate" placeholder="" Value="{{ old('petrol_amount') }}">
                                                @error('petrol_amount')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="visit" class="col-form-label">Visit</label>
                                                <select class="select2 form-control" name="visit">
                                                    <option value="1" selected>1</option>
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
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="" class="col-form-label">Remarks</label>
                                                <textarea class="form-control upper-case" name="remarks">{{ old('remarks') }}</textarea>
                                                @error('remarks')
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
