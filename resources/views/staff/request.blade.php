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
                            <h4 class="mb-sm-0 font-size-18">View Request</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="get" action="{{ route('staffs.search_request') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mt-3 mb-0">
                                                <label>Select Job</label>
                                                <select class="form-control select2" name="job_title">
                                                    <option selected disabled>Select</option>
                                                    @php
                                                        $get_jobs = DB::table('job_applications')->select('job_title')->groupBy('job_title')->get();
                                                    @endphp
                                                    @foreach ( $get_jobs as $jobs )
                                                        <option value="{{ $jobs->job_title }}">{{ $jobs->job_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100"
                                    style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Job</th>
                                            <th>District</th>
                                            <th>Qualification</th>
                                            <th>Experience</th>
                                            <th>Salary</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requests as $request)
                                            <tr>
                                                <td data-sort="">{{ $request->applicant_name }}</td>
                                                <td>{{ $request->application_date }}</td>
                                                <td style="white-space: normal;">{{ $request->job_title }}</td>
                                                <td>{{ $request->applicant_district }}</td>
                                                <td style="white-space: normal;">{{ $request->applicant_qualification }}</td>
                                                <td style="white-space: normal;">{{ $request->experience }}</td>
                                                <td>{{ $request->salary_expectation }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect text-info" data-bs-toggle="modal" data-bs-target="#view_request{{ $request->id }}">
                                                        <i class="mdi mdi-eye font-size-18"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div id="view_request{{ $request->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title add-task-title">View Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="NewtaskForm" method="POST" action="">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label for="taskname" class="col-form-label">Name</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_name }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Job Tite</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->job_title }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">State</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_state }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">District</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_district }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Qualification</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_qualification }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Experience</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->experience }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Salary</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->salary_expectation }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Gender</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_gender }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label class="col-form-label">Date Of Birth</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_dob }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label class="col-form-label">Home Town</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_hometown }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label class="col-form-label">Relocate</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->relocate }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Email</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_email }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Mobile</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->applicant_mobile }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label  class="col-form-label">Linkedin</label>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control validate" Value="{{ $request->linkedin }}" style="text-transform: uppercase;" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="col-form-label">Resume</label>
                                                                            <div class="col-lg-12">
                                                                                <a href="{{ 'https://teamtechsoul.com/'.$request->applicant_resume }}" target="_blank">
                                                                                    {{ $request->applicant_name}}- Resume
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="col-form-label">Cover Letter</label>
                                                                    <div class="col-lg-12">
                                                                        <textarea class="form-control" style="text-transform: uppercase;" rows="4" readonly>{{ $request->remarks }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_request{{ $request->id }}">Delete</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            <!-- Delete Modal -->
                                            <div id="delete_request{{ $request->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-body" style="background-color: rgb(224, 221, 221);">
                                                                <form method="Post" action="{{ route('delete_staff_request', $request->id) }}">
                                                                    @csrf
                                                                    <div class="form-group mb-3">
                                                                        <div class="col-lg-12 text-center">
                                                                            <i class="dripicons-warning text-danger" style="font-size: 50px;">
                                                                            </i>
                                                                            <h4>Are You Sure ??</h4>
                                                                            <p style="font-weight: 300px;font-size:18px;">
                                                                                You can't be revert this!
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-end">
                                                                            <button type="submit" class="btn btn-info" id="addtask">Yes, delete</button>
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
