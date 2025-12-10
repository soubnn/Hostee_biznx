@extends('layouts.layout')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">News and Events Form</h4> <!-- Updated Heading -->
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">news and events/<a href="{{ route('news_events.create') }}">add events</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('news_events.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Date and Title -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="date">Date</label>
                                                <input name="date" type="date" class="form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                                @error('date')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input id="title" name="title" type="text" class="form-control upper-case" value="{{ old('title') }}">
                                                @error('title')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location and Photo -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="location">Location</label>
                                                <input id="location" name="location" type="text" class="form-control" value="{{ old('location') }}">
                                                @error('location')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="photo">Photo</label>
                                                <input id="photo" name="photo" type="file" class="form-control">
                                                @error('photo')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Save Details</button>
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
