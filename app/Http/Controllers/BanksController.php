<?php

namespace App\Http\Controllers;

use App\Exports\BankEntryExport;
use App\Models\Bank;
use App\Models\Daybook;
use PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::all();
        return view('bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'          => 'required',
            'bank_name'     => 'required|string|max:255',
            'acc_no'        => 'required|string|max:225',
            'book_no'       => 'nullable|string|max:225',
            'biller_name'   => 'nullable|string|max:255',
            'phone'         => 'nullable|numeric|digits:10',
        ]);

        $bank = new Bank();
        $bank->type             = $request->type;
        $bank->bank_name        = $request->bank_name;
        $bank->acc_no           = $request->acc_no;
        $bank->book_no          = $request->book_no;
        $bank->biller_name      = $request->biller_name;
        $bank->phone            = $request->phone;
        $bank->opening_balance  = $request->opening_balance;
        $status = $bank->save();

        if ($status) {
            Toastr::success('Investor updated successfully', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Update failed, try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('banks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bank = Bank::findOrFail($id);
        $banks = Daybook::where(function ($query) use ($id) {
            $query->where('income_id', 'WITHDRAW_BANK')
                ->orWhere('expense_id', 'INVEST_BANK');
        })->where('staff', $id)->orderBy('date', 'desc')->get();
        $withdrawalSum = Daybook::where('income_id', 'WITHDRAW_BANK')
            ->where('staff', $id)
            ->sum('amount');

        $investSum = Daybook::where('expense_id', 'INVEST_BANK')
            ->where('staff', $id)
            ->sum('amount');

        $netAmount = $bank->opening_balance + $investSum - $withdrawalSum;
        return view('bank.show', compact('bank', 'banks', 'netAmount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bank = Bank::findOrFail($id);
        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type'          => 'required',
            'bank_name'     => 'required|string|max:255',
            'acc_no'        => 'required|string|max:225',
            'book_no'       => 'nullable|string|max:225',
            'biller_name'   => 'nullable|string|max:255',
            'phone'         => 'nullable|numeric|digits:10',
            'opening_balance' => 'nullable|numeric'
        ]);

        $bank = Bank::findOrFail($id);
        $bank->type             = $request->type;
        $bank->bank_name        = $request->bank_name;
        $bank->acc_no           = $request->acc_no;
        $bank->book_no          = $request->book_no;
        $bank->biller_name      = $request->biller_name;
        $bank->phone            = $request->phone;
        $bank->opening_balance  = $request->opening_balance;
        $status = $bank->save();

        if ($status) {
            Toastr::success('Bank updated successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('banks.index');
        } else {
            Toastr::error('Update failed, try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bank = Bank::findOrFail($id);
        $status = $bank->delete();

        if ($status) {
            Toastr::success('Bank deleted successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Update failed, try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function disable(string $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->status = 'disable';
        $status = $bank->save();

        if ($status) {
            Toastr::success('Bank disabled successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Update failed, try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function enable(string $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->status = 'active';
        $status = $bank->save();

        if ($status) {
            Toastr::success('Bank enabled successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Update failed, try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function invest(Request $request)
    {
        $request->validate([
            'date'          => 'required|date',
            'description'   => 'nullable|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'account'       => 'required',
            'bank'          => 'required',
        ]);

        try {
            DB::beginTransaction();

            $daybook = new Daybook();
            $daybook->date          = $request->date;
            $daybook->description   = $request->description;
            $daybook->amount        = $request->amount;
            $daybook->accounts      = $request->account;
            $daybook->staff         = $request->bank;
            $daybook->expense_id    = 'INVEST_BANK';
            $daybook->type          = 'Expense';
            $daybook->save();

            $currentDayCount = DB::table('daybook_balances')
                ->where('date', Carbon::parse($request->date)->format('Y-m-d'))
                ->count();

            $lastRow = DB::table('daybook_balances')->latest('id')->first();

            if ($currentDayCount == 0) {
                $newBalances = [
                    'date'              => Carbon::parse($request->date),
                    'cash_balance'      => $lastRow->cash_balance,
                    'ledger_balance'    => $lastRow->ledger_balance,
                    'account_balance'   => $lastRow->account_balance,
                ];

                if ($request->account == "CASH") {
                    $newBalances['cash_balance'] -= $request->amount;
                } elseif ($request->account == "ACCOUNT") {
                    $newBalances['account_balance'] -= $request->amount;
                } elseif ($request->account == "LEDGER") {
                    $newBalances['ledger_balance'] -= $request->amount;
                }

                DB::table('daybook_balances')->insert($newBalances);
            } else {
                if ($request->account == "CASH") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['cash_balance' => $lastRow->cash_balance - $request->amount]);
                } elseif ($request->account == "ACCOUNT") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['account_balance' => $lastRow->account_balance - $request->amount]);
                } elseif ($request->account == "LEDGER") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['ledger_balance' => $lastRow->ledger_balance - $request->amount]);
                }
            }

            DB::commit();
            Toastr::success('Bank invested successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Something went wrong: ' . $e->getMessage(), 'Error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'date'          => 'required|date',
            'description'   => 'nullable|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'account'       => 'required',
            'bank'          => 'required',
        ]);

        try {
            DB::beginTransaction();

            $daybook = new Daybook();
            $daybook->date          = $request->date;
            $daybook->description   = $request->description;
            $daybook->amount        = $request->amount;
            $daybook->accounts      = $request->account;
            $daybook->staff         = $request->bank;
            $daybook->income_id     = 'WITHDRAW_BANK';
            $daybook->type          = 'Income';
            $daybook->save();

            $currentDayCount = DB::table('daybook_balances')
                ->where('date', Carbon::parse($request->date)->format('Y-m-d'))
                ->count();

            $lastRow = DB::table('daybook_balances')->latest('id')->first();

            if ($currentDayCount == 0) {
                $newBalances = [
                    'date'              => Carbon::parse($request->date),
                    'cash_balance'      => $lastRow->cash_balance,
                    'ledger_balance'    => $lastRow->ledger_balance,
                    'account_balance'   => $lastRow->account_balance,
                ];

                if ($request->account == "CASH") {
                    $newBalances['cash_balance'] += $request->amount;
                } elseif ($request->account == "ACCOUNT") {
                    $newBalances['account_balance'] += $request->amount;
                } elseif ($request->account == "LEDGER") {
                    $newBalances['ledger_balance'] += $request->amount;
                }

                DB::table('daybook_balances')->insert($newBalances);
            } else {
                if ($request->account == "CASH") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['cash_balance' => $lastRow->cash_balance + $request->amount]);
                } elseif ($request->account == "ACCOUNT") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['account_balance' => $lastRow->account_balance + $request->amount]);
                } elseif ($request->account == "LEDGER") {
                    DB::table('daybook_balances')->where('id', $lastRow->id)->update(['ledger_balance' => $lastRow->ledger_balance + $request->amount]);
                }
            }

            DB::commit();
            Toastr::success('Bank withdraw successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Something went wrong: ' . $e->getMessage(), 'Error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function generateBankEntryReport(Request $request)
    {
        $bankId = $request->bank;
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

        $bank = Bank::findOrFail($bankId);
        $transactions = Daybook::where(function ($query) use ($bankId) {
            $query->where('income_id', 'WITHDRAW_BANK')
                ->orWhere('expense_id', 'INVEST_BANK');
        })->where('staff', $bankId)->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->get();

        $withdrawSum    = $transactions->where('income_id', 'WITHDRAW_BANK')->sum('amount');
        $investSum      = $transactions->where('expense_id', 'INVEST_BANK')->sum('amount');
        $netAmount      = $withdrawSum - $investSum + $bank->opening_balance;

        $openingBalance = $bank->opening_balance;

        if ($request->type === 'PDF') {
            $pdf = PDF::loadView('bank.entry_report', compact(
                'bank',
                'transactions',
                'investSum',
                'withdrawSum',
                'netAmount',
                'openingBalance',
                'startDate',
                'endDate'
            ));
            return $pdf->stream('Investor_Report.pdf', array("Attachment" => false));
        }

        if ($request->type === 'EXCEL') {
            return Excel::download(
                new BankEntryExport($bank, $transactions, $investSum, $withdrawSum, $netAmount, $openingBalance, $startDate, $endDate),
                'Bank_Entry_Report.xlsx'
            );
        }
    }
}
