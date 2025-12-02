@extends('layouts.layout')
@section('content')

<script>
    $(document).ready(function(){
        $("#datatable").dataTable({
            "pageLength" : 100
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
                                    <h4 class="mb-sm-0 font-size-18">Payment History</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-12 mb-4">
                                            <a href="{{ route('staff.salarySlipReport',$staff) }}" class="btn btn-primary" target="_blank">Salary Report</a>
                                        </div>
                                        {{-- <h4 class="card-title mb-4">Daybook</h4> --}}
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Term</th>
                                                <th>leave Days</th>
                                                <th style="white-space: normal;">Description</th>
                                                <th>Accounts</th>
                                                <th>Report</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($history as $history)
                                                <tr>
                                                    <td style="white-space: normal;" class="text-danger" data-sort="">{{ Carbon\carbon::parse($history->date)->format('d-m-Y') }}</td>
                                                    <td style="white-space: normal;" class="text-danger">{{ $history->amount }}</td>
                                                    {{-- @php
                                                        $salary = DB::table('salary_payments')->where('daybook_id',$history->id)->first();
                                                    @endphp
                                                    @if($salary) --}}
                                                        @php
                                                            $term_array = explode('-',$history->term);
                                                            if($term_array[0] < 10){
                                                                $term_month_no = '0'.$term_array[0];
                                                            }
                                                            else{
                                                                $term_month_no = $term_array[0];
                                                            }
                                                            if (strlen($term_month_no) == 3) {
                                                              $term_month_no = substr($term_month_no, 1);
                                                            }
                                                            $last_salary_term = $term_array[1];
                                                            if($last_salary_term == '2'){
                                                                $current_salary_term = '2';
                                                                $current_salary_term_string = '15 to 30';
                                                            }
                                                            elseif($last_salary_term == '1'){
                                                                $current_salary_term = '1';
                                                                $current_salary_term_string = '1 to 15';
                                                            }
                                                            $year = Carbon\carbon::now()->format('Y');
                                                            $years = 20 . $term_array[2];
                                                            $term_month = Carbon\carbon::parse('01-'.$term_month_no.'-'.$years)->format('F');
                                                        @endphp
                                                        <td style="white-space: normal;" class="text-danger">{{ $years }} - {{ $term_month }} - {{ $current_salary_term_string }}</td>
                                                    {{-- @else
                                                        <td style="white-space: normal;" class="text-danger"></td>
                                                    @endif --}}
                                                    <td style="white-space: normal;" class="text-danger">
                                                        @if ($history && $history->leaveDays)
                                                            @php
                                                                $leave = $history->leaveDays-1 ;
                                                            @endphp
                                                            @if ($history->leaveDays == 1)
                                                                1 CASUAL LEAVE
                                                            @else
                                                                1 CASUAL LEAVE , {{ $leave }} LEAVE
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td style="white-space: normal;" class="text-danger">{{ $history->description }}</td>
                                                    <td style="white-space: normal;" class="text-danger">{{ $history->accounts }} @if ( $history && $history->bankReference)[{{ $history->bankReference }}]@endif</td>
                                                    <td style="white-space: normal;" class="text-danger">
                                                        @if ($history && $history->id)
                                                            <a href="{{ route('staff.termSalarySlipReport',$history->id) }}" class="btn btn-primary" target="_blank"><i class="fas fa-print"></i></a>
                                                        @endif
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

