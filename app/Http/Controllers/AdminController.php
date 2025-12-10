<?php

namespace App\Http\Controllers;

use App\Models\Consignment;
use App\Models\Daybook;
use App\Models\DirectSales;
use App\Models\Marketing;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesItems;
use App\Models\staffs;
use App\Models\stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login(){
        if(Auth::check())
        {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function loginsubmit(Request $request){
        $admin = $request->all();
        $login = Auth::attempt(['username' => $admin['username'],'password' => $admin['password']]);

        if($login) {
            Toastr::success('Welcome to biznx', 'success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('dashboard');
        } else{
            Toastr::error('Invalid credentials or account inactive', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back()->withInput($request->only('username'));
        }
    }

    // public function loginsubmit(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only('username', 'password');
    //     $credentials['status'] = 'active';

    //     $remember = $request->has('remember-check');

    //     if (Auth::attempt($credentials, $remember)) {
    //         Toastr::success('Welcome to Biznx', 'Success', ["positionClass" => "toast-bottom-right"]);
    //         return redirect()->route('dashboard');
    //     } else {
    //         Toastr::error('Invalid credentials or account inactive', 'Error', ["positionClass" => "toast-bottom-right"]);
    //         return redirect()->back()->withInput($request->only('username'));
    //     }
    // }

    public function getChartData()
    {
        $year = Carbon::now()->format('Y');
        $janData = Consignment::whereBetween('date',[$year.'-01-01',$year.'-01-31'])->count();
        $FebData = Consignment::whereBetween('date',[$year.'-02-01',$year.'-02-28'])->count();
        $MarData = Consignment::whereBetween('date',[$year.'-03-01',$year.'-03-31'])->count();
        $AprData = Consignment::whereBetween('date',[$year.'-04-01',$year.'-04-30'])->count();
        $MayData = Consignment::whereBetween('date',[$year.'-05-01',$year.'-05-31'])->count();
        $JunData = Consignment::whereBetween('date',[$year.'-06-01',$year.'-06-30'])->count();
        $JulData = Consignment::whereBetween('date',[$year.'-07-01',$year.'-07-31'])->count();
        $AugData = Consignment::whereBetween('date',[$year.'-08-01',$year.'-08-31'])->count();
        $SepData = Consignment::whereBetween('date',[$year.'-09-01',$year.'-09-30'])->count();
        $OctData = Consignment::whereBetween('date',[$year.'-10-01',$year.'-10-31'])->count();
        $NovData = Consignment::whereBetween('date',[$year.'-11-01',$year.'-1-30'])->count();
        $DecData = Consignment::whereBetween('date',[$year.'-11-01',$year.'-1-31'])->count();
        $data = array();
        array_push($data,$janData,$FebData,$MarData,$AprData,$MayData,$JunData,$JulData,$AugData,$SepData,$OctData,$NovData,$DecData);
        return response()->json($data);
    }

    public function dashboard()
    {
        $year  = Carbon::now('Asia/Kolkata')->year;
        $today = Carbon::now('Asia/Kolkata');
        $previousMonth = Carbon::now()->subMonth();
        $currentMonth  = Carbon::now();
        $startOfWeek   = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek     = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        $years = range(Carbon::now()->year - 4, Carbon::now()->year);
        $currentYear = Carbon::now()->year;

        $consignmentData = collect(range(1, 12))->map(function ($month) use ($currentYear) {
            return Consignment::whereYear('date', $currentYear)->whereMonth('date', $month)->count();
        })->toArray();

        $directSalesData = collect(range(1, 12))->map(function ($month) use ($currentYear) {
            return DirectSales::whereYear('sales_date', $currentYear)->whereMonth('sales_date', $month)->count();
        })->toArray();


        // General Counts
        $staff_count   = staffs::where('status', 'active')->count();
        $product_count = Product::count();
        $jobcard_month_count = Consignment::whereYear('date', $year)->whereMonth('date', $currentMonth)->count();

        // job cards and stock
        $jobcards = Consignment::where([['approve_status', '=', 'approved'],['status', '=', 'pending']])->orWhere([['approve_status', '=', 'approved'],['status', '=', 'informed']])->limit(3)->get();
        $stocks = stock::where('product_qty','<','1')->limit(3)->get();

        //credit balance
        $sales = DirectSales::where('print_status','<>','cancelled')->get();
        $saleInvoices  = DirectSales::where('print_status','<>','cancelled')->pluck('invoice_number');
        $sales_balance = 0;
        $total_amount  = 0;
        foreach ( $sales as $sale ){
            if ($sale->discount){
                $amount = ( (float) $sale->grand_total) - ((float) $sale->discount);
            }
            else{
                $amount = (float) $sale->grand_total;
            }
            $total_amount += $amount;
        }
        $paid_amount = Daybook::whereIn('job',$saleInvoices)->where('type','Income')->sum('amount');
        $sales_balance = round($sales_balance + $total_amount - $paid_amount,2);



        return view('dashboard', compact(
            'staff_count', 'product_count', 'jobcard_month_count', 'jobcards', 'directSalesData','consignmentData','years','currentYear',
            'stocks', 'sales_balance'

        ));
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function profile(){
        return view('profile.view');
    }

    public function editprofilename(Request $request, $id){
        $profile = User::findOrFail($id);

        $this->validate($request, [

            'name' => 'required',

        ]);
        $data = $request->all();

        // image upload
        // if($request->file('image'))
        // {
        // $img= $request->file('image');
        // $imgName=time().'.'.$request->file('image')->getClientOriginalName();
        // $img->storeAs('public/images',$imgName);
        // $data['image']= $imgName;
        // }
        // return $data;
        // image upload end

        $status= $profile->fill($data)->save();
        if($status){
            Toastr::success('Username Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function editpassword(Request $request, $id){
        $profile = User::findOrFail($id);


        $data = $request->all();
        //return $data;

        $data['password'] = Hash::make($request->get('password'));

        $status= $profile->fill($data)->save();
        if($status){
            Toastr::success('Password Edited Successfully...','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function editprofileimage(Request $request, $id){
        $profile = User::findOrFail($id);


        $data = $request->all();

        // image upload
        if($request->file('image'))
        {
        $img= $request->file('image');
        $imgName=time().'.'.$request->file('image')->getClientOriginalName();
        $img->storeAs('public/images',$imgName);
        $data['image']= $imgName;
        }

        // image upload end

        $status= $profile->fill($data)->save();
        if($status){
            Toastr::success("Profile picture changed Successfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function maintenance()
    {
        return view('pages-maintenance');
    }

    public function monthlyReport()
    {
        return view('reports.index');
    }

    public function generateMonthlyReport(Request $request)
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
        $endDate = Carbon::parse($endDate)->subDay(1)->format('Y-m-d');
        $totalJobAmount = 0;
        $jobAmount = 0;
        $totalSalesAmount = 0;
        $salesAmount = 0;
        $daybookInvoices = DB::table('daybooks')->whereBetween('date',[$startDate,$endDate])->where('type','Income')->where('income_id','FROM_INVOICE')->distinct()->pluck('job');
        $salesInvoices = DB::table('direct_sales')->whereBetween('sales_date',[$startDate,$endDate])->distinct()->pluck('invoice_number');
        foreach($salesInvoices as $invoiceNumber)
        {
            $consignmentCount = DB::table('consignments')->where('invoice_no',$invoiceNumber)->where('status','delivered')->count();
            $directSale = DB::table('direct_sales')->where('invoice_number',$invoiceNumber)->first();
            if($directSale->discount)
            {
                $amount = (float)$directSale->grand_total - (float) $directSale->discount;
            }
            else
            {
                $amount = (float) $directSale->grand_total;
            }
            $amount = round($amount,2);
            if($consignmentCount > 0)
            {
                $totalJobAmount += $amount;
            }
            else
            {
                $totalSalesAmount += $amount;
            }
        }
        foreach($daybookInvoices as $invoiceNumber)
        {
            $consignmentCount = DB::table('consignments')->where('invoice_no',$invoiceNumber)->where('status','delivered')->count();
            $amount = DB::table('daybooks')->where('job',$invoiceNumber)->whereBetween('date',[$startDate,$endDate])->sum('amount');
            if($consignmentCount > 0)
            {
                $jobAmount += $amount;
            }
            else
            {
                $salesAmount += $amount;
            }
        }
        $totalExpenseInPeriod = DB::table('daybooks')->whereBetween('date',[$startDate,$endDate])->where('type','Expense')->sum('amount');
        $totalIncomeInPeriod = DB::table('daybooks')->whereBetween('date',[$startDate,$endDate])->where('type','Income')->sum('amount');
        $top5expensesInPeriod = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->groupBy('expense_id')->orderByRaw('sum(amount) DESC')->limit(5)->pluck('expense_id');
        $topExpenses = array();
        $total5ExpenseAmount = 0;
        foreach($top5expensesInPeriod as $expenseId)
        {
            $expenseAmount = DB::table('daybooks')->whereBetween('date',[$startDate,$endDate])->where('expense_id',$expenseId)->sum('amount');
            $total5ExpenseAmount += $expenseAmount;
            if($expenseId == "FOR_SUPPLIER")
            {
                $temp['expense'] = "PURCHASE PAYMENTS";
            }
            else if($expenseId == "staff_salary")
            {
                $temp['expense'] = "SALARY";
            }
            else
            {
                $expenseDetails = DB::table('expenses')->where('id',$expenseId)->first();
                $temp['expense'] = $expenseDetails->expense_name;
            }
            $temp['amount'] = $expenseAmount;
            array_push($topExpenses,$temp);
        }
        $numberOfJobs = DB::table('consignments')->whereBetween('date',[$startDate,$endDate])->count();
        $pdf = Pdf::loadView('reports.monthly_report',compact('searchDate','totalJobAmount','totalSalesAmount','jobAmount','salesAmount','totalExpenseInPeriod','topExpenses','total5ExpenseAmount','numberOfJobs','totalIncomeInPeriod'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee the planner - Monthly Report '.$searchDate.'.pdf',array("Attachment"=>false));
    }

    public function updateKeywords(Request $request)
    {
        $updateKeywords = DB::table('meta_data')->where('meta_key','keywords')->update(['meta_content'=>$request->meta_content]);
        if($updateKeywords)
        {
            Toastr::success("Keywords changed Successfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else
        {
            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function fetchYearlyData(Request $request)
    {
        $year = $request->input('year');

        // Fetch data for the selected year
        $consignmentData = collect(range(1, 12))->map(function ($month) use ($year) {
            return Consignment::whereYear('date', $year)->whereMonth('date', $month)->count();
        })->toArray();

        $directSalesData = collect(range(1, 12))->map(function ($month) use ($year) {
            return DirectSales::whereYear('sales_date', $year)->whereMonth('sales_date', $month)->count();
        })->toArray();

        return response()->json([
            'consignmentData' => $consignmentData,
            'directSalesData' => $directSalesData
        ]);
    }
    private function calculateProductCost($salesItems)
    {
        $totalCost = 0;

        foreach ($salesItems as $saleItem) {
            foreach ($saleItem->sales_items as $salesItem) {
                if ($salesItem->product_id == '159' && $saleItem->invoice_number) {
                    $consignment = DB::table('consignments')->where('invoice_no', $saleItem->invoice_number)->first();
                    if ($consignment) {
                        $chiplevel = DB::table('chiplevels')->where('jobcard_id', $consignment->id)->first();
                        if ($chiplevel && $chiplevel->service_charge) {
                            $totalCost += $chiplevel->service_charge;
                        }
                    }
                } else {
                    $productUnitPrice = Stock::where('product_id', $salesItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $totalCost += $productUnitPrice->product_unit_price * (1 + $gst);
                    }
                }
            }
        }
        return $totalCost;
    }

    public function fetchSalesData(Request $request)
    {
        $selectedDate = Carbon::parse($request->date);
        $previousMonth = $selectedDate->copy()->subMonth();
        $currentMonth = $selectedDate->copy();
        $startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SATURDAY);

        $sales = DirectSales::whereDate('sales_date', $selectedDate)->get();
        $salesTotal = $sales->sum('grand_total') - $sales->sum('discount');
        $salesProfit = $salesTotal - $this->calculateProductCost($sales);

        $previousMonthSales = DirectSales::whereMonth('sales_date', $previousMonth->month)
            ->whereYear('sales_date', $previousMonth->year)->get();
        $previousMonthSalesTotal = $previousMonthSales->sum('grand_total') - $previousMonthSales->sum('discount');
        $previousMonthSalesTotalProfit = $previousMonthSalesTotal - $this->calculateProductCost($previousMonthSales);

        $currentMonthSales = DirectSales::whereMonth('sales_date', $currentMonth->month)
            ->whereYear('sales_date', $currentMonth->year)->get();
        $currentMonthSalesTotal = $currentMonthSales->sum('grand_total') - $currentMonthSales->sum('discount');
        $currentMonthSalesTotalProfit = $currentMonthSalesTotal - $this->calculateProductCost($currentMonthSales);

        $weekSales = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->get();
        $weekSalesTotal = $weekSales->sum('grand_total') - $weekSales->sum('discount');
        $weekSalesTotalProfit = $weekSalesTotal - $this->calculateProductCost($weekSales);

        return response()->json([
            'salesRow' => "
                <tr>
                    <td>
                        <b>Sales on {$selectedDate->format('d M Y')}</b> <br>
                        " . number_format($salesTotal, 2) . " / " . number_format($salesProfit, 2) . " (
                        " . ($salesProfit > 5000 ? "<b class='text-success'>" . number_format($salesProfit - 5000, 2) . "</b>" : "<b class='text-danger'>" . number_format($salesProfit - 5000, 2) . "</b>") . "
                        )
                    </td>
                </tr>
            ",
            'previousMonthRow' => "
                <tr>
                    <td>
                        <b>Previous Month ({$previousMonth->format('M Y')})</b> <br>
                        " . number_format($previousMonthSalesTotal, 2) . " / " . number_format($previousMonthSalesTotalProfit, 2) . " (
                        " . ($previousMonthSalesTotalProfit > 195000 ? "<b class='text-success'>" . number_format($previousMonthSalesTotalProfit - 195000, 2) . "</b>" : "<b class='text-danger'>" . number_format($previousMonthSalesTotalProfit - 195000, 2) . "</b>") . "
                        )
                    </td>
                </tr>
            ",
            'currentMonthRow' => "
                <tr>
                    <td>
                        <b>Current Month ({$currentMonth->format('M Y')})</b> <br>
                        " . number_format($currentMonthSalesTotal, 2) . " / " . number_format($currentMonthSalesTotalProfit, 2) . " (
                        " . ($currentMonthSalesTotalProfit > 195000 ? "<b class='text-success'>" . number_format($currentMonthSalesTotalProfit - 19000, 2) . "</b>" : "<b class='text-danger'>" . number_format($currentMonthSalesTotalProfit - 195000, 2) . "</b>") . "
                        )
                    </td>
                </tr>
            ",
            'currentWeekRow' => "
                <tr>
                    <td>
                        <b>Current Week ({$startOfWeek->format('d M Y')} - {$endOfWeek->format('d M Y')})</b> <br>
                        " . number_format($weekSalesTotal, 2) . " / " . number_format($weekSalesTotalProfit, 2) . " (
                        " . ($weekSalesTotalProfit > 35000 ? "<b class='text-success'>" . number_format($weekSalesTotalProfit - 35000, 2) . "</b>" : "<b class='text-danger'>" . number_format($weekSalesTotalProfit - 35000, 2) . "</b>") . "
                        )
                    </td>
                </tr>
            ",
        ]);
    }
}
