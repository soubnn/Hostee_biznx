<?php

namespace App\Http\Controllers;

use App\Mail\SalaryDisbursementNotification;
use App\Models\Daybook;
use App\Models\DaybookBalance;
use App\Models\staffs;
use App\Models\employee_categories;
use App\Models\SalaryPayment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs= Staffs::all()->where('status','<>','disabled');
        return view('staff.index',compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'category_id' => 'required',
            'staff_name' => 'required',
            'phone1' =>'digits:10|required',
            'phone2' =>'digits:10|nullable',
            'email' => 'nullable|email',

        ]);
        $data = $request->all();
        $status= Staffs::create($data);
        if($status){
            Toastr::success('Staff Added edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staffs::findOrFail($id);
        $categories = DB::table('employee_categories')->get();
        return view('staff.edit', compact('staff','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 123;
        $staff = Staffs::findOrFail($id);
        $this->validate($request,[
            'category_id' => 'required',
            'staff_name' => 'required',
            'phone1' =>'digits:10|required',
            'phone2' =>'digits:10|nullable',
            'email' => 'email|nullable',
        ]);
        $data = $request->all();

        $status= $staff->fill($data)->save();
        if($status){
            Toastr::success('Staff edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.index');

    }
    public function updateStaff(Request $request, $id)
    {
        $staff = Staffs::findOrFail($id);
        $this->validate($request,[
            'category_id' => 'required',
            'staff_name' => 'required',
            'phone1' =>'digits:10|required',
            'phone2' =>'digits:10|nullable',
            'email' => 'email|nullable',
        ]);
        $data = $request->all();

        $status= $staff->fill($data)->save();
        if($status){
            Toastr::success('Staff edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_payments()
    {
        $staffs= Staffs::all()->where('status','<>','disabled');
        return view('staff.payments',compact('staffs'));
    }
    public function store_payments(Request $request, $id)
    {
        $this->validate($request,[
            'term' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);
        $data = $request->all();
        $data['staff_id'] = $id;
        $date = Carbon::now()->format('Y-m-d');;
        $data['date'] = $date;
        $data['payment_type'] = 'salary';

        $daybook_data['date'] = Carbon::now()->format('Y-m-d');
        $daybook_data['expense_id'] = 'staff_salary';
        $daybook_data['staff'] = $id;
        $daybook_data['description'] = 'Salary';
        $daybook_data['amount'] = $request->amount;
        $daybook_data['type'] = 'Expense';
        $daybook_data['accounts'] = $request->payment_method;

        $status= SalaryPayment::create($data);
        $daybook_status = Daybook::create($daybook_data);

        if($status){
            $balanceCount = DB::table('daybook_balances')->where('date',$date)->count();
            if($balanceCount == 0)
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                $copyRow = DB::table('daybook_balances')->insert(['date' => $date, 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
            }

            $latestBalance = DB::table('daybook_balances')->latest('id')->first();

            if($daybook_data['accounts'] == "CASH")
            {
                $newCashBalance = $latestBalance->cash_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
            }
            if($daybook_data['accounts'] == "ACCOUNT")
            {
                $newAccountBalance = $latestBalance->account_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
            }
            if($daybook_data['accounts'] == "LEDGER")
            {
                $newLedgerBalance = $latestBalance->ledger_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
            }

            Toastr::success('Salary Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.payments');
    }
    
    public function store_advance(Request $request, $id)
    {

        $this->validate($request,[
            'term' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);

        function numberToWords($number) {
            $words = array(
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
                100 => 'one hundred',
                1000 => 'one thousand',
                100000 => 'one lakh'
            );

            if (!is_numeric($number)) {
                return false;
            }

            if (($number >= 0 && (int)$number < 21) || $number == 100) {
                return $words[$number];
            }

            if ($number < 100) {
                $tens = (int)($number / 10) * 10;
                $units = $number % 10;
                return $words[$tens] . ($units ? ' ' . $words[$units] : '');
            }

            if ($number < 1000) {
                $hundreds = (int)($number / 100);
                $remainder = $number % 100;
                return $words[$hundreds] . ' hundred' . ($remainder ? ' and ' . numberToWords($remainder) : '');
            }

            if ($number < 1000000) {
                $thousands = (int)($number / 1000);
                $remainder = $number % 1000;
                return numberToWords($thousands) . ' thousand' . ($remainder ? ' ' . numberToWords($remainder) : '');
            }

            return false;
        }

        $staff = staffs::findOrFail($id);
        if ($request->lastTerm){
            $termStatus = SalaryPayment::where('staff_id',$staff->id)->where('term',$request->lastTerm)->where('payment_type','salary')->latest('id')->first();
            $termStatusLeaveDays = $termStatus->leaveDays;
            if ($termStatus->status	== 'paid'){
                $currentTermAmount = $request->amount;
            }else {
                $currentTermAmountOld = SalaryPayment::where('staff_id',$staff->id)->where('term',$request->term)->sum('amount');
                $currentTermAmount = $currentTermAmountOld + $request->amount;
            }
        }else {
            $currentTermAmount = $request->amount;
            $termStatusLeaveDays = '';
        }

        $currentTermTotalAmount = $request->totalAmount;

        $data['payment_type'] = 'salary';
        $data['amount'] = $request->amount;
        $data['payment_method'] = $request->payment_method;
        $data['bankReference'] = $request->bankReference;
        $data['term'] = $request->term;
        $data['leaveDays'] = $request->leaveDays;
        $description = $request->description;
        $data['description'] = $description;

        $data['staff_id'] = $id;
        $data['basic_salary'] = $staff->salary;
        $term = explode('-',$request->term);

        $calculateLeaveDays = explode('-',$request->term);
        if ( $calculateLeaveDays[1] == 2 ){
            if ( $termStatusLeaveDays != NULL){
                $leaveDays = $request->leaveDays;
            } else{
                if ($request->leaveDays > 1){
                    $leaveDays = $request->leaveDays - 1;
                }else{
                    $leaveDays = 0;
                }
            }
        }else {
            if ($request->leaveDays > 1){
                $leaveDays = $request->leaveDays - 1;
            }else{
                $leaveDays = 0;
            }
        }
        $paymentMethod = $request->payment_method;
        $bankReferenceId = $request->bankReference;
        $basicSalary = $staff->salary;

        $date = Carbon::parse(DaybookBalance::report_date())->format('Y-m-d');
        $data['date'] = $date;

        if($currentTermTotalAmount > $currentTermAmount){
            $data['status'] = 'partial';
        }else{
            $data['status'] = 'paid';
        }

        $daybook_data['date'] = $date;
        $daybook_data['expense_id'] = 'staff_salary';
        $daybook_data['staff'] = $id;
        if ($description){
            $daybook_data['description'] = 'Salary ['. $description . ']';
        }else{
            $daybook_data['description'] = 'Salary';
        }
        $daybook_data['amount'] = $request->amount;
        $daybook_data['type'] = 'Expense';
        $daybook_data['accounts'] = $paymentMethod;

        $daybook_status = Daybook::create($daybook_data);
        $data['daybook_id'] = $daybook_status->id;
        $status= SalaryPayment::create($data);

        if($status){
            $balanceCount = DB::table('daybook_balances')->where('date',$date)->count();
            if($balanceCount == 0)
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                $copyRow = DB::table('daybook_balances')->insert(['date' => $date, 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
            }

            $latestBalance = DB::table('daybook_balances')->latest('id')->first();

            if($daybook_data['accounts'] == "CASH")
            {
                $newCashBalance = $latestBalance->cash_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
            }
            if($daybook_data['accounts'] == "ACCOUNT")
            {
                $newAccountBalance = $latestBalance->account_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
            }
            if($daybook_data['accounts'] == "LEDGER")
            {
                $newLedgerBalance = $latestBalance->ledger_balance - $daybook_data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
            }

            //SALARY TERM
            $term_array = explode('-',$request->term);
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
            if($last_salary_term == '1'){
                $current_salary_term = '2';
                $current_salary_term_string = '15 to 30';
            }
            elseif($last_salary_term == '2'){
                $current_salary_term = '1';
                $current_salary_term_string = '1 to 15';
            }
            $year ='20'.$term_array[2] ;
            $term_month = Carbon::parse('01-'.$term_month_no.'-'.$year)->format('F');
            $termData = $year . '-' . $term_month . ' [' . $current_salary_term_string . ']';


            //ALLOWANCE
            $allowance = explode(",", $description);
            $grantTotal = 0;
            $dataArray = [];
            foreach ($allowance as $item) {
                $parts = explode(" - ", $item);
                if (count($parts) >= 2) {
                    $name = trim($parts[0]);
                    $amount = trim($parts[1]);
                    $dataArray[] = [
                        'name' => $name,
                        'amount' => $amount
                    ];
                    $grantTotal += $amount;
                } else {
                    Log::error("Invalid format found in description: " . $item);
                    continue;
                }
            }

            $leaveAmount = ($basicSalary * 24 / 300 ) * $leaveDays;
            $totalIncomAmount = $grantTotal + $basicSalary;
            $grandTotalAmount = $request->amount;
            $categorie = employee_categories::where('id',$staff->category_id)->first();
            $staff_categorie = $categorie->category_name;

            $grandTotalAmountInWords = numberToWords($grandTotalAmount);
            $grandTotalAmountWords = strtoupper($grandTotalAmountInWords);

            // paid amount
            $paidAmount = SalaryPayment::where('staff_id',$staff->id)->where('term',$request->term)->where('id','<', $status->id)->sum('amount');

            // Deductions
            $deductions = $paidAmount + $leaveAmount;

            //PDF
            $pdf = Pdf::loadView('staff.salary_slip', compact('staff', 'staff_categorie','date','leaveDays','grandTotalAmount','dataArray','deductions','paidAmount','totalIncomAmount','termData','paymentMethod','bankReferenceId','basicSalary','leaveAmount','grandTotalAmountWords'))->setPaper('a4', 'portrait');
            $filename = time() . "_" . $staff->staff_name . "_" . $date . ".pdf";
            $pdf->save(storage_path('app/public/salary_slip/' . $filename));

            // EMAIL
            $recipientEmail = $staff->email;
            $mailData = [
                'staffName' => $staff->staff_name,
                'term' => $termData,
            ];
            $attachmentPath = storage_path('app/public/salary_slip/' . $filename);
            Mail::to($recipientEmail)->send(new SalaryDisbursementNotification($mailData, $attachmentPath));

            Storage::delete('public/salary_slip/' . $filename);

            Toastr::success('Amount Credited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.payments');
    }

    public function delete_staff($id)
    {
        $staff = Staffs::findOrFail($id);
        $data['status'] = 'disabled';

        $status = $staff->fill($data)->save();

        if($status){
            Toastr::success('Staff deleted', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.index');
    }

    public function staff_payment()
    {
        $currentMonth = Carbon::now()->monthName;
        $currentYear = Carbon::now()->year;
        $searchDate = $currentMonth . ' ' . $currentYear;
        $startDate = Carbon::parse($searchDate)->format('Y-m-d');
        $endDate = Carbon::parse($searchDate)->addMonth()->format('Y-m-d');

        $staffs = DB::table('staffs')->get();
        $result = array();
        foreach($staffs as $staff)
        {
            $temp = array();
            // $total_advance = DB::table('daybooks')->whereBetween('date',[$startDate, $endDate])->where('staff',$staff->id)->where('expense_id','advance')->sum('amount');
            $total_salary = DB::table('daybooks')->whereBetween('date',[$startDate, $endDate])->where('staff',$staff->id)->where('expense_id','staff_salary')->sum('amount');
            $temp['staff'] = $staff->staff_name;
            $temp['salary'] = $total_salary;
            // $temp['advance'] = $total_advance;
            array_push($result, $temp);
        }
        return view('staff.payments', compact('searchDate','result'));
    }

    public function filter_staff_payments(Request $request)
    {
        if($request->year)
        {
            $currentYear = $request->year;
        }
        else
        {
            $currentYear = Carbon::now()->year;
        }
        if($request->month)
        {
            $currentMonth = $request->month;
        }
        else
        {
            $currentMonth = Carbon::now()->monthName;
        }
        $searchDate = $currentMonth . ' ' . $currentYear;
        $startDate = Carbon::parse($searchDate)->format('Y-m-d');
        $endDate = Carbon::parse($searchDate)->addMonth()->format('Y-m-d');

        $staffs = DB::table('staffs')->get();
        $result = array();

        foreach($staffs as $staff)
        {
            $temp = array();
            // $total_advance = DB::table('daybooks')->whereBetween('date',[$startDate, $endDate])->where('staff',$staff->id)->where('expense_id','advance')->sum('amount');
            $total_salary = DB::table('daybooks')->whereBetween('date',[$startDate, $endDate])->where('staff',$staff->id)->where('expense_id','staff_salary')->sum('amount');
            $temp['staff'] = $staff->staff_name;
            $temp['salary'] = $total_salary;
            // $temp['advance'] = $total_advance;
            array_push($result, $temp);
        }

        return view('staff.payments', compact('searchDate','result'));
    }
    public function job_requests()
    {
        $requests = DB::table('job_applications')->where('status','active')->orderBy('id','DESC')->get();
        return view('staff.request', compact('requests'));
    }
    public function delete_staff_request($id)
    {
        $data['status'] = 'disabled';
        $status = DB::table('job_applications')->where('id',$id)->update($data);
        if($status){
            Toastr::success('Request Deleted', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('staff.request');
    }
    public function search_request(Request $request){
        $job_title = $request->job_title;
        $requests = DB::table('job_applications')->where('job_title',$job_title)->get();
        return view('staff.request', compact('requests'));
    }
    public function payment_history($id){
        // $history = Daybook::where('staff',$id)->where('expense_id','staff_salary')->orderBy('id','DESC')->get();
        $staff = $id;
        $history = SalaryPayment::where('staff_id',$id)->orderBy('id','DESC')->get();
        return view('staff.history',compact('history','staff'));
    }
    public function index_user()
    {
        $users= User::all();
        return view('user.index',compact('users'));
    }
    public function delete_user($id)
    {
        $status =User::where('id', $id)->update(['status' => 'disabled']);

        if($status){
            Toastr::success('User deleted', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('user.index');
    }
    public function active_user($id)
    {
        $status =User::where('id', $id)->update(['status' => 'active']);

        if($status){
            Toastr::success('User actived', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('user.index');
    }
    public function termSalarySlipReport($id)
    {
        //table
        $salaryPayment = SalaryPayment::findOrFail($id);
        $staff = staffs::findOrFail($salaryPayment->staff_id);

        //Leave
        if($salaryPayment->leaveDays == null || $salaryPayment->leaveDays <= 1){
            $leave = 0;
        }else{
            $leave = $salaryPayment->leaveDays - 1;
        }

        //staffCategorie
        $categorie = employee_categories::where('id',$staff->category_id)->first();
        $staffCategorie = $categorie->category_name;

        //ALLOWANCE
        $allowance = explode(",", $salaryPayment->description);
        $grantTotal = 0;
        $dataArray = [];
        foreach ($allowance as $item) {
            $parts = explode(" - ", $item);
            if (count($parts) >= 2) {
                $name = trim($parts[0]);
                $amount = trim($parts[1]);
                $dataArray[] = [
                    'name' => $name,
                    'amount' => $amount
                ];
                $grantTotal += $amount;
            } else {
                Log::error("Invalid format found in description: " . $item);
                continue;
            }
        }

        //incom
        $totalIncomAmount = $grantTotal + $salaryPayment->basic_salary;

        //leave
        $leaveAmount = ($salaryPayment->basic_salary * 24 / 300 ) * $leave;

        // paid amount
        $paidAmount = SalaryPayment::where('staff_id',$salaryPayment->staff_id)->where('term',$salaryPayment->term)->where('id','<', $id)->sum('amount');

        // Deductions
        $deductions = $paidAmount + $leaveAmount;

        //SALARY TERM
        $term_array = explode('-',$salaryPayment->term);
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
        if($last_salary_term == '1'){
            $current_salary_term = '2';
            $current_salary_term_string = '1 to 15';
        }
        elseif($last_salary_term == '2'){
            $current_salary_term = '1';
            $current_salary_term_string = '15 to 30';
        }
        $year ='20'.$term_array[2] ;
        $term_month = Carbon::parse('01-'.$term_month_no.'-'.$year)->format('F');
        $termData = $year . '-' . $term_month . ' [' . $current_salary_term_string . ']';

        // return view('staff.salary_slip_report',compact('staff','salaryPayment','leave','staffCategorie','dataArray','totalIncomAmount','termData','leaveAmount'));
        $pdf = Pdf::loadView('staff.salary_slip_report',compact('staff','salaryPayment','leave','staffCategorie','dataArray','totalIncomAmount','termData','paidAmount','leaveAmount','deductions'))->setPaper('a4','portrait');
        return $pdf->stream($staff->staff_name . '-'. $termData.' - Salary Slip Report.pdf',array("Attachment"=>false));
    }
    public function salarySlipReport($id)
    {
        $staff = staffs::findOrFail($id);
        $salaryPayments = SalaryPayment::where('staff_id',$staff->id)->get();

        //staffCategorie
        $categorie = employee_categories::where('id',$staff->category_id)->first();
        $staffCategorie = $categorie->category_name;

        $salaryPayment = [];
        foreach ($salaryPayments as $salary) {

            //leave
            if($salary->leaveDays == null || $salary->leaveDays <= 1){
                $leave = 0;
            }else{
                $leave = $salary->leaveDays - 1;
            }

            //ALLOWANCE
            $allowance = explode(",", $salary->description);
            $grantTotal = 0;
            $dataArray = [];
            foreach ($allowance as $item) {
                $parts = explode(" - ", $item);
                if (count($parts) >= 2) {
                    $name = trim($parts[0]);
                    $amount = trim($parts[1]);
                    $dataArray[] = [
                        'name' => $name,
                        'amount' => $amount
                    ];
                    $grantTotal += $amount;
                } else {
                    Log::error("Invalid format found in description: " . $item);
                    continue;
                }
            }

            //incom
            $totalIncomAmount = $grantTotal + $salary->basic_salary;

            //leave
            $leaveAmount = ($salary->basic_salary * 24 / 300 ) * $leave;

            // paid amount
            $paidAmount = SalaryPayment::where('staff_id',$salary->staff_id)->where('term',$salary->term)->where('id','<', $salary->id)->sum('amount');

            // Deductions
            $deductions = $paidAmount + $leaveAmount;

            //SALARY TERM
            $term_array = explode('-',$salary->term);
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
            if($last_salary_term == '1'){
                $current_salary_term = '2';
                $current_salary_term_string = '1 to 15';
            }
            elseif($last_salary_term == '2'){
                $current_salary_term = '1';
                $current_salary_term_string = '15 to 30';
            }
            $year ='20'.$term_array[2] ;
            $term_month = Carbon::parse('01-'.$term_month_no.'-'.$year)->format('F');
            $termData = $year . '-' . $term_month . ' [' . $current_salary_term_string . ']';

            $salaryPayment[] = [
                'id' => $salary->id,
                'date' => $salary->date,
                'amount' => $salary->amount,
                'payment_method' => $salary->payment_method,
                'bankReference' => $salary->bankReference,
                'basic_salary' => $salary->basic_salary,
                'leave' => $leave,
                'dataArray' => $dataArray,
                'totalIncomAmount' => $totalIncomAmount,
                'leaveAmount' => $leaveAmount,
                'paidAmount' => $paidAmount,
                'deductions' => $deductions,
                'termData' => $termData,
            ];

        }
        // return $salaryPayment;
        // return view('staff.salary_slip_all_report',compact('salaryPayment','staff','staffCategorie'));
        $pdf = Pdf::loadView('staff.salary_slip_all_report',compact('salaryPayment','staff','staffCategorie'))->setPaper('a4','portrait');
        return $pdf->stream($staff->staff_name . ' - Salary Slip Report.pdf',array("Attachment"=>false));
    }
}
