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
                        <h4 class="mb-sm-0 font-size-18">View Investment</h4>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end mb-2">
                                <button class="btn btn-primary" type="button" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#newInvestor">Add Investor</button>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Designation</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($investors as $investor)
                                    <tr>
                                        <td style="white-space: normal">{{ $investor->name }}</td>
                                        <td style="white-space: normal">{{ $investor->phone_number }}</td>
                                        <td style="white-space: normal">{{ $investor->designation }}</td>
                                        <td style="white-space: normal">{{ $investor->balance }}</td>
                                        <td style="white-space: normal">
                                            <div class="d-flex gap-3">
                                                <a href="{{ route('investment.show', $investor->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="mdi mdi-eye "></i> View
                                                </a>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editInvestorModal{{ $investor->id }}">
                                                    <i class="mdi mdi-pencil"></i> Edit
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End col -->
            </div> <!-- End row -->
            @foreach ($investors as $investor)
                @include('investment.modals.edit-investor')
            @endforeach
            @include('investment.modals.new-investor')
        </div> <!-- End container-fluid -->
    </div> <!-- End Page-content -->
</div>

@endsection
