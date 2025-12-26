<?php

namespace App\Http\Controllers;

use App\Models\Daybook;
use App\Models\DaybookBalance;
use App\Models\DaybookService;
use App\Models\DaybookSummary;
use App\Models\DirectSales;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\SalesItems;
use App\Models\Seller;
use App\Models\stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaybookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daybook = Daybook::whereDate('date', '>=', now()->subDays(5))->orderBy('date', 'DESC')->get();
        $total = 0;
        $start_date = 0;
        $end_date = 0;

        foreach ($daybook as $entry) {
            if (!$entry) {
                continue;
            }

            if ($entry->type == "Expense") {
                switch ($entry->expense_id) {
                    case 'staff_salary':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'Staff Salary <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                        break;
                    case 'staff_incentive':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'Incentive <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                        break;
                    case 'SALE_RETURN':
                        $entry->edit_status = 'no';
                        $entry->expense_name = $entry->job ? 'FOR INVOICE #' . $entry->job : 'FOR INVOICE';
                        break;
                    case 'FOR_SUPPLIER':
                        $entry->edit_status = 'yes';
                        $entry->expense_name = 'FOR SUPPLIER - <br> ' . $entry->sellers_detail->seller_name;
                        break;
                    case 'INVESTOR_WITHDRAWAL':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'INVESTOR WITHDRAWAL ' . $entry->investor_detail->name;
                        break;
                    case 'INVEST_BANK':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'DEPOSITED IN BANK ' . $entry->bank_detail->bank_name;
                        if ($entry->bank_detail->book_no) {
                            $entry->expense_name .= ' No. ' . $entry->bank_detail->book_no;
                        }
                        break;
                    default:
                        $entry->edit_status = 'yes';
                        $entry->expense_name = $entry->expenses_detail->expense_name;
                }
            }

            if ($entry->type == "Income") {
                switch ($entry->income_id) {
                    case 'FROM_INVOICE':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'FROM INVOICE <br> #' . $entry->job;
                        $entry->description = $entry->sales_detail->customer_detail->name;
                        break;
                    case 'PURCHASE_RETURN':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'FOR SUPPLIER <br> #' . $entry->job;
                        break;
                    case 'add_income':
                        $entry->edit_status = 'yes';
                        $entry->expense_name = 'Income';
                        break;
                    case 'INVESTOR_INVESTMENT':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'INVESTOR WITHDRAWAL ' . $entry->investor_detail->name;
                        break;
                    case 'WITHDRAW_BANK':
                        $entry->edit_status = 'no';
                        $entry->expense_name = 'WITHDRAW IN BANK ' .  $entry->bank_detail->bank_name;
                        if ($entry->bank_detail->book_no) {
                            $entry->expense_name .= ' No. ' . $entry->bank_detail->book_no;
                        }
                        break;
                    default:
                        $entry->edit_status = 'yes';
                        $entry->expense_name = $entry->incomes_detail->income_name;
                }
            }

            if ($entry->type == "Transfer") {
                $entry->edit_status = 'no';
            }
            $entry->today = Carbon::parse(DaybookBalance::report_date())->format('Y-m-d');
        }
        $incomes = Income::get();
        $expenses = Expense::get();
        $suppliers = Seller::get();

        return view('daybook.index', compact('daybook', 'total', 'start_date', 'end_date', 'incomes', 'expenses', 'suppliers'));
    }

    public function all_index()
    {
        $startDate = '';
        $endDate   = '';
        $daybook    = '';
        $total = 0;
        $start_date = 0;
        $end_date = 0;
        return view('daybook.all_index', compact('daybook', 'total', 'start_date', 'end_date', 'startDate', 'endDate'));
    }
    public function generateDaybook(Request $request)
    {
        $this->validate($request, [
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = date('Y-m-d', strtotime($request->startDate));
        $endDate = date('Y-m-d', strtotime($request->endDate));
        $daybook = Daybook::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->orderBy('date', 'DESC')->get();
        $total      = 0;
        $start_date = 0;
        $end_date   = 0;
        return view('daybook.all_index', compact('daybook', 'total', 'start_date', 'end_date', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daybook.create');
    }

    public function createIncome()
    {
        return view('daybook.createIncome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->get('expense_id')) {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $date = date('Y-m-d', strtotime($request->date));
            $expense_id       =   $request->get('expense_id');
            $amount          =   $request->get('amount');
            $description          =   $request->get('description');
            $job            =   $request->get('job');
            $staff         =   $request->get('staff');
            $type           =  $request->get('type');
            $accounts           =  $request->get('accounts');

            for ($i = 0; $i < count($expense_id); $i++) {
                if ($amount[$i] != 0) {
                    if ($expense_id[$i] != '') {
                        $datasave = [
                            'date'   =>  Carbon::parse($request->date)->format('Y-m-d'),
                            'expense_id'    =>  $expense_id[$i],
                            'amount'        =>  $amount[$i],
                            'description'   =>  $description[$i],
                            'job'           =>  $job[$i],
                            'staff'         =>  $staff[$i],
                            'type'          =>  'Expense',
                            'accounts'      =>  $accounts[$i],
                            'add_date'      =>  Carbon::now(),
                            'add_by'        =>  Auth::user()->name,
                        ];
                        $status = DB::table('daybooks')->insert($datasave);
                    }
                }
            }
            if ($status) {
                $currentDayCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
                if ($currentDayCount == 0) {
                    $status1 = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date)->format('Y-m-d'), 'ledger_balance' => $request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
                } else {
                    $status1 = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->update(['ledger_balance' => $request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
                }
                Toastr::success('Details Added', 'success', ["positionClass" => "toast-bottom-right"]);
            } else {
                Toastr::error('try again!', 'error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
        if ($request->get('income_id')) {

            $date = Carbon::parse($request->date)->format('Y-m-d');
            $date = date('Y-m-d', strtotime($request->date));
            $income_id       =   $request->get('income_id');
            $description          =   $request->get('description');
            $amount          =   $request->get('amount');
            $job            =   $request->get('job');
            $staff         =   $request->get('staff');
            $type           =  $request->get('type');
            $accounts           =  $request->get('accounts');

            // // return $stock_price;
            for ($i = 0; $i < count($income_id); $i++) {
                if ($amount[$i] != 0 || $amount[$i] != '') {
                    $datasave = [
                        'date'   =>  Carbon::parse($request->date)->format('Y-m-d'),
                        'income_id'      =>  $income_id[$i],
                        'amount'         =>  $amount[$i],
                        'job'           =>  $job[$i],
                        'description'   =>  $description[$i],
                        'staff'         => $staff[$i],
                        'type'          => 'Income',
                        'accounts'      => $accounts[$i],
                        'add_date'      =>  Carbon::now(),
                        'add_by'        =>  Auth::user()->name,
                    ];

                    if ($job[$i] != null) {
                        $jobNumber = $job[$i];
                        $updateStatus = DB::table('consignments')->where('jobcard_number', $jobNumber)->update(['status' => 'paid']);
                    }
                    $status = DB::table('daybooks')->insert($datasave);
                }
            }
            if ($status) {
                $currentDayCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
                if ($currentDayCount == 0) {
                    $status1 = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date)->format('Y-m-d'), 'ledger_balance' => $request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
                } else {
                    $status1 = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->update(['ledger_balance' => $request->ledgerCB, 'account_balance' => $request->bankCB, 'cash_balance' => $request->cashCB]);
                }
                Toastr::success('Details Added', 'success', ["positionClass" => "toast-bottom-right"]);
            } else {
                Toastr::error('try again!', 'error', ["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        } else {
            return redirect()->back();
        }

        //return $data;
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
        $daybook = Daybook::findOrFail($id);
        $daybook_balance = DaybookBalance::latest('id')->first();

        $new_cash_balance = $daybook_balance->cash_balance;
        $new_account_balance = $daybook_balance->account_balance;

        if ($daybook->type == "Income") {
            $daybook->income_id = $request->income_id;

            if ($daybook->accounts == 'CASH') {
                if ($request->accounts == 'ACCOUNT') {
                    $new_cash_balance -= $daybook->amount;
                    $new_account_balance += $request->amount;
                } elseif ($request->accounts == 'CASH') {
                    $new_cash_balance = $new_cash_balance - $daybook->amount + $request->amount;
                }
            } elseif ($daybook->accounts == 'ACCOUNT') {
                if ($request->accounts == 'CASH') {
                    $new_account_balance -= $daybook->amount;
                    $new_cash_balance += $request->amount;
                } elseif ($request->accounts == 'ACCOUNT') {
                    $new_account_balance = $new_account_balance - $daybook->amount + $request->amount;
                }
            }
        } elseif ($daybook->type == "Expense") {
            if ($daybook->expense_id == "FOR_SUPPLIER") {
                $daybook->expense_id = "FOR_SUPPLIER";
                $daybook->job = $request->expense_id;

                if ($daybook->accounts == 'CASH') {
                    if ($request->accounts == 'ACCOUNT') {
                        $new_cash_balance += $daybook->amount;
                        $new_account_balance -= $request->amount;
                    } elseif ($request->accounts == 'CASH') {
                        $new_cash_balance = $new_cash_balance + $daybook->amount - $request->amount;
                    }
                } elseif ($daybook->accounts == 'ACCOUNT') {
                    if ($request->accounts == 'CASH') {
                        $new_account_balance += $daybook->amount;
                        $new_cash_balance -= $request->amount;
                    } elseif ($request->accounts == 'ACCOUNT') {
                        $new_account_balance = $new_account_balance + $daybook->amount - $request->amount;
                    }
                }
            } else {
                $daybook->expense_id = $request->expense_id;

                if ($daybook->accounts == 'CASH') {
                    if ($request->accounts == 'ACCOUNT') {
                        $new_cash_balance += $daybook->amount;
                        $new_account_balance -= $request->amount;
                    } elseif ($request->accounts == 'CASH') {
                        $new_cash_balance = $new_cash_balance + $daybook->amount - $request->amount;
                    }
                } elseif ($daybook->accounts == 'ACCOUNT') {
                    if ($request->accounts == 'CASH') {
                        $new_account_balance += $daybook->amount;
                        $new_cash_balance -= $request->amount;
                    } elseif ($request->accounts == 'ACCOUNT') {
                        $new_account_balance = $new_account_balance + $daybook->amount - $request->amount;
                    }
                }
            }
        }

        if ($new_cash_balance < 0) {
            Toastr::error('Insufficient funds! In Cash Account', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        if ($new_account_balance < 0) {
            Toastr::error('Insufficient funds! In Bank Account', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }

        $daybook->amount = $request->amount;
        $daybook->accounts = $request->accounts;
        $status = $daybook->save();

        $daybook_balance->cash_balance = $new_cash_balance;
        $daybook_balance->account_balance = $new_account_balance;
        $balance_status = $daybook_balance->save();

        if ($status && $balance_status) {
            Toastr::success('Details Edited', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteEntry = DB::table('daybooks')->where('id', $id)->delete();
        if ($deleteEntry) {
            Toastr::success('Deleted', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::success('Error occurred', 'success', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function get_commission(Request $request)
    {
        $jobcard_no = $request->jobcard_no;

        if (substr($jobcard_no, 0, 1) == 'c') {

            $get_jobcard_details = DB::table('cng_jobcards')->where('cng_jobno', $jobcard_no)->get();

            if ($get_jobcard_details == NULL) {
                $get_jobcard_details = 'Error';
            }
        } else {

            $commissionDetails = DB::table('commissions')->where('jobcard_number', $jobcard_no)->first();
            $data = array();
            if ($commissionDetails->mechanic_id != "direct") {
                $mechanic = DB::table('mechanics')->where('id', $commissionDetails->mechanic_id)->first();
                $data['mechanic_name'] = $mechanic->mechanic_name;
                $data['mechanic'] = $mechanic->id;
                $data['job_no'] = $jobcard_no;
                $data['pending'] = $commissionDetails->pending_commission;
            } else {
                $data['mechanic_name'] = "Direct";
                $data['mechanic'] = "direct";
                $data['job_no'] = $jobcard_no;
                $data['pending'] = $commissionDetails->pending_commission;
            }
        }
        return response()->json($data);
    }
    public function get_salary(Request $request)
    {
        $staff = $request->staff;

        $staffDetails = DB::table('staffs')->where('id', $staff)->first();
        return response()->json($staffDetails);
    }

    public function addInvoicePayment(Request $request)
    {
        $this->validate($request, [
            'accounts' => 'required',
            'amount' => 'required|gt:0'
        ]);

        try {

            $data = $request->all();
            $data['date'] = Carbon::parse($request->date)->format('Y-m-d');

            $salesDetails = DB::table('direct_sales')->where('invoice_number', $request->job)->first();
            if (!$salesDetails) {
                throw new \Exception('Sales details not found');
            }

            $paid_amount = Daybook::where('job', $request->job)->sum('amount');
            $total_amount = $paid_amount + $request->amount;
            $grand_total = $salesDetails->grand_total - $salesDetails->discount;

            $sale_data = [];
            if ($grand_total > $total_amount) {
                $sale_data['payment_status'] = 'partial';
            } elseif ($grand_total == $total_amount) {
                $sale_data['payment_status'] = 'paid';
            }

            if ($salesDetails->pay_method == 'CREDIT') {
                $sale_data['pay_method'] = $request->accounts;
            } else {
                $existingAccounts = explode(',', $salesDetails->pay_method);
                if (!in_array($request->accounts, $existingAccounts)) {
                    $existingAccounts[] = $request->accounts;
                }
                $sale_data['pay_method'] = implode(',', $existingAccounts);
            }

            $data['add_date'] = Carbon::now();
            $data['add_by'] = Auth::user()->name;

            $paymentStatus = Daybook::create($data);
            if (!$paymentStatus) {
                throw new \Exception('Failed to create payment record');
            }

            DB::table('direct_sales')->where('id', $salesDetails->id)->update($sale_data);

            $balanceCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
            if ($balanceCount == 0) {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                if ($lastRow) {
                    DB::table('daybook_balances')->insert([
                        'date' => Carbon::parse($request->date)->format('Y-m-d'),
                        'ledger_balance' => $lastRow->ledger_balance,
                        'account_balance' => $lastRow->account_balance,
                        'cash_balance' => $lastRow->cash_balance
                    ]);
                }
            }

            $latestBalance = DB::table('daybook_balances')->latest('id')->first();
            $customer = DB::table('customers')->where('id', $salesDetails->customer_id)->first();
            if (!$customer) {
                throw new \Exception('Customer not found');
            }

            $newBalance = round($customer->balance - $data['amount'], 2);
            $updateCustomerBalance = DB::table('customers')->where('id', $salesDetails->customer_id)->update(['balance' => $newBalance]);

            if (!$updateCustomerBalance) {
                throw new \Exception('Failed to update customer balance');
            }

            $accountsForSMS = "";
            if ($data['accounts'] == "CASH") {
                $accountsForSMS = "CASH";
                $newCashBalance = $latestBalance->cash_balance + $data['amount'];
                DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['cash_balance' => $newCashBalance]);
            } elseif ($data['accounts'] == "ACCOUNT") {
                $accountsForSMS = "BANK";
                $newAccountBalance = $latestBalance->account_balance + $data['amount'];
                DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['account_balance' => $newAccountBalance]);
            } elseif ($data['accounts'] == "LEDGER") {
                $accountsForSMS = "CASH";
                $newLedgerBalance = $latestBalance->ledger_balance + $data['amount'];
                DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
            }

            Toastr::success('Income Added', 'success', ["positionClass" => "toast-bottom-right"]);
            // if(strlen($customer->mobile) == 10)
            // {
            //     $apiKey = urlencode(env('SMS_API_KEY'));
            //     $sender = urlencode('TECYSO');
            //     $numbers = $customer->mobile;
            //     $message = rawurlencode("We acknowledge your payment of Rs. ". $data['amount'] .", which we received from you through ". $accountsForSMS . " on ". Carbon::parse($data['date'])->format('d-m-Y') ." for purchase with our company. -Team Techsoul 8891989842");
            //     $data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);

            //     $ch = curl_init('https://api.textlocal.in/send/');
            //     curl_setopt($ch, CURLOPT_POST, true);
            //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //     $response = curl_exec($ch);
            //     curl_close($ch);
            // }
            return redirect()->back()->with('receiptChoice', $request->job);
        } catch (\Exception $e) {
            Toastr::error('Error: ' . $e->getMessage(), 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function addPurchasePayment(Request $request)
    {
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date)->format('Y-m-d');
        $purchaseDetails = DB::table('purchases')->where('invoice_no', $request->job)->first();
        $paymentStatus = Daybook::create($data);
        if ($paymentStatus) {
            $balanceCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
            if ($balanceCount == 0) {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                $copyRow = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
            }

            $latestBalance = DB::table('daybook_balances')->latest('id')->first();
            $seller = DB::table('sellers')->where('id', $purchaseDetails->seller_details)->first();
            $currentBalance = $seller->seller_opening_balance;
            $amount = $data['amount'];
            $newBalance = $currentBalance - $amount;
            $newBalance = round($newBalance, 2);
            $updateSellerBalance = DB::table('sellers')->where('id', $purchaseDetails->seller_details)->update(['seller_opening_balance' => $newBalance]);
            if ($updateSellerBalance) {
                if ($data['accounts'] == "CASH") {
                    $newCashBalance = $latestBalance->cash_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                }
                if ($data['accounts'] == "ACCOUNT") {
                    $newAccountBalance = $latestBalance->account_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                }
                if ($data['accounts'] == "LEDGER") {
                    $newLedgerBalance = $latestBalance->ledger_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
                }
                Toastr::success('Expense Added', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        } else {
            Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function addSupplierPayment(Request $request)
    {
        $this->validate(
            $request,
            [
                'accounts' => 'required',
                'amount' => 'required|gt:0'
            ]
        );
        $data['expense_id'] = 'FOR_SUPPLIER';
        $data['job'] = $request->job;
        $data['type'] = $request->type;
        $data['amount'] = $request->amount;
        $data['accounts'] = $request->accounts;
        $data['date'] = Carbon::parse($request->date)->format('Y-m-d');
        $data['add_date'] = Carbon::now();
        $data['add_by'] = Auth::user()->name;
        $paymentStatus = Daybook::create($data);
        if ($paymentStatus) {
            $balanceCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
            if ($balanceCount == 0) {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                $copyRow = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
            }
            $latestBalance = DB::table('daybook_balances')->latest('id')->first();
            if ($data['accounts'] == "CASH") {
                $newCashBalance = $latestBalance->cash_balance - $data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['cash_balance' => $newCashBalance]);
            }
            if ($data['accounts'] == "ACCOUNT") {
                $newAccountBalance = $latestBalance->account_balance - $data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['account_balance' => $newAccountBalance]);
            }
            if ($data['accounts'] == "LEDGER") {
                $newLedgerBalance = $latestBalance->ledger_balance - $data['amount'];
                $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
            }
            Toastr::success('Expense Added', 'success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } else {
            Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function addJobcardInvoicePayment(Request $request)
    {
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date)->format('Y-m-d');
        $salesDetails = DB::table('consignments')->where('invoice_no', $request->job)->first();
        $paymentStatus = Daybook::create($data);
        if ($paymentStatus) {
            $customer = DB::table('customers')->where('id', $salesDetails->customer_name)->first();
            $currentBalance = $customer->balance;
            $amount = $data['amount'];
            $newBalance = $currentBalance - $amount;
            $newBalance = round($newBalance, 2);
            $updateCustomerBalance = DB::table('customers')->where('id', $salesDetails->customer_name)->update(['balance' => $newBalance]);
            if ($updateCustomerBalance) {
                Toastr::success('Income Added', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back()->with('receiptChoice', $request->job);
            }
        } else {
            Toastr::success('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function generateReciept(Request $request)
    {
        function number_to_word(float $number)
        {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(
                0 => '',
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
                90 => 'ninety'
            );
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_length) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                } else $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal > 0) ? "point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . '' : '';
            return ($Rupees ? $Rupees . '' : '') . $paise;
        }

        $invoiceNumber = $request->invoiceNumber;
        $invoiceDetails = DB::table('direct_sales')->where('invoice_number', $invoiceNumber)->first();
        $paymentDetails = DB::table('daybooks')->where('job', $invoiceNumber)->orderBy('id', 'asc')->get();
        foreach ($paymentDetails as $payment) {
            $payment->date = Carbon::parse($payment->date)->format('d-m-Y');
            $payment->amountInWords = strtoupper(number_to_word((float)$payment->amount));
        }
        $pdf = Pdf::loadView('invoices.payment_reciept', compact('paymentDetails', 'invoiceDetails'))->setPaper('a4', 'portrait');
        return $pdf->stream('Income Expense Report.pdf', array("Attachment" => false));
    }

    public function getOpeningBalance(Request $request)
    {
        $selectedDate = Carbon::parse($request->date)->format('Y-m-d');
        $currentBalanceCount = DB::table('daybook_balances')->where('date', $selectedDate)->count();
        if ($currentBalanceCount == 0) {
            $balanceDetails = DB::table('daybook_balances')->where('date', '<', $selectedDate)->latest('id')->first();
        } else {
            $balanceDetails = DB::table('daybook_balances')->where('date', $selectedDate)->first();
        }
        if ($balanceDetails) {
            return $balanceDetails;
        } else {
            return "Error";
        }
    }

    public function cashTransfer(Request $request)
    {
        $selectedDate = Carbon::parse($request->transferDate)->format('Y-m-d');
        $currentBalanceCount = DB::table('daybook_balances')->where('date', $selectedDate)->count();
        if ($currentBalanceCount == 0) {
            $balanceDetails = DB::table('daybook_balances')->where('date', '<', $selectedDate)->latest('id')->first();
        } else {
            $balanceDetails = DB::table('daybook_balances')->where('date', $selectedDate)->first();
        }
        if ($balanceDetails) {
            $fromAccount = $request->fromSelect;
            $toAccount = $request->toSelect;
            if ($fromAccount != $toAccount) {
                if ($fromAccount == "LEDGER") {
                    $balance = $balanceDetails->ledger_balance;
                } else if ($fromAccount == "CASH") {
                    $balance = $balanceDetails->cash_balance;
                } else if ($fromAccount == "ACCOUNT") {
                    $balance = $balanceDetails->account_balance;
                }
                if ($toAccount == "LEDGER") {
                    $toBalance = $balanceDetails->ledger_balance;
                } else if ($toAccount == "CASH") {
                    $toBalance = $balanceDetails->cash_balance;
                } else if ($toAccount == "ACCOUNT") {
                    $toBalance = $balanceDetails->account_balance;
                }

                if ($request->amount <= $balance) {
                    $createDaybook = DB::table('daybooks')->insert([
                        'date' => $selectedDate,
                        'income_id' => 'CASH_TRANSFER',
                        'description' => $fromAccount . ' TO ' . $toAccount,
                        'amount' => $request->amount,
                        'type' => 'Transfer',
                        'accounts' => strtoupper($toAccount),
                        'add_date' => Carbon::now(),
                        'add_by' => Auth::user()->name
                    ]);
                    if ($createDaybook) {
                        $newFromBalance = $balance - $request->amount;
                        $newToBalance = $toBalance + $request->amount;
                        if ($currentBalanceCount != 0) {
                            if ($fromAccount == "LEDGER") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['ledger_balance' => $newFromBalance]);
                            } else if ($fromAccount == "CASH") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['cash_balance' => $newFromBalance]);
                            } else if ($fromAccount == "ACCOUNT") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['account_balance' => $newFromBalance]);
                            }
                            if ($toAccount == "LEDGER") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['ledger_balance' => $newToBalance]);
                            } else if ($toAccount == "CASH") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['cash_balance' => $newToBalance]);
                            } else if ($toAccount == "ACCOUNT") {
                                $updateBalance = DB::table('daybook_balances')->where('id', $balanceDetails->id)->update(['account_balance' => $newToBalance]);
                            } else {
                                Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
                            }
                        } else {
                            if ($fromAccount == "LEDGER" && $toAccount == "CASH") {
                                $updateBalance  = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $newFromBalance, 'account_balance' => $balanceDetails->account_balance, "cash_balance" => $newToBalance]);
                            } else if ($fromAccount == "LEDGER" && $toAccount == "ACCOUNT") {
                                $updateBalance = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $newFromBalance, 'account_balance' => $newToBalance, 'cash_balance' => $balanceDetails->cash_balance]);
                            } else if ($fromAccount == "CASH" && $toAccount == "LEDGER") {
                                $updateBalance = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $newToBalance, 'account_balance' => $balanceDetails->account_balance, 'cash_balance' => $newFromBalance]);
                            } else if ($fromAccount == "CASH" && $toAccount == "ACCOUNT") {
                                $updateBalance = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $balanceDetails->ledger_balance, 'account_balance' => $newToBalance, 'cash_balance' => $newFromBalance]);
                            } else if ($fromAccount == "ACCOUNT" && $toAccount == "CASH") {
                                $updateBalance = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $balanceDetails->ledger_balance, 'account_balance' => $newFromBalance, 'cash_balance' => $newToBalance]);
                            } else if ($fromAccount == "ACCOUNT" && $toAccount == "LEDGER") {
                                $updateBalance = DB::table('daybook_balances')->insert(['date' => $selectedDate, 'ledger_balance' => $newToBalance, 'account_balance' => $newFromBalance, 'cash_balance' => $balanceDetails->cash_balance]);
                            } else {
                                Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
                            }
                        }
                        Toastr::success('Expense Added', 'success', ["positionClass" => "toast-bottom-right"]);
                    } else {
                        Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
                    }
                } else {
                    Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
                }
            } else {
                Toastr::error('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
            }
        }
        return redirect()->back();
    }
    public function generateDaybookReport(Request $request)
    {

        $startDate = date('Y-m-d', strtotime($request->startDate));
        $endDate = date('Y-m-d', strtotime($request->endDate));
        $this->validate($request, [

            'startDate' => 'required',
        ]);
        $data = $request->all();

        $tableData = array();
        $startDate = Carbon::parse($data['startDate'])->format('d-m-Y');
        $endDate = Carbon::parse($data['endDate'])->format('d-m-Y');
        $totalIncomeInPeriod = DB::table('daybooks')->where('type', 'Income')->whereBetween('date', [$data['startDate'], $data['endDate']])->sum('amount');
        $totalExpenseInPeriod = DB::table('daybooks')->where('type', 'Expense')->whereBetween('date', [$data['startDate'], $data['endDate']])->sum('amount');
        $balanceAmountInPeriod = $totalIncomeInPeriod - $totalExpenseInPeriod;
        $expensesInPeriod = DB::table('daybooks')->where('type', 'Expense')->whereBetween('date', [$data['startDate'], $data['endDate']])->get();
        $incomesInPeriod = DB::table('daybooks')->where('type', 'Income')->whereBetween('date', [$data['startDate'], $data['endDate']])->get();
        $incomeTypesInPeriod = DB::table('daybooks')->where('type', 'Income')->whereBetween('date', [$data['startDate'], $data['endDate']])->distinct()->select('income_id')->get();
        $expenseTypesInPeriod = DB::table('daybooks')->where('type', 'Expense')->whereBetween('date', [$data['startDate'], $data['endDate']])->distinct()->select('expense_id')->get();
        $transferTypesInPeriod = DB::table('daybooks')->where('type', 'Transfer')->whereBetween('date', [$data['startDate'], $data['endDate']])->distinct()->select('description')->get();
        $incomeTypeDetails = array();
        foreach ($incomeTypesInPeriod as $type) {
            $temp = array();
            $amount = DB::table('daybooks')->where('income_id', $type->income_id)->whereBetween('date', [$data['startDate'], $data['endDate']])->sum('amount');
            $temp['amount'] = $amount;
            if ($type->income_id == "FROM_INVOICE") {
                $temp['name'] = "PAYMENT FROM SALES";
            } elseif ($type->income_id == "INVESTOR_INVESTMENT") {
                $temp['name'] = "INVESTOR INVESTMENT";
            } elseif ($type->income_id == "WITHDRAW_BANK") {
                $temp['name'] = "WITHDRAW IN BANK";
            } else if ($type->income_id == "PURCHASE_RETURN") {
                $temp['name'] = "PAYMENT FROM SELLERS";
            } else {
                $incomeType = DB::table('incomes')->where('id', $type->income_id)->first();
                $temp['name'] = $incomeType->income_name;
            }
            array_push($incomeTypeDetails, $temp);
        }
        usort($incomeTypeDetails, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });
        $expenseTypeDetails = array();
        foreach ($expenseTypesInPeriod as $type) {
            $temp = array();
            $amount = DB::table('daybooks')->where('expense_id', $type->expense_id)->whereBetween('date', [$data['startDate'], $data['endDate']])->sum('amount');
            $temp['amount'] = $amount;
            if ($type->expense_id == "staff_salary") {
                $temp['name'] = "SALARY";
            } else if ($type->expense_id == "staff_incentive") {
                $temp['name'] = "INCENTIVE";
            } else if ($type->expense_id == "SALE_RETURN") {
                $temp['name'] = "SALE RETURN PAYMENTS";
            } else if ($type->expense_id == "FOR_SUPPLIER") {
                $temp['name'] = "PURCHASE PAYMENTS";
            } else if ($type->expense_id == "INVESTOR_WITHDRAWAL") {
                $temp['name'] = "INVESTOR WITHDRAWAL";
            } else if ($type->expense_id == "INVEST_BANK") {
                $temp['name'] = "DEPOSITED IN BANK";
            } else {
                $expenseType = DB::table('expenses')->where('id', $type->expense_id)->first();
                $temp['name'] = $expenseType->expense_name;
            }
            array_push($expenseTypeDetails, $temp);
        }
        usort($expenseTypeDetails, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });
        $transferTypeDetails = array();
        foreach ($transferTypesInPeriod as $type) {
            $temp = array();
            $amount = DB::table('daybooks')->where('type', 'Transfer')->where('description', $type->description)->whereBetween('date', [$data['startDate'], $data['endDate']])->sum('amount');
            $temp['amount'] = $amount;
            if ($type->description == "LEDGER TO CASH") {
                $temp['name'] = "LEDGER TO CASH";
            } else if ($type->description == "LEDGER TO ACCOUNT") {
                $temp['name'] = "LEDGER TO ACCOUNT";
            } else if ($type->description == "CASH TO LEDGER") {
                $temp['name'] = "CASH TO LEDGER";
            } else if ($type->description == "CASH TO ACCOUNT") {
                $temp['name'] = "CASH TO ACCOUNT";
            } else if ($type->description == "ACCOUNT TO CASH") {
                $temp['name'] = "ACCOUNT TO CASH";
            } else if ($type->description == "ACCOUNT TO LEDGER") {
                $temp['name'] = "ACCOUNT TO LEDGER";
            }
            array_push($transferTypeDetails, $temp);
        }
        usort($transferTypeDetails, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });
        $totalIncomeBeforePeriod = DB::table('daybooks')->where('date', '<', $data['startDate'])->where('type', 'Income')->sum('amount');
        $totalExpenseBeforePeriod = DB::table('daybooks')->where('date', '<', $data['startDate'])->where('type', 'Expense')->sum('amount');
        $openingBalance = $totalIncomeBeforePeriod - $totalExpenseBeforePeriod;
        $balance = $openingBalance;
        $daybooksInPeriod = DB::table('daybooks')->whereBetween('date', [$data['startDate'], $data['endDate']])->orderby('date', 'asc')->get();
        foreach ($daybooksInPeriod as $daybook) {
            if ($daybook->type == "Expense") {
                $temp = array();
                $temp['date'] = $daybook->date;
                if ($daybook->expense_id == "staff_salary") {
                    $temp['name'] = "Salary";
                } else if ($daybook->expense_id == "staff_incentive") {
                    $temp['name'] = "Incentive";
                } else if ($daybook->expense_id == "SALE_RETURN") {
                    $temp['name'] = strtoupper($daybook->job);
                } else if ($daybook->expense_id == "FOR_SUPPLIER") {
                    $sellerDetails = DB::table('sellers')->where('id', $daybook->job)->first();
                    $temp['name'] = strtoupper($sellerDetails->seller_name);
                } else if ($daybook->expense_id == "INVESTOR_WITHDRAWAL") {
                    $temp['name'] = 'INVESTOR WITHDRAWAL';
                } else if ($daybook->expense_id == "INVEST_BANK") {
                    $temp['name'] = 'DEPOSITED IN BANK';
                } else {
                    $expenseType = DB::table('expenses')->where('id', $daybook->expense_id)->first();
                    $temp['name'] = $expenseType->expense_name;
                }
                $temp['debit'] = $daybook->amount;
                $temp['credit'] = '';
                $temp['description'] = $daybook->description;
                $balance -= $daybook->amount;
                $temp['balance'] = $balance;
                array_push($tableData, $temp);
            }
            if ($daybook->type == "Income") {
                $temp1 = array();
                $temp1['date'] = $daybook->date;
                if ($daybook->income_id == "FROM_INVOICE") {
                    $temp1['name'] = $daybook->job;
                } elseif ($daybook->income_id == "INVESTOR_INVESTMENT") {
                    $temp1['name'] = "INVESTOR INVESTMENT";
                } elseif ($daybook->income_id == "WITHDRAW_BANK") {
                    $temp1['name'] = "WITHDRAW IN BANK";
                } else if ($daybook->income_id == "PURCHASE_RETURN") {
                    $temp1['name'] = $daybook->job;
                } else {
                    $incomeType = DB::table('incomes')->where('id', $daybook->income_id)->first();
                    $temp1['name'] = $incomeType->income_name;
                }
                $temp1['debit'] = '';
                $temp1['credit'] = $daybook->amount;
                $temp1['description'] = $daybook->description;
                $balance += $daybook->amount;
                $temp1['balance'] = $balance;
                array_push($tableData, $temp1);
            }
            if ($daybook->type == "Transfer") {
                $temp1 = array();
                $temp1['date'] = $daybook->date;
                if ($daybook->description == "LEDGER TO CASH") {
                    $temp1['name'] = 'LEDG - CASH';
                } else if ($daybook->description == "LEDGER TO ACCOUNT") {
                    $temp1['name'] = 'LEDG - ACC';
                } elseif ($daybook->description == "CASH TO LEDGER") {
                    $temp1['name'] = 'CASH - LEDG';
                } elseif ($daybook->description == "CASH TO ACCOUNT") {
                    $temp1['name'] = 'CASH - ACC';
                } elseif ($daybook->description == "ACCOUNT TO CASH") {
                    $temp1['name'] = 'ACC - CASH';
                } elseif ($daybook->description == "ACCOUNT TO LEDGER") {
                    $temp1['name'] = 'ACC - LEDG';
                }
                $temp1['debit'] = $daybook->amount;;
                $temp1['credit'] = $daybook->amount;
                $temp1['description'] = $daybook->description;
                $temp1['balance'] = $balance;
                array_push($tableData, $temp1);
            }
        }
        $pdf = Pdf::loadView('daybook.report', compact('startDate', 'endDate', 'totalIncomeInPeriod', 'totalExpenseInPeriod', 'balanceAmountInPeriod', 'incomeTypeDetails', 'expenseTypeDetails', 'transferTypeDetails', 'openingBalance', 'tableData', 'balance'));
        return $pdf->stream($startDate . ' to ' . $endDate . ' - Income Expense Report.pdf', array("Attachment" => false));
    }
    public function date_report(Request $request)
    {
        $report_date = Carbon::parse($request->report_date)->format('Y-m-d');
        $sales = DirectSales::where('sales_date', $report_date)->get();
        $daybook_summary = DaybookSummary::where('date', $report_date)->first();
        if ($daybook_summary == Null) {
            $prev_date_details = DB::table('daybook_summaries')->where('date', '<', $report_date)->orderby('date', 'DESC')->first();
            $prev_date = $prev_date_details->date ?? Carbon::today()->toDateString();
            $prev_closing_balance = DaybookBalance::where('date', $prev_date)->first();
            $cur_closing_balance = DaybookBalance::where('date', $report_date)->first();
            if ($cur_closing_balance == Null) {
                $cur_closing_balance = $prev_closing_balance;
            }
            $get_expense = Daybook::where('date', $report_date)->where('type', 'Expense')->get();
            $get_income = Daybook::where('date', $report_date)->where('type', 'Income')->get();
            $get_transfer = Daybook::where('date', $report_date)->where('type', 'Transfer')->get();
            $total_expense = Daybook::where('date', $report_date)->where('type', 'Expense')->sum('amount');
            $total_income = Daybook::where('date', $report_date)->where('type', 'Income')->sum('amount');
            $daybook_services = DaybookService::where('date', $report_date)->get();

            $status = 'empty';
            return view('daybook.report_date', compact('daybook_services', 'report_date', 'prev_closing_balance', 'cur_closing_balance', 'get_expense', 'get_income', 'get_transfer', 'total_expense', 'total_income', 'status', 'sales'));
        } else {
            $get_expense      = Daybook::where('date', $report_date)->where('type', 'Expense')->get();
            $get_income       = Daybook::where('date', $report_date)->where('type', 'Income')->get();
            $get_transfer     = Daybook::where('date', $report_date)->where('type', 'Transfer')->get();
            $total_expense    = Daybook::where('date', $report_date)->where('type', 'Expense')->sum('amount');
            $total_income     = Daybook::where('date', $report_date)->where('type', 'Income')->sum('amount');
            $daybook_services = DaybookService::where('date', $report_date)->get();

            $status = 'not_empty';
            return view('daybook.report_date', compact('report_date', 'daybook_summary', 'daybook_services', 'get_expense', 'get_income', 'get_transfer', 'total_expense', 'total_income', 'status', 'sales'));
        }
    }
    public function store_daybook_summary(Request $request)
    {
        $latestBalance = DaybookBalance::orderBy('date', 'DESC')->first();

        if ($latestBalance) {
            if (
                $latestBalance->cash_balance != $request->closing_cash ||
                $latestBalance->account_balance != $request->closing_account ||
                $latestBalance->ledger_balance != $request->closing_ledger
            ) {
                return response()->json([
                    'status' => 'mismatch'
                ]);
            }
        }

        $data['date']            = $request->date;
        $data['opening_cash']    = $request->opening_cash;
        $data['opening_account'] = $request->opening_account;
        $data['opening_ledger']  = $request->opening_ledger;
        $data['closing_cash']    = $request->closing_cash;
        $data['closing_account'] = $request->closing_account;
        $data['closing_ledger']  = $request->closing_ledger;
        $data['added_by']        = Auth::user()->name;
        $status = DaybookSummary::create($data);

        $day_blance_date = DaybookBalance::where('date', $request->date)->first();
        if ($day_blance_date == Null) {
            DaybookBalance::insert([
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'ledger_balance' => $request->closing_ledger,
                'account_balance' => $request->closing_account,
                'cash_balance' => $request->closing_cash
            ]);
        }

        if ($status) {
            Toastr::success('Details Added', 'success', ["positionClass" => "toast-bottom-right"]);

            $dateDisplay = Carbon::parse($data['date'])->format('d-m-Y');
            $dateParam   = Carbon::parse($data['date'])->format('Y-m-d');

            $params = urlencode("{$dateDisplay}, hostee.biznx.in/dailyReport/{$dateParam}");

            $user   = urlencode('Techsoul_BW');
            $pass   = urlencode('123456');
            $sender = urlencode('BUZWAP');

            $numbers = '';

            $url = "https://bhashsms.com/api/sendmsgutil.php?user={$user}&pass={$pass}&sender={$sender}&phone={$numbers}&text=dialy_repport&priority=wa&stype=normal&Params={$params}";

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);

            curl_close($ch);

        } else {
            Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('daybook.index');

    }
    public function daybook_daily_report($id)
    {
        $report_date = $id;

        // Fetch necessary data with eager loading
        $daybook_summary = DaybookSummary::where('date', $report_date)->first();
        $daybooks = Daybook::where('date', $report_date)->get()->groupBy('type');
        $daybook_services = DaybookService::where('date', $report_date)->get();

        // Grouped Data
        $get_expense  = $daybooks->get('Expense', collect());
        $get_income   = $daybooks->get('Income', collect());
        $get_transfer = $daybooks->get('Transfer', collect());

        // Totals
        $total_expense = $get_expense->sum('amount');
        $total_income  = $get_income->sum('amount');

        // Sales Data
        $sales = DirectSales::where('sales_date', $report_date)->get();
        $sales_totals = DirectSales::where('sales_date', $report_date)
            ->selectRaw('SUM(grand_total) as total, SUM(discount) as discount')
            ->first();

        $sales_grand_total = round($sales_totals->total - $sales_totals->discount, 2);

        // Sales Balance Calculation
        $total_sales = DirectSales::where('print_status', '<>', 'cancelled')->get();
        $invoice_numbers = $total_sales->pluck('invoice_number')->toArray();

        $total_sales_balance = 0;
        $total_amount = $total_sales->sum('grand_total') - $total_sales->sum('discount');
        $paidAmount   = Daybook::whereIn('job', $invoice_numbers)->where('type', 'Income')->sum('amount');
        $total_sales_balance = round($total_amount - $paidAmount, 2);

        // Supplier Balances
        $supplier_totals = Purchase::selectRaw('SUM(grand_total) as purchase_amount, SUM(discount) as purchase_discount')
            ->first();
        $opening_balance = Seller::sum('seller_opening_balance');
        $paid_amount = Daybook::where('expense_id', 'FOR_SUPPLIER')->sum('amount');
        $purchase_return_total = PurchaseReturn::sum('total');
        $seller_balance = round($opening_balance + ($supplier_totals->purchase_amount - $supplier_totals->purchase_discount) - $purchase_return_total - $paid_amount, 2);

        // Stock Balance
        $stock_balance = DB::table('stocks')
            ->whereNotIn('product_id', [159, 162])
            ->sum(DB::raw('product_unit_price * product_qty'));
        $stock_balance = round($stock_balance, 2);

        // Profit Calculation
        $expense_total = Daybook::where('daybooks.date', $report_date)
            ->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')
            ->where('expenses.expense_category', 'Expense')
            ->sum('daybooks.amount');
        $profit = round($sales_grand_total - $expense_total, 2);

        // Printing details
        $printed_by = Auth::user()->name;
        $printed_on = now();

        $sms = '';

        $pdf = Pdf::loadView('daybook.daily_report', compact(
            'report_date',
            'daybook_summary',
            'daybook_services',
            'get_expense',
            'get_income',
            'get_transfer',
            'total_expense',
            'total_income',
            'sales',
            'sales_grand_total',
            'total_sales_balance',
            'seller_balance',
            'stock_balance',
            'sms',
            'profit',
            'printed_by',
            'printed_on'
        ))->setPaper('a4', 'portrait');
        return $pdf->stream($report_date . ' - Daily Report.pdf', array("Attachment" => false));
    }
    // public function daybook_daily_report($id)
    // {
    //     $report_date       = $id;
    //     $sales_grand_total = 0;
    //     $daybook_summary   = DaybookSummary::where('date',$report_date)->first();
    //     $get_expense       = Daybook::where('date',$report_date)->where('type','Expense')->get();
    //     $get_income        = Daybook::where('date',$report_date)->where('type','Income')->get();
    //     $get_transfer      = Daybook::where('date',$report_date)->where('type','Transfer')->get();
    //     $total_expense     = Daybook::where('date',$report_date)->where('type','Expense')->sum('amount');
    //     $total_income      = Daybook::where('date',$report_date)->where('type','Income')->sum('amount');
    //     $daybook_services  = DaybookService::where('date',$report_date)->get();
    //     $sales             = DirectSales::where('sales_date',$report_date)->get();
    //     $sales_total       = DirectSales::where('sales_date',$report_date)->sum('grand_total');
    //     $discount_total    = DirectSales::where('sales_date',$report_date)->sum('discount');
    //     $sales_grand_total = $sales_total - $discount_total;
    //     $total_sales = DirectSales::where('print_status','<>','cancelled')->get();
    //     $total_sales_balance = 0;
    //     foreach ( $total_sales as $total_sale ){
    //         if ($total_sale->discount){
    //             $amount = ( (float) $total_sale->grand_total) - ((float) $total_sale->discount);
    //         }
    //         else{
    //             $amount = (float) $total_sale->grand_total;
    //         }
    //         $paidAmount = Daybook::where('job',$total_sale->invoice_number)->where('type','Income')->sum('amount');
    //         $balance = $amount - $paidAmount;
    //         $total_sales_balance = round($total_sales_balance + $balance,2);
    //     }
    //     $opening_balance = Seller::sum('seller_opening_balance');
    //     $purchase_amount = Purchase::sum('grand_total');
    //     $purchase_discount = Purchase::sum('discount');
    //     $paid_amount = Daybook::where('expense_id', 'FOR_SUPPLIER')->sum('amount');
    //     $purchase_return_total = PurchaseReturn::sum('total');
    //     $seller_opening_balance = $opening_balance + ($purchase_amount - $purchase_discount) - $purchase_return_total - $paid_amount;
    //     $seller_balance = $seller_opening_balance;
    //     $stock_balance_array = DB::table('stocks')->select(DB::raw('sum(product_unit_price * product_qty) as total'))->whereNotIn('product_id',[159,162])->get();
    //     $stock_balance =  round($stock_balance_array[0]->total,2);
    //     $sms = '';

    //     //profit
    //     $sales_total = DB::table('direct_sales')->where('sales_date',$report_date)->sum('grand_total');
    //     $sales_discount = DB::table('direct_sales')->where('sales_date',$report_date)->sum('discount');
    //     $sales_grand_total = $sales_total - $sales_discount;
    //     $expense = DB::table('daybooks')->join('expenses','daybooks.expense_id','expenses.id')->where('expense_category','Expense')->where('daybooks.date',$report_date)->sum('amount');
    //     $profit = $sales_grand_total - $expense;

    //     //printing details
    //     if(Auth::user()){
    //         $printed_by = Auth::user()->name;
    //     }else{
    //         $printed_by = 'RAMIS ABDUL HAKEEM O';
    //     }
    //     $printed_on = Carbon::now();


    //     // $pdf = Pdf::loadView('daybook.daily_report',compact('report_date','daybook_summary','daybook_services','get_expense','get_income','get_transfer','total_expense','total_income','sales','sales_grand_total','total_sales_balance','seller_balance','stock_balance','sms'))->setPaper('a4', 'portrait');
    //     // return $pdf->stream($report_date.' - Daily Report.pdf',array("Attachment"=>false));
    //     return view('daybook.daily_report',compact('report_date','daybook_summary','daybook_services','get_expense','get_income','get_transfer','total_expense','total_income','sales','sales_grand_total','total_sales_balance','seller_balance','stock_balance','sms'));

    // }

    public function dailyReport($id)
    {
        $report_date = $id;

        // Fetch necessary data with eager loading
        $daybook_summary = DaybookSummary::where('date', $report_date)->first();
        $daybooks = Daybook::where('date', $report_date)->get()->groupBy('type');
        $daybook_services = DaybookService::where('date', $report_date)->get();

        // Grouped Data
        $get_expense  = $daybooks->get('Expense', collect());
        $get_income   = $daybooks->get('Income', collect());
        $get_transfer = $daybooks->get('Transfer', collect());

        // Totals
        $total_expense = $get_expense->sum('amount');
        $total_income  = $get_income->sum('amount');

        // Sales Data
        $sales = DirectSales::where('sales_date', $report_date)->get();
        $sales_totals = DirectSales::where('sales_date', $report_date)
            ->selectRaw('SUM(grand_total) as total, SUM(discount) as discount')
            ->first();

        $sales_grand_total = round($sales_totals->total - $sales_totals->discount, 2);

        // Sales Balance Calculation
        $total_sales = DirectSales::where('print_status', '<>', 'cancelled')->get();
        $invoice_numbers = $total_sales->pluck('invoice_number')->toArray();

        $total_sales_balance = 0;
        $total_amount = $total_sales->sum('grand_total') - $total_sales->sum('discount');
        $paidAmount   = Daybook::whereIn('job', $invoice_numbers)->where('type', 'Income')->sum('amount');
        $total_sales_balance = round($total_amount - $paidAmount, 2);

        // Supplier Balances
        $supplier_totals = Purchase::selectRaw('SUM(grand_total) as purchase_amount, SUM(discount) as purchase_discount')
            ->first();
        $opening_balance = Seller::sum('seller_opening_balance');
        $paid_amount = Daybook::where('expense_id', 'FOR_SUPPLIER')->sum('amount');
        $purchase_return_total = PurchaseReturn::sum('total');
        $seller_balance = round($opening_balance + ($supplier_totals->purchase_amount - $supplier_totals->purchase_discount) - $purchase_return_total - $paid_amount, 2);

        // Stock Balance
        $stock_balance = DB::table('stocks')
            ->whereNotIn('product_id', [159, 162])
            ->sum(DB::raw('product_unit_price * product_qty'));
        $stock_balance = round($stock_balance, 2);

        $sms = 'yes';
        $today = Carbon::createFromFormat('Y-m-d', $report_date);
        $previousMonthStart = $today->copy()->subMonth()->startOfMonth()->toDateString();
        $previousMonthEnd = $today->copy()->subMonth()->endOfMonth()->toDateString();
        $previousMonth  = $today->copy()->subMonth();
        $currentMonthStart = $today->copy()->startOfMonth()->toDateString();
        $currentMonthStartDate = $today->copy()->startOfMonth();
        $currentMonthEnd = $today->format('Y-m-d');
        $startOfWeek = $today->copy()->startOfWeek()->toDateString();
        $startOfWeekDate = $today->copy()->startOfWeek();
        $endOfWeek = $today->format('Y-m-d');

        $previousMonthSales = DirectSales::whereBetween('sales_date', [$previousMonthStart, $previousMonthEnd])->get();
        $previousMonthSaleItemProductAmount = 0;
        foreach ($previousMonthSales as $previousMonthSale) {
            $previousMonthSaleItems = SalesItems::where('sales_id', $previousMonthSale->id)->get();
            foreach ($previousMonthSaleItems as $previousMonthSaleItem) {
                if ($previousMonthSaleItem->product_id == '159') {
                    if ($previousMonthSale->invoice_number == null) {
                        $previousMonthSaleItemProductAmount += 0;
                    } else {
                        $previousMonthConsignment = DB::table('consignments')->where('invoice_no', $previousMonthSale->invoice_number)->first();
                        if (!empty($previousMonthConsignment)) {
                            $previousMonthChiplevel = DB::table('chiplevels')->where('jobcard_id', $previousMonthConsignment->id)->first();
                            if ($previousMonthChiplevel) {
                                if ($previousMonthChiplevel->service_charge) {
                                    $previousMonthSaleItemProductAmount += $previousMonthChiplevel->service_charge;
                                } else {
                                    $previousMonthSaleItemProductAmount += 0;
                                }
                            } else {

                                $previousMonthSaleItemProductAmount += 0;
                            }
                        } else {
                            $previousMonthSaleItemProductAmount += 0;
                        }
                    }
                } else {
                    $productUnitPrice = stock::where('product_id', $previousMonthSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $previousMonthSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $previousMonthSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $previousMonthSalesGrandTotal   = DirectSales::whereBetween('sales_date', [$previousMonthStart, $previousMonthEnd])->sum('grand_total');
        $previousMonthSalesDiscount     = DirectSales::whereBetween('sales_date', [$previousMonthStart, $previousMonthEnd])->sum('discount');
        $previousMonthSalesTotal        = $previousMonthSalesGrandTotal - $previousMonthSalesDiscount;
        $previousMonthSalesTotalProfit  = $previousMonthSalesTotal - $previousMonthSaleItemProductAmount;

        $currentMonthSales = DirectSales::whereBetween('sales_date', [$currentMonthStart, $currentMonthEnd])->get();
        $currentMonthSaleItemProductAmount = 0;
        foreach ($currentMonthSales as $currentMonthSale) {
            $currentMonthSaleItems = SalesItems::where('sales_id', $currentMonthSale->id)->get();
            foreach ($currentMonthSaleItems as $currentMonthSaleItem) {
                if ($currentMonthSaleItem->product_id == '159') {
                    if ($currentMonthSale->invoice_number == null) {
                        $currentMonthSaleItemProductAmount += 0;
                    } else {
                        $currentMonthConsignment = DB::table('consignments')->where('invoice_no', $currentMonthSale->invoice_number)->first();
                        if (!empty($currentMonthConsignment)) {
                            $currentMonthChiplevel = DB::table('chiplevels')->where('jobcard_id', $currentMonthConsignment->id)->first();
                            if ($currentMonthChiplevel) {
                                if ($currentMonthChiplevel->service_charge) {
                                    $currentMonthSaleItemProductAmount += $currentMonthChiplevel->service_charge;
                                } else {
                                    $currentMonthSaleItemProductAmount += 0;
                                }
                            } else {

                                $currentMonthSaleItemProductAmount += 0;
                            }
                        } else {
                            $currentMonthSaleItemProductAmount += 0;
                        }
                    }
                } else {
                    $productUnitPrice = stock::where('product_id', $currentMonthSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $currentMonthSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $currentMonthSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $currentMonthSalesGrandTotal = DirectSales::whereBetween('sales_date', [$currentMonthStart, $currentMonthEnd])->sum('grand_total');
        $currentMonthSalesDiscount = DirectSales::whereBetween('sales_date', [$currentMonthStart, $currentMonthEnd])->sum('discount');
        $currentMonthSalesTotal = $currentMonthSalesGrandTotal - $currentMonthSalesDiscount;
        $currentMonthSalesTotalProfit = $currentMonthSalesTotal - $currentMonthSaleItemProductAmount;

        // Sales for the Current Week
        $weekSales = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->get();
        $weekSaleItemProductAmount = 0;
        foreach ($weekSales as $weekSale) {
            $weekSaleItems = SalesItems::where('sales_id', $weekSale->id)->get();
            foreach ($weekSaleItems as $weekSaleItem) {
                if ($weekSaleItem->product_id == '159') {
                    if ($weekSale->invoice_number == null) {
                        $weekSaleItemProductAmount += 0;
                    } else {
                        $weekConsignment = DB::table('consignments')->where('invoice_no', $weekSale->invoice_number)->first();
                        if (!empty($weekConsignment)) {
                            $weekChiplevel = DB::table('chiplevels')->where('jobcard_id', $weekConsignment->id)->first();
                            if ($weekChiplevel) {
                                if ($weekChiplevel->service_charge) {
                                    $weekSaleItemProductAmount += $weekChiplevel->service_charge;
                                } else {
                                    $weekSaleItemProductAmount += 0;
                                }
                            } else {

                                $weekSaleItemProductAmount += 0;
                            }
                        } else {
                            $weekSaleItemProductAmount += 0;
                        }
                    }
                } else {
                    $productUnitPrice = stock::where('product_id', $weekSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $weekSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $weekSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $weekSalesGrandTotal = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->sum('grand_total');
        $weekSalesDiscount = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->sum('discount');
        $weekSalesTotal = $weekSalesGrandTotal - $weekSalesDiscount;
        $weekSalesTotalProfit = $weekSalesTotal - $weekSaleItemProductAmount;

        $todaySales = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->get();
        $todaySaleItemProductAmount = 0;
        foreach ($todaySales as $todaySale) {
            $todaySaleItems = SalesItems::where('sales_id', $todaySale->id)->get();
            foreach ($todaySaleItems as $todaySaleItem) {
                if ($todaySaleItem->product_id == '159') {
                    if ($todaySale->invoice_number == null) {
                        $todaySaleItemProductAmount += 0;
                    } else {
                        $todayConsignment = DB::table('consignments')->where('invoice_no', $todaySale->invoice_number)->first();
                        if (!empty($todayConsignment)) {
                            $todayChiplevel = DB::table('chiplevels')->where('jobcard_id', $todayConsignment->id)->first();
                            if ($todayChiplevel) {
                                if ($todayChiplevel->service_charge) {
                                    $todaySaleItemProductAmount += $todayChiplevel->service_charge;
                                } else {
                                    $todaySaleItemProductAmount += 0;
                                }
                            } else {

                                $todaySaleItemProductAmount += 0;
                            }
                        } else {
                            $todaySaleItemProductAmount += 0;
                        }
                    }
                } else {
                    $productUnitPrice = stock::where('product_id', $todaySaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $todaySaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $todaySaleItemProductAmount += 0;
                    }
                }
            }
        }
        $todaySalesGrandTotal = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->sum('grand_total');
        $todaySalesDiscount = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->sum('discount');
        $todaySalesTotal = $todaySalesGrandTotal - $todaySalesDiscount;
        $todaySalesTotalProfit = $todaySalesTotal - $todaySaleItemProductAmount;

        // Profit Calculation
        $expense_total = Daybook::where('daybooks.date', $report_date)
            ->join('expenses', 'daybooks.expense_id', '=', 'expenses.id')
            ->where('expenses.expense_category', 'Expense')
            ->sum('daybooks.amount');
        $profit = round($sales_grand_total - $expense_total, 2);

        //printing details
        if (Auth::user()) {
            $printed_by = Auth::user()->name;
        } else {
            $printed_by = 'ADMIN';
        }
        $printed_on = Carbon::now();

        return view('daybook.daily_report', compact(
            'report_date',
            'daybook_summary',
            'daybook_services',
            'get_expense',
            'get_income',
            'get_transfer',
            'total_expense',
            'total_income',
            'sales',
            'sales_grand_total',
            'total_sales_balance',
            'seller_balance',
            'stock_balance',
            'sms',
            'previousMonth',
            'previousMonthSalesTotal',
            'previousMonthSalesTotalProfit',
            'currentMonthStartDate',
            'currentMonthSalesTotal',
            'currentMonthSalesTotalProfit',
            'startOfWeekDate',
            'weekSalesTotal',
            'weekSalesTotalProfit',
            'today',
            'todaySalesTotal',
            'todaySalesTotalProfit',
            'profit',
            'printed_by',
            'printed_on'
        ));
    }

    public function getDaybookValues(Request $request)
    {
        $type = $request->type;
        if ($type == "Income") {
            $incomes = DB::table('daybooks')->where('type', 'Income')->distinct()->pluck('income_id');
            $incomeArray = array();
            foreach ($incomes as $income) {
                $temp = array();
                $incomeCategory = DB::table('incomes')->where('id', $income)->first();
                if ($incomeCategory) {
                    $temp['id'] = $incomeCategory->id;
                    $temp['name'] = $incomeCategory->income_name;
                    array_push($incomeArray, $temp);
                }
                if ($income == "FROM_INVOICE") {
                    $temp['id'] = "FROM_INVOICE";
                    $temp['name'] = "FROM INVOICE";
                    array_push($incomeArray, $temp);
                }
            }
            return $incomeArray;
        }
        if ($type == "Expense") {
            $expenses = DB::table('daybooks')->where('type', 'Expense')->distinct()->pluck('expense_id');
            $expenseArray = array();
            foreach ($expenses as $expense) {
                $temp = array();
                $expenseCategory = DB::table('expenses')->where('id', $expense)->first();
                if ($expenseCategory) {
                    $temp['id'] = $expenseCategory->id;
                    $temp['name'] = $expenseCategory->expense_name;
                    array_push($expenseArray, $temp);
                }
                if ($expense == "FOR_SUPPLIER") {
                    $temp['id'] = "FOR_SUPPLIER";
                    $temp['name'] = "FOR SUPPLIER";
                    array_push($expenseArray, $temp);
                }
                if ($expense == "staff_salary") {
                    $temp['id'] = "staff_salary";
                    $temp['name'] = "STAFF SALARY";
                    array_push($expenseArray, $temp);
                }
                if ($expense == "staff_incentive") {
                    $temp['id'] = "staff_incentive";
                    $temp['name'] = "STAFF INCENTIVE";
                    array_push($expenseArray, $temp);
                }
            }
            return $expenseArray;
        }
    }

    public function daybookSearch(Request $request)
    {
        $type = $request->search_type;
        $value = $request->search_value;
        $sort_type = $request->sort_type;
        $expense_name = '';
        if ($type == "Income") {
            $keyVar = 'income_id';
            $total = '';
            $start_date = '';
            $end_date = '';

            $daybook = Daybook::where('type', $type)->where($keyVar, $value)->orderBy('date', 'DESC')->get();

            foreach ($daybook as $entry) {
                if (!$entry) {
                    continue;
                }

                if ($entry->type == "Expense") {
                    switch ($entry->expense_id) {
                        case 'staff_salary':
                            $entry->edit_status = 'no';
                            $entry->expense_name = 'Staff Salary <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                            break;
                        case 'staff_incentive':
                            $entry->edit_status = 'no';
                            $entry->expense_name = 'Incentive <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                            break;
                        case 'SALE_RETURN':
                            $entry->edit_status = 'no';
                            $entry->expense_name = $entry->job ? 'FOR INVOICE #' . $entry->job : 'FOR INVOICE';
                            break;
                        case 'FOR_SUPPLIER':
                            $entry->edit_status = 'no';
                            $entry->expense_name = 'FOR SUPPLIER - <br> ' . $entry->sellers_detail->seller_name;
                            break;
                        default:
                            $entry->edit_status = 'yes';
                            $entry->expense_name = $entry->expenses_detail->expense_name;
                    }
                }

                if ($entry->type == "Income") {
                    switch ($entry->income_id) {
                        case 'FROM_INVOICE':
                            $entry->edit_status = 'no';
                            $entry->expense_name = 'FROM INVOICE <br> #' . $entry->job;
                            $entry->description = $entry->sales_detail->customer_detail->name;
                            break;
                        case 'PURCHASE_RETURN':
                            $entry->edit_status = 'no';
                            $entry->expense_name = 'FOR SUPPLIER <br> #' . $entry->job;
                            break;
                        case 'add_income':
                            $entry->edit_status = 'yes';
                            $entry->expense_name = 'Income';
                            break;
                        default:
                            $entry->edit_status = 'yes';
                            $entry->expense_name = $entry->incomes_detail->income_name;
                    }
                }

                if ($entry->type == "Transfer") {
                    $entry->edit_status = 'no';
                }
                $entry->today = Carbon::now()->format('Y-m-d');
            }
            $incomes = Income::get();
            $expenses = Expense::get();

            return view('daybook.index', compact('daybook', 'total', 'start_date', 'end_date', 'incomes', 'expenses', 'expense_name'));
        } else if ($type == "Expense") {
            if ($sort_type == 'all') {
                $keyVar = 'expense_id';
                $start_date = '';
                $end_date = '';
                $expense = Expense::where('id', $value)->first();
                if ($expense) {
                    $expense_name = $expense->expense_name;
                } else {
                    $expense_name = $value;
                }
                $total = Daybook::where('expense_id', $value)->sum('amount');
                $daybook = Daybook::where('type', $type)->where($keyVar, $value)->orderBy('date', 'DESC')->get();
                foreach ($daybook as $entry) {
                    if (!$entry) {
                        continue;
                    }

                    if ($entry->type == "Expense") {
                        switch ($entry->expense_id) {
                            case 'staff_salary':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'Staff Salary <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                                break;
                            case 'staff_incentive':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'Incentive <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                                break;
                            case 'SALE_RETURN':
                                $entry->edit_status = 'no';
                                $entry->expense_name = $entry->job ? 'FOR INVOICE #' . $entry->job : 'FOR INVOICE';
                                break;
                            case 'FOR_SUPPLIER':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FOR SUPPLIER - <br> ' . $entry->sellers_detail->seller_name;
                                break;
                            default:
                                $entry->edit_status = 'yes';
                                $entry->expense_name = $entry->expenses_detail->expense_name;
                        }
                    }

                    if ($entry->type == "Income") {
                        switch ($entry->income_id) {
                            case 'FROM_INVOICE':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FROM INVOICE <br> #' . $entry->job;
                                $entry->description = $entry->sales_detail->customer_detail->name;
                                break;
                            case 'PURCHASE_RETURN':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FOR SUPPLIER <br> #' . $entry->job;
                                break;
                            case 'add_income':
                                $entry->edit_status = 'yes';
                                $entry->expense_name = 'Income';
                                break;
                            default:
                                $entry->edit_status = 'yes';
                                $entry->expense_name = $entry->incomes_detail->income_name;
                        }
                    }

                    if ($entry->type == "Transfer") {
                        $entry->edit_status = 'no';
                    }
                    $entry->today = Carbon::now()->format('Y-m-d');
                }
                $incomes = Income::get();
                $expenses = Expense::get();

                return view('daybook.index', compact('daybook', 'total', 'start_date', 'end_date', 'incomes', 'expenses', 'expense_name'));
            } elseif ($sort_type == 'datewise') {
                $keyVar = 'expense_id';
                $start_date = $request->sort_start;
                $end_date = $request->sort_end;
                $expense = Expense::where('id', $value)->first();
                if ($expense) {
                    $expense_name = $expense->expense_name;
                } else {
                    $expense_name = $value;
                }
                $daybook = Daybook::where('type', $type)->where($keyVar, $value)->whereBetween('date', [$start_date, $end_date])->orderBy('date', 'DESC')->get();
                $total = Daybook::where('expense_id', $value)->whereBetween('date', [$start_date, $end_date])->sum('amount');

                foreach ($daybook as $entry) {
                    if (!$entry) {
                        continue;
                    }

                    if ($entry->type == "Expense") {
                        switch ($entry->expense_id) {
                            case 'staff_salary':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'Staff Salary <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                                break;
                            case 'staff_incentive':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'Incentive <br> [ Staff: ' . $entry->staffs_detail->staff_name . ' ]';
                                break;
                            case 'SALE_RETURN':
                                $entry->edit_status = 'no';
                                $entry->expense_name = $entry->job ? 'FOR INVOICE #' . $entry->job : 'FOR INVOICE';
                                break;
                            case 'FOR_SUPPLIER':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FOR SUPPLIER - <br> ' . $entry->sellers_detail->seller_name;
                                break;
                            default:
                                $entry->edit_status = 'yes';
                                $entry->expense_name = $entry->expenses_detail->expense_name;
                        }
                    }

                    if ($entry->type == "Income") {
                        switch ($entry->income_id) {
                            case 'FROM_INVOICE':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FROM INVOICE <br> #' . $entry->job;
                                $entry->description = $entry->sales_detail->customer_detail->name;
                                break;
                            case 'PURCHASE_RETURN':
                                $entry->edit_status = 'no';
                                $entry->expense_name = 'FOR SUPPLIER <br> #' . $entry->job;
                                break;
                            case 'add_income':
                                $entry->edit_status = 'yes';
                                $entry->expense_name = 'Income';
                                break;
                            default:
                                $entry->edit_status = 'yes';
                                $entry->expense_name = $entry->incomes_detail->income_name;
                        }
                    }

                    if ($entry->type == "Transfer") {
                        $entry->edit_status = 'no';
                    }
                    $entry->today = Carbon::now()->format('Y-m-d');
                }
                $incomes = Income::get();
                $expenses = Expense::get();

                return view('daybook.index', compact('daybook', 'total', 'start_date', 'end_date', 'incomes', 'expenses', 'expense_name'));
            }
        } else {
            $daybook = Daybook::orderBy('date', 'DESC')->get();
            return view('daybook.index', compact('daybook'));
        }
    }
    function view_personal()
    {
        $daybooks = '';
        return view('daybook.personal_index', compact('daybooks'));
    }
    function search_personal(Request $request)
    {
        $person = $request->search_value;
        if ($person == 'ramis') {
            $daybooks = DB::table('daybooks')->where('expense_id', 9)->orWhere('income_id', 6)->orwhere('staff', 10)->orderby('date', 'desc')->get();
        } elseif ($person == 'hashim') {
            $daybooks = DB::table('daybooks')->where('expense_id', 16)->orWhere('income_id', 7)->orwhere('staff', 7)->orderby('date', 'desc')->get();
        } elseif ($person == 'haseeb') {
            $daybooks = DB::table('daybooks')->where('expense_id', 17)->orwhere('staff', 8)->orderby('date', 'desc')->get();
        } elseif ($person == 'akhilesh') {
            $daybooks = DB::table('daybooks')->where('staff', 16)->orderby('date', 'desc')->get();
        } elseif ($person == 'fawaz') {
            $daybooks = DB::table('daybooks')->where('expense_id', 40)->orwhere('staff', 11)->orderby('date', 'desc')->get();
        } elseif ($person == 'fahanas') {
            $daybooks = DB::table('daybooks')->where('staff', 12)->orderby('date', 'desc')->get();
        }
        return view('daybook.personal_index', compact('daybooks'));
    }

    function get_item_total(Request $request)
    {
        $expense = $request->expense;
        $sort_type = $request->sort_type;
        if ($sort_type == 'all') {
            $total = DB::table('daybooks')->where('expense_id', $expense)->sum('amount');
        } elseif ($sort_type == 'datewise') {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $total = DB::table('daybooks')->where('expense_id', $expense)->whereBetween('date', [$start_date, $end_date])->sum('amount');
        }
        return response()->json($total);
    }
    public function addSalesReturnInvoicePayment(Request $request)
    {

        $this->validate($request, [
            'accounts' => 'required',
            'amount' => 'required|gt:0'
        ]);
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date)->format('Y-m-d');
        $salesDetails = DB::table('sales_returns')->where('invoice_number', $request->job)->first();
        $directSalesDetails = DB::table('direct_sales')->where('id', $salesDetails->sale_id)->first();
        $paid_amount = Daybook::where('job', $request->job)->sum('amount');
        $total_amount = $paid_amount +  $request->amount;
        $grand_total = $salesDetails->total;
        if ($grand_total > $total_amount) {
            $sale_data['payment_status'] = 'partial';
        } elseif ($grand_total == $total_amount) {
            $sale_data['payment_status'] = 'paid';
        }
        $paymentStatus = Daybook::create($data);
        if ($paymentStatus) {
            $saleStatus = DB::table('sales_returns')->where('id', $salesDetails->id)->update($sale_data);
            $balanceCount = DB::table('daybook_balances')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->count();
            if ($balanceCount == 0) {
                $lastRow = DB::table('daybook_balances')->latest('id')->first();
                $copyRow = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
            }

            $latestBalance = DB::table('daybook_balances')->latest('id')->first();
            $customer = DB::table('customers')->where('id', $directSalesDetails->customer_id)->first();
            $currentBalance = $customer->balance;
            $amount = $data['amount'];
            $newBalance = $currentBalance - $amount;
            $newBalance = round($newBalance, 2);
            $updateCustomerBalance = DB::table('customers')->where('id', $directSalesDetails->customer_id)->update(['balance' => $newBalance]);
            if ($updateCustomerBalance) {
                if ($data['accounts'] == "CASH") {
                    $accountsForSMS = "CASH";
                    $newCashBalance = $latestBalance->cash_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                }
                if ($data['accounts'] == "ACCOUNT") {
                    $accountsForSMS = "BANK";
                    $newAccountBalance = $latestBalance->account_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                }
                if ($data['accounts'] == "LEDGER") {
                    $accountsForSMS = "CASH";
                    $newLedgerBalance = $latestBalance->ledger_balance - $data['amount'];
                    $addBalance = DB::table('daybook_balances')->where('id', $latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
                }
                Toastr::success('Expense Added', 'success', ["positionClass" => "toast-bottom-right"]);

                return redirect()->back();
            }
        } else {
            Toastr::success('Error occurred', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
}
