    @extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
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
                                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">profile/view profile</a></li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                    @php
                        $profile=Auth::user();
                    @endphp




                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div>
                                                <img src="{{ asset('storage/images/'.$profile->image) }}" alt="" style="object-fit: cover" class="img-fluid mx-auto profile-images">
                                            </div>

                                        </div>

                                        <div class="col-sm-2">
                                            <div class="text-sm-end mt-4 mt-sm-0">
                                                <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        <form method="POST" action="{{ route('editprofileimage',$profile->id) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                            <div class="modal-body">
                                                                <input class="form-control" name="image" type="file">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Upadte</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-top">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div>
                                                <h4>Role</h5>
                                                @if($profile->role == "intern")
                                                <h5 class="mt-4 text-muted">user</h5>
                                                @else
                                                <h5 class="mt-4 text-muted">{{ $profile->role }}</h5>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div>
                                                <h4>Name</h5>
                                                <h5 class="mt-4 text-muted">{{ $profile->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="text-sm-end mt-4 mt-sm-0">
                                                <button type="button" class="btn btn-light waves-effect text-success" href="#" id="editname" data-id="#up-name" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title add-task-title">Edit Name</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{-- <form id="EditName" role="form"> --}}
                                                                    <form method="POST" action="{{ route('editprofilename',$profile->id) }}">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                        <div class="form-group mb-3">
                                                                            <label for="profilename" class="col-form-label" style="float:left;">Name</label>
                                                                            <div class="col-lg-12">
                                                                                <input name="name" type="text" class="form-control validate" placeholder="" Value="{{ $profile->name }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 text-end">
                                                                                <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div>
                                                <h4>Password</h5>
                                                <h5 class="mt-4">*****</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="text-sm-end mt-4 mt-sm-0">
                                                <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </button>
                                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title" >Edit Password</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- <form id="NewtaskForm" role="form"> --}}
                                                                <form method="POST" action="{{ route('editpassword',$profile->id) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskname" class="col-form-label" style="float:left;">New Password</label>
                                                                        <div class="col-lg-12">
                                                                            <input name="password" type="password" class="form-control validate" placeholder="enter password" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->role == "admin")
                                @php
                                $metaData = DB::table('meta_data')->where('meta_key','keywords')->first();
                                @endphp
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div>
                                                <h4>Meta Keywords</h5>
                                                <h5 class="mt-4">{{ $metaData->meta_content }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="text-sm-end mt-4 mt-sm-0">
                                                <button type="button" class="btn btn-light waves-effect text-success" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center-1">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </button>
                                                <div class="modal fade bs-example-modal-center-1" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title" >Edit Keywords</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- <form id="NewtaskForm" role="form"> --}}
                                                                <form method="POST" action="{{ route('updateKeywords') }}">
                                                                        @csrf
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskname" class="col-form-label" style="float:left;">Keywords</label>
                                                                        <div class="col-lg-12">
                                                                            <textarea name="meta_content" class="form-control validate" style="height:100px;">{{ $metaData->meta_content }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" id="addtask">Update Changes</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>







                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection
