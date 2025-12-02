<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Daybook;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvestorReportExport;


class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investors = Investor::where('status','active')->get();
        return view('investment.index', compact('investors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $investor = Investor::findOrFail($id);
        $investments = Daybook::where(function ($query) use ($id) {
            $query->where('income_id', 'INVESTOR_INVESTMENT')
                  ->orWhere('expense_id', 'INVESTOR_WITHDRAWAL');
        })->where('staff', $id)->orderBy('date', 'desc')->get();
        $investmentSum = Daybook::where('income_id', 'INVESTOR_INVESTMENT')
            ->where('staff', $id)
            ->sum('amount');

        $withdrawalSum = Daybook::where('expense_id', 'INVESTOR_WITHDRAWAL')
            ->where('staff', $id)
            ->sum('amount');

        $netAmount = $withdrawalSum - $investmentSum;
        return view('investment.show',compact('investor','investments','netAmount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    public function addInvestor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
        ]);

        $investor   = new Investor();
        $investor->name         = $request->name;
        $investor->phone_number = $request->phone_number;
        $investor->designation  = $request->designation;
        $status     = $investor->save();

        if($status){
            Toastr::success('Investor added successfully', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function updateInvestor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
        ]);

        $investor = Investor::findOrFail($id);
        $investor->name = $request->name;
        $investor->phone_number = $request->phone_number;
        $investor->designation = $request->designation;
        $status = $investor->save();

        if($status){
            Toastr::success('Investor updated successfully', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Update failed, try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function storeInvestment(Request $request)
    {
        $request->validate([
            'date'          => 'required|date',
            'description'   => 'nullable|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'account'       => 'required',
            'investor'      => 'required',
        ]);

        try {
            $daybook = new Daybook();
            $daybook->date          = $request->date;
            $daybook->description   = $request->description;
            $daybook->amount        = $request->amount;
            $daybook->accounts      = $request->account;
            $daybook->staff         = $request->investor;
            $daybook->income_id     = 'INVESTOR_INVESTMENT';
            $daybook->type          = 'Income';
            $daybook->save();

            $investor = Investor::findOrFail($request->investor);
            $investor->balance += $request->amount;
            $investor->save();

            $currentDayCount = DB::table('daybook_balances')->where('date',Carbon::parse($request->date)->format('Y-m-d'))->count();
            if($currentDayCount == 0)
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                if($request->account == "CASH")
                {
                    $newCashBalance = $lastRow->cash_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'cash_balance' => $newCashBalance , 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance]);
                }
                if($request->account == "ACCOUNT")
                {
                    $newAccountBalance = $lastRow->account_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'account_balance' => $newAccountBalance , 'ledger_balance' => $lastRow->ledger_balance, 'cash_balance' => $lastRow->cash_balance]);
                }
                if($request->account == "LEDGER")
                {
                    $newLedgerBalance = $lastRow->ledger_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'ledger_balance' => $newLedgerBalance , 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
                }
            }
            else
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                if($request->account == "CASH")
                {
                    $newCashBalance = $lastRow->cash_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['cash_balance' => $newCashBalance]);
                }
                if($request->account == "ACCOUNT")
                {
                    $newAccountBalance = $lastRow->account_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['account_balance' => $newAccountBalance]);
                }
                if($request->account == "LEDGER")
                {
                    $newLedgerBalance = $lastRow->ledger_balance + $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['ledger_balance' => $newLedgerBalance]);
                }
            }
            if (strlen($investor->phone_number) == 10) {

                $numbers = $investor->phone_number;
                $param1 = urlencode($investor->name);
                $param2 = $request->amount;
                $param3 = $request->account;
                $param4 = Carbon::parse($request->date)->format('d-m-Y');

                $url = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=$numbers&text=investment_alert&priority=wa&stype=normal&Params=$param1,$param2,$param3,$param4";

                // dd([
                //     'url' => $url
                // ]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
            }
            Toastr::success('Investment added successfully', 'success', ["positionClass" => "toast-bottom-right"]);
        } catch (\Exception $e) {
            Toastr::error('Try again! ' . $e->getMessage(), 'error', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'account' => 'required|string',
            'investor' => 'required|exists:investors,id',
        ]);

        try {
            $daybook = new Daybook();
            $daybook->date          = $request->date;
            $daybook->description   = $request->description;
            $daybook->amount        = $request->amount;
            $daybook->accounts      = $request->account;
            $daybook->staff         = $request->investor;
            $daybook->expense_id    = 'INVESTOR_WITHDRAWAL';
            $daybook->type          = 'Expense';
            $daybook->save();

            $investor = Investor::findOrFail($request->investor);
            $investor->balance -= $request->amount;
            $investor->save();

            $currentDayCount = DB::table('daybook_balances')->where('date',Carbon::parse($request->date)->format('Y-m-d'))->count();
            if($currentDayCount == 0)
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                if($request->account == "CASH")
                {
                    $newCashBalance = $lastRow->cash_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'cash_balance' => $newCashBalance , 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance]);
                }
                if($request->account == "ACCOUNT")
                {
                    $newAccountBalance = $lastRow->account_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'account_balance' => $newAccountBalance , 'ledger_balance' => $lastRow->ledger_balance, 'cash_balance' => $lastRow->cash_balance]);
                }
                if($request->account == "LEDGER")
                {
                    $newLedgerBalance = $lastRow->ledger_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date),'ledger_balance' => $newLedgerBalance , 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
                }
            }
            else
            {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                if($request->account == "CASH")
                {
                    $newCashBalance = $lastRow->cash_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['cash_balance' => $newCashBalance]);
                }
                if($request->account == "ACCOUNT")
                {
                    $newAccountBalance = $lastRow->account_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['account_balance' => $newAccountBalance]);
                }
                if($request->account == "LEDGER")
                {
                    $newLedgerBalance = $lastRow->ledger_balance - $request->amount;
                    $addBalance = DB::table('daybook_balances')->where('id',$lastRow->id)->update(['ledger_balance' => $newLedgerBalance]);
                }
            }

            Toastr::success('Withdrawal added successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        } catch (\Exception $e) {
            Toastr::error('Try again! ' . $e->getMessage(), 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function generateInvestorReport(Request $request)
    {
        $investorId = $request->investor;
        $reportType = $request->report_type;

        if ($reportType === 'current_month') {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        } elseif ($reportType === 'current_financial_year') {
            $currentYear = Carbon::now()->year;
            if (Carbon::now()->month < 4) {
                $startDate = Carbon::create($currentYear - 1, 4, 1)->toDateString();
                $endDate = Carbon::create($currentYear, 3, 31)->toDateString();
            } else {
                $startDate = Carbon::create($currentYear, 4, 1)->toDateString();
                $endDate = Carbon::create($currentYear + 1, 3, 31)->toDateString();
            }
        } elseif ($reportType === 'last_financial_year') {
            $currentYear = Carbon::now()->year;
            if (Carbon::now()->month < 4) {
                $startDate = Carbon::create($currentYear - 2, 4, 1)->toDateString();
                $endDate = Carbon::create($currentYear - 1, 3, 31)->toDateString();
            } else {
                $startDate = Carbon::create($currentYear - 1, 4, 1)->toDateString();
                $endDate = Carbon::create($currentYear, 3, 31)->toDateString();
            }
        } elseif ($reportType === 'complete') {
            $startDate = '2016-04-01';
            $endDate = Carbon::now()->toDateString();
        } elseif ($reportType === 'select_date_range') {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
        } else {
            return redirect()->back()->with('error', 'Invalid Report Type');
        }

        $investor = Investor::findOrFail($investorId);

        $transactions = Daybook::where('staff', $investorId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        $investmentSum = $transactions->where('income_id', 'INVESTOR_INVESTMENT')->sum('amount');
        $withdrawalSum = $transactions->where('expense_id', 'INVESTOR_WITHDRAWAL')->sum('amount');
        $netAmount = $investmentSum - $withdrawalSum;

        $openingBalance = 0;

        if ($request->type === 'PDF') {
            $pdf = PDF::loadView('investment.investor_report', compact(
                'investor', 'transactions', 'investmentSum', 'withdrawalSum', 'netAmount', 'openingBalance', 'startDate', 'endDate'
            ));
            return $pdf->stream('Investor_Report.pdf', array("Attachment"=>false));
        }

        if ($request->type === 'EXCEL') {
            return Excel::download(new InvestorReportExport($investor, $transactions), 'Investor_Report.csv');

        }
    }

}
