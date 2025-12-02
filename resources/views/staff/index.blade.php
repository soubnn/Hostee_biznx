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
                                    <h4 class="mb-sm-0 font-size-18">View Staffs</h4>
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
                                                <th>Category</th>
                                                <th>Name</th>
                                                <th>Phone 1</th>
                                                <th>Salary</th>
                                                <th>DOB</th>
                                                <th>Email</th>
                                                {{-- <th>Address</th>
                                                <th>Remarks</th> --}}
                                                <th>Action</th>

                                            </tr>
                                            </thead>


                                            <tbody>
                                            @foreach($staffs as $staff)
                                                <tr>
                                                    <td>
                                                        @php
                                                            $cat_name=DB::table('employee_categories')->where('id',$staff->category_id)->first();
                                                        @endphp
                                                        {{ $cat_name->category_name }}
                                                    </td>
                                                    <td>{{$staff->staff_name}}</td>
                                                    <td>{{$staff->phone1}}</td>
                                                    <td>{{$staff->salary}}</td>
                                                    <td>{{ Carbon\carbon::parse($staff->dob)->format('d M Y')}}</td>
                                                    <td style="text-transform:lowercase;">{{$staff->email}}</td>
                                                    {{-- <td>{{$staff->address}}</td>
                                                    <td>{{$staff->remark}}</td> --}}
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                         <a  class="btn btn-light waves-effect text-info" href="{{ route('staff.edit',$staff->id) }}" >
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </a>

                                                        <!--<button type="button" class="btn btn-light waves-effect text-info" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#stModal{{$staff->id}}">-->
                                                        <!--    <i class="mdi mdi-pencil font-size-18"></i>-->
                                                        <!--</button>-->

                                                        <button type="button" class="btn btn-light waves-effect text-danger" data-bs-toggle="modal" data-bs-target="#delte_staff_modal{{$staff->id}}">
                                                            <i class="mdi mdi-delete font-size-18"></i>
                                                        </button>
                                                    </td>

                                                </tr>
                                                <!-- Modal -->
                                                <div id="stModal{{$staff->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-task-title">Edit Staff Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('staff.update',$staff->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group mb-3">
                                                                        @php
                                                                            $categories = DB::table('employee_categories')->get();
                                                                        @endphp
                                                                        <label class="col-form-label">Categories</label>
                                                                        <div class="col-lg-12">
                                                                            <select class="form-select validate" id="TaskStatus" name="category_id">
                                                                                @foreach ( $categories as $category )
                                                                                <option value="{{ $category->id }}" {{ old('category_id', ($staff->category_id == $category->id ? 'selected' : '')) }}>{{ $category->category_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskname" class="col-form-label">Name</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="taskname" name="staff_name" type="text" class="form-control validate" placeholder="" Value="{{$staff->staff_name}}" style="text-transform: uppercase;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="taskemployee_code" class="col-form-label">Employee Code</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="taskemployee_code" name="employee_code" type="text" class="form-control validate" placeholder="" Value="{{$staff->employee_code}}" style="text-transform: uppercase;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="phone1" class="col-form-label">Phone 1</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="phone1" name="phone1" type="text" class="form-control validate" placeholder="" Value="{{$staff->phone1}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="phone2" class="col-form-label">Phone 2</label>
                                                                        <div class="col-lg-12">
                                                                            <input id="phone2" name="phone2" type="text" class="form-control validate" placeholder="" Value="{{$staff->phone2}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="order-date" class="col-md-2 col-form-label">Date Of Birth</label>
                                                                        <div class="col-md-12">
                                                                            <input class="form-control" max="{{ Carbon\carbon::now()->format('Y-m-d')}}" name="dob" type="date" value="{{ $staff->dob }}" id="example-date-input" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Email Address</label>
                                                                        <div class="col-md-12">
                                                                            <input type="email" name="email" class="form-control" id="billing-email-address" value="{{ $staff->email }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Monthly salary</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" name="salary" id="salary" class="form-control" placeholder="Enter Salary" value={{ $staff->salary }}>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Address</label>
                                                                        <div class="col-lg-12">
                                                                            <textarea id="taskdesc" class="form-control" name="address" style="text-transform: uppercase;">{{ $staff->address }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label class="col-form-label">Remarks</label>
                                                                        <div class="col-lg-12">
                                                                            <textarea id="taskdesc" class="form-control" name="remark" style="text-transform: uppercase;">{{ $staff->remark }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.innerHTML='Updating...';this.form.submit();">Update Details</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <!-- Delete Modal -->
                                                <div id="delte_staff_modal{{$staff->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            {{-- <div class="modal-header"> --}}
                                                                {{-- <h5 class="modal-title add-task-title">Delete Staff Details</h5> --}}
                                                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> --}}
                                                            <div class="modal-body">
                                                                <form method="Post" action="{{ route('delete_staff',$staff->id) }}">
                                                                    @csrf
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-lg-12 text-center">
                                                                            <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                                                            <h4>Are You Sure ??</h4>
                                                                            <p style="font-weight: 300px;font-size:18px;">You can't be revert this!</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-info" id="addtask" onclick="this.disabled=true;this.innerHTML='Deleting...';this.form.submit();">Yes, delete</button>
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Close</button>

                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->




            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @endsection





