@extends('layouts.layout')
@section('content')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                order: [[0, 'desc']],
                "pageLength": 100,
                // order: [[1, 'desc']],
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
                                    <h4 class="mb-sm-0 font-size-18">View Projects</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">project/view project</li>
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
                                        <h4 class="card-title mb-4">{{ $page_headline }}(<span style="color: rgb(247, 57, 57)">{{ $project_count }}</span>)</h4>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Customer</th>
                                                    <th>Start Date</th>
                                                    <th>Team Leader</th>
                                                    <th>View</th>
                                                    {{-- <th>View Works</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($projects as $project)
                                                    <tr>
                                                        <td style="white-space: normal"><a href="{{ route( 'project.show',$project->id ) }}">{{ $project->project_name }}</a></td>
                                                        @php
                                                            $customer = DB::table('customers')->where('id',$project->customer)->first();
                                                        @endphp
                                                        <td style="white-space: normal;">{{ $customer->name.','.$customer->place }}</td>
                                                        <td>{{ $project->start_date }}</td>
                                                        @php
                                                            $staff = DB::table('staffs')->where('id',$project->team_leader)->first();
                                                        @endphp
                                                        <td style="white-space: normal">{{ $staff->staff_name }}</td>
                                                        <td><a href="{{ route( 'project.show',$project->id ) }}">
                                                                <button type="button" class="btn btn-light waves-effect text-info">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                        {{-- <td>
                                                            <a href="{{ route( 'project.view_works',$project->id ) }}">
                                                                <button type="button" class="btn btn-light waves-effect text-info">
                                                                    <i class="mdi mdi-file"></i>
                                                                </button>
                                                            </a>
                                                        </td> --}}
                                                    </tr>
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
