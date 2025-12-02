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
                                    <h4 class="mb-sm-0 font-size-18">Ledger Group</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Group Information</h4>

                                        <form action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data" id="purchaseForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label for="group_name">Group Name</label>
                                                        <input id="group_name" name="group_name" type="text" class="form-control" value="{{ old('group_name') }}" style="text-transform: uppercase;">
                                                        @error('group_name')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mt-1">
                                                    <div class="mb-3">
                                                        <label class="control-label">Parent Group</label>
                                                        <select class="form-control select2" name="group_subgroup" id="group_subgroup">
                                                            <option disabled selected>Select Group</option>
                                                            @foreach ($groups as $group)
                                                                <option value="{{ $group->group_name }}">{{ $group->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('group_subgroup')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="purchase_submit_btn" >Add Group</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card-->
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table datatable nowrap w-100 table-bordered table-striped" id="datatable">
                                            <thead>
                                                <th>Group</th>
                                                <th>Belongs to</th>
                                                <th>Delete</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($groups as $group)
                                                <tr>
                                                    <td>{{ $group->group_name }}</td>
                                                    <td>{{ $group->group_subgroup }}</td>
                                                    @if($group->group_subgroup == "Parent")
                                                    <td>---</td>
                                                    @else
                                                    <td><a href="{{ route('deleteGroup',$group->id) }}"><i class="fa fa-trash btn text-danger"></i></a></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
