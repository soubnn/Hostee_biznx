@extends('layouts.layout')
@section('content')
    <script>
        $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">View Banks</h4>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-end mb-2">
                                    <a class="btn btn-primary" type="button" href="{{ route('banks.create') }}">Add
                                        Bank</a>
                                </div>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Book No.</th>
                                            <th>Type</th>
                                            <th>Name of Bank</th>
                                            <th>Opening Balance</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banks as $bank)
                                            <tr>
                                                <td style="white-space: normal"><b>{{ $bank->book_no }}</b></td>
                                                <td style="white-space: normal">{{ $bank->type }}</td>
                                                <td style="white-space: normal">{{ $bank->bank_name }}</td>
                                                <td style="white-space: normal">0</td>
                                                <td style="white-space: normal; color: {{ $bank->status === 'active' ? 'green' : 'red' }}">{{ $bank->status }}</td>
                                                <td style="white-space: normal">
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('banks.show', $bank->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="mdi mdi-eye "></i> View
                                                        </a>
                                                        <a class="btn btn-warning btn-sm" href="{{ route('banks.edit', $bank->id) }}">
                                                            <i class="mdi mdi-pencil"></i> Edit
                                                        </a>
                                                        {{-- <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $bank->id }}">
                                                            <i class="mdi mdi-trash-can"></i> Delete
                                                        </button> --}}
                                                        @if ( $bank->status === 'active' )
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#disableModal{{ $bank->id }}">
                                                                <i class="mdi mdi-block-helper"></i> Disable
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#enableModal{{ $bank->id }}">
                                                                <i class="mdi mdi-check"></i> Enable
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @foreach ($banks as $bank)
                            @include('bank.modals.delete-modal')
                            @include('bank.modals.enable-disable-modal')
                        @endforeach
                    </div> <!-- End col -->
                </div> <!-- End row -->
            </div> <!-- End container-fluid -->
        </div> <!-- End Page-content -->
    </div>
@endsection
