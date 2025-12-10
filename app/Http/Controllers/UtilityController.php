<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Daybook;
use App\Models\DaybookBalance;
use App\Models\DirectSales;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\PurchaseItems;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\SalesItems;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\Seller;
use App\Models\stock;
use App\Models\UtilityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class UtilityController extends Controller
{
    public function utility_login()
    {
        return view('utility.index');
    }

    public function utility_check(Request $request)
    {
        if (md5($request->utility_pass) == md5("hosteeadmin")) {
            $login_user = new UtilityLog();
            $login_user->login_user = Auth::user()->name;
            $login_user->add_date   = Carbon::now();
            $login_user->save();
            Toastr::success('Welcome to Utility Mode', 'success', ["positionClass" => 'toast-bottom-right']);
            return redirect()->route('util_dash');
        } else {
            Toastr::error('Incorrect password', 'error', ["positionClass" => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    public function utility_dashboard()
    {
        return view('utility.dashboard');
    }

    public function utility_purchases()
    {
        $year = request('year', date('Y'));
        $purchases = DB::table('purchases')
            ->leftJoin('sellers', 'sellers.id', '=', 'purchases.seller_details')
            ->leftJoin('purchase_items', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->select(
                'purchases.id',
                'purchases.invoice_no',
                'purchases.invoice_date',
                'sellers.seller_name',
                DB::raw('COUNT(purchase_items.id) as item_count')
            )
            ->whereYear('purchases.invoice_date', $year)
            ->groupBy('purchases.id', 'purchases.invoice_no', 'purchases.invoice_date', 'sellers.seller_name')
            ->paginate(250);

        return view('utility.purchases', compact('purchases', 'year'));
    }

    public function util_purchase_details($id)
    {
        $purchases = DB::table('purchase_items')->where('purchase_id', $id)->get();
        return view('utility.purchase_items', compact('purchases'));
    }


    public function utility_edit_stock(Request $request)
    {
        $id = $request->id;
        $stock = DB::table('stocks')->where('id', $id)->first();

        $stock->product_unit_price = $request->price;
        $stock->product_qty = $request->qty;

        $status = DB::table('stocks')->where('id', $id)->update([
            'product_unit_price' => $stock->product_unit_price,
            'product_qty' => $stock->product_qty
        ]);

        if ($status) {
            return redirect()->back();
        }
    }

    public function utility_edit_purchase(Request $request)
    {
        $id = $request->id;
        $purchase = DB::table('purchase_items')->where('id', $id)->first();

        $purchase->unit_price = (float)$request->price;
        $purchase->product_quantity = (float)$request->qty;
        $purchase->gst_percent = (int)$purchase->gst_percent;

        $gst = ($purchase->unit_price * $purchase->product_quantity * $purchase->gst_percent) / 100;

        $purchase->purchase_price = ($purchase->unit_price * $purchase->product_quantity) + $gst;

        $status = DB::table('purchase_items')->where('id', $id)->update([
            'unit_price' => $purchase->unit_price,
            'product_quantity' => $purchase->product_quantity,
            'purchase_price' => $purchase->purchase_price
        ]);

        if ($status) {
            return redirect()->back();
        }
    }

    public function utility_update_sales(Request $request)
    {
        $sales = DirectSales::findOrFail($request->salesId);
        $customer = Customer::findOrFail($sales->customer_id);
        $currentBalance = $customer->balance;
        $paidAmount = DB::table('daybooks')->where('type', 'Income')->where('income_id', 'FROM_INVOICE')->where('job', $sales->invoice_number)->sum('amount');
        $maxDiscount = (float)$sales->grand_total - (float)$paidAmount;
        $maxDiscount = round($maxDiscount, 2);

        $this->validate($request, [
            "discount" => 'nullable|lte:' . $maxDiscount
        ]);

        if ($sales->discount) {
            $oldAmount = (float)$sales->grand_total - (float) $sales->discount;
        } else {
            $oldAmount = (float)$sales->grand_total;
        }
        $newBalance = $currentBalance - $oldAmount;
        if ($request->discount) {
            $data['discount'] = $request->discount;
            $new_blance_amount = (float)$sales->grand_total - $request->discount;
            if( $new_blance_amount == $paidAmount ){
                $data['payment_status'] = 'paid';
            }
        }
        $data['sales_staff'] = $request->sales_staff;
        $status = $sales->fill($data)->save();
        if ($status) {
            $newSales = DirectSales::findOrFail($request->salesId);
            if ($newSales->discount) {
                $newAmount = (float)$newSales->grand_total - (float) $newSales->discount;
            } else {
                $newAmount = (float)$newSales->grand_total;
            }
            $newBalance += $newAmount;
            $data1['balance'] = round($newBalance, 2);
            $updateBalanceStatus = $customer->fill($data1)->save();
            if ($updateBalanceStatus) {
                Toastr::success('Sales Edited Successfully...', 'success', ["positionClass" => 'toast-bottom-right']);
            } else {
                Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
            }
        } else {
            Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
        }
        return redirect()->back();
    }

    public function util_update_sales_item(Request $request)
    {
        $salesItem = SalesItems::findOrFail($request->id);
        $salesDetails = DirectSales::findOrFail($request->sales_id);
        $customer = Customer::findOrFail($salesDetails->customer_id);
        $currentBalance = $customer->balance;
        if ($salesDetails->discount) {
            $oldBalance = (float) $salesDetails->grand_total - (float) $salesDetails->discount;
        } else {
            $oldBalance = (float) $salesDetails->grand_total;
        }
        $data['unit_price'] = $request->unit_price;
        $data['gst_percent'] = $request->gst_percent;
        $data['sales_price'] = $request->sales_price;
        $data['serial_number'] = strtoupper($request->serial_number);
        $updateItemStatus = $salesItem->fill($data)->save();
        if ($updateItemStatus) {
            $totalAmount = DB::table('sales_items')->where('sales_id', $salesDetails->id)->sum('sales_price');
            $data1['grand_total'] = round($totalAmount, 2);
            if ($salesDetails->discount) {
                $newBalance = (float)$totalAmount - (float) $salesDetails->discount;
            } else {
                $newBalance = (float)$totalAmount;
            }
            $updateSalesStatus = $salesDetails->fill($data1)->save();
            if ($updateSalesStatus) {
                $data2['balance'] = ($currentBalance - $oldBalance) + $newBalance;
                $data2['balance'] = round($data2['balance'], 2);
                $updateBalanceStatus = $customer->fill($data2)->save();
                if ($updateBalanceStatus) {
                    Toastr::success('Item Edited Successfully...', 'success', ["positionClass" => 'toast-bottom-right']);
                } else {
                    Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
                }
            } else {
                Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
            }
        } else {
            Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
        }
        return redirect()->back();
    }

    public function util_delete_sales_item(Request $request)
    {
        $id = $request->id;
        $salesItem = SalesItems::findOrFail($id);
        $salesDetails = DirectSales::findOrFail($salesItem->sales_id);
        $product = $salesItem->product_id;
        $product_qty = $salesItem->product_quantity;
        $customer = Customer::findOrFail($salesDetails->customer_id);
        $stockDetails = stock::where('product_id', $product)->first();
        $currentQty = $stockDetails->product_qty;
        $currentBalance = $customer->balance;
        if ($salesDetails->discount) {
            $oldBalance = (float) $salesDetails->grand_total - (float) $salesDetails->discount;
        } else {
            $oldBalance = (float) $salesDetails->grand_total;
        }
        $status = DB::table('sales_items')->delete($salesItem->id);
        if ($status) {
            $itemsCount = DB::table('sales_items')->where('sales_id',$salesDetails->id)->count();
            if($itemsCount == 0)
            {
                $data1['grand_total'] = 0;
                $data1['discount'] = 0;
                $data1['print_status'] = 'cancelled';
                $data1['payment_status'] = 'cancelled';
            }
            else
            {
                $totalAmount = DB::table('sales_items')->where('sales_id', $salesDetails->id)->sum('sales_price');
                $data1['grand_total'] = round($totalAmount, 2);
                if ($salesDetails->discount) {
                    $newBalance = (float) $totalAmount - (float) $salesDetails->discount;
                } else {
                    $newBalance = (float) $totalAmount;
                }
            }
            $updateSalesStatus = $salesDetails->fill($data1)->save();
            if ($updateSalesStatus) {
                $data2['balance'] = ($currentBalance - $oldBalance) + $newBalance;
                $data2['balance'] = round($data2['balance'], 2);
                $updateBalanceStatus = $customer->fill($data2)->save();
                if ($updateBalanceStatus) {
                    $newQty = $currentQty + $product_qty;
                    $data3['product_qty'] = $newQty;
                    $updateStockStatus = $stockDetails->fill($data3)->save();
                    if ($updateStockStatus) {
                        Toastr::success('Item Deleted Successfully...', 'success', ["positionClass" => 'toast-bottom-right']);
                        if($itemsCount == 0)
                        {
                            return redirect()->route('utility_sales');
                        }
                    } else {
                        Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
                    }
                } else {
                    Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
                }
            } else {
                Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
            }
        } else {
            Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
        }
        return redirect()->back();
    }

    public function util_new_sales_item(Request $request)
    {
        $product_id = $request->product_id;
        $stockDetails = stock::where('product_id', $product_id)->first();
        $maxQty = $stockDetails->product_qty;

        $this->validate($request, [
            "product_quantity" => 'required|lte:' . $maxQty
        ]);

        $sales = DirectSales::findOrFail($request->sales_id);
        $customer = Customer::findOrFail($sales->customer_id);
        $currentBalance = $customer->balance;
        if ($sales->discount) {
            $oldAmount = (float)$sales->grand_total - (float) $sales->discount;
        } else {
            $oldAmount = (float)$sales->grand_total;
        }
        $newBalance = $currentBalance - $oldAmount;
        $data['product_id'] = $request->product_id;
        $data['product_quantity'] = $request->product_quantity;
        $data['unit_price'] = $request->unit_price;
        $data['gst_percent'] = $request->gst_percent;
        $data['sales_price'] = $request->sales_price;
        $data['sales_id'] = $request->sales_id;
        $data['serial_number'] = strtoupper($request->serial_number);
        $updateItemStatus = SalesItems::create($data);
        if ($updateItemStatus) {
            $qty = (float) $data['product_quantity'];
            $stockQty = (float) $stockDetails->product_qty;
            $newQty = $stockQty - $qty;
            $updateStockBalance = DB::table('stocks')->where('product_id',$data['product_id'])->update(['product_qty' => $newQty]);
            if($updateStockBalance)
            {
                $totalAmount = DB::table('sales_items')->where('sales_id', $sales->id)->sum('sales_price');
                $data1['grand_total'] = round($totalAmount, 2);
                if ($sales->discount) {
                    $newBalance = (float)$totalAmount - (float) $sales->discount;
                } else {
                    $newBalance = (float)$totalAmount;
                }
                $updateSalesStatus = $sales->fill($data1)->save();
                if ($updateSalesStatus) {
                    $data2['balance'] = ($currentBalance - $oldAmount) + $newBalance;
                    $data2['balance'] = round($data2['balance'], 2);
                    $updateBalanceStatus = $customer->fill($data2)->save();
                    if ($updateBalanceStatus) {
                        Toastr::success('New Item Added Successfully...', 'success', ["positionClass" => 'toast-bottom-right']);
                    } else {
                        Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
                    }
                } else {
                    Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
                }
            }
        } else {
            Toastr::error('Please try again...', 'error', ["positionClass" => 'toast-bottom-right']);
        }
        return redirect()->back();
    }

    public function util_convert_invoice(Request $request)
    {
        try {
            $current_month = Carbon::now()->format('m');
            $direct_sale = DirectSales::where('invoice_number', $request->invoice)->first();
            $direct_sale_month = Carbon::parse($direct_sale->sales_date)->format('m');

            if ($current_month == $direct_sale_month) {
                $inv = $request->invoice;
                $invoiceType = substr($inv, 0, 3);
                if ($invoiceType == "B2B") {
                    $isGst = "No";
                    $invoice = DB::table('invoices')->where('is_gst', "No")->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-", $invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = "B2C-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                if ($invoiceType == "B2C") {
                    $isGst = "Yes";
                    $invoice = DB::table('invoices')->where('is_gst', "Yes")->latest('id')->first();
                    $invoiceNumber = $invoice->invoice_no;
                    $invoiceNumberArray = explode("-", $invoiceNumber);
                    $invoiceCount = $invoiceNumberArray[1];
                    $invoiceCount++;
                    $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                    $newInvoiceNumber = "B2B-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
                $salesDetails = DB::table('direct_sales')->where('invoice_number', $inv)->first();
                $customerDetails = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
                if($customerDetails->gst_no)
                {
                    $gstNumber = $customerDetails->gst_no;
                }
                else
                {
                    $gstNumber = '';
                }
                $updateSales = DB::table('direct_sales')->where('invoice_number', $inv)->update(['invoice_number' => $newInvoiceNumber,'gst_number'=>$gstNumber,'is_gst'=>$isGst]);
                $daybooks = DB::table('daybooks')->where('type', 'Income')->where('job', $inv)->where('income_id', 'FROM_INVOICE')->get();
                foreach ($daybooks as $daybook) {
                    $updateDaybook = DB::table('daybooks')->where('id', $daybook->id)->update(['job' => $newInvoiceNumber]);
                }
                $consignment = DB::table('consignments')->where('invoice_no', $inv)->first();
                if ($consignment) {
                    $updateConsignment = DB::table('consignments')->where('id', $consignment->id)->update(['invoice_no' => $newInvoiceNumber]);
                }
                $data['sales_id'] = $salesDetails->id;
                $data['is_gst'] = $isGst;
                $data['invoice_no'] = $newInvoiceNumber;
                $status = Invoice::create($data);
                Toastr::success('Changed B2B/B2C Successfully...', 'success', ["positionClass" => 'toast-bottom-right']);
                return redirect()->back();
            } else {
                throw new \Exception('Error: Cannot convert invoice in a different month.');
            }
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'error', ["positionClass" => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    public function util_convert_data()
    {
        return view('utility.masters_conversion');
    }
    //sales edit
    public function utility_sales()
    {
        $sales = DirectSales::whereIn('payment_status',['not_paid','partial'])->orderBy('id','DESC')->get();
        return view('utility.sales',compact('sales'));
    }
    public function util_sales_details($id)
    {
        $sales = SalesItems::where('sales_id', $id)->get();
        if(!$sales)
        {
            $sales = array();
        }
        $salesDetails = DirectSales::where('id', $id)->first();
        return view('utility.sales_items', compact('sales', 'salesDetails'));
    }

    //sales cancel
    function utility_sales_cancel(){
        $sales = DirectSales::where('payment_status','paid')->orderBy('id','DESC')->get();
        return view('utility.sales_cancel',compact('sales'));
    }
    public function util_sales_details_cancel($id)
    {
        $sales = SalesItems::where('sales_id', $id)->get();
        if(!$sales)
        {
            $sales = array();
        }
        $salesDetails = DirectSales::where('id', $id)->first();
        return view('utility.sales_items_cancel', compact('sales', 'salesDetails'));
    }
    public function util_sales_return(Request $request, $id)
    {
        try {
            $sale = DirectSales::findOrFail($id);
            $grand_total = $sale->grand_total - $sale->discount;

            $sale->discount = 0;
            $sale->grand_total = 0;
            $sale->payment_status = 'cancelled';
            $sale->print_status = 'cancelled';
            $sale->save();

            $sale_items = SalesItems::where('sales_id', $id)->get();
            foreach ($sale_items as $item) {
                $stock = stock::where('product_id', $item->product_id)->first();
                $stock->increment('product_qty', $item->product_quantity);
            }

            SalesItems::where('sales_id', $id)->delete();

            $date = Carbon::now()->format('Y-m-d');
            $daybook = new Daybook();
            $daybook->date = $date;
            $daybook->expense_id = '64';
            $daybook->description = 'SALES RETURN OF INVOICE ' . $sale->invoice_number;
            $daybook->amount = $grand_total;
            $daybook->type = 'Expense';
            $daybook->accounts = $request->payment_method;
            $daybook_status = $daybook->save();

            if ($daybook_status) {
                $currentDayCount = DaybookBalance::where('date', $date)->count();
                if ($currentDayCount === 0) {
                    $latest_daybook_balance = DaybookBalance::latest('id')->first();
                    $daybook_balance = new DaybookBalance();
                    $daybook_balance->date = $date;
                    $daybook_balance->ledger_balance = 0;
                    if ($request->payment_method === 'ACCOUNT') {
                        $daybook_balance->account_balance = ($latest_daybook_balance->account_balance) - $grand_total;
                        $daybook_balance->cash_balance = $latest_daybook_balance->cash_balance;
                    } elseif ($request->payment_method === 'CASH') {
                        $daybook_balance->account_balance = $latest_daybook_balance->account_balance;
                        $daybook_balance->cash_balance = ($latest_daybook_balance->cash_balance) - $grand_total;
                    }
                    $daybook_balance->save();
                } else {
                    $daybook_balance = DaybookBalance::where('date', $date)->first();
                    $daybook_balance->cash_balance = 0;
                    if ($request->payment_method === 'ACCOUNT') {
                        $daybook_balance->account_balance = ($daybook_balance->account_balance) - $grand_total;
                    } elseif ($request->payment_method === 'CASH') {
                        $daybook_balance->cash_balance = ($daybook_balance->cash_balance) - $grand_total;
                    }
                    $daybook_balance->save();
                }
                Toastr::success('Sales Cancelled', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->route('util_sales.cancel');
            } else {
                Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error('An error occurred during sales return: ' . $e->getMessage());
            Toastr::error('An error occurred during sales return. Please try again later.', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }

    }
    public function util_unpaid_sales_return(Request $request, $id)
    {
        try {
            $sale = DirectSales::findOrFail($id);
            $grand_total = $sale->grand_total - $sale->discount;

            $sale->discount = 0;
            $sale->grand_total = 0;
            $sale->payment_status = 'cancelled';
            $sale->print_status = 'cancelled';
            $sale->save();

            $sale_items = SalesItems::where('sales_id', $id)->get();
            foreach ($sale_items as $item) {
                $stock = stock::where('product_id', $item->product_id)->first();
                $stock->increment('product_qty', $item->product_quantity);
            }

            $status = SalesItems::where('sales_id', $id)->delete();

            if ($status) {
                Toastr::success('Sales Cancelled', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->route('util_sales.cancel');
            } else {
                Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error('An error occurred during sales return: ' . $e->getMessage());
            Toastr::error('An error occurred during sales return. Please try again later.', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }

    }
    //sales return
    public function sales_return(){
        $sales = DirectSales::orderBy('id', 'DESC')->where('is_gst','Yes')->get();
        return view('utility.sales.return',compact('sales'));
    }
    public function sales_return_items($id){
        $sale = DirectSales::findOrFail($id);
        $sales_items = SalesItems::where('sales_id',$id)->get();
        foreach($sales_items as $item){
            $item->returned = SalesReturnItem::where('sales_item_id',$item->id)->sum('quantity');
        }
        return view('utility.sales.return_items',compact('sale','sales_items'));
    }
    public function return_sales_items(Request $request, $id)
    {
        try {

            $invoiceCount = SalesReturn::count();
            $year = Carbon::now()->format('y');
            if($invoiceCount > 0)
            {
                $invoice = SalesReturn::latest('id')->first();
                $invoiceNumber = $invoice->invoice_number;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $invoiceCount = str_pad($invoiceCount, 3, '0', STR_PAD_LEFT);
                if($year > $invoiceNumberArray[2]){
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $year;
                }
                elseif($year == $invoiceNumberArray[2]){
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
            }
            else
            {
                $newInvoiceNumber = "CN-001-".$year;
            }

            $selectedItems = $request->input('sales_item');
            $quantities = $request->input('quantity');
            $payment_status = $request->input('payment_status');
            $payment_account = $request->input('payment_method');

            $grand_total = 0;
            foreach ($selectedItems as $key => $itemId) {
                $quantity = $quantities[$key];
                $sales_item = SalesItems::findOrFail($itemId);

                $unit_price_with_tax = ($sales_item->unit_price)+(($sales_item->unit_price/100) * $sales_item->gst_percent);
                $total = round(($unit_price_with_tax) * ($quantity),2);
                $grand_total += $total;
            }
            $sales_return = new SalesReturn();
            $sales_return->return_date = Carbon::now()->format('Y-m-d');
            $sales_return->invoice_number   = $newInvoiceNumber;
            $sales_return->sale_id          = $id;
            $sales_return->total            = $grand_total;
            if ($payment_status == 'not paid'){
                $sales_return->payement_method ='Add to Customer Balance';
                $sales_return->payment_status = $payment_status;
            }
            if($payment_status == 'paid'){
                $sales_return->payment_status = $payment_status;
                $sales_return->payement_method = $payment_account;
            }
            $sales_return->date        = Carbon::now();
            $sales_return->add_by      = Auth::user()->name;
            $status2 = $sales_return->save();
            foreach ($selectedItems as $key => $itemId) {
                $quantity = $quantities[$key];
                $sales_return_item = new SalesReturnItem();
                $sales_item = SalesItems::findOrFail($itemId);

                $stock = stock::where('product_id',$sales_item->product_id)->first();
                $stock->product_qty += $quantity;

                $sales_return_item->return_date = Carbon::now()->format('Y-m-d');
                $sales_return_item->return_id   = $sales_return->id;
                $sales_return_item->sales_item_id = $itemId;
                $sales_return_item->product     = $sales_item->product_id;
                $sales_return_item->unit_price  = round(($sales_item->unit_price),2);
                $sales_return_item->tax         = $sales_item->gst_percent;
                $sales_return_item->quantity    = $quantity;
                $sales_item_total_price         = round(($sales_item->unit_price) + (($sales_item->unit_price/100) * ($sales_item->gst_percent)),2);
                $sales_return_item->total       = round(($sales_item_total_price) * ($quantity),2);
                $stock->save();
                $status = $sales_return_item->save();
            }
            $sales = DirectSales::findOrFail($id);
            $amount = $grand_total;
            if($payment_status == 'paid'){
                $daybook = new Daybook();
                $daybook->date = $sales_return->return_date;
                $daybook->job = $sales_return->invoice_number;
                $daybook->description = 'Sales Invoice No'.$sales->invoice_number;
                $daybook->amount = $amount;
                $daybook->expense_id = 'SALE_RETURN';
                $daybook->type = 'Expense';
                $daybook->accounts = $payment_account;
                $daybook->save();

                if ($daybook) {

                    $balanceCount = DaybookBalance::where('date',Carbon::parse($daybook->date)->format('Y-m-d'))->count();
                    if($balanceCount == 0)
                    {
                        $lastRow = DaybookBalance::latest('id')->first();
                        $copyRow = DaybookBalance::insert(['date' => Carbon::parse($daybook->date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
                    }
                    $latestBalance = DaybookBalance::latest('id')->first();
                    if( $payment_account == 'CASH')
                    {
                        $newCashBalance = $latestBalance->cash_balance - $amount;
                        $addBalance = DaybookBalance::where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                    }
                    if( $payment_account == 'ACCOUNT')
                    {
                        $newAccountBalance = $latestBalance->account_balance - $amount;
                        $addBalance = DaybookBalance::where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                    }
                }

            }
            if($status && $status2){
                Toastr::success('Item return added', 'success', ["positionClass" => 'toast-bottom-right']);
            }
            else{
                Toastr::error('Try again!', 'error', ["positionClass" => 'toast-bottom-right']);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Toastr::error('An error occurred: ' . $e->getMessage(), 'error', ["positionClass" => 'toast-bottom-right']);
            return redirect()->back();
        }
    }
    public function view_sale_return(){
        $returned_sales = SalesReturn::all();
        return view('utility.sales.return_index',compact('returned_sales'));
    }
    public function view_sale_returned_items($id){
        $sale = SalesReturn::findOrFail($id);
        $sales_items = SalesReturnItem::where('return_id',$id)->get();
        return view('utility.sales.returned_items',compact('sale','sales_items'));
    }
    public function credit_note($id){
        $sales_details = SalesReturn::where('id',$id)->first();
        $sales_agianst = DirectSales::where('id',$sales_details->sale_id)->first();
        $invoice_details = array();
        $invoice_details['credit_no']   = $sales_details->invoice_number;
        $invoice_details['invoice_no']  = $sales_agianst->invoice_number;
        $invoice_details['return_date'] = Carbon::parse($sales_details->return_date)->format('d-m-Y');

        $customer = Customer::where('id',$sales_agianst->customer_id)->first();
        $invoice_details['name'] = $customer->name;
        $invoice_details['customer_contact'] = $customer->mobile;

        $sales_items = SalesReturnItem::where('return_id',$id)->get();
        $net_total = 0.000;
        $net_tax = 0.000;
        $sub_total = 0.000;
        foreach($sales_items as $item)
        {
            $gst_percentage = ($item->tax/2);
            $unit_price   = number_format((float) $item->unit_price, 2, '.', '');
            $amount       = $unit_price * $item->quantity;
            $tax          = ($amount * ($item->tax/100))/2;
            $total        = $amount + ($tax * 2);
            $item->tax    = $tax;
            $item->amount = $amount;
            $item->total  = $total;
            $item->gst_percentage  = $gst_percentage;
            $sub_total    += $amount;
            $net_tax      += $tax;
            $net_total    += $total;
        }
        $invoice_details['total'] = number_format((float)$net_total, 3, '.', '');
        $discount = 0;
        $grand_total = $net_total-$discount;
        $grand_total = number_format((float)$grand_total, 3, '.', '');
        $invoice_details['sub_total'] = $sub_total;
        $invoice_details['net_tax'] = $net_tax;
        $invoice_details['net_total'] = $net_total;
        $invoice_details['discount'] = $discount;
        $invoice_details['grand_total'] = $grand_total;
        $invoice_details['sales_items'] = $sales_items;
        $invoice_details['purchase_id'] = $id;

        $pdf = Pdf::loadView('utility.sales.credit_note',compact('invoice_details'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee - Crdit Note.pdf',array("Attachment"=>false));
    }
    //purchase return
    function purchase_return(){
        $purchases = Purchase::orderBy('id', 'DESC')->get();
        return view('utility.purchases.return',compact('purchases'));
    }
    function purchase_return_items($id){
        $purchase = Purchase::findOrFail($id);
        $seller = Seller::where('id',$purchase->seller_details)->first();
        $purchase_items = PurchaseItems::where('purchase_id',$id)->get();
        foreach($purchase_items as $item){
            $item->returned = PurchaseReturnItem::where('purchase_item_id',$item->id)->sum('quantity');
        }
        $purchase_count = DB::table('purchase_items')->where('purchase_id',$purchase->id)->count();
        $purchase_products_count = DB::table('purchase_items')->where('purchase_id',$purchase->id)->sum('product_quantity');
        return view('utility.purchases.return_items',compact('purchase','purchase_items','seller','purchase_count','purchase_products_count'));
    }
    function return_purchase_items(Request $request, $id)
    {
        try {

            $invoiceCount = PurchaseReturn::count();
            $year = Carbon::now()->format('y');
            if($invoiceCount > 0)
            {
                $invoice = PurchaseReturn::latest('id')->first();
                $invoiceNumber = $invoice->invoice_number;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $invoiceCount = str_pad($invoiceCount, 3, '0', STR_PAD_LEFT);
                if($year > $invoiceNumberArray[2]){
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $year;
                }
                elseif($year == $invoiceNumberArray[2]){
                    $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                }
            }
            else
            {
                $newInvoiceNumber = "DN-001-".$year;
            }

            $selectedItems = $request->input('purchase_item');
            $quantities = $request->input('quantity');
            $payment_status = $request->input('payment_status');
            $payment_account = $request->input('payment_method');

            $grand_total = 0;
            foreach ($selectedItems as $key => $itemId) {
                $quantity = $quantities[$key];
                $purchase_item = PurchaseItems::findOrFail($itemId);

                $unit_price_with_tax = ($purchase_item->unit_price)+(($purchase_item->unit_price/100) * $purchase_item->gst_percent);
                $purchase_price = round(($unit_price_with_tax) * ($quantity),2);
                $grand_total += $purchase_price;
            }
            $purchase_return = new PurchaseReturn();
            $purchase_return->return_date = Carbon::now()->format('Y-m-d');
            $purchase_return->purchase_id = $id;
            $purchase_return->invoice_number = $newInvoiceNumber;
            $purchase_return->total       = $grand_total;
            if ($payment_status == 'not paid'){
                $purchase_return->payment_status = $payment_status;
                $purchase_return->payement_method ='Seller Balance';
            }
            if($payment_status == 'paid'){
                $purchase_return->payment_status = $payment_status;
                $purchase_return->payement_method = $payment_account;
            }
            $purchase_return->date        = Carbon::now();
            $purchase_return->add_by      = Auth::user()->name;
            $status2 = $purchase_return->save();

            foreach ($selectedItems as $key => $itemId) {
                $quantity = $quantities[$key];
                $purchase_return_item = new PurchaseReturnItem();
                $purchase_item = PurchaseItems::findOrFail($itemId);

                $stock = stock::where('product_id',$purchase_item->product_id)->first();
                $stock->product_qty -= $quantity;

                $purchase_return_item->return_date = Carbon::now()->format('Y-m-d');
                $purchase_return_item->return_id   = $purchase_return->id;
                $purchase_return_item->purchase_item_id = $itemId;
                $purchase_return_item->product     = $purchase_item->product_id;
                $purchase_return_item->unit_price  = $purchase_item->unit_price;
                $purchase_return_item->tax         = $purchase_item->gst_percent;
                $unit_price_with_tax               = ($purchase_item->unit_price)+(($purchase_item->unit_price/100) * $purchase_item->gst_percent);
                $purchase_return_item->quantity    = $quantity;
                $purchase_return_item->total       = round(($unit_price_with_tax) * ($quantity),2);

                $stock->save();
                $status = $purchase_return_item->save();
            }
            $purchase = Purchase::findOrFail($id);
            $amount = $grand_total;

            if ($payment_status == 'not paid'){
                $seller_balance = Seller::where('id',$purchase->seller_details)->first();
                $current_balance = $seller_balance->seller_opening_balance;
                $purchase_return_balance = $amount;
                $new_seller_balance = round($current_balance - $purchase_return_balance,2);
                // $seller_balance->update(['seller_opening_balance' => $new_seller_balance]);

            }
            if($payment_status == 'paid'){
                $daybook = new Daybook();
                $daybook->date = $purchase_return->return_date;
                $daybook->job = $purchase_return->invoice_number;
                $daybook->description = 'Purchase Invoice No'.$purchase->invoice_no;
                $daybook->amount = $amount;
                $daybook->income_id = 'PURCHASE_RETURN';
                $daybook->type = 'Income';
                $daybook->accounts = $payment_account;
                $daybook->save();

                if ($daybook) {

                    $balanceCount = DaybookBalance::where('date',Carbon::parse($daybook->date)->format('Y-m-d'))->count();
                    if($balanceCount == 0)
                    {
                        $lastRow = DaybookBalance::latest('id')->first();
                        $copyRow = DaybookBalance::insert(['date' => Carbon::parse($daybook->date), 'ledger_balance' => $lastRow->ledger_balance, 'account_balance' => $lastRow->account_balance, 'cash_balance' => $lastRow->cash_balance]);
                    }
                    $latestBalance = DaybookBalance::latest('id')->first();
                    if( $payment_account == 'CASH')
                    {
                        $newCashBalance = $latestBalance->cash_balance + $amount;
                        $addBalance = DaybookBalance::where('id',$latestBalance->id)->update(['cash_balance' => $newCashBalance]);
                    }
                    if( $payment_account == 'ACCOUNT')
                    {
                        $newAccountBalance = $latestBalance->account_balance + $amount;
                        $addBalance = DaybookBalance::where('id',$latestBalance->id)->update(['account_balance' => $newAccountBalance]);
                    }
                }

            }

            if($status && $status2){
                Toastr::success('Item return added', 'success', ["positionClass" => 'toast-bottom-right']);
            }
            else{
                Toastr::error('Try again!', 'error', ["positionClass" => 'toast-bottom-right']);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Toastr::error('An error occurred: ' . $e->getMessage(), 'error', ["positionClass" => 'toast-bottom-right']);
            return redirect()->back();
        }
    }
    public function view_return(){
        $returned_purchases = PurchaseReturn::all();
        return view('utility.purchases.return_index',compact('returned_purchases'));
    }
    public function view_returned_items($id){
        $purchase = PurchaseReturn::findOrFail($id);
        $purchase_items = PurchaseReturnItem::where('return_id',$id)->get();
        return view('utility.purchases.returned_items',compact('purchase','purchase_items'));
    }
    public function debit_note($id){
        $purchase_details = PurchaseReturn::where('id',$id)->first();
        $purchase_agianst = Purchase::where('id',$purchase_details->purchase_id)->first();
        $invoice_details = array();
        $invoice_details['debit_no']    = $purchase_details->invoice_number;
        $invoice_details['invoice_no']  = $purchase_agianst->invoice_no;
        $invoice_details['return_date'] = Carbon::parse($purchase_details->return_date)->format('d-m-Y');

        $supplier = DB::table('sellers')->where('id',$purchase_agianst->seller_details)->first();
        $invoice_details['supplier_name'] = $supplier->seller_name;
        $invoice_details['supplier_city'] = $supplier->seller_city;
        $invoice_details['supplier_contact'] = $supplier->seller_mobile;
        $invoice_details['gst_number'] = $supplier->seller_gst;

        $purchase_items = DB::table('purchase_return_items')->where('return_id',$id)->get();
        $net_total = 0.000;
        $net_tax = 0.000;
        $sub_total = 0.000;
        foreach($purchase_items as $item)
        {
            $gst_percentage = ($item->tax/2);
            $unit_price     = number_format((float) $item->unit_price, 2, '.', '');
            $amount         = $unit_price * $item->quantity;
            $tax            = ($amount * ($item->tax/100))/2;
            $total          = $amount + ($tax * 2);
            $item->tax      = $tax;
            $item->amount   = $amount;
            $item->total    = $total;
            $item->gst_percentage  = $gst_percentage;
            $sub_total      += $amount;
            $net_tax        += $tax;
            $net_total      += $total;
        }
        $invoice_details['total'] = number_format((float)$net_total, 3, '.', '');
        $discount = 0;
        $grand_total = $net_total-$discount;
        $grand_total = number_format((float)$grand_total, 3, '.', '');
        $invoice_details['sub_total'] = $sub_total;
        $invoice_details['net_tax'] = $net_tax;
        $invoice_details['net_total'] = $net_total;
        $invoice_details['discount'] = $discount;
        $invoice_details['grand_total'] = $grand_total;
        $invoice_details['purchase_items'] = $purchase_items;
        $invoice_details['purchase_id'] = $id;

        $pdf = Pdf::loadView('utility.purchases.debit_note',compact('invoice_details'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee - Debit Note.pdf',array("Attachment"=>false));
    }
}
