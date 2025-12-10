<?php

namespace App\Http\Controllers;

use App\Exports\CreditCustomerExport;
use App\Models\Consoulidate;
use App\Models\Customer;
use App\Models\Daybook;
use App\Models\DirectSales;
use App\Models\SalesReturn;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::with([
            'directSales' => function ($query) {
                $query->whereNotIn('payment_status', ['paid', 'cancelled'])
                    ->orderBy('id', 'ASC');
            }
        ])->get();

        $now = Carbon::now();
        $customerIds = $customers->pluck('id');

        // fetch sales balances
        $salesData = DirectSales::whereIn('customer_id', $customerIds)
            ->selectRaw('customer_id, SUM(grand_total) as total_sales_amount, SUM(discount) as total_sales_discount')
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');

        // fetch paid amounts
        $paidAmounts = Daybook::join('direct_sales', 'daybooks.job', '=', 'direct_sales.invoice_number')
            ->whereIn('direct_sales.customer_id', $customerIds)
            ->where('daybooks.type', 'Income')
            ->selectRaw('direct_sales.customer_id, SUM(daybooks.amount) as paid_amount')
            ->groupBy('direct_sales.customer_id')
            ->get()
            ->keyBy('customer_id');

        // fetch sales return amounts
        $salesReturns = SalesReturn::join('direct_sales', 'sales_returns.sale_id', '=', 'direct_sales.id')
            ->whereIn('direct_sales.customer_id', $customerIds)
            ->where('sales_returns.payment_status', 'not paid')
            ->selectRaw('direct_sales.customer_id, SUM(total) as sales_return_amount')
            ->groupBy('direct_sales.customer_id')
            ->get()
            ->keyBy('customer_id');

        foreach ($customers as $customer) {
            $not_paid_sales = $customer->directSales->first();
            $pending_days = $not_paid_sales ? $now->diffInDays(Carbon::parse($not_paid_sales->sales_date)) : 0;

            $total_sales_amount = $salesData[$customer->id]->total_sales_amount ?? 0;
            $total_sales_discount = $salesData[$customer->id]->total_sales_discount ?? 0;
            $paid_amount = $paidAmounts[$customer->id]->paid_amount ?? 0;
            $sales_return_amount = $salesReturns[$customer->id]->sales_return_amount ?? 0;

            $sales_balance = round(($total_sales_amount - $total_sales_discount - $paid_amount - $sales_return_amount), 2);

            $customer->sales_balance = $sales_balance;
            $customer->pending_days = $pending_days;
        }

        if ($request->has('send')) {
            $sendId = $request->get('send');
            $customer = $customers->where('id', $sendId)->first();

            if ($customer && $customer->sales_balance > 0 && strlen($customer->mobile) == 10) {
                $phone = $customer->mobile;
                $param1 = urlencode($customer->name);
                $param2 = urlencode($customer->sales_balance);
                $param3 = urlencode($customer->pending_days);

                $url = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=$phone&text=payment_reminder&priority=wa&stype=normal&Params=$param1,$param2,$param3";

                // dd([
                //     'url' => $url
                // ]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                // \Log::info("Bhash WA sent to {$customer->mobile} | Response: $response");

                Toastr::success("WhatsApp reminder sent to {$customer->name}", 'Success', ["positionClass" => "toast-bottom-right"]);
            } else {
                Toastr::error('Invalid mobile number or no pending balance', 'Error', ["positionClass" => "toast-bottom-right"]);
            }

            return redirect()->route('customers.index');
        }

        return view('customers.index',compact('customers'));
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
        $this->validate($request, [
            'name'=> 'required',
            'mobile'=> 'required|digits:10',
        ]);
        $data = $request->all();
        $data['generated_by']          = Auth::user()->name;
        $data['add_date']              = Carbon::now();
        $createCustomer = Customer::create($data);

        if($createCustomer){
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
        $data = $request->all();
        $this->validate($request, [
            'name'=> 'required',
            'mobile'=> 'required|digits:10',
        ]);
        $customer = Customer::findOrFail($id);

        $status = $customer->fill($data)->save();

        if($status){
            Toastr::success("Details Edited Successfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
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
        //
    }

    public function addNewCustomer(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name'=> 'required',
            'mobile'=> 'required|digits:10',
        ]);
        $data['generated_by']          = Auth::user()->name;
        $data['add_date']              = Carbon::now();
        $status = Customer::create($data);

        if($status)
        {
            $customerDetails = DB::table('customers')->latest('id')->first();
        }
        else
        {
            $customerDetails = "Error";
        }
        return response()->json($customerDetails);
    }
    public function getCustomerSales(Request $request, $id) {
        $sales = DB::table('direct_sales')->where('customer_id', $id)->orderBy('sales_date','DESC')->get();
        $sales_returns = SalesReturn::whereIn('sale_id', $sales->pluck('id')->toArray())->orderBy('return_date', 'DESC') ->get();
        // $jobcard_sales = DB::table('consignments')->select(DB::raw('DISTINCT(consignments.id)'))->join('sales','consignments.id','=','sales.job_card_id')->where('consignments.customer_name', $id)->get();
        foreach($sales as $sale){
            if ($sale->discount){
                $amount = round((float) $sale->grand_total,2) - round((float) $sale->discount,2);
            }else{
                $amount = round((float) $sale->grand_total,2);
            }
            $paidAmount = Daybook::where('job',$sale->invoice_number)->where('type','Income')->sum('amount');
            $paidAmount = round($paidAmount,2);
            $balance    = round($amount - $paidAmount,2);

            if($sale->payment_status != 'paid' && $sale->payment_status != 'cancelled'){
                $now = Carbon::now();
                $sales_date = Carbon::parse($sale->sales_date);
                $pending_days = $now->diffInDays($sales_date);
            }
            else{
                $pending_days = 0;
            }

            $customer = DB::table('customers')->where('id',$sale->customer_id)->first();
            $date = Carbon::parse($sale->sales_date)->format('d-m-Y');

            $pay_balance = ((float)$sale->grand_total) - ((float)$sale->discount) - ((float)$paidAmount);

            $sale->mobile_no    = $customer->mobile;
            $sale->pay_balance  = round($pay_balance,2);
            $sale->amount       = $amount;
            $sale->paidAmount   = $paidAmount;
            $sale->pending_days = $pending_days;
            // $sale->message      = $message;
            $sale->balance      = round($balance,2);
            $sale->consolidate_bill = Consoulidate::where('sales_id', $sale->id)->first();
        }

        // single_payment
        $complete_credit_sales = DirectSales::where('customer_id',$id)->where('payment_status','<>','paid')->get();
        $total_balance = 0;
        foreach ( $complete_credit_sales as $credit_sales){
            $single_total = ( $credit_sales->grand_total )-($credit_sales->discount);
            $paid_amount = Daybook::where('job',$credit_sales->invoice_number)->where('type','Income')->sum('amount');
            $single_balance = $single_total - $paid_amount;
            $total_balance = $total_balance + $single_balance;
        }
        foreach ( $sales_returns as $sales_return ){
            $sales_return_paidAmount = DB::table('daybooks')->where('job',$sales_return->id)->where('type','Expense')->sum('amount');
            $balance_sales_return = $sales_return->total - $sales_return_paidAmount;
            $payment_sales_return_balance = ((float)$sales_return->total) - ((float)$sales_return_paidAmount);

            $sales_return->sales_return_paidAmount              = $sales_return_paidAmount;
            $sales_return->balance_sales_return                 = $balance_sales_return;
            $sales_return->payment_sales_return_balance         = $payment_sales_return_balance;
        }

        return view('customers.salesIndex',compact('sales','id','sales_returns','total_balance'));
    }
    public function show_jobcard_sales($id)
    {
        $salesItems = DB::table('sales')->where('job_card_id',$id)->get();
        return view('direct_sales.sales_show', compact('salesItems'));
    }
    public function view_credit_list(Request $request)
    {
        $customers= DB::table('customers')->where('balance','>','0')->get();
        $now = Carbon::now();

        foreach($customers as $customer){
            $not_paid_sales = DirectSales::where('customer_id', $customer->id)->whereNotIn('payment_status', ['paid', 'cancelled'])->orderBy('id', 'ASC')->first();
            if ($not_paid_sales) {
                $sales_date   = Carbon::parse($not_paid_sales->sales_date);
                $pending_days = $now->diffInDays($sales_date);
            } else {
                $pending_days = 0;
            }

            //calculate sales balance
            // $total_sales_amount   = DirectSales::where('customer_id', $customer->id)->sum('grand_total');
            // $total_sales_discount = DirectSales::where('customer_id', $customer->id)->sum('discount');
            // $paid_amount = Daybook::join('direct_sales','daybooks.job','direct_sales.invoice_number')->where('direct_sales.customer_id', $customer->id)->where('daybooks.type', 'Income')->sum('daybooks.amount');
            // $sales_return_amount = SalesReturn::join('direct_sales','sales_returns.sale_id','direct_sales.id')->where('sales_returns.payment_status', 'not paid')->sum('total');
            // $sales_balance = round((float) $total_sales_amount,2) - round((float) $total_sales_discount,2) - round((float) $paid_amount,2) - round((float) $sales_return_amount,2);

            $total_sales_amount   = DirectSales::where('customer_id', $customer->id)->sum('grand_total');
            $total_sales_discount = DirectSales::where('customer_id', $customer->id)->sum('discount');
            $paid_amount = Daybook::join('direct_sales','daybooks.job','direct_sales.invoice_number')->where('direct_sales.customer_id', $customer->id)->where('daybooks.type', 'Income')->sum('daybooks.amount');
            $sales_return_amount = SalesReturn::join('direct_sales','sales_returns.sale_id','direct_sales.id')->where('direct_sales.customer_id', $customer->id)->where('sales_returns.payment_status', 'not paid')->sum('sales_returns.total');
            $sales_balance = round($total_sales_amount, 2) - round($total_sales_discount, 2) - round($paid_amount, 2) - round($sales_return_amount, 2);

            $customer->sales_balance = $sales_balance;
            $customer->pending_days  = $pending_days;
        }

        if ($request->has('send')) {
            $sendId = $request->get('send');
            $customer = $customers->where('id', $sendId)->first();

            if ($customer && $customer->sales_balance > 0 && strlen($customer->mobile) == 10) {

                $phone = $customer->mobile;

                $firstName = explode(' ', trim($customer->name))[0];
                $param1 = urlencode($firstName);
                $param2 = urlencode($customer->sales_balance);
                $param3 = urlencode($customer->pending_days);

                $url = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=$phone&text=payment_reminder&priority=wa&stype=normal&Params=$param1,$param2,$param3";

                // dd([
                //     'url' => $url
                // ]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                // \Log::info("Bhash WA sent to {$customer->mobile} | Response: $response");

                Toastr::success("WhatsApp reminder sent to {$customer->name}", 'Success', ["positionClass" => "toast-bottom-right"]);
            } else {
                Toastr::error('Invalid mobile number or no pending balance', 'Error', ["positionClass" => "toast-bottom-right"]);
            }

            return redirect()->route('customers.credit_list');
        }

        return view('customers.credit_customers',compact('customers'));
    }
    public function view_credit_sales($id)
    {
        $sales = DirectSales::where('customer_id', $id)->orderBy('sales_date','DESC')->get();
        $now = Carbon::now();
        foreach($sales as $sale){
            $sale->sales_date = Carbon::parse($sale->sales_date)->format('d-m-Y');
            if ($sale->discount){
                $amount = ( (float) $sale->grand_total) - ((float) $sale->discount);
            } else {
                $amount = (float) $sale-> grand_total;
            }
            $paidAmount = Daybook::where('job',$sale->invoice_number)->where('type','Income')->sum('amount');
            $balance = $amount - $paidAmount;

            if($sale->payment_status != 'paid' && $sale->payment_status != 'cancelled'){
                $sales_date = Carbon::parse($sale->sales_date);
                $pending_days = $now->diffInDays($sales_date);
            }
            else{
                $pending_days = 0;
            }

            $customerName = $sale->customer_detail->name;
            $firstName = explode(' ', trim($customerName))[0];

            $param1 = urlencode($firstName);
            $param2 = urlencode($balance);
            $param3 = urlencode($pending_days);
            $phone = $sale->customer_detail->mobile;

            $message_url = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=91$phone&text=payment_reminder&priority=wa&stype=normal&Params=$param1,$param2,$param3";

            $sale->message_url = $message_url;

            $pay_balance = ((float)$sale->grand_total) - ((float)$sale->discount) - ((float)$paidAmount);

            $sale->sales_amount     = $amount;
            $sale->paidAmount       = $paidAmount;
            $sale->balance          = round($balance,2);
            $sale->pending_days     = $pending_days;
            $sale->pay_balance      = $pay_balance;
            $sale->consolidate_bill = Consoulidate::where('sales_id', $sale->id)->first();
        }

        // single_payment
        $complete_credit_sales = DirectSales::where('customer_id',$id)->where('payment_status','<>','paid')->get();
        $total_balance = 0;
        foreach ( $complete_credit_sales as $credit_sales){
            $single_total = ( $credit_sales->grand_total )-($credit_sales->discount);
            $paid_amount = Daybook::where('job',$credit_sales->invoice_number)->where('type','Income')->sum('amount');
            $single_balance = $single_total - $paid_amount;
            $total_balance = $total_balance + $single_balance;
        }
        return view('customers.credit_sales',compact('sales','id','total_balance'));
    }
    public function single_payment(Request $request, $id){
        $this->validate($request,[
            'accounts' => 'required',
            'amount' => 'required|gt:0'
        ]);
        try {

            $date = $request->date;
            $amount = $request->amount;
            $income_id = $request->income_id;
            $type = $request->type;
            $accounts = $request->accounts;

            $complete_credit_sales = DirectSales::where('customer_id', $id)->where('payment_status','<>','paid')->where('print_status', '<>', 'cancelled')->get();
            foreach ($complete_credit_sales as $credit_sales) {
                if ($amount > 0) {
                    $single_total = ($credit_sales->grand_total) - ($credit_sales->discount);
                    $paid_amount = Daybook::where('job', $credit_sales->invoice_number)->where('type', 'Income')->sum('amount');
                    $balance = $single_total - $paid_amount;

                    if ($balance > 0) {
                        $payment_amount = min($balance, $amount);
                        $amount -= $payment_amount;

                        $data = [
                            'date' => $date,
                            'income_id' => $income_id,
                            'type' => $type,
                            'accounts' => $accounts,
                            'amount' => $payment_amount,
                            'job' => $credit_sales->invoice_number,
                            'add_date' => Carbon::now(),
                            'add_by' => Auth::user()->name
                        ];

                        $salesDetails = DB::table('direct_sales')->where('invoice_number', $credit_sales->invoice_number)->first();
                        if (!$salesDetails) {
                            throw new \Exception('Sales details not found');
                        }

                        $paid_amount = Daybook::where('job', $credit_sales->invoice_number)->sum('amount');
                        $total_amount = $paid_amount + $payment_amount;
                        $grand_total = $salesDetails->grand_total - $salesDetails->discount;

                        $sale_data['payment_status'] = $grand_total > $total_amount ? 'partial' : 'paid';
                        $sale_data['pay_method'] = $salesDetails->pay_method == 'CREDIT' ? $accounts : implode(',', array_unique(array_merge(explode(',', $salesDetails->pay_method), [$accounts])));

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
                        $customer = DB::table('customers')->where('id', $credit_sales->customer_id)->first();
                        if (!$customer) {
                            throw new \Exception('Customer not found');
                        }

                        $newBalance = round($customer->balance - $payment_amount, 2);
                        $updateCustomerBalance = DB::table('customers')->where('id', $credit_sales->customer_id)->update(['balance' => $newBalance]);
                        if (!$updateCustomerBalance) {
                            throw new \Exception('Failed to update customer balance');
                        }

                        $balanceFields = ['CASH' => 'cash_balance', 'ACCOUNT' => 'account_balance', 'LEDGER' => 'ledger_balance'];
                        if (isset($balanceFields[$accounts])) {
                            $newBalance = $latestBalance->{$balanceFields[$accounts]} + $payment_amount;
                            DB::table('daybook_balances')->where('id', $latestBalance->id)->update([$balanceFields[$accounts] => $newBalance]);
                        }
                    }
                }
            }

            Toastr::success('Balance Updated', 'success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Error: ' . $e->getMessage(), 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function export_csv()
    {
        return Excel::download(new CreditCustomerExport, 'credit_customers.csv', ExcelExcel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }
    public function tally_balance(){
        $sales = DirectSales::where('payment_status','not_paid')->get();
        foreach($sales as $sale){
            $sales_total = $sale->grand_total - $sale->discount;
            $paid_amount = Daybook::where('job', $sale->invoice_number)->where('income_id','FROM_INVOICE')->sum('amount');
            if($sales_total == $paid_amount){
                $sale->payment_status = 'paid';
            }
            $sale->save();
        }
        Toastr::success('Balance Updated', 'success',["positionClass" => "toast-bottom-right"]);
        return redirect()->back();
    }
}
