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
                                    <h4 class="mb-sm-0 font-size-18">Journal</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Code</th>
                                                <td>{{ $journal->journal_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Journal Name</th>
                                                <td style="white-space: normal">{{ $journal->journal_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Journal Group</th>
                                                <td style="white-space: normal">{{ $group->group_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Opening Balance</th>
                                                <td>{{ $journal->opening_balance }}</td>
                                            </tr>
                                            <tr>
                                                <th>Current Balance</th>
                                                <td>{{ $journal->balance }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Information</th>
                                                <td style="white-space: normal">
                                                    <textarea class="form-control" readonly>{{ $journal->contact_info }}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-md-2">
                                            <a href="#!" onclick="window.history.back()" class="btn btn-primary">Go Back</a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <!-- end card-->
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
