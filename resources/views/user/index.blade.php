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
                                    <h4 class="mb-sm-0 font-size-18">View User</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $users as $user )
                                                    <tr>
                                                        <td style="white-space: normal">{{$user->name}}</td>
                                                        <td style="white-space: normal">{{$user->username}}</td>
                                                        <td style="white-space: normal">{{$user->email}}</td>
                                                        <td style="white-space: normal">{{$user->role}}</td>
                                                        <td style="white-space: normal">
                                                            @if ($user->status == 'active')
                                                                <button type="button" class="btn waves-effect text-danger" data-bs-toggle="modal" data-bs-target="#delete_user_modal{{$user->id}}">
                                                                    <span class="badge badge-soft-success" style="text-transform: uppercase;">{{$user->status}}</span>
                                                                </button>
                                                                @include('user.modals.delete-user')
                                                            @elseif ($user->status == 'disabled')
                                                                <button type="button" class="btn waves-effect text-danger" data-bs-toggle="modal" data-bs-target="#active_user_modal{{$user->id}}">
                                                                    <span class="badge badge-soft-danger" style="text-transform: uppercase;">{{$user->status}}</span>
                                                                </button>
                                                                @include('user.modals.active-user')
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
@endsection





