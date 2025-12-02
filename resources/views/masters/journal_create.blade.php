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
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Journals</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <form action="{{ route('journals.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label for="journal_code">Journal Code</label>
                                                        <input id="journal_code" name="journal_code" type="text" class="form-control" value="{{ old('journal_code') }}" placeholder="Journal Code">
                                                        @error('journal_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label for="journal_name">Journal Name</label>
                                                        <input id="journal_name" name="journal_name" type="text" class="form-control" value="{{ old('journal_name') }}" placeholder="Journal Name">
                                                        @error('journal_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label class="control-label">Journal Group</label>
                                                        <select class="form-control select2" name="journal_group" id="journal_group">
                                                            <option disabled selected>Select Group</option>
                                                            @foreach ($groups as $group)
                                                                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('journal_group')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label for="opening_balance">Opening Balance</label>
                                                        <input id="opening_balance" name="opening_balance" type="number" class="form-control" value="{{ old('opening_balance',0) }}" placeholder="Opening Balance">
                                                        @error('opening_balance')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label for="contact_info">Contact Information</label>
                                                        <textarea id="contact_info" name="contact_info" class="form-control">
                                                            {{ old('contact_info') }}
                                                        </textarea>
                                                        @error('contact_info')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="purchase_submit_btn" >Add Journal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card-->
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
