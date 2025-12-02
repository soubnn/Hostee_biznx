@extends('layouts.layout')

@section('content')
<script>
    $(function() {
        $("input[type='text']").keyup(function() {
            this.value = this.value.toUpperCase();
        });
        $('textarea').keyup(function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Banks</h4>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <!-- Form Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('banks.store')}}">
                                @csrf

                                <div class="row">
                                    <!-- Bank Type -->
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">Types</label>
                                        <select class="form-control" id="type" name="type">
                                            <option selected disabled>Select Type</option>
                                            <option value="Rent" {{ old('type') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                            <option value="Kuri" {{ old('type') == 'Kuri' ? 'selected' : '' }}>Kuri</option>
                                            <option value="Savings" {{ old('type') == 'Savings' ? 'selected' : '' }}>Savings</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Name of Bank -->
                                    <div class="col-md-6 mb-3">
                                        <label for="bank_name" class="form-label">Name of Bank</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                                        @error('bank_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Acc No. -->
                                    <div class="col-md-6 mb-3">
                                        <label for="acc_no" class="form-label">Account Number</label>
                                        <input type="number" class="form-control" id="acc_no" name="acc_no" value="{{ old('acc_no') }}">
                                        @error('acc_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Bank No. -->
                                    <div class="col-md-6 mb-3">
                                        <label for="book_no" class="form-label">Book Number</label>
                                        <input type="number" class="form-control" id="book_no" name="book_no" value="{{ old('book_no') }}">
                                        @error('book_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Name of Biller -->
                                    <div class="col-md-6 mb-3">
                                        <label for="biller_name" class="form-label">Name of Biller</label>
                                        <input type="text" class="form-control" id="biller_name" name="biller_name" value="{{ old('biller_name') }}">
                                        @error('biller_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Balance -->
                                    <div class="col-md-6 mb-3">
                                        <label for="opening_balance" class="form-label">Opening Balance</label>
                                        <input type="number" class="form-control" id="opening_balance" name="opening_balance" value="{{ old('opening_balance', 0)}}">
                                        @error('opening_balance')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Adding...';this.form.submit();">
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- End col -->
            </div> <!-- End row -->

        </div> <!-- End container-fluid -->
    </div> <!-- End Page-content -->
</div>
@endsection
