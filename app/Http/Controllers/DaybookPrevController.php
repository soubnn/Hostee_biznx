<?php

namespace App\Http\Controllers;

use App\Exports\PrevDaybookExport;
use App\Models\DaybookBalance;
use App\Models\DaybookPrev;
use App\Models\DaybookPrevBalance;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class DaybookPrevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daybooks = DaybookPrev::all();
        return view('daybook_prev.index',compact('daybooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daybook_prev.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense_status = false;
        $income_status = false;
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $expense        =  $request->get('expense');
        $expense_amount =  $request->get('expense_amount');
        $expense_accounts       =  $request->get('expense_accounts');

        $income        =  $request->get('income');
        $income_amount =  $request->get('income_amount');
        $income_accounts  =  $request->get('income_accounts');

        if($expense){
            if(count($expense) > 0){
                for($i = 0; $i < count($expense); $i++){
                    if($expense_amount[$i] != 0)
                    {
                        $expense_data = [
                            'date'     =>  $date,
                            'expense'  =>  $expense[$i],
                            'amount'   =>  $expense_amount[$i],
                            'type'     =>  'Expense',
                            'accounts' =>  $expense_accounts[$i],
                        ];
                        $expense_status = DB::table('daybook_prevs')->insert($expense_data);
                    }
                }
            }
        }
        if($income){
            if(count($income) > 0){
                for($i = 0; $i < count($income); $i++){
                    if($income_amount[$i] != 0)
                    {
                        $income_data = [
                            'date'     =>  $date,
                            'income'  =>  $income[$i],
                            'amount'   =>  $income_amount[$i],
                            'type'     =>  'Income',
                            'accounts' =>  $income_accounts[$i],
                        ];
                        $income_status = DB::table('daybook_prevs')->insert($income_data);
                    }
                }
            }
        }
        if($expense_status || $income_status){
            $currentDayCount = DB::table('daybook_prev_balances')->where('date',Carbon::parse($request->date)->format('Y-m-d'))->count();
            if($currentDayCount == 0)
            {
                $status1 = DB::table('daybook_prev_balances')->insert(['date'=>Carbon::parse($request->date)->format('Y-m-d'),'ledger_balance'=>$request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
            }
            else
            {
                $status1 = DB::table('daybook_prev_balances')->where('date',Carbon::parse($request->date)->format('Y-m-d'))->update(['ledger_balance'=>$request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
            }
            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    //opening and closing balance functions
    public function getPrevOpeningBalance(Request $request)
    {
        $selectedDate = Carbon::parse($request->date)->format('Y-m-d');
        $currentBalanceCount = DaybookPrevBalance::where('date',$selectedDate)->count();
        if($currentBalanceCount == 0)
        {
            $balanceDetails = DaybookPrevBalance::where('date','<',$selectedDate)->latest('id')->first();
        }
        else
        {
            $balanceDetails = DaybookPrevBalance::where('date',$selectedDate)->first();
        }
        if($balanceDetails)
        {
            return $balanceDetails;
        }
        else
        {
            return "Error";
        }
    }
    
    //export
    public function export()
    {
        return Excel::download(new PrevDaybookExport, 'prev_accounts.csv', ExcelExcel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
