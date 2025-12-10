<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function profit_summary(){
        return view('reports.profit_summary');
    }
    public function monhtly_summary(){
        return view('reports.monthly_summary');
    }
    public function generate_profit_summary_month(Request $request){
        $startDate = Carbon::parse($request->summary_date)->format('Y-m-d');
        $search_date = $request->summary_date;
        $startDate = Carbon::parse($search_date)->format('Y-m-d');
        $endDate = Carbon::parse($search_date)->addMonth()->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->subDay(1)->format('Y-m-d');
        // $sales_details = DB::table('direct_sales')->join('sales_items', 'direct_sales.id', '=', 'sales_items.sales_id')->whereBetween('direct_sales.sales_date',[$startDate,$endDate])->get();
        $sales_details = DB::table('direct_sales')->whereBetween('direct_sales.sales_date',[$startDate,$endDate])->get();
        $total_expense = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $staff_salary_expense = DB::table('daybooks')->where('expense_id','staff_salary')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $purchase_expense = DB::table('daybooks')->where('expense_id','FOR_SUPPLIER')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $expense_catgeory = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->where('daybooks.type','Expense')->where('expenses.expense_category','Expense')->whereBetween('daybooks.date',[$startDate,$endDate])->sum('daybooks.amount');
        $deposit_catgeory = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->where('daybooks.type','Expense')->where('expenses.expense_category','Deposit/Others')->whereBetween('daybooks.date',[$startDate,$endDate])->sum('daybooks.amount');
        $total_expense_category = $staff_salary_expense + $expense_catgeory;
        $total_deposit_category = $purchase_expense + $deposit_catgeory;

        $expense_types_categroy_expenses = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->whereBetween('daybooks.date',[$startDate,$endDate])->where('daybooks.type','Expense')->where('expenses.expense_category','Expense')->distinct()->select('daybooks.expense_id')->get();
        $expense_categroy_expenses = array();
        foreach($expense_types_categroy_expenses as $type)
        {
            $temp = array();
            $amount = DB::table('daybooks')->where('expense_id',$type->expense_id)->whereBetween('date',[$startDate,$endDate])->sum('amount');
            $temp['amount'] = $amount;

            $expenseType = DB::table('expenses')->where('id',$type->expense_id)->first();
            $temp['name'] = $expenseType->expense_name;

            array_push($expense_categroy_expenses,$temp);
        }
        $temp1['name'] = 'SALARY';
        $temp1['amount'] = $staff_salary_expense;
        array_push($expense_categroy_expenses,$temp1);
        usort($expense_categroy_expenses, function($a,$b){
            return $b['amount'] <=> $a['amount'];
        });

        $deposit_types_categroy_expenses = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->whereBetween('daybooks.date',[$startDate,$endDate])->where('daybooks.type','Expense')->where('expenses.expense_category','Deposit/Others')->distinct()->select('daybooks.expense_id')->get();
        $deposit_categroy_expenses = array();
        foreach($deposit_types_categroy_expenses as $type)
        {
            $temp = array();
            $amount = DB::table('daybooks')->where('expense_id',$type->expense_id)->whereBetween('date',[$startDate,$endDate])->sum('amount');
            $temp['amount'] = $amount;

            $expenseType = DB::table('expenses')->where('id',$type->expense_id)->first();
            $temp['name'] = $expenseType->expense_name;

            array_push($deposit_categroy_expenses,$temp);
        }
        $temp1['name'] = 'PURCAHSE AMOUNT';
        $temp1['amount'] = $purchase_expense;
        array_push($deposit_categroy_expenses,$temp1);
        usort($deposit_categroy_expenses, function($a,$b){
            return $b['amount'] <=> $a['amount'];
        });
        $pdf = Pdf::loadView('reports.profit_report',compact('sales_details','search_date','total_expense','total_expense_category','total_deposit_category','expense_categroy_expenses','deposit_categroy_expenses'))->setPaper('a4', 'landscape');
        return $pdf->stream('Hostee the Planner - Profit Summary '.$search_date.'.pdf',array("Attachment"=>false));
    }
    public function generate_profit_summary_date(Request $request){
        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $start_date = Carbon::parse($request->start_date)->format('d-m-Y');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('d-m-Y');
        $search_date = 'From :'.$start_date.' To : '.$end_date;
        $sales_details = DB::table('direct_sales')->whereBetween('direct_sales.sales_date',[$startDate,$endDate])->get();
        $total_expense = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $staff_salary_expense = DB::table('daybooks')->where('expense_id','staff_salary')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $purchase_expense = DB::table('daybooks')->where('expense_id','FOR_SUPPLIER')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $expense_catgeory = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->where('daybooks.type','Expense')->where('expenses.expense_category','Expense')->whereBetween('daybooks.date',[$startDate,$endDate])->sum('daybooks.amount');
        $deposit_catgeory = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->where('daybooks.type','Expense')->where('expenses.expense_category','Deposit/Others')->whereBetween('daybooks.date',[$startDate,$endDate])->sum('daybooks.amount');
        $total_expense_category = $staff_salary_expense + $expense_catgeory;
        $total_deposit_category = $purchase_expense + $deposit_catgeory;

        $expense_types_categroy_expenses = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->whereBetween('daybooks.date',[$startDate,$endDate])->where('daybooks.type','Expense')->where('expenses.expense_category','Expense')->distinct()->select('daybooks.expense_id')->get();
        $expense_categroy_expenses = array();
        foreach($expense_types_categroy_expenses as $type)
        {
            $temp = array();
            $amount = DB::table('daybooks')->where('expense_id',$type->expense_id)->whereBetween('date',[$startDate,$endDate])->sum('amount');
            $temp['amount'] = $amount;

            $expenseType = DB::table('expenses')->where('id',$type->expense_id)->first();
            $temp['name'] = $expenseType->expense_name;

            array_push($expense_categroy_expenses,$temp);
        }
        $temp1['name'] = 'SALARY';
        $temp1['amount'] = $staff_salary_expense;
        array_push($expense_categroy_expenses,$temp1);
        usort($expense_categroy_expenses, function($a,$b){
            return $b['amount'] <=> $a['amount'];
        });

        $deposit_types_categroy_expenses = DB::table('daybooks')->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')->whereBetween('daybooks.date',[$startDate,$endDate])->where('daybooks.type','Expense')->where('expenses.expense_category','Deposit/Others')->distinct()->select('daybooks.expense_id')->get();
        $deposit_categroy_expenses = array();
        foreach($deposit_types_categroy_expenses as $type)
        {
            $temp = array();
            $amount = DB::table('daybooks')->where('expense_id',$type->expense_id)->whereBetween('date',[$startDate,$endDate])->sum('amount');
            $temp['amount'] = $amount;

            $expenseType = DB::table('expenses')->where('id',$type->expense_id)->first();
            $temp['name'] = $expenseType->expense_name;

            array_push($deposit_categroy_expenses,$temp);
        }
        $temp1['name'] = 'PURCAHSE AMOUNT';
        $temp1['amount'] = $purchase_expense;
        array_push($deposit_categroy_expenses,$temp1);
        usort($deposit_categroy_expenses, function($a,$b){
            return $b['amount'] <=> $a['amount'];
        });
        $pdf = Pdf::loadView('reports.profit_report',compact('sales_details','search_date','total_expense','total_expense_category','total_deposit_category','expense_categroy_expenses','deposit_categroy_expenses'))->setPaper('a4', 'landscape');
        return $pdf->stream('Hostee the Planner - Profit Summary From :'.$start_date.' To : '.$end_date.'.pdf',array("Attachment"=>false));
    }
    public function generate_monthly_summary(Request $request){
        $startDate = Carbon::parse($request->summary_date)->format('Y-m-d');
        $search_date = $request->summary_date;
        $startDate = Carbon::parse($search_date)->format('Y-m-d');
        $endDate = Carbon::parse($search_date)->addMonth()->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->subDay(1)->format('Y-m-d');

        $total_job_amount = 0;
        $total_sales_amount = 0;
        $total_income = DB::table('daybooks')->whereBetween('date',[$startDate,$endDate])->where('type','Income')->sum('amount');
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
                $total_job_amount += $amount;
            }
            else
            {
                $total_sales_amount += $amount;
            }
        }

        $total_expense = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->sum('amount');
        $total_bank_deposit = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->whereIn('expense_id', [10,24,25])->sum('amount');
        $total_amount_to_sellers = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->where('expense_id', 'FOR_SUPPLIER')->sum('amount');
        $total_amount_to_salary = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->where('expense_id', 'staff_salary')->sum('amount');
        $total_amount_to_incentive = DB::table('daybooks')->where('type','Expense')->whereBetween('date',[$startDate,$endDate])->where('expense_id', 'staff_incentive')->sum('amount');
        $total_of_top_expense = $total_bank_deposit + $total_amount_to_sellers + $total_amount_to_salary + $total_amount_to_incentive;

        $total_bill_amount = 0;
        $total_rate_of_item = 0;
        $total_purchase_amount = 0;
        $total_profit_amount = 0;
        $total_service_charge = 0;
        $total_amount_to_techsoul = 0;
        $total_paid_amount = 0;
        $total_credit_amount = 0;
        $sales_details = DB::table('direct_sales')->whereBetween('direct_sales.sales_date',[$startDate,$endDate])->get();

        foreach ( $sales_details as $sales_detail){
            $sales_items = DB::table('sales_items')->where('sales_id',$sales_detail->id)->get();
            foreach ( $sales_items as $item){
                $daybook_details = DB::table('daybooks')->where('income_id','FROM_INVOICE')->where('job',$sales_detail->invoice_number)->first();
                if($item->product_id == '159' || $item->product_id == '162'){
                    if($daybook_details){
                        $total_paid_amount = $total_paid_amount+$item->sales_price;
                    }
                    else{
                        $total_credit_amount = $total_credit_amount+$item->sales_price;
                    }
                    $total_bill_amount = $total_bill_amount+$item->sales_price;
                    $total_profit = $item->sales_price;
                    $total_service_charge = $total_service_charge + $item->sales_price;
                }
                else{
                    $product_details = DB::table('products')->where('id',$item->product_id)->first();
                    if($daybook_details){
                        $total_paid_amount = $total_paid_amount+$item->sales_price;
                    }
                    else{
                        $total_credit_amount = $total_credit_amount+$item->sales_price;
                    }
                    $total_bill_amount = $total_bill_amount+$item->sales_price;
                    $total_rate_of_item = $total_rate_of_item+$item->sales_price;

                    $stock = DB::table('stocks')->where('product_id',$item->product_id)->first();
                    $purchase_details = DB::table('purchase_items')->where('product_id',$item->product_id)->latest('id')->first();
                    $purchase_amount_without_gst =( $stock->product_unit_price) * ($item->product_quantity);
                    $purchase_tax_amount = $purchase_amount_without_gst * ($purchase_details->gst_percent/100);
                    $purchase_amount = $purchase_amount_without_gst + $purchase_tax_amount;
                    $purchase_amount = number_format($purchase_amount, 2, '.', '');
                    $profit = ($item->sales_price) - $purchase_amount;
                    $total_purchase_amount = $total_purchase_amount+$purchase_amount;
                    $total_purchase_amount = number_format($total_purchase_amount, 2, '.', '');
                    $total_profit_amount = $total_profit_amount+$profit;

                    $total_profit = $profit;
                }
                $total_amount_to_techsoul = $total_amount_to_techsoul+$total_profit;
            }
        }

        $pdf = Pdf::loadView('reports.monthly_summary_pdf',compact('search_date','total_expense','total_bank_deposit','total_amount_to_sellers','total_amount_to_salary','total_amount_to_incentive','total_of_top_expense','total_bill_amount','total_rate_of_item','total_purchase_amount','total_profit_amount','total_service_charge','total_amount_to_techsoul','total_sales_amount','total_job_amount','total_income'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee the Planner - Monthly Summary '.$search_date.'.pdf',array("Attachment"=>false));
    }
}
