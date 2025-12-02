@extends('utility.layout')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @php
                    $profile = Auth::user();
                @endphp
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Welcome To Utility Mode</h5>
                                            <p>Dashboard</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <img src="{{ asset('storage/images/'.$profile->image) }}" alt="" class="img-thumbnail rounded-circle">
                                        </div>
                                        <h5 class="font-size-15">{{ $profile->role }}</h5>
                                        <p class="text-muted mb-0">{{ $profile->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

@endsection
