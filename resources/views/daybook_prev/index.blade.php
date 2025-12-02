@extends('layouts.layout')
@section('content')

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Prev Accounts</h4>
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('prev_accounts.export.csv') }}" class="btn btn-primary">Generate Excel</a>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Daybook</h4>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th style="white-space: normal;">Expense</th>
                                                    <th style="white-space: normal;">Income</th>
                                                    <th>Amount</th>
                                                    <th>Accounts</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($daybooks as $daybook)

                                                <tr>
                                                    @if($daybook->type == "Expense")
                                                        <td class="text-success" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td class="text-danger" style="white-space: normal;">{{ $daybook->expense }}</td>
                                                        <td></td>
                                                        <td class="text-danger">{{ $daybook->amount }}</td>
                                                        <td class="text-danger">{{ $daybook->accounts }}</td>
                                                    @endif
                                                    @if($daybook->type == "Income")
                                                        <td class="text-success" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td></td>
                                                        <td class="text-success" style="white-space: normal;">{{ $daybook->income }}</td>
                                                        <td class="text-success">{{ $daybook->amount }}</td>
                                                        <td class="text-success">{{ $daybook->accounts }}</td>
                                                    @endif
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

