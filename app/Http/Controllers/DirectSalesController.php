<?php

namespace App\Http\Controllers;

use App\Exports\SalesReportExport;
use App\Exports\CustomerExport;
use App\Models\Consignment;
use App\Models\Consoulidate;
use App\Models\Customer;
use App\Models\Daybook;
use App\Models\DirectSales;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Seller;
use App\Models\stock;
use App\Models\SalesItems;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DirectSalesController extends Controller
{

    //For Ajax
    public function checkInvoiceNumber(Request $request)
    {
        $invoiceNumber = $request->invoice;

        $invoiceCount = DB::table('invoices')->where('invoice_no',$invoiceNumber)->count();
        if($invoiceCount > 0)
        {
            return "Existing";
        }
        else
        {
            return "Not Existing";
        }
    }


    //For Ajax
    public function getCustomerDetails(Request $request)
    {

        $customer = DB::table('customers')->where('id',$request->customer)->first();
        return $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $startDay = Carbon::now()->subDays(30)->format('Y-m-d');

        // Use eager loading to minimize queries
        $sales = DirectSales::with(['customer_detail', 'staff_detail', 'sales_items', 'consolidate_bill'])
            ->whereBetween('sales_date', [$startDay, $today])
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($sale) {
                $sale->message = urlencode('Dear ' . $sale->customer_detail->name .
                    ', Your invoice #' . $sale->invoice_number .
                    ' dated ' . Carbon::parse($sale->sales_date)->format('d-m-Y') .
                    ' has been generated.');

                $sale->salesCount = $sale->sales_items->count(); // Use relationship count instead of querying separately
                $sale->total_amount = $sale->grand_total - $sale->discount;

                return $sale;
            });

        return view('direct_sales.index', compact('sales'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('direct_sales.create');
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
            'invoice_number' => 'required',
            'sales_date' => 'required',
            'customer_id' => 'required|numeric',
            'sales_staff' => 'required',
            'pay_method' => 'required'
        ]);

        $balanceCount = DB::table('daybook_balances')->where('date',Carbon::parse($request->sales_date)->format('Y-m-d') )->count();
        if($balanceCount == 0)
        {
            $lastRow = DB::table('daybook_balances')->latest('id')->first();
            $copyRow = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->sales_date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
        }

        $latestBalance = DB::table('daybook_balances')->latest('id')->first();
        $invoiceNumber = $request->invoice_number;
        $existingInvoiceCount = DirectSales::where('invoice_number', $invoiceNumber)->count();

        if ($existingInvoiceCount > 0) {
            if($request->gst_available == "Yes")
            {
                $invoiceCount = DB::table('invoices')->where('is_gst',$request->isGst)->count();
                if($invoiceCount > 0)
                {
                    $invoice = DB::table('invoices')->where('is_gst',$request->isGst)->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-",$invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    if($invoiceNumberArray[2] == "22")
                    {
                        $invoiceNumberArray[2] = "2324";
                        $invoiceCount = 1;
                    }
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                else
                {
                    $newInvoiceNumber = "B2B-00001-2324";
                }
            }

            if($request->gst_available == "No")
            {
                $invoiceCount = DB::table('invoices')->where('is_gst',$request->gst_available)->count();
                if($invoiceCount > 0)
                {
                    $invoice = DB::table('invoices')->where('is_gst',$request->gst_available)->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-",$invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    if($invoiceNumberArray[2] == "22")
                    {
                        $invoiceNumberArray[2] = "2324";
                        $invoiceCount = 1;
                    }
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                else
                {
                    $newInvoiceNumber = "B2C-00001-2324";
                }
            }
        }
        else{
            $newInvoiceNumber = $request->invoice_number;
        }

        $data = array();
        $data['sales_date'] = $request->sales_date;
        $data['invoice_number'] = $newInvoiceNumber;
        $data['customer_id'] = $request->customer_id;
        $data['customer_name'] = $request->customer_name;
        $data['customer_place'] = $request->customer_place;
        $data['customer_phone'] = $request->customer_phone;
        $data['pay_method'] = $request->pay_method;
        $data['sales_staff'] = (int) $request->sales_staff;
        $data['discount'] = $request->discount;
        $data['grand_total'] = $request->grand_total;
        $data['is_gst'] = $request->gst_available;
        $data['gst_number'] = $request->gst_number;

        if($request->pay_method != 'CREDIT'){
            $data['payment_status'] = 'paid';
        }

        $data_invoice['is_gst'] = $request->gst_available;
        $data_invoice['invoice_no'] = $newInvoiceNumber;

        $status = DirectSales::create($data);
        if($status)
        {
            $salesDetails = DB::table('direct_sales')->latest('id')->first();
            $data_invoice['sales_id'] = $salesDetails->id;
            $data_invoice['bill_generated'] = strtoupper(Auth::user()->name);
            $invoice_status = Invoice::create($data_invoice);
            $products = $request->get('productSelect');
            $serialNumber = $request->get('serial');
            $unitPrice = $request->get('unitPrice');
            $productQty = $request->get('productQty');
            $productTax = $request->get('productTax');
            $total = $request->get('total');

            for($i=0; $i < count($products); $i++)
            {
                $getStockCount = DB::table('stocks')->where('product_id',$products[$i])->count();
                if($getStockCount > 0)
                {
                    $getStockDetails = DB::table('stocks')->where('product_id',$products[$i])->first();
                    if($productQty[$i] <= $getStockDetails->product_qty)
                    {
                        $data1 = [
                            'sales_id' => $salesDetails->id,
                            'product_id' => $products[$i],
                            'unit_price' => $unitPrice[$i],
                            // 'unit_price' => $unitPrice[$i],
                            'product_quantity' => $productQty[$i],
                            'gst_percent' => $productTax[$i],
                            'sales_price' => $total[$i],
                            'sales_date' => $salesDetails->sales_date,
                            'serial_number' => $serialNumber[$i]
                        ];

                        $status2 = SalesItems::create($data1);
                    }

                    if($status2)
                    {
                        $qty = (float) $productQty[$i];
                        $stockQty = (float) $getStockDetails->product_qty;
                        $newQty = $stockQty - $qty;
                        $updateStockBalance = DB::table('stocks')->where('product_id',$products[$i])->update(['product_qty' => $newQty]);
                    }
                }
            }
            if($status2 && $invoice_status)
            {
                if($salesDetails->pay_method == "CASH")
                {

                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "CASH";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newCashBalance = $latestBalance->cash_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "ACCOUNT")
                {
                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "ACCOUNT";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newAccountBalance = $latestBalance->account_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "LEDGER")
                {
                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "LEDGER";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newLedgerBalance = $latestBalance->ledger_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "CREDIT")
                {
                    $sales = DB::table('direct_sales')->where('id',$salesDetails->id)->first();
                    $user = DB::table('customers')->where('id',$sales->customer_id)->first();
                    if($user)
                    {
                        $userBalance = (float) $user->balance;
                        $salesTotal = (float) $sales->grand_total;
                        $salesTotal = round($salesTotal,2);
                        if($sales->discount)
                        {
                            $salesDiscount = (float) $sales->discount;
                        }
                        else
                        {
                            $salesDiscount = 0;
                        }
                        $amount = $salesTotal - $salesDiscount;
                        $newBalance = $userBalance + $amount;
                        $updateBalance = DB::table('customers')->where('id',$user->id)->update(['balance'=>$newBalance]);
                        if($updateBalance)
                        {
                            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                        }
                    }
                }
                $customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
                // if(strlen($customer->mobile) == 10)
                // {
                //     $apiKey = urlencode(env('SMS_API_KEY'));
                //     $sender = urlencode('TECYSO');
                //     $numbers = $customer->mobile;
                //     $message = rawurlencode("Dear " . $customer->name . ", Your invoice # ". $salesDetails->invoice_number . " dated ". Carbon::parse($salesDetails->sales_date)->format('d-m-Y') . " has been generated. View now: techsoul.biznx.in/userInvoice/". $salesDetails->id . " -Team Techsoul 8891989842");
                //     $data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);

                //     $ch = curl_init('https://api.textlocal.in/send/');
                //     curl_setopt($ch, CURLOPT_POST, true);
                //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //     $response = curl_exec($ch);
                //     curl_close($ch);
                // }
            }
        }
        else
        {
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('directSales.show',$salesDetails->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salesItems = SalesItems::where('sales_id',$id)->get();
        $salesCount = count($salesItems);
        $consolidate_bill = Consoulidate::where('sales_id', $id)->first();
        foreach($salesItems as $item){
            if($item->product_detail->product_name == 'SERVICE' || $item->product_detail->product_name == 'SECOND HAND'){
                $item->product_name = $item->product_detail->product_name.' - '.$item->serial_number;
            } else {
                $item->product_name = $item->product_detail->product_name;
            }
        }
        $salesDetails = DirectSales::where('id', $salesItems[0]->sales_id)->first();
        $message = "Dear " . $salesDetails->customer_detail->name . ",
    Your invoice #" . $salesDetails->invoice_number . " dated " . Carbon::parse($salesDetails->sales_date)->format('d-m-Y') . " has been generated.";
        $message = urlencode($message);
        $url = 'https://api.whatsapp.com/send/?phone=91'.$salesDetails->customer_detail->mobile.'&text='.$message;
        return view('direct_sales.show', compact('salesItems','salesCount','message','salesDetails','url','consolidate_bill'));
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
    public function store_jobcard_invoice(Request $request)
    {
        $this->validate($request,[
            'invoice_number' => 'required|unique:direct_sales,invoice_number',
            'sales_date' => 'required',
            'customer_id' => 'required',
            'sales_staff' => 'required',
            'pay_method' => 'required'
        ]);

        $balanceCount = DB::table('daybook_balances')->where('date',Carbon::parse($request->sales_date)->format('Y-m-d'))->count();
        if($balanceCount == 0)
        {
            $lastRow = DB::table('daybook_balances')->latest('id')->first();
            $copyRow = DB::table('daybook_balances')->insert(['date' => Carbon::parse($request->sales_date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
        }

        $latestBalance = DB::table('daybook_balances')->latest('id')->first();

        $invoiceNumber = $request->invoice_number;
        $existingInvoiceCount = DirectSales::where('invoice_number', $invoiceNumber)->count();

        if ($existingInvoiceCount > 0) {
            if($request->gst_available == "Yes")
            {
                $invoiceCount = DB::table('invoices')->where('is_gst',$request->isGst)->count();
                if($invoiceCount > 0)
                {
                    $invoice = DB::table('invoices')->where('is_gst',$request->isGst)->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-",$invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    if($invoiceNumberArray[2] == "22")
                    {
                        $invoiceNumberArray[2] = "2324";
                        $invoiceCount = 1;
                    }
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                else
                {
                    $newInvoiceNumber = "B2B-00001-2324";
                }
            }

            if($request->gst_available == "No")
            {
                $invoiceCount = DB::table('invoices')->where('is_gst',$request->gst_available)->count();
                if($invoiceCount > 0)
                {
                    $invoice = DB::table('invoices')->where('is_gst',$request->gst_available)->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-",$invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    if($invoiceNumberArray[2] == "22")
                    {
                        $invoiceNumberArray[2] = "2324";
                        $invoiceCount = 1;
                    }
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                else
                {
                    $newInvoiceNumber = "B2C-00001-2324";
                }
            }
        }
        else{
            $newInvoiceNumber = $request->invoice_number;
        }

        $data = array();
        $data['sales_date'] = $request->sales_date;
        $data['invoice_number'] = $newInvoiceNumber;
        $data['customer_id'] = $request->customer_id;
        $data['customer_name'] = $request->customer_name;
        $data['customer_place'] = $request->customer_place;
        $data['customer_phone'] = $request->customer_phone;
        $data['pay_method'] = $request->pay_method;
        $data['sales_staff'] = (int) $request->sales_staff;
        $data['discount'] = $request->discount;
        $data['grand_total'] = $request->grand_total;
        $data['is_gst'] = $request->gst_available;
        $data['gst_number'] = $request->gst_number;
        // return $data;

        $data_invoice['is_gst'] = $request->gst_available;
        $data_invoice['invoice_no'] = $newInvoiceNumber;

        $status = DirectSales::create($data);
        if($request->consignment_id){
            $data_consignments['invoice_no'] = $newInvoiceNumber;
            $get_consignment = DB::table('consignments')->where('id',$request->consignment_id)->first();
            if($get_consignment->status != 'printed'){
                $data_consignments['status'] = 'delivered';
                $data_consignments['delivered_date']    = Carbon::now();
                $data_consignments['delivered_staff']   = Auth::user()->name;
            }
            $consignments_status = DB::table('consignments')->where('id',$request->consignment_id)->update($data_consignments);
        }
        if($status)
        {
            $salesDetails = DB::table('direct_sales')->latest('id')->first();
            $data_invoice['sales_id'] = $salesDetails->id;
            $data_invoice['bill_generated'] = strtoupper(Auth::user()->name);
            $invoice_status = Invoice::create($data_invoice);
            $products = $request->get('productSelect');
            $serialNumber = $request->get('serial');
            $unitPrice = $request->get('unitPrice');
            $productQty = $request->get('productQty');
            $productTax = $request->get('productTax');
            $total = $request->get('total');
            for($i=0; $i < count($products); $i++)
            {
                $data1 = [
                'sales_id' => $salesDetails->id,
                'product_id' => $products[$i],
                'unit_price' => $unitPrice[$i],
                'product_quantity' => $productQty[$i],
                'gst_percent' => $productTax[$i],
                'sales_price' => $total[$i],
                'sales_date' => $salesDetails->sales_date,
                'serial_number' => $serialNumber[$i]
                ];
                $status2 = SalesItems::create($data1);
            }
            if($status2 && $invoice_status)
            {
                if($salesDetails->pay_method == "CASH")
                {
                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "CASH";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newCashBalance = $latestBalance->cash_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "LEDGER")
                {
                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "LEDGER";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newLedgerBalance = $latestBalance->ledger_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['ledger_balance' => $newLedgerBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "ACCOUNT")
                {
                    $data3 = array();
                    $data3['income_id'] = "FROM_INVOICE";
                    $data3['type'] = "Income";
                    $data3['accounts'] = "ACCOUNT";
                    $data3['date'] = $salesDetails->sales_date;
                    $data3['job'] = $salesDetails->invoice_number;
                    $amount = $salesDetails->grand_total - $salesDetails->discount;
                    $data3['amount'] = $amount;
                    $status3 = Daybook::create($data3);
                    if($status3)
                    {
                        $newAccountBalance = $latestBalance->account_balance + $amount;
                        $addBalance = DB::table('daybook_balances')->where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                        Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    }
                }
                if($salesDetails->pay_method == "CREDIT")
                {
                    $sales = DB::table('direct_sales')->where('id',$salesDetails->id)->first();
                    $user = DB::table('customers')->where('id',$sales->customer_id)->first();
                    if($user)
                    {
                        $userBalance = (float) $user->balance;
                        $salesTotal = (float) $sales->grand_total;
                        $salesTotal = round($salesTotal,2);
                        if($sales->discount)
                        {
                            $salesDiscount = (float) $sales->discount;
                        }
                        else
                        {
                            $salesDiscount = 0;
                        }
                        $amount = $salesTotal - $salesDiscount;
                        $newBalance = $userBalance + $amount;
                        $updateBalance = DB::table('customers')->where('id',$user->id)->update(['balance'=>$newBalance]);
                        if($updateBalance)
                        {
                            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                        }
                    }
                }
                $customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
                if (strlen($customer->mobile) == 10) {
                    $username = urlencode(env('BHSMS_USER'));
                    $password = urlencode(env('BHSMS_PASS'));
                    $sender   = urlencode(env('BHSMS_SENDER'));

                    $numbers = '91' . $customer->mobile;
                    $message = rawurlencode(
                        "Dear " . $customer->name .
                        ", your invoice # " . $salesDetails->invoice_number .
                        " dated " . Carbon::parse($salesDetails->sales_date)->format('d-m-Y') .
                        " has been generated. View now: hostee.biznx.in/userInvoice/" .
                        $salesDetails->id . " - Hostee the Planner 8891989842"
                    );

                    $url = "http://bhashsms.com/api/sendmsg.php?user=$username&pass=$password&sender=$sender&phone=$numbers&text=$message&priority=ndnd&stype=normal";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    // Optionally log the response for debugging
                    // \Log::info('BhashSMS Invoice SMS Response: ' . $response);
                }
            }
        }
        else
        {
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('directSales.show',$salesDetails->id);
    }
    public function getLatestInvoiceNumber(Request $request)
    {
        if($request->isGst == "Yes")
        {
            $invoiceCount = DB::table('invoices')->where('is_gst',$request->isGst)->count();
            if($invoiceCount > 0)
            {
                $invoice = DB::table('invoices')->where('is_gst',$request->isGst)->latest('id')->first();
                $invoiceNumber = $invoice->invoice_no;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $currentMonth = date('m');
                $currentYear  = date('y');
                if($currentMonth >= 4){
                    $year_suffix  = $currentYear.($currentYear+1);
                    $invoice_year = substr($invoiceNumberArray[2],0,2);
                    if($invoice_year < $currentYear){
                        $invoiceCount = 1;
                    }
                }else{
                    $year_suffix  = ($currentYear - 1).($currentYear);
                }
                $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $year_suffix;
                return $newInvoiceNumber;
            }
            else
            {
                $currentMonth = date('m');
                $currentYear  = date('y');
                if($currentMonth >= 4){
                    $year_suffix  = $currentYear.($currentYear+1);
                }else{
                    $year_suffix  = ($currentYear - 1).($currentYear);
                }
                return "B2B-00001-" . $year_suffix;
            }
        }

        if($request->isGst == "No")
        {
            $invoiceCount = DB::table('invoices')->where('is_gst',$request->isGst)->count();
            if($invoiceCount > 0)
            {
                $invoice = DB::table('invoices')->where('is_gst',$request->isGst)->latest('id')->first();
                $invoiceNumber = $invoice->invoice_no;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $currentMonth = date('m');
                $currentYear  = date('y');
                if($currentMonth >= 4){
                    $year_suffix  = $currentYear.($currentYear+1);
                    $invoice_year = substr($invoiceNumberArray[2],0,2);
                    if($invoice_year < $currentYear){
                        $invoiceCount = 1;
                    }
                }else{
                    $year_suffix  = ($currentYear - 1).($currentYear);
                }
                $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $year_suffix;
                return $newInvoiceNumber;
            }
            else
            {
                $currentMonth = date('m');
                $currentYear  = date('y');
                if($currentMonth >= 4){
                    $year_suffix  = $currentYear.($currentYear+1);
                }else{
                    $year_suffix  = ($currentYear - 1).($currentYear);
                }
                return "B2C-00001-" . $year_suffix;
            }
        }
    }

    public function updateCreditBalance(Request $request)
    {
        $sales = DB::table('direct_sales')->where('id',$request->sales)->first();
        $user = DB::table('customers')->where('id',$sales->customer_id)->first();
        if($user)
        {
            $userBalance = (float) $user->balance;
            $salesTotal = (float) $sales->grand_total;
            $salesTotal = round($salesTotal,2);
            if($sales->discount)
            {
                $salesDiscount = (float) $sales->discount;
            }
            else
            {
                $salesDiscount = 0;
            }
            $amount = $salesTotal - $salesDiscount;
            $newBalance = $userBalance + $amount;
            $updateBalance = DB::table('customers')->where('id',$user->id)->update(['balance'=>$newBalance]);
            if($updateBalance)
            {
                return response()->json("Success");
            }
            else
            {
                return response()->json("Error");
            }
        }
    }

    public function salesInvoice(Request $request, $id)
    {
        function number_to_word(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');

            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }

            $d = 0;
            while( $d < $decimal_length ) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d += $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str2[] = null;
            }

            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }

        $salesDetails = DB::table('direct_sales')->where('id',$id)->first();
        $completeReportDetails = array();
        $qtyTotal = DB::table('sales_items')->where('sales_id',$id)->sum('product_quantity');
        $completeReportDetails['invoice_number'] = $salesDetails->invoice_number;
        $completeReportDetails['invoice_date'] = Carbon::createFromFormat('Y-m-d',$salesDetails->sales_date)->format('d-m-Y');
        $get_customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
        $completeReportDetails['customer_name'] = $get_customer->name;
        $completeReportDetails['pay_method'] = $salesDetails->pay_method;
        $completeReportDetails['customer_place'] = $get_customer->place;
        $getInvoice = Invoice::where('sales_id',$id)->latest('id')->first();
        if($getInvoice->is_gst == "Yes")
        {
            $completeReportDetails['gst_number'] = $salesDetails->gst_number;
        }
        else
        {
            $completeReportDetails['gst_number'] = "";
        }
        $completeReportDetails['qty_total'] = $qtyTotal;
        $getSoldItems = DB::table('sales_items')->where('sales_id',$id)->get();
        $gst_amount = 0.00;
        $netTotal = 0.00;

        foreach($getSoldItems as $item)
        {
            $unitPrice = number_format((float) $item->unit_price, 2, '.', '');
            $unitQty = (float) $item->product_quantity;
            $gstPercent = (float) $item->gst_percent;
            $total = $unitPrice * $unitQty;
            $gst = ($unitPrice * $unitQty * $gstPercent) / 100 ;
            $gst_amount += $gst;
            $netTotal += $total;
        }

        $completeReportDetails['net_total'] = number_format((float)$netTotal, 2, '.', '');
        $discount = number_format((float) $salesDetails->discount, 2, '.', '');
        $grandTotal = number_format((float) $salesDetails->grand_total, 2, '.', '');
        $discounted_total = $grandTotal-$salesDetails->discount;
        $completeReportDetails['gst_amount'] = $gst_amount;
        $completeReportDetails['discount'] = $salesDetails->discount;
        $completeReportDetails['grand_total'] = $grandTotal;
        $completeReportDetails['discounted_total'] = $discounted_total;
        $grand_total_in_words = number_to_word($discounted_total);
        $completeReportDetails['grand_total_words'] = strtoupper($grand_total_in_words);
        $completeReportDetails['sales_items'] = $getSoldItems;
        $get_sales_staff = DB::table('staffs')->where('id',$salesDetails->sales_staff)->first();
        $completeReportDetails['sales_staff'] = $get_sales_staff->staff_name;
        $invoice_details = DB::table('invoices')->where('sales_id',$id)->first();

        if($invoice_details->bill_generated == Null){
            $data['bill_generated'] = strtoupper(Auth::user()->name);
            $status = DB::table('invoices')->where('id',$invoice_details->id)->update($data);
            $bill_generated = strtoupper(Auth::user()->name);
        } else {
            $bill_generated = $invoice_details->bill_generated;
        }
        $completeReportDetails['bill_generated_staff'] = $bill_generated;
        $completeReportDetails['sales_id'] = $id;

        //jobcard details
        $jobcard = Consignment::where('invoice_no', $salesDetails->invoice_number)->first();
        if($jobcard){
            $completeReportDetails['job_no'] = $jobcard->jobcard_number;
        }else{
            $completeReportDetails['job_no'] =  '';
        }
        $pdf = Pdf::loadView('invoices.invoice',compact('completeReportDetails'));

        return $pdf->stream($salesDetails->invoice_number.'-Hostee the Planner.pdf',array("Attachment"=>false));
    }

    public function generateCustomerReport(Request $request)
    {
        $data = $request->all();
        if (!isset($data['customer'])) {
            return back()->withErrors('Customer selection is required.');
        }

        $customerDetails = Customer::where('id', $data['customer'])->first();
        $currentDate = Carbon::now();
        $financialYearStart = Carbon::create($currentDate->year, 4, 1);
        $financialYearEnd = Carbon::create($currentDate->year + 1, 3, 31);
        $dateRange = $data['report_type'] ?? 'current_financial_year';

        switch ($dateRange) {
            case 'current_month':
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;

            case 'current_financial_year':
                if ($currentDate->month >= 4) {
                    $financialYearStart = Carbon::create($currentDate->year, 4, 1);
                    $financialYearEnd = Carbon::create($currentDate->year + 1, 3, 31);
                } else {
                    $financialYearStart = Carbon::create($currentDate->year - 1, 4, 1);
                    $financialYearEnd = Carbon::create($currentDate->year, 3, 31);
                }
                $startDate = $financialYearStart->format('Y-m-d');
                $endDate = $financialYearEnd->format('Y-m-d');
                break;

            case 'last_financial_year':
                if ($currentDate->month >= 4) {
                    $lastFinancialYearStart = Carbon::create($currentDate->year - 1, 4, 1);
                    $lastFinancialYearEnd = Carbon::create($currentDate->year, 3, 31);
                } else {
                    $lastFinancialYearStart = Carbon::create($currentDate->year - 2, 4, 1);
                    $lastFinancialYearEnd = Carbon::create($currentDate->year - 1, 3, 31);
                }
                $startDate = $lastFinancialYearStart->format('Y-m-d');
                $endDate = $lastFinancialYearEnd->format('Y-m-d');
                break;

            case 'complete':
                $startDate = '2020-01-01';
                $endDate =  Carbon::now()->format('Y-m-d');
                break;

            case 'select_date_range':
                $this->validate($request, [
                    'startDate' => 'required|date',
                    'endDate' => 'required|date|after:startDate',
                ]);
                $startDate = Carbon::parse($data['startDate'])->format('Y-m-d');
                $endDate = Carbon::parse($data['endDate'])->format('Y-m-d');
                break;

            default:
                return back()->withErrors('Invalid date range selection');
        }
        $tableData = array();
        $totalPurchaseAmountBefore = DirectSales::where('customer_id',$data['customer'])->where('sales_date','<',$startDate)->sum('grand_total');
        $totalDiscountBefore = DirectSales::where('customer_id',$data['customer'])->where('sales_date','<',$startDate)->sum('discount');
        $totalPurchasesBeforePeriod = DirectSales::where('customer_id',$data['customer'])->get();
        $paidAmountBeforePeriod = 0;
        foreach ($totalPurchasesBeforePeriod as $purchase) {
            $paidAmountBeforePeriod += Daybook::where('job', $purchase->invoice_number)->where('type', 'Income')->where('date','<',$startDate)->sum('amount');
        }
        $openingBalanceTotalPurchases = ($totalPurchaseAmountBefore - $totalDiscountBefore) -$paidAmountBeforePeriod;
        $openingBalance = $openingBalanceTotalPurchases;
        $totalPurchaseAmount = DirectSales::where('customer_id', $data['customer'])->whereBetween('sales_date', [$startDate, $endDate])->sum('grand_total');
        $totalDiscount = DirectSales::where('customer_id', $data['customer'])->whereBetween('sales_date', [$startDate, $endDate])->sum('discount');
        $totalPurchasesInPeriod = DirectSales::where('customer_id', $data['customer'])->orderBy('sales_date', 'asc')->get();

        $paidAmount = 0;
        $balance = $openingBalance;
        if($request->type == "EXCEL"){
            $temp_excel = array();
            $temp_excel['date'] = '';
            $temp_excel['invoiceNumber'] = '';
            $temp_excel['debit'] = '';
            $temp_excel['credit'] = 'Opening';
            $temp_excel['balance'] = round(abs($balance),2);
            array_push($tableData,$temp_excel);
        }
        foreach ($totalPurchasesInPeriod as $purchase) {
            $paidAmount += Daybook::where('job', $purchase->invoice_number)->where('type', 'Income')->sum('amount');
            $temp = array();
            $temp['date'] = $purchase->sales_date;
            $temp['invoiceNumber'] = $purchase->invoice_number;
            $temp['debit'] = ($purchase->grand_total) - ($purchase->discount);
            $temp['credit'] = '';
            $balance += ($purchase->grand_total) - ($purchase->discount);
            $temp['balance'] = $balance;
            array_push($tableData, $temp);

        }
        $totalPurchasesInPeriodincom = DirectSales::where('customer_id', $data['customer'])->orderBy('sales_date', 'asc')->get();
        foreach ($totalPurchasesInPeriodincom as $purchase) {
            $paidInvoices = DB::table('daybooks')
                ->select(DB::raw('date, SUM(amount) as total_amount'))
                ->where('job', $purchase->invoice_number)
                ->where('type', 'Income')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
            $tableDataIncome = [];
            foreach ($paidInvoices as $invoice) {
                $temp1 = [];
                $temp1['date'] = $invoice->date;
                $temp1['invoiceNumber'] = 'Income' ;
                $temp1['debit'] = '';
                $temp1['credit'] = $invoice->total_amount;
                $balance -= $invoice->total_amount;
                $temp1['balance'] = $balance;
                array_push($tableDataIncome, $temp1);
            }
            foreach ($tableDataIncome as $row) {
                $date = $row['date'];
                if (isset($tableData[$date])) {
                    if ($row['invoiceNumber'] == 'Income') {
                        $tableData[$date]['credit'] += $row['credit'];
                        $tableData[$date]['balance'] = $row['balance'];
                    }
                } else {
                    $tableData[$date] = $row;
                }
            }

        }
        $tableData = array_filter($tableData, function ($data) use ($startDate, $endDate) {
            $date = strtotime($data['date']);
            return $date >= strtotime($startDate) && $date <= strtotime($endDate);
        });
        usort($tableData, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $balance_data = $openingBalance;
        $combinedData = [];
        $totalCredit = 0;
        $totalDebit = 0;
        foreach ($tableData as $data) {
            if ($data['credit'] === ''){
                $direct_salesdata = DB::table('direct_sales')->where('invoice_number', $data['invoiceNumber'])->first();
                $temp2 = array();
                $temp2['date'] = $direct_salesdata->sales_date;
                $temp2['invoiceNumber'] = $data['invoiceNumber'];
                $temp2['debit'] = ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $totalDebit += ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $temp2['credit'] = '';
                $balance_data += ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $temp2['balance'] = number_format($balance_data, 2, '.', '');
                array_push($combinedData, $temp2);
            } elseif ($data['debit'] === '') {
                $temp3 = [];
                $temp3['date'] = $data['date'];
                $temp3['invoiceNumber'] = 'INCOME';
                $temp3['debit'] = '';
                $temp3['credit'] = $data['credit'];
                $totalCredit += $data['credit'];
                $balance_data = (float)$balance_data - (float)$data['credit'];
                $temp3['balance'] = number_format($balance_data, 2, '.', '');
                array_push($combinedData, $temp3);
            }
        }

        $totalPurchaseAmount = $totalPurchaseAmount - $totalDiscount;
        $balanceAmount = $balance_data;

        if($request->type == "PDF")
        {
            $pdf = Pdf::loadView('customers.customer_report',compact('customerDetails','startDate','endDate','totalPurchaseAmount','balanceAmount','openingBalance','combinedData','totalDebit','totalCredit'));
            return $pdf->stream($startDate.' to '.$endDate.' - '.$customerDetails->name,array("Attachment"=>false));
        }
        if($request->type == "EXCEL")
        {
            return Excel::download(new CustomerExport($combinedData), $startDate.' to '.$endDate.' - '.' Report.csv');
        }
    }
    // public function generateCustomerReport(Request $request)
    // {
    //     $data = $request->all();
    //     $customerDetails = DB::table('customers')->where('id',$data['customer'])->first();
    //     $startDate = date('Y-m-d', strtotime($request->startDate));
    //     $endDate = date('Y-m-d', strtotime($request->endDate));
    //     $this->validate($request, [

    //         'startDate' => 'required',
    //         'endDate' => 'required|after:startDate',

    //     ]);
    //     $startDate = Carbon::parse($data['startDate'])->format('d-m-Y');
    //     $endDate = Carbon::parse($data['endDate'])->format('d-m-Y');
    //     $tableData = array();
    //     $totalPurchaseAmountBefore = DB::table('direct_sales')->where('customer_id',$data['customer'])->where('sales_date','<',$data['startDate'])->sum('grand_total');
    //     $totalDiscountBefore = DB::table('direct_sales')->where('customer_id',$data['customer'])->where('sales_date','<',$data['startDate'])->sum('discount');
    //     $totalPurchasesBeforePeriod = DB::table('direct_sales')->where('customer_id',$data['customer'])->where('sales_date','<',$data['startDate'])->get();
    //     $paidAmountBeforePeriod = 0;
    //     foreach($totalPurchasesBeforePeriod as $purchase)
    //     {
    //         $paidAmountBeforePeriod += DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->sum('amount');
    //     }
    //     $openingBalance = $totalPurchaseAmountBefore - $paidAmountBeforePeriod - $totalDiscountBefore;
    //     $totalPurchaseAmount= DB::table('direct_sales')->where('customer_id',$data['customer'])->whereBetween('sales_date',[$data['startDate'],$data['endDate']])->sum('grand_total');
    //     $totalDiscount= DB::table('direct_sales')->where('customer_id',$data['customer'])->whereBetween('sales_date',[$data['startDate'],$data['endDate']])->sum('discount');
    //     $totalPurchasesInPeriod= DB::table('direct_sales')->where('customer_id',$data['customer'])->whereBetween('sales_date',[$data['startDate'],$data['endDate']])->orderby('sales_date','asc')->get();
    //     $paidAmount = 0;
    //     $balance = $openingBalance;
    //     if($request->type == "EXCEL"){
    //         $temp_excel = array();
    //         $temp_excel['date'] = '';
    //         $temp_excel['invoiceNumber'] = '';
    //         $temp_excel['debit'] = '';
    //         $temp_excel['credit'] = 'Opening';
    //         $temp_excel['balance'] = round(abs($balance),2);
    //         array_push($tableData,$temp_excel);
    //     }
    //     foreach($totalPurchasesInPeriod as $purchase)
    //     {
    //         $paidAmount += DB::table('daybooks')->where('job',$purchase->invoice_number)->whereBetween('date',[$data['startDate'],$data['endDate']])->where('type','Income')->sum('amount');
    //         $temp = array();
    //         $temp['date'] = $purchase->sales_date;
    //         $temp['invoiceNumber'] = $purchase->invoice_number;
    //         $temp['debit'] = ($purchase->grand_total)-($purchase->discount);
    //         $temp['credit'] = '';
    //         $balance += ($purchase->grand_total)-($purchase->discount);
    //         $temp['balance'] = round($balance,2);
    //         array_push($tableData,$temp);
    //         $paidInvoices = DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->whereBetween('date',[$data['startDate'],$data['endDate']])->orderby('date','asc')->get();
    //         foreach($paidInvoices as $invoice)
    //         {
    //             $temp1 = array();
    //             $temp1['date'] = $invoice->date;
    //             $temp1['invoiceNumber'] = $invoice->job;
    //             $temp1['debit'] = '';
    //             $temp1['credit'] = $invoice->amount;
    //             $balance -= $invoice->amount;
    //             $temp1['balance'] = round($balance,2);
    //             array_push($tableData,$temp1);
    //         }
    //     }
    //     $totalPurchaseAmount = $totalPurchaseAmount - $totalDiscount;
    //     $balanceAmount = $totalPurchaseAmount - $paidAmount;

    //     if($request->type == "PDF")
    //     {
    //         $pdf = Pdf::loadView('customers.customer_report',compact('customerDetails','startDate','endDate','totalPurchaseAmount','balanceAmount','openingBalance','tableData'));
    //         return $pdf->stream($startDate.' to '.$endDate.' - '.$customerDetails->name,array("Attachment"=>false));
    //     }
    //     if($request->type == "EXCEL")
    //     {
    //         return Excel::download(new CustomerExport($tableData), $startDate.' to '.$endDate.' - '.' Report.csv');
    //     }
    // }
    // public function WhatsappInvoice($id)
    // {
    //     function number_to_word1(float $number)
    //     {
    //         $no = floor($number);
    //         $decimal = round($number - $no, 2) * 100;
    //         $decimal_part = $decimal;
    //         $hundred = null;
    //         $hundreds = null;
    //         $digits_length = strlen($no);
    //         $decimal_length = strlen($decimal);
    //         $i = 0;
    //         $str = array();
    //         $str2 = array();
    //         $words = array(0 => '', 1 => 'one', 2 => 'two',
    //             3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
    //             7 => 'seven', 8 => 'eight', 9 => 'nine',
    //             10 => 'ten', 11 => 'eleven', 12 => 'twelve',
    //             13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
    //             16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
    //             19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
    //             40 => 'forty', 50 => 'fifty', 60 => 'sixty',
    //             70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    //         $digits = array('', 'hundred','thousand','lakh', 'crore');

    //         while( $i < $digits_length ) {
    //             $divider = ($i == 2) ? 10 : 100;
    //             $number = floor($no % $divider);
    //             $no = floor($no / $divider);
    //             $i += $divider == 10 ? 1 : 2;
    //             if ($number) {
    //                 $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
    //                 $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
    //                 $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
    //             } else $str[] = null;
    //         }

    //         $d = 0;
    //         while( $d < $decimal_length ) {
    //             $divider = ($d == 2) ? 10 : 100;
    //             $decimal_number = floor($decimal % $divider);
    //             $decimal = floor($decimal / $divider);
    //             $d += $divider == 10 ? 1 : 2;
    //             if ($decimal_number) {
    //                 $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
    //                 $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
    //                 @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
    //             } else $str2[] = null;
    //         }

    //         $Rupees = implode('', array_reverse($str));
    //         $paise = implode('', array_reverse($str2));
    //         $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
    //         return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    //     }

    //     $salesDetails = DB::table('direct_sales')->where('id',$id)->first();
    //     $completeReportDetails = array();
    //     $qtyTotal = DB::table('sales_items')->where('sales_id',$id)->sum('product_quantity');
    //     $completeReportDetails['invoice_number'] = $salesDetails->invoice_number;
    //     $completeReportDetails['invoice_date'] = Carbon::createFromFormat('Y-m-d',$salesDetails->sales_date)->format('d-m-Y');
    //     $get_customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
    //     $completeReportDetails['customer_name'] = $get_customer->name;
    //     $completeReportDetails['pay_method'] = $salesDetails->pay_method;
    //     $completeReportDetails['customer_place'] = $get_customer->place;
    //     $getInvoice = Invoice::where('sales_id',$id)->latest('id')->first();
    //     if($getInvoice->is_gst == "Yes")
    //     {
    //         $completeReportDetails['gst_number'] = $salesDetails->gst_number;
    //     }
    //     else
    //     {
    //         $completeReportDetails['gst_number'] = "";
    //     }
    //     $completeReportDetails['qty_total'] = $qtyTotal;
    //     $getSoldItems = DB::table('sales_items')->where('sales_id',$id)->get();
    //     $gst_amount = 0.00;
    //     $netTotal = 0.00;
    //     foreach($getSoldItems as $item)
    //     {
    //         $unitPrice = number_format((float) $item->unit_price, 2, '.', '');
    //         $unitQty = (float) $item->product_quantity;
    //         $gstPercent = (float) $item->gst_percent;
    //         $total = $unitPrice * $unitQty;
    //         $gst = ($unitPrice * $unitQty * $gstPercent) / 100 ;
    //         $gst_amount += $gst;
    //         $netTotal += $total;
    //     }
    //     $completeReportDetails['net_total'] = number_format((float)$netTotal, 2, '.', '');
    //     $discount = number_format((float) $salesDetails->discount, 2, '.', '');
    //     $grandTotal = number_format((float) $salesDetails->grand_total, 2, '.', '');
    //     $discounted_total = $grandTotal-$salesDetails->discount;
    //     $completeReportDetails['gst_amount'] = $gst_amount;
    //     $completeReportDetails['discount'] = $salesDetails->discount;
    //     $completeReportDetails['grand_total'] = $grandTotal;
    //     $completeReportDetails['discounted_total'] = $discounted_total;
    //     $grand_total_in_words = number_to_word1($discounted_total);
    //     $completeReportDetails['grand_total_words'] = strtoupper($grand_total_in_words);
    //     $completeReportDetails['sales_items'] = $getSoldItems;
    //     $get_sales_staff = DB::table('staffs')->where('id',$salesDetails->sales_staff)->first();
    //     $completeReportDetails['sales_staff'] = $get_sales_staff->staff_name;
    //     if(Auth::user())
    //     {
    //         $completeReportDetails['bill_generated_staff'] = strtoupper(Auth::user()->name);
    //     }
    //     else
    //     {
    //         $completeReportDetails['bill_generated_staff'] = $get_sales_staff->staff_name;
    //     }
    //     $completeReportDetails['sales_id'] = $id;
    //     $fileName = "Hostee the Planner - #" . $salesDetails->invoice_number. ".pdf";
    //     $pdf = Pdf::loadView('invoices.userInvoice',compact('completeReportDetails'));
    //     return $pdf->download($fileName,array("Attachment"=>false));
    // }
    public function WhatsappInvoice($id)
    {
        function number_to_word1(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $words = [
                0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
                18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
                50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
            ];
            $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];

            $str = [];
            $i = 0;
            while ($no > 0) {
                $divider = ($i == 2) ? 10 : 100;
                $number = $no % $divider;
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $counter = count($str);
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : '';
                    $str[] = ($number < 21)
                        ? $words[$number] . ' ' . $digits[$counter] . ' ' . $hundred
                        : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . ' ' . $hundred;
                } else {
                    $str[] = null;
                }
            }

            $Rupees = implode('', array_reverse($str));
            return trim(ucwords($Rupees) . ' Rupees Only');
        }

        $sales = DB::table('direct_sales')->where('id', $id)->first();
        $customer = DB::table('customers')->where('id', $sales->customer_id)->first();

        $qtyTotal = DB::table('sales_items')->where('sales_id', $id)->sum('product_quantity');
        $getSoldItems = DB::table('sales_items')->where('sales_id', $id)->get();
        $getInvoice = DB::table('invoices')->where('sales_id', $id)->latest('id')->first();

        $gst_amount = 0.00;
        $netTotal = 0.00;
        foreach ($getSoldItems as $item) {
            $unitPrice = (float) $item->unit_price;
            $unitQty = (float) $item->product_quantity;
            $gstPercent = (float) $item->gst_percent;
            $total = $unitPrice * $unitQty;
            $gst = ($total * $gstPercent) / 100;
            $gst_amount += $gst;
            $netTotal += $total;
        }

        $discount = (float) $sales->discount;
        $grandTotal = (float) $sales->grand_total;
        $discounted_total = $grandTotal - $discount;

        $gst_number = ($getInvoice && $getInvoice->is_gst == "Yes") ? $sales->gst_number : "";

        $completeReportDetails = [
            'invoice_number'      => $sales->invoice_number,
            'invoice_date'        => Carbon::parse($sales->sales_date)->format('d-m-Y'),
            'customer_name'       => $customer->name,
            'customer_place'      => $customer->place,
            'gst_number'          => $gst_number,
            'pay_method'          => $sales->pay_method,
            'qty_total'           => $qtyTotal,
            'sales_items'         => $getSoldItems,
            'net_total'           => number_format($netTotal, 2, '.', ''),
            'gst_amount'          => number_format($gst_amount, 2, '.', ''),
            'discount'            => number_format($discount, 2, '.', ''),
            'grand_total'         => number_format($grandTotal, 2, '.', ''),
            'discounted_total'    => number_format($discounted_total, 2, '.', ''),
            'grand_total_words'   => strtoupper(number_to_word1($discounted_total)),
            'sales_id'            => $id,
            'sales_staff'         => DB::table('staffs')->where('id', $sales->sales_staff)->value('staff_name') ?? 'N/A',
            'bill_generated_staff'=> Auth::user()->name ?? 'SYSTEM',
        ];

        // $fileName = "Hostee_" . $sales->invoice_number . ".pdf";
        // $filePath = storage_path("app/public/invoices/" . $fileName);
        // if (!file_exists(dirname($filePath))) {
        //     mkdir(dirname($filePath), 0777, true);
        // }

        // $pdf = Pdf::loadView('invoices.userInvoice', compact('completeReportDetails'));
        // $pdf->save($filePath);
        // $publicUrl = asset('storage/invoices/' . $fileName);

        $phone    = $customer->mobile;

        $param1 = urlencode($customer->name);
        $param2 = $sales->invoice_number;
        $param3 = Carbon::parse($sales->sales_date)->format('d-m-Y');

        $publicUrl = route('userInvoice', ['id' => $id]);

        $apiUrl = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=$phone&text=inv_pdf_1711&priority=wa&stype=normal&Params=$param1,$param2,$param3&htype=document&url=$publicUrl";

        // dd([
        //     'url' => $apiUrl
        // ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        Toastr::success('Invoice generated and WhatsApp message sent successfully.', 'Success', ["positionClass" => "toast-bottom-right"]);
        session()->flash('whatsapp_sent', true);

        return redirect()->back();
    }

    public function userInvoice($id)
    {
        function number_to_word1(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');

            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }

            $d = 0;
            while( $d < $decimal_length ) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d += $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str2[] = null;
            }

            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }

        $salesDetails = DB::table('direct_sales')->where('id',$id)->first();
        $completeReportDetails = array();
        $qtyTotal = DB::table('sales_items')->where('sales_id',$id)->sum('product_quantity');
        $completeReportDetails['invoice_number'] = $salesDetails->invoice_number;
        $completeReportDetails['invoice_date'] = Carbon::createFromFormat('Y-m-d',$salesDetails->sales_date)->format('d-m-Y');
        $get_customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
        $completeReportDetails['customer_name'] = $get_customer->name;
        $completeReportDetails['pay_method'] = $salesDetails->pay_method;
        $completeReportDetails['customer_place'] = $get_customer->place;
        $getInvoice = Invoice::where('sales_id',$id)->latest('id')->first();
        if($getInvoice->is_gst == "Yes")
        {
            $completeReportDetails['gst_number'] = $salesDetails->gst_number;
        }
        else
        {
            $completeReportDetails['gst_number'] = "";
        }
        $completeReportDetails['qty_total'] = $qtyTotal;
        $getSoldItems = DB::table('sales_items')->where('sales_id',$id)->get();
        $gst_amount = 0.00;
        $netTotal = 0.00;
        foreach($getSoldItems as $item)
        {
            $unitPrice = number_format((float) $item->unit_price, 2, '.', '');
            $unitQty = (float) $item->product_quantity;
            $gstPercent = (float) $item->gst_percent;
            $total = $unitPrice * $unitQty;
            $gst = ($unitPrice * $unitQty * $gstPercent) / 100 ;
            $gst_amount += $gst;
            $netTotal += $total;
        }
        $completeReportDetails['net_total'] = number_format((float)$netTotal, 2, '.', '');
        $discount = number_format((float) $salesDetails->discount, 2, '.', '');
        $grandTotal = number_format((float) $salesDetails->grand_total, 2, '.', '');
        $discounted_total = $grandTotal-$salesDetails->discount;
        $completeReportDetails['gst_amount'] = $gst_amount;
        $completeReportDetails['discount'] = $salesDetails->discount;
        $completeReportDetails['grand_total'] = $grandTotal;
        $completeReportDetails['discounted_total'] = $discounted_total;
        $grand_total_in_words = number_to_word1($discounted_total);
        $completeReportDetails['grand_total_words'] = strtoupper($grand_total_in_words);
        $completeReportDetails['sales_items'] = $getSoldItems;
        $get_sales_staff = DB::table('staffs')->where('id',$salesDetails->sales_staff)->first();
        $completeReportDetails['sales_staff'] = $get_sales_staff->staff_name;
        if(Auth::user())
        {
            $completeReportDetails['bill_generated_staff'] = strtoupper(Auth::user()->name);
        }
        else
        {
            $completeReportDetails['bill_generated_staff'] = $get_sales_staff->staff_name;
        }
        $completeReportDetails['sales_id'] = $id;
        $fileName = "Hostee the Planner - #" . $salesDetails->invoice_number. ".pdf";
        $pdf = Pdf::loadView('invoices.userInvoice',compact('completeReportDetails'));
        return $pdf->stream($fileName,array("Attachment"=>false));
    }

    public function generateSalesGSTReport(Request $request)
    {
        $service = $request->service;
        $output = $request->output;
        $fromDate = $request->startDate;
        $toDate = $request->endDate;

        $this->validate($request, [

            'startDate' => 'required',
            'endDate' => 'required|after:startDate',

        ]);

        $salesData = DirectSales::whereBetween('sales_date',[Carbon::parse($fromDate)->format('Y-m-d'),Carbon::parse($toDate)->format('Y-m-d')])->get();
        $tableData = array();
        $totalQty = 0;
        $totalTaxable = 0;
        $totalGst = 0;
        $totalTotal = 0;
        foreach($salesData as $sales)
        {
            $customer = Customer::where('id',$sales->customer_id)->first();
            if($service == "YES")
            {
                if(substr($sales->invoice_number,0,3) == "B2B")
                {
                    $items = SalesItems::where('sales_id',$sales->id)->get();
                }
                else
                {
                    $items = SalesItems::where('sales_id',$sales->id)->where('product_id','<>','159')->get();
                }
            }
            if($service == "NO")
            {
                $items = SalesItems::where('sales_id',$sales->id)->where('product_id','<>','159')->get();
            }
            foreach($items as $item)
            {
                $product = Product::where('id',$item->product_id)->first();
                $stockDetails = stock::where('product_id',$item->product_id)->first();
                $temp = array();
                $temp['invoice'] = $sales->invoice_number;
                $temp['date'] = $sales->sales_date;
                $temp['invoiceType'] = substr($sales->invoice_number,0,3);
                $temp['GSTIN'] = $customer->gst_no;
                $temp['customer'] = $customer->name;
                $temp['place'] = $customer->place;
                $temp['product'] = $product->product_name;
                $temp['hsn'] = $product->hsn_code;
                $temp['inprice'] = $stockDetails->product_unit_price;
                $temp['uprice'] = $item->unit_price;
                $temp['qty'] = $item->product_quantity;
                $totalQty += $item->product_quantity;
                $taxable = (float) $item->unit_price * (float) $item->product_quantity;
                $taxable = round($taxable,2);
                $temp['taxable'] = $taxable;
                $totalTaxable += $taxable;
                $temp['tax'] = $item->gst_percent;
                $temp['cgst'] = ((($item->gst_percent /2) * $taxable)/100);
                $temp['cgst'] = round($temp['cgst'],2);
                $temp['sgst'] = round($temp['cgst'],2);
                $totalGst += round($temp['cgst'],2);
                $temp['igst'] = 0;
                $temp['cess'] = 0;
                $temp['total'] = $item->sales_price;
                $totalTotal += $item->sales_price;
                array_push($tableData,$temp);
            }
        }
        $temp = array();
        $temp['invoice'] = '';
        $temp['date'] = '';
        $temp['invoiceType'] = '';
        $temp['GSTIN'] = '';
        $temp['customer'] = '';
        $temp['place'] = '';
        $temp['product'] = '';
        $temp['hsn'] = '';
        $temp['inprice'] = '';
        $temp['uprice'] = '';
        $temp['qty'] = $totalQty;
        $temp['taxable'] = $totalTaxable;
        $temp['tax'] = '';
        $temp['cgst'] = $totalGst;
        $temp['sgst'] = $totalGst;
        $temp['igst'] = 0;
        $temp['cess'] = 0;
        $temp['total'] = $totalTotal;
        array_push($tableData,$temp);
        if($output == "PDF")
        {
            $pdf = Pdf::loadView('direct_sales.report',compact('tableData','fromDate','toDate'));
            return $pdf->setPaper('A4','landscape')->stream($fromDate.' to '.$toDate."- Sales GST Report.pdf",array("Attachment"=>false));
        }
        if($output == "EXCEL")
        {
            return Excel::download(new SalesReportExport($tableData), 'Hostee - Sales Report.csv');
        }
    }

    public function sendInvoiceSMS($id)
    {
        $salesDetails = DB::table('direct_sales')->where('id',$id)->first();
        $customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
        if (strlen($customer->mobile) == 10) {
            $username = urlencode(env('BHSMS_USER'));
            $password = urlencode(env('BHSMS_PASS'));
            $sender   = urlencode(env('BHSMS_SENDER'));

            $numbers = $customer->mobile;
            $message = rawurlencode(
                "Dear " . $customer->name .
                ", your invoice # " . $salesDetails->invoice_number .
                " dated " . Carbon::parse($salesDetails->sales_date)->format('d-m-Y') .
                " has been generated. View now: hostee.biznx.in/userInvoice/" .
                $salesDetails->id . " - Hostee the Planner 8891989842"
            );

            $url = "http://bhashsms.com/api/sendmsg.php?user=$username&pass=$password&sender=$sender&phone=$numbers&text=$message&priority=ndnd&stype=normal";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            Toastr::success('SMS Sent Successfully.', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Check your mobile number!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    // public function generateCompleteCustomerReport(Request $request)
    // {
    //     $data = $request->all();
    //     $customerDetails = DB::table('customers')->where('id',$data['customer'])->first();
    //     $tableData = array();
    //     // $totalPurchaseAmountBefore = DB::table('direct_sales')->where('customer_id',$data['customer'])->sum('grand_total');
    //     // $totalDiscountBefore = DB::table('direct_sales')->where('customer_id',$data['customer'])->sum('discount');
    //     // $totalPurchasesBeforePeriod = DB::table('direct_sales')->where('customer_id',$data['customer'])->get();
    //     // $paidAmountBeforePeriod = 0;
    //     // foreach($totalPurchasesBeforePeriod as $purchase)
    //     // {
    //     //     $paidAmountBeforePeriod += DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->sum('amount');
    //     // }
    //     // $openingBalance = $totalPurchaseAmountBefore - $paidAmountBeforePeriod - $totalDiscountBefore;
    //     $openingBalance = 0;
    //     $totalPurchaseAmount= DB::table('direct_sales')->where('customer_id',$data['customer'])->sum('grand_total');
    //     $totalDiscount= DB::table('direct_sales')->where('customer_id',$data['customer'])->sum('discount');
    //     $totalPurchasesInPeriod= DB::table('direct_sales')->where('customer_id',$data['customer'])->orderby('sales_date','asc')->get();
    //     $paidAmount = 0;
    //     $balance = $openingBalance;
    //     // foreach($totalPurchasesInPeriod as $purchase)
    //     // {
    //     //     $paidAmount += DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->sum('amount');

    //     //     $temp = array();
    //     //     $temp['date'] = $purchase->sales_date;
    //     //     $temp['invoiceNumber'] = $purchase->invoice_number;
    //     //     $temp['debit'] = ($purchase->grand_total)-($purchase->discount);
    //     //     $temp['credit'] = '';
    //     //     $balance += ($purchase->grand_total)-($purchase->discount);
    //     //     $temp['balance'] = $balance;
    //     //     array_push($tableData,$temp);
    //     //     $paidInvoices = DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->orderby('date','asc')->get();
    //     //     foreach($paidInvoices as $invoice)
    //     //     {
    //     //         $temp1 = array();
    //     //         $temp1['date'] = $invoice->date;
    //     //         $temp1['invoiceNumber'] = $invoice->job;
    //     //         $temp1['debit'] = '';
    //     //         $temp1['credit'] = $invoice->amount;
    //     //         $balance -= $invoice->amount;
    //     //         $temp1['balance'] = $balance;
    //     //         array_push($tableData,$temp1);
    //     //     }
    //     // }
    //     // function cmp($a, $b) {
    //     //     $dateA = strtotime($a['date']);
    //     //     $dateB = strtotime($b['date']);
    //     //     return $dateA - $dateB;
    //     // }
    //     foreach($totalPurchasesInPeriod as $purchase)
    //     {
    //         $paidAmount += DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->sum('amount');

    //         $temp = array();
    //         $temp['date'] = $purchase->sales_date;
    //         $temp['invoiceNumber'] = $purchase->invoice_number;
    //         $temp['debit'] = ($purchase->grand_total)-($purchase->discount);
    //         $temp['credit'] = '';
    //         $balance += ($purchase->grand_total)-($purchase->discount);
    //         // $temp['balance'] = $balance;
    //         array_push($tableData,$temp);
    //         $paidInvoices = DB::table('daybooks')->where('job',$purchase->invoice_number)->where('type','Income')->orderby('date','asc')->get();
    //         foreach($paidInvoices as $invoice)
    //         {
    //             $temp1 = array();
    //             $temp1['date'] = $invoice->date;
    //             $temp1['invoiceNumber'] = $invoice->job;
    //             $temp1['debit'] = '';
    //             $temp1['credit'] = $invoice->amount;
    //             $balance -= $invoice->amount;
    //             // $temp1['balance'] = $balance;
    //             array_push($tableData,$temp1);
    //         }
    //     }

    //     usort($tableData, function ($a, $b) {
    //         return strtotime($a['date']) - strtotime($b['date']);
    //     });
    //     // return $tableData;
    //     $totalPurchaseAmount = $totalPurchaseAmount - $totalDiscount;
    //     $balanceAmount = $totalPurchaseAmount - $paidAmount;
    //     $pdf = Pdf::loadView('customers.complete_customer_report',compact('customerDetails','totalPurchaseAmount','balanceAmount','openingBalance','tableData'));
    //     return $pdf->stream($customerDetails->name.' - Customer Sales Report.pdf',array("Attachment"=>false));
    // }
    public function generateCompleteCustomerReport(Request $request)
    {
        $data = $request->all();
        $customerDetails = DB::table('customers')->where('id', $data['customer'])->first();
        $tableData = array();
        $totalPurchaseAmountBefore = DB::table('direct_sales')->where('customer_id', $data['customer'])->sum('grand_total');
        $totalDiscountBefore = DB::table('direct_sales')->where('customer_id', $data['customer'])->sum('discount');
        $totalPurchasesBeforePeriod = DB::table('direct_sales')->where('customer_id', $data['customer'])->get();
        $paidAmountBeforePeriod = 0;
        foreach ($totalPurchasesBeforePeriod as $purchase) {
            $paidAmountBeforePeriod += DB::table('daybooks')->where('job', $purchase->invoice_number)->where('type', 'Income')->sum('amount');
        }
        $openingBalance = 0;
        $totalPurchaseAmount = DB::table('direct_sales')->where('customer_id', $data['customer'])->sum('grand_total');
        $totalDiscount = DB::table('direct_sales')->where('customer_id', $data['customer'])->sum('discount');
        $totalPurchasesInPeriod = DB::table('direct_sales')->where('customer_id', $data['customer'])->orderBy('sales_date', 'asc')->get();
        $paidAmount = 0;
        $balance = $openingBalance;

        foreach ($totalPurchasesInPeriod as $purchase) {
            $paidAmount += DB::table('daybooks')->where('job', $purchase->invoice_number)->where('type', 'Income')->sum('amount');
            $temp = array();
            $temp['date'] = $purchase->sales_date;
            $temp['invoiceNumber'] = $purchase->invoice_number;
            $temp['debit'] = ($purchase->grand_total) - ($purchase->discount);
            $temp['credit'] = '';
            $balance += ($purchase->grand_total) - ($purchase->discount);
            $temp['balance'] = $balance;
            array_push($tableData, $temp);
            $paidInvoices = DB::table('daybooks')
                ->select(DB::raw('date, SUM(amount) as total_amount'))
                ->where('job', $purchase->invoice_number)
                ->where('type', 'Income')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
            $tableDataIncome = [];
            foreach ($paidInvoices as $invoice) {
                $temp1 = [];
                $temp1['date'] = $invoice->date;
                $temp1['invoiceNumber'] = 'Income' ;
                $temp1['debit'] = '';
                $temp1['credit'] = $invoice->total_amount;
                $balance -= $invoice->total_amount;
                $temp1['balance'] = $balance;
                array_push($tableDataIncome, $temp1);
            }
            // Combine income records by date

            foreach ($tableDataIncome as $row) {
                $date = $row['date'];
                if (isset($tableData[$date])) {
                    if ($row['invoiceNumber'] == 'Income') {
                        $tableData[$date]['credit'] += $row['credit'];
                        $tableData[$date]['balance'] = $row['balance'];
                    }
                } else {
                    $tableData[$date] = $row;
                }
            }
        }

        // Sort tableData by date first
        usort($tableData, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $balance_data = $openingBalance;
        $combinedData = [];
        $totalCredit = 0;
        $totalDebit = 0;
        foreach ($tableData as $data) {
            if ($data['credit'] === ''){
                $direct_salesdata = DB::table('direct_sales')->where('invoice_number', $data['invoiceNumber'])->first();
                $temp2 = array();
                $temp2['date'] = $direct_salesdata->sales_date;
                $temp2['invoiceNumber'] = $data['invoiceNumber'];
                $temp2['debit'] = ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $totalDebit += ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $temp2['credit'] = '';
                $balance_data += ($direct_salesdata->grand_total) - ($direct_salesdata->discount);
                $temp2['balance'] = $balance_data;
                array_push($combinedData, $temp2);
            } elseif ($data['debit'] === '') {
                $temp3 = [];
                $temp3['date'] = $data['date'];
                $temp3['invoiceNumber'] = 'INCOME';
                $temp3['debit'] = '';
                $temp3['credit'] = $data['credit'];
                $totalCredit += $data['credit'];
                $balance_data -= $data['credit'];
                $temp3['balance'] = $balance_data;
                array_push($combinedData, $temp3);
            }
        }

        $totalPurchaseAmount = $totalPurchaseAmount - $totalDiscount;
        $balanceAmount = $totalPurchaseAmount - $paidAmount;

        $pdf = Pdf::loadView('customers.complete_customer_report', compact('customerDetails', 'totalPurchaseAmount', 'balanceAmount', 'openingBalance', 'combinedData','totalDebit','totalCredit'));

        return $pdf->stream("Individual Customer Report - $customerDetails->name.pdf",array("Attachment"=>false));
    }
    function getSellerDetails(Request $request){
        $seller = Seller::findOrFail($request->seller);
        return $seller;
    }
    //direct sales
    public function view_sale_return(){
        $returned_sales = SalesReturn::all();
        return view('direct_sales.returned_index',compact('returned_sales'));
    }
    public function view_sale_returned_items($id){
        $sale        = SalesReturn::findOrFail($id);
        $sales_items = SalesReturnItem::where('return_id',$id)->get();
        return view('direct_sales.returned_items',compact('sale','sales_items'));
    }
    public function searchBySerial()
    {
        $serial_numbers = SalesItems::where('serial_number','<>','')->get();
        $sale  = '';
        return view('direct_sales.search_by_serial', compact('serial_numbers','sale'));
    }
    public function search_by_serial_sale(Request $request)
    {
        $serial_numbers = SalesItems::where('serial_number','<>','')->get();
        $sale  = DirectSales::where('id',$request->sales_id)->first();
        return view('direct_sales.search_by_serial', compact('serial_numbers','sale'));
    }
    public function view_all_sales(){
        $sales = [];
        return view('direct_sales.all_sales',compact('sales'));
    }
    public function search_sales(Request $request){
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',

        ]);
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date   = Carbon::parse($request->end_date)->format('Y-m-d');
        $sales = DirectSales::with(['customer_detail', 'staff_detail', 'sales_items', 'consolidate_bill'])
            ->whereBetween('sales_date', [$start_date, $end_date])
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($sale) {
                $sale->message = urlencode('Dear ' . $sale->customer_detail->name .
                    ', Your invoice #' . $sale->invoice_number .
                    ' dated ' . Carbon::parse($sale->sales_date)->format('d-m-Y') .
                    ' has been generated.');

                $sale->salesCount = $sale->sales_items->count();
                $sale->total_amount = $sale->grand_total - $sale->discount;

                return $sale;
            });
        return view('direct_sales.all_sales',compact('sales'));
    }
}
