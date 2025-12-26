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
        // function validate_amount(pay_amount, staff_id){
        //     let balance = document.getElementById('balance_amount_'+staff_id).value;
        //     let error_msg = document.getElementById('amount_error_msg_'+staff_id);
        //     let pay_amount_input = document.getElementById('amount_'+staff_id);
        //     error_msg.style.display = 'none';
        //     console.log(balance);
        //     if(parseFloat(pay_amount) > parseFloat(balance)){
        //         pay_amount_input.value = 0;
        //         error_msg.style.display = 'block';
        //     }
        // }
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
                                                    $casualLeaveDay = 0;
                                                    $leaveDays = 0;
                                                    $lastTotalAmount = 0;

                                                    $last_term_salary = DB::table('salary_payments')->where('staff_id',$staff->id)->where('payment_type','salary')->latest('id')->first();
                                                    $today_color = Carbon\carbon::now()->format('Y-m-d');

                                                    if ($last_term_salary == null) {
                                                        // First salary
                                                        $join_date = $staff->join_date ?? now();
                                                        $day = Carbon\carbon::parse($join_date)->format('d');
                                                        $month = intval(Carbon\carbon::parse($join_date)->format('m'));
                                                        $year = Carbon\carbon::parse($join_date)->format('Y');
                                                        $month_string = Carbon\carbon::parse($join_date)->format('F');

                                                        $term = '1';
                                                        $current_term = $month . '-' . $term . '-' . substr($year, -2);
                                                        $current_term_string = $year . '-' . $month_string . ' (1 to 30)';

                                                        // Color logic for first salary
                                                        $next_month = ($month == 12) ? 1 : $month + 1;
                                                        $next_year = ($month == 12) ? $year + 1 : $year;
                                                        $color_day = $day . '-' . str_pad($next_month, 2, '0', STR_PAD_LEFT) . '-' . $next_year;
                                                        $color_date = Carbon\carbon::parse($color_day)->format('Y-m-d');
                                                        $color = ($today_color >= $color_date) ? 'text-danger' : 'text-success';

                                                        $lastTermSalaryStatus = '';
                                                        $lastTermSalaryTerm = '';
                                                        $lastTermSalaryLleaveDays = '';
                                                        $lastTermSalaryDescription = '';

                                                    } else {
                                                        // Staff has previous salary
                                                        $last_salary_month_term = explode('-', $last_term_salary->term);
                                                        $last_salary_month = intval($last_salary_month_term[0]);
                                                        $last_salary_year = intval($last_salary_month_term[2]);

                                                        // Next term is simply next month
                                                        if ($last_term_salary->status == 'paid') {
                                                            $current_salary_month = ($last_salary_month == 12) ? 1 : $last_salary_month + 1;
                                                            $currentTermYear = ($last_salary_month == 12) ? $last_salary_year + 1 : $last_salary_year;

                                                            $term = '1';
                                                            $current_term = $current_salary_month . '-' . $term . '-' . $currentTermYear;
                                                            $current_term_month_string = Carbon\carbon::parse('01-' . $current_salary_month . '-20' . $currentTermYear)->format('F');
                                                            $current_term_string = '20' . $currentTermYear . ' - ' . $current_term_month_string . ' (1 to 30)';

                                                            // Color logic
                                                            $color_day = '30-' . str_pad($current_salary_month, 2, '0', STR_PAD_LEFT) . '-20' . $currentTermYear;
                                                            $color_date = Carbon\carbon::parse($color_day)->format('Y-m-d');
                                                            $color = (Carbon\carbon::now()->format('Y-m-d') >= $color_date) ? 'text-danger' : 'text-success';

                                                        } else {
                                                            // Last salary unpaid
                                                            $current_salary_month = $last_salary_month;
                                                            $currentTermYear = $last_salary_year;
                                                            $term = '1';
                                                            $current_term = $current_salary_month . '-' . $term . '-' . $currentTermYear;
                                                            $current_term_month_string = Carbon\carbon::parse('01-' . $current_salary_month . '-20' . $currentTermYear)->format('F');
                                                            $current_term_string = '20' . $currentTermYear . ' - ' . $current_term_month_string . ' (1 to 30)';

                                                            // Calculate allowances and balance
                                                            $totalAllowanceAmount = 0;
                                                            if ($last_term_salary->description) {
                                                                $allowances = explode(',', $last_term_salary->description);
                                                                foreach ($allowances as $allowance) {
                                                                    $parts = explode(' - ', $allowance);
                                                                    $totalAllowanceAmount += $parts[1] ?? 0;
                                                                }
                                                            }

                                                            $currentLeaveDays = $last_term_salary->leaveDays;
                                                            $currentBasicSalary = $last_term_salary->basic_salary;

                                                            if ($currentLeaveDays > 0) {
                                                                $leaveDays = $currentLeaveDays - 1;
                                                                $casualLeaveDay = 0;
                                                            } else {
                                                                $leaveDays = 0;
                                                                $casualLeaveDay = 0;
                                                            }

                                                            $currentSalaryAmount = $currentBasicSalary - ($currentBasicSalary * 24 * $leaveDays) / 300;
                                                            $lastAmount = DB::table('salary_payments')
                                                                ->where('staff_id', $staff->id)
                                                                ->where('term', $last_term_salary->term)
                                                                ->sum('amount');

                                                            $lastTotalAmount = $currentSalaryAmount + $totalAllowanceAmount;
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
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('staff.store_advance', $staff->id) }}">
                                                                @csrf

                                                                <!-- Salary Term -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Salary Term</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="{{ $current_term_string }}" readonly>
                                                                        <input type="hidden" name="term" value="{{ $current_term }}">
                                                                        <input type="hidden" name="lastTerm" value="{{ $lastTermSalaryTerm }}">
                                                                    </div>
                                                                </div>

                                                                <!-- Basic Salary -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Basic Salary</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" id="basicSalary{{ $staff->id }}" value="{{ $staff->salary }}" readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Working Days, Leave -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Working Days</label>
                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control" value="30" readonly>
                                                                    </div>
                                                                    {{-- <label class="col-md-2 col-form-label">Casual Leave</label> --}}
                                                                    <label class="col-md-2 col-form-label">Extra Leave</label>
                                                                    <div class="col-md-1">
                                                                        <input type="checkbox" id="casualLeave{{$staff->id}}" onchange="toggleLeaveDays(this, {{$staff->id}})">
                                                                    </div>
                                                                    <label class="col-md-2 col-form-label">Leave Days</label>
                                                                    <div class="col-md-2">
                                                                        <input type="text" name="leaveDays" id="leaveDays{{$staff->id}}" class="form-control" value="{{ $leaveDays }}" onkeyup="getPayablesalary({{$staff->id}}); generateDescription({{$staff->id}})" disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Payable Amount -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Payable Amount</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" id="paybleAmount{{$staff->id}}" value="{{ $balancePaymentAmount ?? $staff->salary }}" readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Allowances -->
                                                                <div id="additionalAllowanceFields{{ $staff->id }}"></div>

                                                                <!-- Total & Paying Amount -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Total Amount</label>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="totalAmount" id="amount{{$staff->id}}" class="form-control" value="{{ $balancePaymentAmount ?? $staff->salary }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Paying Amount</label>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="amount" id="PayingAmount{{$staff->id}}" class="form-control" value="{{ $balancePaymentAmount ?? $staff->salary }}" onkeyup="term_validate_amount(this.value,{{$staff->id}});" onchange="term_validate_amount(this.value,{{$staff->id}});">
                                                                        <span class="text-danger" id="amount_error_msg_{{ $staff->id }}" style="display: none">The amount can't be greater than balance amount</span>
                                                                    </div>
                                                                </div>

                                                                <!-- Payment Method -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Payment Method</label>
                                                                    <div class="col-md-9">
                                                                        <select class="form-control" name="payment_method" data-dropdown-parent="#advance_modal{{$staff->id}}" style="width:100%">
                                                                            <option selected disabled>Select</option>
                                                                            <option value="CASH">CASH</option>
                                                                            <option value="ACCOUNT">ACCOUNT</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Bank Reference -->
                                                                <div class="form-group row mb-4">
                                                                    <label class="col-md-3 col-form-label">Bank Reference No</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" name="bankReference">
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" name="description" id="description{{$staff->id}}" value="{{ $lastTermSalaryDescription }}">
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-end">
                                                                        <button type="submit" class="btn btn-primary" onclick="generateDescription({{$staff->id}});this.disabled=true;this.value='Adding...';this.form.submit();" id="addtask{{$staff->id}}">
                                                                            Make Payment
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

        // function getPayablesalary( staffId ){

        //     let leaveDaysInput = document.getElementById('leaveDays' + staffId);
        //     var leaveDays = parseInt(leaveDaysInput.value) || 0;

        //     var basicSalary = parseFloat($('#basicSalary' + staffId).val());
        //     let payableAmount = basicSalary;

        //     if (leaveDays > 0) {
        //         payableAmount = basicSalary - ((basicSalary * 24 * leaveDays) / 300);
        //     }

        //     $('#paybleAmount'+staffId).val(payableAmount.toFixed(2));
        //     calculateTotalAmount(staffId);
        // }

        function getPayablesalary(staffId) {
            let leaveDaysInput = document.getElementById('leaveDays' + staffId);
            let leaveDays = parseInt(leaveDaysInput.value) || 0;

            let basicSalary = parseFloat($('#basicSalary' + staffId).val()) || 0;
            let totalWorkingDays = 26;
            let perDaySalary = basicSalary / totalWorkingDays;

            let payableAmount = basicSalary - (perDaySalary * leaveDays);

            $('#paybleAmount' + staffId).val(payableAmount.toFixed(2));
            $('#amount' + staffId).val(payableAmount.toFixed(2));
            $('#PayingAmount' + staffId).val(payableAmount.toFixed(2));

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

        // function generateLeaveDays(staffId) {
        //     var casualLeaveCheckbox = document.getElementById('casualLeave' + staffId);
        //     var leaveDaysText = document.querySelectorAll('[id^=leaveDays' + staffId + ']');
        //     var leaveDays = 0;

        //     if (casualLeaveCheckbox.checked) {
        //         leaveDays = parseFloat(leaveDaysText[0].value) + 1;
        //     } else {
        //         leaveDays = parseFloat(leaveDaysText[1].value);
        //     }

        //     document.getElementById('leaveDayshidden' + staffId).value = leaveDays;
        // }

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

