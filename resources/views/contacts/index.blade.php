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
    <script>
        $(document).ready(function() {
            $("#datatable").dataTable({
                "pageLength": 100
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
                            <h4 class="mb-sm-0 font-size-18">View Enquiries</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100"
                                    style="text-transform: uppercase;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            @if ($contact->status == 'unread')
                                                @php
                                                    $table_class = 'table-success';
                                                @endphp
                                            @else
                                                @php
                                                    $table_class = 'table-light';
                                                @endphp
                                            @endif
                                            <tr class="{{ $table_class }}">
                                                <td>
                                                    {{ Carbon\carbon::parse($contact->date)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->contact }}</td>
                                                <td>
                                                    <a class="btn btn-light text-primary"
                                                        href="{{ route('contact.show', $contact->id) }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                </td>
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
