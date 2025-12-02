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
    function validate_amount(pay_amount, staff_id){
        let balance = document.getElementById('balance_amount_'+staff_id).value;
        let error_msg = document.getElementById('amount_error_msg_'+staff_id);
        let pay_amount_input = document.getElementById('amount_'+staff_id);
        error_msg.style.display = 'none';
        console.log(balance);
        if(parseFloat(pay_amount) > parseFloat(balance)){
            pay_amount_input.value = 0;
            error_msg.style.display = 'block';
        }
    }
    function term_validate_amount(pay_amount, staff_id){
        let balance = document.getElementById('amount'+staff_id).value;
        let error_msg = document.getElementById('amount_error_msg_'+staff_id);
        let pay_amount_input = document.getElementById('PayingAmount'+staff_id);
        error_msg.style.display = 'none';
        console.log(balance);
        if(parseFloat(pay_amount) > parseFloat(balance)){
            pay_amount_input.value = 0;
            error_msg.style.display = 'block';
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
                                    <h4 class="mb-sm-0 font-size-18">Staff Payments</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-head">
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered dt-responsive nowrap w-100" id="data-table" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Staff Name</th>
                                                    <th>Term</th>
                                                    <th>History</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staffs as $staff)
                                                    <tr>
                                                        <td>{{ $staff->staff_name }}</td>
                                                        @php
                                                            $last_term_salary = DB::table('salary_payments')->where('staff_id',$staff->id)->where('payment_type','salary')->latest('id')->first();
                                                            $today_color = Carbon\carbon::now()->format('Y-m-d');
                                                            if($last_term_salary == Null){
                                                                if ($staff->join_date){
                                                                    $day = Carbon\carbon::parse($staff->join_date)->format('d');
                                                                    $month = intval(Carbon\Carbon::parse($staff->join_date)->format('m'));
                                                                    $year_string =  substr(Carbon\Carbon::parse($staff->join_date)->format('Y'), -2);
                                                                    $year = Carbon\carbon::parse($staff->join_date)->format('Y');
                                                                    $month_string = Carbon\carbon::parse($staff->join_date)->format('F');
                                                                    if($month == 12){
                                                                        $color_month = '1';
                                                                        $color_month_year = $year + 1;
                                                                    }else{
                                                                        $color_month = $month + 1;
                                                                        $color_month_year = $year;
                                                                    }
                                                                    $check_date =  str_pad($color_month, 2, '0', STR_PAD_LEFT);
                                                                    $color_day = $day.'-'.$check_date.'-'.$color_month_year;
                                                                    $color_date = Carbon\carbon::parse($color_day)->format('Y-m-d');
                                                                    if($today_color >= $color_date){
                                                                        $color = 'text-danger';
                                                                    }else{
                                                                        $color = 'text-success';
                                                                    }
                                                                } else {
                                                                    $day = Carbon\carbon::now()->format('d');
                                                                    $month = intval(Carbon\Carbon::now()->format('m'));
                                                                    $year_string =  substr(Carbon\Carbon::now()->format('Y'), -2);
                                                                    $year = Carbon\carbon::now()->format('Y');
                                                                    $month_string = Carbon\carbon::now()->format('F');
                                                                    $color = 'text-success';
                                                                }
                                                                if($day <= 15){
                                                                    $current_term = $month.'-1-' . $year_string;
                                                                    $current_term_string  = $year . '-' . $month_string . ' (1 to 15)';
                                                                }
                                                                else{
                                                                    $current_term = $month.'-2-'. $year_string;;
                                                                    $current_term_string  = $year . '-' . $month_string.' (15 to 30)';
                                                                }
                                                                $lastTermSalaryTerm = '';
                                                                $lastTermSalaryLleaveDays = '';
                                                                $lastTermSalaryDescription = '';
                                                            }else{
                                                                if ($last_term_salary->status	== 'paid') {
                                                                    $last_salary_month_term = explode('-',$last_term_salary->term);
                                                                    $last_salary_month = $last_salary_month_term[0];
                                                                    $last_salary_term = $last_salary_month_term[1];
                                                                    $last_salary_year = $last_salary_month_term[2];
                                                                    if($last_salary_term == '1'){
                                                                        $current_salary_month = $last_salary_month;
                                                                        $current_salary_term = '2';
                                                                        $current_salary_term_string = '15 to 30';
                                                                        if($current_salary_month == '12'){
                                                                            $last_salary_month_color = '01';
                                                                            $last_salary_year = $last_salary_year+1;
                                                                        }else{
                                                                            $last_salary_month_color = str_pad($current_salary_month+1, 2, '0', STR_PAD_LEFT);
                                                                        }
                                                                        $color_day = '05-'.$last_salary_month_color.'-20'.$last_salary_year;
                                                                    }
                                                                    elseif($last_salary_term == '2'){
                                                                        if($last_salary_month == '12'){
                                                                            $current_salary_month = '1';
                                                                            $last_salary_year_color = $last_salary_year+1;
                                                                        }
                                                                        else{
                                                                            $current_salary_month = $last_salary_month+1;
                                                                            $last_salary_year_color = $last_salary_year;
                                                                        }
                                                                        $current_salary_term = '1';
                                                                        $current_salary_term_string = '1 to 15';
                                                                        
                                                                        $last_salary_month_color = str_pad($current_salary_month, 2, '0', STR_PAD_LEFT);
                                                                        $color_day = '20-'.$last_salary_month_color .'-20'.$last_salary_year_color;
                                                                    }
                                                                    if ( $current_salary_month == 1 && $current_salary_term == 1) {
                                                                        $currentTermYear = $last_salary_month_term[2] + 1;
                                                                    }else{
                                                                        $currentTermYear = $last_salary_month_term[2];
                                                                    }
                                                                    $year =  20 . $currentTermYear;
                                                                    $current_term = $current_salary_month.'-'.$current_salary_term.'-'.$currentTermYear;
                                                                    $current_term_month_string = Carbon\carbon::parse('01-'.$current_salary_month.'-'.$year)->format('F');
                                                                    $current_term_string = $year .' - '. $current_term_month_string.' ('.$current_salary_term_string . ')';
                                                                    $current_term_advance = DB::table('salary_payments')->where('staff_id',$staff->id)->where('payment_type','advance')->where('term',$current_term)->sum('amount');
                                                                    if($current_term_advance == 0){
                                                                        $advance = 0;
                                                                    }
                                                                    else{
                                                                        $advance = $current_term_advance;
                                                                    }
                                                                    $balance = ($staff->salary) - $advance;
                                                                    $balancePaymentAmount = '';
                                                                    
                                                                    $color_date = Carbon\carbon::parse($color_day)->format('Y-m-d');
                                                                    if($today_color >= $color_date){
                                                                        $color = 'text-danger';
                                                                    }else{
                                                                        $color = 'text-success';
                                                                    }

                                                                }else {
                                                                    $last_salary_month_term = explode('-',$last_term_salary->term);
                                                                    $last_salary_month = $last_salary_month_term[0];
                                                                    $last_salary_term = $last_salary_month_term[1];
                                                                    $currentTermYear = $last_salary_month_term[2];

                                                                    $current_salary_month = $last_salary_month;
                                                                    if ($last_salary_term == '1') {
                                                                        $current_salary_term = '1';
                                                                        $current_salary_term_string = '1 to 15';
                                                                    }elseif ($last_salary_term == '2') {
                                                                        $current_salary_term = '2';
                                                                        $current_salary_term_string = '15 to 30';
                                                                    }
                                                                    $year =  20 . $currentTermYear;
                                                                    $current_term = $current_salary_month.'-'.$current_salary_term.'-'.$currentTermYear;
                                                                    $current_term_month_string = Carbon\carbon::parse('01-'.$current_salary_month.'-'.$year)->format('F');
                                                                    $current_term_string = $year .' - '. $current_term_month_string.' ('.$current_salary_term_string . ')';
                                                                    $totalAllowanceAmount = 0;
                                                                    if ($last_term_salary->description) {
                                                                        $allowanceAmounts = explode(',',$last_term_salary->description);
                                                                        foreach ( $allowanceAmounts as $allowanceAmount ) {
                                                                            $allowanceParts = explode(' - ', $allowanceAmount);
                                                                            $totalAllowanceAmount += $allowanceParts[1];
                                                                        }
                                                                    }
                                                                    $currentLeaveDays = $last_term_salary->leaveDays;
                                                                    $currentBasicSalary = $last_term_salary->basic_salary;
                                                                    if ($currentLeaveDays > 1){
                                                                        $leaveDays = $currentLeaveDays - 1;
                                                                        $casualLeaveDay = 1;
                                                                    }else{
                                                                        $leaveDays = 0;
                                                                        $casualLeaveDay = 0;
                                                                    }
                                                                    $currentSalaryAmont = $currentBasicSalary - ($currentBasicSalary * 24 * $leaveDays)/300;
                                                                    $lastAmount = DB::table('salary_payments')->where('staff_id',$staff->id)->where('term',$last_term_salary->term)->sum('amount');
                                                                    $lastTotalAmount = $currentSalaryAmont + $totalAllowanceAmount;
                                                                    $balancePaymentAmount = $lastTotalAmount - $lastAmount;
                                                                    
                                                                    $color = 'text-danger';
                                                                }
                                                                $lastTermSalaryStatus = $last_term_salary->status;
                                                                $lastTermSalaryTerm = $last_term_salary->term;
                                                                $lastTermSalaryLleaveDays = $last_term_salary->leaveDays;
                                                                $lastTermSalaryDescription = $last_term_salary->description;
                                                            }
                                                        @endphp

                                                        <td class="{{ $color }}">{{ $current_term_string }} &nbsp;  [<b>{{ $staff->salary}}</b>]</td>
                                                        <td>
                                                            <a class="btn btn-light text-primary" href="{{ route('staff.payment.history',$staff->id) }}">
                                                                View
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#advance_modal{{ $staff->id }}">Pay Salary</button>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div id="advance_modal{{$staff->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title add-task-title">Salary</h5>[{{ $staff->staff_name }}]
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('staff.store_advance',$staff->id) }}">
                                                                        @csrf
                                                                        @if ($lastTermSalaryStatus	== 'paid')
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Upcoming Salary Term</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" value="{{ $current_term_string }}" readonly>
                                                                                    <input type="hidden" name="term" class="form-control" value="{{ $current_term }}" >
                                                                                    <input type="hidden" name="lastTerm" class="form-control" value="{{ $lastTermSalaryTerm }}" >
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Basic  Salary</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" id="basicSalary{{$staff->id}}" class="form-control" value="{{ $staff->salary}}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Working Days</label>
                                                                                <div class="col-md-2">
                                                                                    <input type="text" class="form-control" value="15" readonly>
                                                                                </div>
                                                                                @if ( $current_salary_term == 2)
                                                                                    @if ( $lastTermSalaryLleaveDays == NULL)
                                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Casual Leave</label>
                                                                                        <div class="col-md-1">
                                                                                            <input type="checkbox" style="margin-top: 12px" id="casualLeave{{$staff->id}}" onchange="toggleLeaveDays(this, {{$staff->id}})">
                                                                                        </div>
                                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Leave Days</label>
                                                                                        <div class="col-md-2">
                                                                                            <input type="text" id="leaveDays{{$staff->id}}" onkeyup="getPayablesalary({{$staff->id}}); generateDescription({{$staff->id}}); generateLeaveDays({{$staff->id}})" class="form-control" value="0" disabled>
                                                                                        </div>
                                                                                        <input type="hidden" name="leaveDays" id="leaveDayshidden{{$staff->id}}">
                                                                                    @else
                                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Leave Days</label>
                                                                                        <div class="col-md-2">
                                                                                            <input type="text" name="leaveDays" id="leaveDays{{$staff->id}}" onkeyup="getPayablesalary({{$staff->id}}); generateDescription({{$staff->id}}); generateLeaveDays({{$staff->id}})" class="form-control" value="0">
                                                                                        </div>
                                                                                    @endif
                                                                                @else
                                                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Casual Leave</label>
                                                                                    <div class="col-md-1">
                                                                                        <input type="checkbox" style="margin-top: 12px" id="casualLeave{{$staff->id}}" onchange="toggleLeaveDays(this, {{$staff->id}})">
                                                                                    </div>
                                                                                    <label for="billing-email-address" class="col-md-2 col-form-label">Leave Days</label>
                                                                                    <div class="col-md-2">
                                                                                        <input type="text" id="leaveDays{{$staff->id}}" onkeyup="getPayablesalary({{$staff->id}}); generateDescription({{$staff->id}}); generateLeaveDays({{$staff->id}})" class="form-control" value="0" disabled>
                                                                                    </div>
                                                                                    <input type="hidden" name="leaveDays" id="leaveDayshidden{{$staff->id}}">
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Payable Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" id="paybleAmount{{$staff->id}}" value="{{ $staff->salary }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div id="additionalAllowanceFields{{ $staff->id }}"></div>
                                                                            <div class="form-group row mb-4" style="display: none">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Allowance Name</label>
                                                                                <div class="col-md-3">
                                                                                    <input type="text" class="form-control" >
                                                                                </div>
                                                                                <label for="billing-email-address" class="col-md-2 col-form-label">Amount</label>
                                                                                <div class="col-md-3">
                                                                                    <input type="text" class="form-control"  >
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <div class="col-md-9 offset-md-3 text-end">
                                                                                    <button type="button" class="btn btn-secondary" onclick="addAllowance({{$staff->id}}); generateLeaveDays({{$staff->id}})">Add Allowance</button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Total Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="number" name="totalAmount" id="amount{{$staff->id}}" class="form-control" placeholder="Enter amount" value="{{ $staff->salary}}" min="0" max="" readonly>
                                                                                    @error('amount')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Paying Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="number" name="amount" id="PayingAmount{{$staff->id}}" class="form-control" placeholder="Enter amount" value="{{ $staff->salary }}" onkeyup="term_validate_amount(this.value,{{$staff->id}});" onchange="term_validate_amount(this.value,{{$staff->id}});">
                                                                                    <span class="text-danger" id="amount_error_msg_{{ $staff->id }}" style="display: none">The amount can't be greater than balance amount</span>
                                                                                    @error('amount')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Payment Method</label>
                                                                                <div class="col-md-9">
                                                                                    <select class="form-control" name="payment_method" data-dropdown-parent="#advance_modal{{$staff->id}}" style="width:100%">
                                                                                        <option selected disabled>Select</option>
                                                                                        <option value="CASH">CASH</option>
                                                                                        <option value="ACCOUNT">ACCOUNT</option>
                                                                                    </select>
                                                                                    @error('payment_method')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Bank Reference No</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" name="bankReference" value="">
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" name="description" id="description{{$staff->id}}">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary" onclick="generateDescription({{$staff->id}});this.disabled=true;this.value='Adding...';this.form.submit();" id="addtask{{$staff->id}}">Make Payment</button>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Salary Term</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" value="{{ $current_term_string }}" readonly>
                                                                                    <input type="hidden" name="term" class="form-control" value="{{ $current_term }}" >
                                                                                    <input type="hidden" name="lastTerm" class="form-control" value="{{ $lastTermSalaryTerm }}" >
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Basic  Salary</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text"  class="form-control" value="{{ $staff->salary}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Working Days</label>
                                                                                <div class="col-md-2">
                                                                                    <input type="text" class="form-control" value="15" disabled>
                                                                                </div>
                                                                                <label for="billing-email-address" class="col-md-2 col-form-label">Casual Leave</label>
                                                                                <div class="col-md-1">
                                                                                    <input type="text" class="form-control" id="casualLeave{{$staff->id}}" value="{{ $casualLeaveDay }}"disabled>
                                                                                </div>
                                                                                <label for="billing-email-address" class="col-md-2 col-form-label">Leave Days</label>
                                                                                <div class="col-md-2">
                                                                                    <input type="text" class="form-control" value="{{ $leaveDays }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                            @if ( $lastTermSalaryDescription )
                                                                                @foreach ( $allowanceAmounts as $allowanceAmount )
                                                                                    @php
                                                                                        $allowanceParts = explode(' - ', $allowanceAmount);
                                                                                    @endphp
                                                                                    <div class="form-group row mb-4" >
                                                                                        <label for="billing-email-address" class="col-md-3 col-form-label">Allowance Name</label>
                                                                                        <div class="col-md-4">
                                                                                            <input type="text" class="form-control" value="{{ $allowanceParts[0] }}" disabled>
                                                                                        </div>
                                                                                        <label for="billing-email-address" class="col-md-2 col-form-label">Amount</label>
                                                                                        <div class="col-md-3">
                                                                                            <input type="text" class="form-control" value="{{ $allowanceParts[1] }}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Total Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="number" name="totalAmount" class="form-control" value="{{ $lastTotalAmount }}"  readonly>
                                                                                    @error('amount')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Balance Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="number" id="balance_amount_{{$staff->id}}"  class="form-control" value="{{ $balancePaymentAmount }}"  readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Paying Amount</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="number" name="amount" id="amount_{{$staff->id}}" class="form-control" placeholder="Enter amount" value="{{ $balancePaymentAmount }}" onkeyup="validate_amount(this.value,{{$staff->id}});" onchange="validate_amount(this.value,{{$staff->id}});">
                                                                                    <span class="text-danger" id="amount_error_msg_{{ $staff->id }}" style="display: none">The amount can't be greater than balance amount</span>
                                                                                    @error('amount')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Payment Method</label>
                                                                                <div class="col-md-9">
                                                                                    <select class="form-control" name="payment_method" data-dropdown-parent="#advance_modal{{$staff->id}}" style="width:100%">
                                                                                        <option selected disabled>Select</option>
                                                                                        <option value="CASH">CASH</option>
                                                                                        <option value="ACCOUNT">ACCOUNT</option>
                                                                                    </select>
                                                                                    @error('payment_method')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-4">
                                                                                <label for="billing-email-address" class="col-md-3 col-form-label">Bank Reference No</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" name="bankReference" value="">
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" name="description" value="{{ $lastTermSalaryDescription }}">
                                                                            <input type="hidden" name="leaveDays" value="{{ $lastTermSalaryLleaveDays }}">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-end">
                                                                                    <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.value='Adding...';this.form.submit();" id="addtask{{$staff->id}}">Make Payment</button>
                                                                                </div>
                                                                            </div>
                                                                        @endif
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
                            </div>
                        </div>


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <script>
            function addAllowance(staffId) {
                var additionalFields = `
                    <div class="form-group row mb-4">
                        <label for="billing-email-address" class="col-md-3 col-form-label">Allowance Name</label>
                        <div class="col-md-4">
                            <select class="form-control" id="allowance_name_${staffId}[]" name="allowance_name_${staffId}[]" onchange="handleAllowanceChange(this, ${staffId})">
                                <option value="Dearness Allowance">Dearness Allowance</option>
                                <option value="Entertainment Allowance">Entertainment Allowance</option>
                                <option value="Medical Allowance">Medical Allowance</option>
                                <option value="Overtime Allowance">Overtime Allowance</option>
                                <option value="Project Allowance">Project Allowance</option>
                                <option value="Tiffin/Meals Allowance">Tiffin/Meals Allowance</option>
                                <option value="Cash Allowance">Cash Allowance</option>
                                <option value="Other Allowance">Other Allowance</option>
                            </select>
                        </div>
                        <label for="billing-email-address" class="col-md-2 col-form-label">Amount</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control allowance-amount" value="" onkeyup="calculateTotalAmount(${staffId}); generateDescription(${staffId});"  id="allowance_amount_${staffId}[]" name="allowance_amount_${staffId}[]">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger" onclick="removeAllowance(this)"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                `;
                document.getElementById('additionalAllowanceFields'+ staffId).insertAdjacentHTML('beforeend', additionalFields);

                calculateTotalAmount(staffId);
                generateDescription(staffId);
                generateLeaveDays(staffId);
            }

            function handleAllowanceChange(selectElement, staffId) {
                var allowanceValue = selectElement.value;
                if (allowanceValue === 'Other Allowance') {
                    var inputField = document.createElement('input');
                    inputField.setAttribute('type', 'text');
                    inputField.setAttribute('class', 'form-control');
                    inputField.setAttribute('style', 'width: 30%');
                    inputField.setAttribute('id', `allowance_name_${staffId}[]`);
                    inputField.setAttribute('name', `allowance_name_${staffId}[]`);

                    var parentDiv = selectElement.parentNode.parentNode;
                    var selectDiv = selectElement.parentNode;
                    parentDiv.replaceChild(inputField, selectDiv);
                }
            }

            function calculateTotalAmount(staffId) {
                var paybleAmount = parseFloat($('#paybleAmount'+ staffId).val());
                var totalAmount = paybleAmount;

                $('.allowance-amount').each(function() {
                    var allowanceAmount = parseFloat($(this).val());
                    if (!isNaN(allowanceAmount)) {
                        totalAmount += allowanceAmount;
                    }
                });

                $('#amount'+ staffId).val(totalAmount.toFixed(2));
                $('#PayingAmount'+ staffId).val(totalAmount.toFixed(2));
            }

            function removeAllowance(button) {
                var row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);

                calculateTotalAmount(staffId);
            }

            $(document).ready(function() {
                $(document).on('keyup', '.allowance-amount', function() {
                    calculateTotalAmount(staffId);
                });
            });
            function getPayablesalary( staffId ){
                console.log(staffId);
                let leaveDaysInput = document.getElementById('leaveDays'+staffId);
                var leaveDays = parseInt(leaveDaysInput.value);
                var basicSalary = parseFloat($('#basicSalary'+staffId).val());
                var payableAmount = leaveDays === 0 ? basicSalary : basicSalary - (basicSalary * 24 * leaveDays) / 300;
                $('#paybleAmount'+staffId).val(payableAmount.toFixed(2));
                calculateTotalAmount(staffId);
            }

            function generateDescription(staffId) {
                var description = "";

                var allowanceNames = document.querySelectorAll('[id^=allowance_name_' + staffId + ']');
                var allowanceAmounts = document.querySelectorAll('[id^=allowance_amount_' + staffId + ']');
                for (var i = 0; i < allowanceNames.length; i++) {
                    if(i == 0){
                        description = description + allowanceNames[i].value + " - " + allowanceAmounts[i].value;
                    }
                    else{
                        description = description + "," + allowanceNames[i].value + " - " + allowanceAmounts[i].value;
                    }
                }

                document.getElementById('description' + staffId).value = description;
            }
            function generateLeaveDays(staffId) {
                var casualLeaveCheckbox = document.getElementById('casualLeave' + staffId);
                var leaveDaysText = document.querySelectorAll('[id^=leaveDays' + staffId + ']');
                var leaveDays = 0;

                if (casualLeaveCheckbox.checked) {
                    leaveDays = parseFloat(leaveDaysText[0].value) + 1;
                } else {
                    leaveDays = parseFloat(leaveDaysText[1].value);
                }

                document.getElementById('leaveDayshidden' + staffId).value = leaveDays;
            }

        </script>
        <script>
            function toggleLeaveDays(checkbox, staffId) {
                var leaveDaysInput = document.getElementById('leaveDays' + staffId);
                leaveDaysInput.disabled = !checkbox.checked;
                if (checkbox.checked) {
                    leaveDaysInput.focus();
                }
            }
        </script>


        @endsection

