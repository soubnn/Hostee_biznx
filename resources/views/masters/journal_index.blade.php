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
                                    <h4 class="mb-sm-0 font-size-18">chart of accounts</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table datatable nowrap w-100 table-bordered table-striped" id="datatable">
                                            <thead>
                                                <th>Code</th>
                                                <th>Journal Name</th>
                                                <th>Group</th>
                                                <th>Balance</th>
                                                <th>View</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($journals as $journal)
                                                <tr>
                                                    <td>{{ $journal->journal_code }}</td>
                                                    <td>{{ $journal->journal_name }}</td>
                                                    @php
                                                        $group = DB::table('groups')->where('id',$journal->journal_group)->first();
                                                    @endphp
                                                    <td>{{ $group->group_name }}</td>
                                                    <td>{{ $journal->balance }}</td>                                                
                                                    <td>
                                                        <a class="btn btn-info" href="{{ route('journals.show',$journal->id) }}">View&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                                    </td>
                                                    {{-- @else
                                                    <td><a href="{{ route('deletejournal',$journal->id) }}"><i class="fa fa-trash btn text-danger"></i></a></td>
                                                    @endif --}}
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
