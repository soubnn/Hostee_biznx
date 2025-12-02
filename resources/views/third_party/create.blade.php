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
                                    <h4 class="mb-sm-0 font-size-18">Third-Party Registration</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Third-Party Registration</h4>
                                        <p class="card-title-desc">Fill all information below</p>

                                        <form action="{{ route('store_servicer_single') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" style="float:left;">Servicer Name</label>
                                                        <input type="text" class="form-control" name="servicer_name" id="servicer_name" value="{{ old('servicer_name') }}" style="text-transform:uppercase;">
                                                        @error('servicer_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" style="float:left;">Servicer Contact</label>
                                                        <input type="text" class="form-control" name="servicer_contact" id="servicer_contact" value="{{ old('servicer_contact') }}">
                                                        @error('servicer_contact')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" style="float:left;">Servicer Place</label>
                                                        <input type="text" class="form-control" name="servicer_place" id="servicer_place" value="{{ old('servicer_place') }}" style="text-transform:uppercase;">
                                                        @error('servicer_place')
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
