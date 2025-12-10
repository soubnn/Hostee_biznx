@extends('layouts.layout')
@section('content')
    <script>
        function show_method(status) {
            var method_div = document.getElementById('method_div');
            if (status == 'not paid') {
                method_div.style.display = 'none';
            } else {
                method_div.style.display = 'block';
            }
        }
    </script>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Project Details</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">project/<a href="{{ route('project.index') }}">view
                                            projects</a>/project details</li>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Project Name</th>
                                                <td>{{ $project->project_name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Customer</th>
                                                @php
                                                    $customer = DB::table('customers')
                                                        ->where('id', $project->customer)
                                                        ->first();
                                                @endphp
                                                <td>{{ $customer->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">project Description</th>
                                                <td>{{ $project->project_description ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Satrt Date</th>
                                                <td>{{ $project->start_date }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">End Date</th>
                                                <td>{{ $project->end_date }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Budget</th>
                                                <td> {{ $project->budget ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Team Leader</th>
                                                @php
                                                    $staff = DB::table('staffs')
                                                        ->where('id', $project->team_leader)
                                                        ->first();
                                                @endphp
                                                <td>{{ $staff->staff_name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Team Members</th>
                                                @php
                                                    $team_members = '';
                                                @endphp
                                                @foreach (explode(',', $project->team_members) as $staff_id)
                                                    @php
                                                        $team = DB::table('staffs')->where('id', $staff_id)->first();
                                                        if ($team_members == '') {
                                                            @$team_members = $team->staff_name;
                                                        } else {
                                                            $team_members = $team_members . ',' . $team->staff_name;
                                                        }
                                                    @endphp
                                                @endforeach
                                                <td>{{ $team_members }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-nowrap" scope="row">Project Report</th>
                                                @if ($project->attachment1 == null)
                                                    <td>No Project Report available</td>
                                                @else
                                                    <td>
                                                        @if ($project->attachment1)
                                                            <a href="{{ asset('storage/projects/' . $project->attachment1) }}"
                                                                target="_blank">Attachment_1</a><br>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if ($project->status == 'active')
                                    <div class="button-items mt-4" style="float:right;">
                                        <button type="button" class="btn btn-warning waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#edit_modal">
                                            <i class="bx bx-pencil font-size-16 align-middle me-2"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#reject_modal">
                                            <i class="bx bx-block font-size-16 align-middle me-2"></i> Reject
                                        </button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#deliver_modal">
                                            <i class="bx bx-check-double font-size-16 align-middle me-2"></i> Delivered
                                        </button>
                                    </div>
                                @endif
                                <!-- Edit Modal -->
                                <div id="edit_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title add-task-title">Edit Project Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('project.update', $project->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="row mb-4">
                                                        <label for="projectname" class="col-form-label col-lg-2">Project
                                                            Name</label>
                                                        <div class="col-lg-10">
                                                            <input id="project_name" name="project_name" type="text"
                                                                class="form-control" placeholder="Enter Project Name"
                                                                value="{{ $project->project_name }}">
                                                            @error('project_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label for="projectname" class="col-form-label col-lg-2">Customer
                                                            Name</label>
                                                        <div class="col-lg-10">
                                                            <select id="customer" name="customer" type="text"
                                                                class="form-control select2"
                                                                data-dropdown-parent="#edit_modal" style="width:100%;">
                                                                <option selected disabled>Select Customer</option>
                                                                @php
                                                                    $customers = DB::table('customers')->get();
                                                                @endphp
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id }}"
                                                                        @if ($customer->id == $project->customer) selected @endif>
                                                                        {{ $customer->name }}, {{ $customer->place }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('customer')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label for="projectdesc" class="col-form-label col-lg-2">Project
                                                            Description</label>
                                                        <div class="col-lg-10">
                                                            <textarea class="form-control" name="project_description" rows="3" placeholder="Enter Project Description">{{ $project->project_description }}</textarea>
                                                            @error('project_description')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-form-label col-lg-2">Project Date</label>
                                                        <div class="col-lg-10">
                                                            <div class="input-daterange input-group"
                                                                id="project-date-inputgroup" data-provide="datepicker"
                                                                data-date-format="dd M, yyyy"
                                                                data-date-container='#project-date-inputgroup'
                                                                data-date-autoclose="true">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Start Date" name="start_date"
                                                                    value="{{ Carbon\carbon::parse($project->start_date)->format('d M, Y') }}" />
                                                                <input type="text" class="form-control"
                                                                    placeholder="End Date" name="end_date"
                                                                    value="{{ Carbon\carbon::parse($project->end_date)->format('d M, Y') }}" />
                                                            </div>
                                                            @error('start_date')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                            @error('end_date')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label for="projectbudget"
                                                            class="col-form-label col-lg-2">Budget</label>
                                                        <div class="col-lg-10">
                                                            <input id="projectbudget" name="budget" type="text"
                                                                placeholder="Enter Project Budget" class="form-control"
                                                                value="{{ $project->budget }}">
                                                            @error('budget')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label for="projectbudget" class="col-form-label col-lg-2">Team
                                                            Leader</label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control select2" name="team_leader"
                                                                data-dropdown-parent="#edit_modal" style="width:100%;">
                                                                <option selected disabled>Select</option>
                                                                @php
                                                                    $staffs = DB::table('staffs')->get();
                                                                @endphp
                                                                @foreach ($staffs as $staff)
                                                                    <option value="{{ $staff->id }}"
                                                                        @if ($staff->id == $project->team_leader) selected @endif>
                                                                        {{ $staff->staff_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label for="projectbudget" class="col-form-label col-lg-2">Team
                                                            Members</label>
                                                        <div class="col-lg-10">
                                                            <select class="select2 form-control select2-multiple"
                                                                name="team_members[]" data-dropdown-parent="#edit_modal"
                                                                multiple="multiple" data-placeholder="Choose ..."
                                                                style="width:100%;">
                                                                @php
                                                                    $staffs = DB::table('staffs')->get();
                                                                @endphp
                                                                @foreach ($staffs as $staff)
                                                                    <option value="{{ $staff->id }}">
                                                                        {{ $staff->staff_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label for="projectbudget" class="col-form-label col-lg-2">Project
                                                            Report</label>
                                                        <div class="col-lg-10">
                                                            <input class="form-control" name="attachment1"
                                                                type="file">
                                                            @error('attachment1')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-end">
                                                            <button type="submit" class="btn btn-primary"
                                                                id="addtask">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Deliver Modal -->
                                <div id="deliver_modal" class="modal fade bs-example-modal-center" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="Post"
                                                    action="{{ route('project.deliver', $project->id) }}">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <div class="col-lg-12">
                                                            <label class="col-form-label" style="float:left;">Payment
                                                                Status</label>
                                                            <select class="form-control select2"
                                                                data-dropdown-parent="#deliver_modal"
                                                                name="payment_status" id='payment_status'
                                                                onchange="show_method(this.value)" style="width:100%;">
                                                                <option value="not paid">Not Paid</option>
                                                                <option value="paid">Paid</option>
                                                            </select>
                                                            @error('payment_status')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12" id="method_div" style="display:none;">
                                                            <label class="col-form-label" style="float:left;">Payment
                                                                Method</label>
                                                            <select class="form-control select2"
                                                                data-dropdown-parent="#deliver_modal"
                                                                name="payment_method" id='payment_method'
                                                                style="width:100%;">
                                                                <option value="cash">Cash</option>
                                                                <option value="account">Account</option>
                                                                <option value="ledger">Ledger</option>
                                                            </select>
                                                            @error('payment_method')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12 text-end mt-3">
                                                            <button type="submit" class="btn btn-info"
                                                                id="addtask">Confirm</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Reject Modal -->
                                <div id="reject_modal" class="modal fade bs-example-modal-center" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="Post"
                                                    action="{{ route('project.reject', $project->id) }}">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <div class="col-lg-12 text-center">
                                                            <i class="dripicons-warning text-danger"
                                                                style="font-size: 50px;"></i>
                                                            <h4>Are You Sure ??</h4>
                                                            <p style="font-weight: 300px;font-size:18px;">this project will
                                                                be rejected!</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-end">
                                                            <button type="submit" class="btn btn-info"
                                                                id="addtask">Yes, reject</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    @endsection
