<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItems;
use App\Models\Seller;
use App\Models\stock;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseReportExport;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::orderBy('id','DESC')->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase.create');
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
            'invoice_no' => 'required|unique:purchases',
            'seller_details' => 'required',
            'invoice_date' => 'required',
            'delivery_date' => 'required'
        ]);

        $data = array();
        $data['ref_no'] = strtoupper($request->get('ref_no'));
        $data['transaction_type'] = strtoupper($request->get('transaction_type'));
        $data['invoice_no'] = strtoupper($request->get('invoice_no'));
        $data['invoice_date'] = strtoupper($request->get('invoice_date'));
        $data['delivery_date'] = strtoupper($request->get('delivery_date'));
        $data['seller_details'] = strtoupper($request->get('seller_details'));
        $data['discount'] = strtoupper($request->get('discount'));
        $data['grand_total'] = strtoupper($request->get('grand_total'));
        $data['date']        = Carbon::now();
        $data['add_by']      = Auth::user()->name;
        
        $status = Purchase::create($data);
        if($status)
        {
            $purchaseDetails = DB::table('purchases')->latest('id')->first();
            $products = $request->get('productSelect');
            $unitPrice = $request->get('unitPrice');
            $productQty = $request->get('productQty');
            $productTax = $request->get('productTax');
            $total = $request->get('total');

            for($i = 0; $i < count($products); $i++)
            {
                $data1 = [
                    'purchase_id' => $purchaseDetails->id,
                    'product_id' => $products[$i],
                    'unit_price' => $unitPrice[$i],
                    'product_quantity' => $productQty[$i],
                    'gst_percent' => $productTax[$i],
                    'purchase_price' => $total[$i],
                    'purchase_date' => $purchaseDetails->invoice_date
                ];
                $status1 = PurchaseItems::create($data1);
                if($status1)
                {
                    $stockCount = DB::table('stocks')->where('product_id',$products[$i])->count();
                    if($stockCount > 0)
                    {
                        $stockDetails = DB::table('stocks')->where('product_id',$products[$i])->first();
                        $stockDetails->product_unit_price = $unitPrice[$i];
                        $newQuantity = (float) $productQty[$i];
                        $oldQuantity = (float) $stockDetails->product_qty;
                        $quantity = $newQuantity + $oldQuantity;
                        $stockDetails->product_qty = (string) $quantity;

                        $status2 = DB::table('stocks')->where('product_id',$products[$i])->update(['product_unit_price' => $stockDetails->product_unit_price,
                        'product_qty' => $stockDetails->product_qty]);
                        $updateProductPrice = DB::table('products')->where('id',$products[$i])->update(['product_price' => $stockDetails->product_unit_price]);

                    }
                    else
                    {
                        $data2['product_id'] = $products[$i];
                        $data2['product_unit_price'] = $unitPrice[$i];
                        $data2['product_qty'] = $productQty[$i];
                        $status2 = stock::create($data2);
                        $updateProductPrice = DB::table('products')->where('id',$products[$i])->update(['product_price' => $unitPrice[$i]]);
                    }
                }
            }
            if($status2)
            {
                $seller = DB::table('sellers')->where('id',$purchaseDetails->seller_details)->first();
                $sellerBalance = (float) $seller->seller_opening_balance;
                $purchaseTotal = (float) $purchaseDetails->grand_total;
                if($purchaseDetails->discount)
                {
                    $purchaseDiscount = (float) $purchaseDetails->discount;
                }
                else
                {
                    $purchaseDiscount = 0;
                }
                $amount = $purchaseTotal - $purchaseDiscount;
                $newBalance = $sellerBalance + $amount;
                // $updateBalance = DB::table('sellers')->where('id',$seller->id)->update(['seller_opening_balance'=>$newBalance]);
                // if($updateBalance)
                // {
                    Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                    return redirect()->route('purchase.show',$purchaseDetails->id);
                // }
            }
        }
        else
        {
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseItems = DB::table('purchase_items')->where('purchase_id',$id)->get();
        $purchase_id = $id;
        return view('purchase.show', compact('purchaseItems','purchase_id'));    }

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
        $this->validate($request,[
            'invoice_no' => 'required|unique:purchases,invoice_no,'.$id,
            'invoice_date' => 'required|date',
        ]);
        
        $purchase = Purchase::findOrFail($id);
        $purchase->invoice_no = $request->invoice_no;
        $purchase->invoice_date = $request->invoice_date;
        
        if($request->purchase_bill){
            $purchase_bill= $request->file('purchase_bill');
            $bill_name = time().'.'.$request->file('purchase_bill')->getClientOriginalName();
            $purchase_bill->storeAs('public/purchase',$bill_name);
            $purchase->purchase_bill = $bill_name;
        }
        $status = $purchase->save();
        if($status){
            Toastr::success('Purchase Updated', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
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

    public function purchase_report(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        $this->validate($request, [

            'end_date' => 'required|after:start_date',

        ]);
        $total_purchase_amount = 0;
        $purchase_product_count = 0;

        $purchase1 = Purchase::whereBetween('invoice_date', [$start_date, $end_date])->get();
        // return $purchase;

        $purchase_count = Purchase::whereBetween('invoice_date', [$start_date, $end_date])->count();
        foreach( $purchase1 as $purchase){
            // $date[] = $purchase->invoice_date;
            $purchase_product_count = $purchase_count + PurchaseItems::where('purchase_id', $purchase->id)->count();
            $total_purchase_amount = $total_purchase_amount + PurchaseItems::where('purchase_id', $purchase->id)->sum('purchase_price');

        }
        // return $date;

        return view('purchase.purchase_report',compact('start_date','end_date','purchase1','purchase_count','purchase_product_count','total_purchase_amount'));
    }

    public function updateBalance(Request $request)
    {
        $purchase = DB::table('purchases')->where('id',$request->purchase)->first();
        $seller = DB::table('sellers')->where('id',$purchase->seller_details)->first();
        $sellerBalance = (float) $seller->seller_opening_balance;
        $purchaseTotal = (float) $purchase->grand_total;
        if($purchase->discount)
        {
            $purchaseDiscount = (float) $purchase->discount;
        }
        else
        {
            $purchaseDiscount = 0;
        }
        $amount = $purchaseTotal - $purchaseDiscount;
        $newBalance = $sellerBalance + $amount;
        $updateBalance = DB::table('sellers')->where('id',$seller->id)->update(['seller_opening_balance'=>$newBalance]);
        if($updateBalance)
        {
            return response()->json("Success");
        }
        else
        {
            return response()->json("Error");
        }
    }

    public function generatePurchaseGSTReport(Request $request)
    {
        $output = $request->output;
        $fromDate = $request->startDate;
        $toDate = $request->endDate;

        $this->validate($request, [

            'startDate' => 'required',
            'endDate' => 'required|after:startDate',

        ]);

        $purchaseData = Purchase::whereBetween('invoice_date',[Carbon::parse($fromDate)->format('Y-m-d'),Carbon::parse($toDate)->format('Y-m-d')])->get();
        $tableData = array();
        $totalQty = 0;
        $totalTaxable = 0;
        $totalGst = 0;
        $totalTotal = 0;
        foreach($purchaseData as $purchase)
        {
            $seller = Seller::where('id',$purchase->seller_details)->first();
            $items = PurchaseItems::where('purchase_id',$purchase->id)->get();
            foreach($items as $item)
            {
                $product = Product::where('id',$item->product_id)->first();
                $temp = array();
                $temp['invoice'] = $purchase->invoice_no;
                $temp['date'] = $purchase->invoice_date;
                $temp['invoiceType'] = $purchase->transaction_type;
                $temp['GSTIN'] = $seller->seller_gst;
                $temp['customer'] = $seller->seller_name;
                $temp['place'] = $seller->seller_area;
                $temp['product'] = $product->product_name;
                $temp['hsn'] = $product->hsn_code;
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
                $temp['total'] = $item->purchase_price;
                $totalTotal += $item->purchase_price;
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
            $pdf = Pdf::loadView('purchase.report',compact('tableData','fromDate','toDate'));
            return $pdf->setPaper('A4','landscape')->stream("Techsoul - Purchase GST Report.pdf",array("Attachment"=>false));
        }
        if($output == "EXCEL")
        {
            return Excel::download(new PurchaseReportExport($tableData), 'Techsoul - Purchase Report.csv');
        }
    }
    public function add_purchase_bill(Request $request, $id ){
        $purchase = Purchase::findOrFail($id);
        if($request->purchase_bill){
            $purchase_bill= $request->file('purchase_bill');
            $bill_name = time().'.'.$request->file('purchase_bill')->getClientOriginalName();
            $purchase_bill->storeAs('public/purchase',$bill_name);
            $data['purchase_bill']= $bill_name;
            $status = $purchase->fill($data)->save();
            if($status){
                Toastr::success('Bill Added', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
        }
        else{
            Toastr::error('No File Found!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    //return
    public function view_return(){
        $returned_purchases = PurchaseReturn::all();
        return view('purchase.return_index',compact('returned_purchases'));
    }
    public function view_returned_items($id){
        $purchase = PurchaseReturn::findOrFail($id);
        $purchase_items = PurchaseReturnItem::where('return_id',$id)->get();
        return view('purchase.return_items',compact('purchase','purchase_items'));
    }
}
