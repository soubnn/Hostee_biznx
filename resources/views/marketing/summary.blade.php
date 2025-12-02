@extends('layouts.layout')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Merketing Summary</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('marketing.summary_store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="date">Date</label>
                                                <input type="text" class="form-control" value="{{ Carbon\carbon::now()->format('d M Y') }}" readonly>
                                                <input name="date" type="hidden" value="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="no_of_customers">Total No Of Customers Visited</label>
                                                @php
                                                    $get_customer_count = DB::table('marketings')->where('employee_id',Auth::user()->id)->where('date',Carbon\carbon::now()->format('Y-m-d'))->count();
                                                @endphp
                                                <input type="text" class="form-control upper-case" value="{{ $get_customer_count }}" readonly>
                                                <input id="no_of_customers" name="no_of_customers" type="hidden" class="form-control upper-case" value="{{ $get_customer_count }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="total_fuel_amount">Total Fuel Amount</label>
                                                <input id="total_fuel_amount" name="total_fuel_amount" type="number" class="form-control upper-case" value="{{ old('total_fuel_amount') }}">
                                                @error('total_fuel_amount')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="total_km">Total KM</label>
                                                <input id="total_km" name="total_km" type="number" class="form-control upper-case validate" Value="{{ old('total_km') }}">
                                                @error('total_km')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="image" class="col-form-label">Upload Image</label>
                                                <input id="image" name="image" type="file" class="form-control" required>
                                                @error('image')
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
