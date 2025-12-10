<?php

namespace App\Http\Controllers;

use App\Exports\SellerReportExport;
use App\Models\Daybook;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use Illuminate\Http\Request;
use App\Models\Seller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::with([
            'purchases.purchaseReturns',
            'payments'
        ])->get();

        foreach ($sellers as $seller) {
            $opening_balance = $seller->seller_opening_balance;

            // Calculate total purchase amount and discount
            $purchase_amount = $seller->purchases->sum(fn($purchase) => (float) $purchase->grand_total);
            $purchase_discount = $seller->purchases->sum(fn($purchase) => (float) $purchase->discount);
            // $purchase_discount = 0;

            // Calculate total purchase return amount
            $purchase_return_total = $seller->purchases->sum(function ($purchase) {
                return $purchase->purchaseReturns->sum('total');
            });

            // Calculate total paid amount
            $paid_amount = $seller->payments->sum('amount');

            // Final total balance calculation
            $seller->total_balance = round($opening_balance + $purchase_amount - $purchase_discount - $purchase_return_total - $paid_amount,2);
        }

        return view('seller.index', compact('sellers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.create');
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

        $createStatus = Seller::create($data);
        if($createStatus)
        {
            $sellerDetails = DB::table('sellers')->latest('id')->first();
        }
        else
        {
            $sellerDetails = "Error";
        }
        return response()->json($sellerDetails);
    }

    public function store1(Request $request)
    {
        $this->validate($request,[
            'seller_name' => 'required',
            'seller_opening_balance' => 'required',
            'seller_mobile' => 'required|digits:10'
        ]);
        $seller = new Seller();
        $seller->seller_name = $request->input('seller_name');
        $seller->seller_phone = $request->input('seller_phone');
        $seller->seller_city = $request->input('seller_city');
        $seller->seller_email = $request->input('seller_email');
        $seller->seller_opening_balance = $request->input('seller_opening_balance');
        $seller->seller_mobile = $request->input('seller_mobile');
        $seller->seller_area = $request->input('seller_area');
        $seller->seller_pincode = $request->input('seller_pincode');
        $seller->seller_state = $request->input('seller_state');
        $seller->seller_district = $request->input('seller_district');
        $seller->seller_state_code = $request->input('seller_state_code');
        $seller->seller_bank_acc_no = $request->input('seller_bank_acc_no');
        $seller->seller_bank_name = $request->input('seller_bank_name');
        $seller->seller_bank_ifsc = $request->input('seller_bank_ifsc');
        $seller->seller_bank_branch = $request->input('seller_bank_branch');
        $seller->seller_gst = $request->input('seller_gst');
        $seller->seller_tin = $request->input('seller_tin');
        $seller->seller_pan = $request->input('seller_pan');
        $seller->seller_status = $request->input('seller_status');
        $courier_address = $request->input('address') . '\ ' .
                           $request->input('courier_place') . '\ ' .
                           $request->input('post_office_pin') . '\ ' .
                           $request->input('district_state') . '\ ' .
                           $request->input('phone_number');
        $seller->courier_address = $courier_address;
        $createStatus = $seller->save();
        if($createStatus)
        {
            Toastr::success('Seller Added Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else
        {
            Toastr::error("Error occured", 'error', ["positionClass" => "toast-bottom-right"]);
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
        $seller = DB::table('sellers')->where('id',$id)->first();
        return view('seller.show',compact('seller'));
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

    // Editing start

    public function seller_edit_name(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, ['seller_name' => 'required']);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Name Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_phone(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Phone Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_mobile(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_mobile' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Mobile Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_city(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_city' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Place Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function seller_edit_courier_address(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $request->validate([
            // 'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'post_office_pin' => 'required|string|max:255',
            'district_state' => 'required|string|max:255',
            'phone_number' => 'required|string',
        ]);

        // $courier_address = $request->input('company_name') . '\ ' .
        $courier_address = $request->input('address') . '\ ' .
                           $request->input('place') . '\ ' .
                           $request->input('post_office_pin') . '\ ' .
                           $request->input('district_state') . '\ ' .
                           $request->input('phone_number');

        $seller->courier_address = $courier_address;
        $seller->save();

        if ($seller->wasChanged()) {
            Toastr::success('Seller Courier Address Edited Successfully', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Please try again!!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function seller_edit_area(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_area' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller City Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_email(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_email' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Email Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_pincode(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_pincode' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Pincode Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_state(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_state' => 'required',
            'seller_district' => 'required',
            'seller_state_code' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller State and District Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_account(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $this->validate($request, [
            'seller_bank_acc_no' => 'required',
            'seller_bank_branch' => 'required',
            'seller_bank_ifsc' => 'required',
            'seller_bank_name' => 'required'
        ]);

        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller Account Details Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_gst(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);


        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller GST Number Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_pan(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);


        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller GST Number Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function seller_edit_tin(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);


        $data = $request->all();
        $status = $seller->fill($data)->save();
        if($status){
            Toastr::success('Seller TIN Number Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function purchaseIndex(Request $request, $id)
    {
        $purchases = Purchase::where('seller_details',$id)->get();
        $purchase_returns = [];
        foreach ($purchases as $purchase) {
            $returns = PurchaseReturn::where('purchase_id', $purchase->id)->get();
            foreach ($returns as $return) {
                $purchaseCount = PurchaseReturnItem::where('return_id',$return->id)->count();
                $purchase_return = new \stdClass();
                $purchase_return->invoice_number = $return->invoice_number;
                $purchase_return->old_invoice_number = $purchase->invoice_no;
                $purchase_return->seller = $purchase->seller_detail->seller_name;
                $purchase_return->id = $return->id;
                $purchase_return->return_date = $return->return_date;
                $purchase_return->items = $purchaseCount;
                $purchase_returns[] = $purchase_return;
            }
        }
        return view('seller.purchaseIndex',compact('purchases','purchase_returns'));
    }

    public function sellerSummary($id)
    {
        $purchases = DB::table('purchases')->where('seller_details',$id)->get();
        $payments = DB::table('daybooks')->where('expense_id','FOR_SUPPLIER')->where('job',$id)->get();
        $summaries = array();
        foreach($purchases as $purchase)
        {
            $temp['date'] = Carbon::parse($purchase->invoice_date);
            $temp['id'] = $purchase->id;
            $temp['invoice'] = $purchase->invoice_no;
            $temp['type'] = "purchase";
            if($purchase->discount)
            {
                $amount = ((float) $purchase->grand_total) - ((float) $purchase->discount);
            }
            else
            {
                $amount = (float) $purchase->grand_total;
            }
            $temp['amount'] = $amount;
            array_push($summaries,$temp);
        }
        foreach($payments as $payment)
        {
            $temp['date'] = Carbon::parse($payment->date);
            $temp['invoice'] = $payment->id;
            $temp['amount'] = $payment->amount;
            $temp['id'] = '';
            $temp['type'] = "payment";
            array_push($summaries, $temp);
        }
        usort($summaries, function($a, $b){
            return strtotime($a['date']) - strtotime($b['date']);
        });
        return view('seller.summary',compact('summaries','id'));
    }
    public function generateCompleteSellerReport(Request $request)
    {
        $seller = Seller::findOrFail($request->seller);
        $seller_name = $seller->seller_name;

        $opening_balance = $seller->seller_opening_balance;
        $return_balance = 0;
        $purchases_balance = 0;
        $total_debit = 0;
        $total_credit = 0;
        $balance = $opening_balance;

        $seller_datas = array();
        $purchases = Purchase::where('seller_details',$seller->id)->get();
        foreach ( $purchases as $purchas ) {
            $grand_total = is_numeric($purchas->grand_total) ? (float) $purchas->grand_total : 0;
            $discount = is_numeric($purchas->discount) ? (float) $purchas->discount : 0;
            $purchas_total = $grand_total - $discount;
            $temp = array();
            $temp['date']           = $purchas->invoice_date;
            $temp['invoiceNumber']  = $purchas->invoice_no;
            $temp['debit']          = '';
            $temp['credit']         = $purchas_total;
            $temp['total_amount']   = $purchas_total;
            $purchases_balance += $purchas_total;
            $total_credit += $purchas_total;
            array_push($seller_datas, $temp);
            $returns = PurchaseReturn::where('purchase_id', $purchas->id)->get();
            foreach ($returns as $return) {
                $temp1 = array();
                $temp1['date']           = $return->return_date;
                $temp1['invoiceNumber']  = $return->invoice_number;
                $temp1['debit']          = $return->total;
                $temp1['credit']         = '';
                $temp1['total_amount']   = $return->total;
                $return_balance += $return->total;
                $total_debit += $return->total;
                array_push($seller_datas, $temp1);
            }
        }
        $paid_seller = Daybook::where('expense_id','FOR_SUPPLIER')->where('job',$seller->id )->get();
        foreach($paid_seller as $amount)
        {
            $temp = array();
            $temp['date']          = $amount->date;
            $temp['invoiceNumber'] = 'Paid';
            $temp['debit']         = $amount->amount;
            $temp['credit']        = '';
            $temp['total_amount']  = $amount->amount;
            $total_debit  += $amount->amount;
            array_push($seller_datas,$temp);
        }
        usort($seller_datas, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $final_seller_datas = array();
        foreach($seller_datas as $data)
        {
            $temp = array();
            $temp['date']          = $data['date'];
            $temp['invoiceNumber'] = $data['invoiceNumber'];
            $temp['debit']         = $data['debit'];
            $temp['credit']        = $data['credit'];
            if ( $data['credit'] == '' ) {
                $balance -= $data['total_amount'];
            }elseif ( $data['debit'] == '' ) {
                $balance += $data['total_amount'];
            }
            $temp['balance']       = $balance;
            array_push($final_seller_datas,$temp);
        }
        // return $final_seller_datas;
        $pdf = Pdf::loadView('seller.complete_seller_report',compact('seller_name','final_seller_datas','opening_balance','purchases_balance','return_balance','return_balance','balance','total_credit','total_debit'));
        return $pdf->stream($seller_name.' - Supplier Report.pdf',array("Attachment"=>false));
    }
    public function generateSellerReport(Request $request)
    {


        $data = $request->all();
        $seller = Seller::findOrFail($request->seller);
        $seller_name = $seller->seller_name;
        $currentDate = Carbon::now();
        $startDate = $currentDate->format('Y-m-d');
        $endDate = $currentDate->format('Y-m-d');
        $dateRange = $data['report_type'] ?? 'current_financial_year';
        $financialYearStart = Carbon::create($currentDate->year, 4, 1);
        $financialYearEnd = Carbon::create($currentDate->year + 1, 3, 31);

        switch ($dateRange) {
            case 'current_month':
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;

            case 'current_financial_year':
                if ($currentDate->month >= 4) {
                    $startDate = $financialYearStart->format('Y-m-d');
                    $endDate = $financialYearEnd->format('Y-m-d');
                } else {
                    $startDate = $financialYearStart->subYear()->format('Y-m-d');
                    $endDate = $financialYearEnd->subYear()->format('Y-m-d');
                }
                break;

            case 'last_financial_year':
                if ($currentDate->month >= 4) {
                    $startDate = Carbon::create($currentDate->year - 1, 4, 1)->format('Y-m-d');
                    $endDate = Carbon::create($currentDate->year, 3, 31)->format('Y-m-d');
                } else {
                    $startDate = Carbon::create($currentDate->year - 2, 4, 1)->format('Y-m-d');
                    $endDate = Carbon::create($currentDate->year - 1, 3, 31)->format('Y-m-d');
                }
                break;

            case 'complete':
                $startDate = '2020-01-01';
                $endDate =  Carbon::now()->format('Y-m-d');
                break;

            case 'select_date_range':
                $this->validate($request, [
                    'startDate' => 'nullable|date',
                    'endDate' => 'nullable|date|after:startDate',
                ]);
                $startDate = Carbon::parse($data['startDate'])->format('Y-m-d');
                $endDate = Carbon::parse($data['endDate'])->format('Y-m-d');
                break;

            default:
                return back()->withErrors('Invalid date range selection');
        }

        $purchases_grand_total = Purchase::where('seller_details',$seller->id)->whereBetween('invoice_date', [$startDate, $endDate])->sum('grand_total');
        $purchases_discount = Purchase::where('seller_details',$seller->id)->whereBetween('invoice_date', [$startDate, $endDate])->sum('discount');
        $purchases_amount = $purchases_grand_total - $purchases_discount;

        $prv_purchases_grand_total = Purchase::where('seller_details',$seller->id)->where('invoice_date','<',$startDate)->sum('grand_total');
        $prv_purchases_discount = Purchase::where('seller_details',$seller->id)->where('invoice_date','<',$startDate)->sum('discount');
        $prv_purchases_amount = $prv_purchases_grand_total - $prv_purchases_discount;
        $prv_paid_seller_amount = Daybook::where('expense_id','FOR_SUPPLIER')->where('job',$seller->id )->where('date','<', $startDate)->sum('amount');

        $opening_balance = $seller->seller_opening_balance;
        $return_amount = 0;
        $prv_return_amount = 0;
        $total_debit = 0;
        $total_credit = 0;

        $seller_datas = array();
        $purchases = Purchase::where('seller_details',$seller->id)->get();
        foreach ( $purchases as $purchas ) {
            $grand_total = is_numeric($purchas->grand_total) ? (float) $purchas->grand_total : 0;
            $discount = is_numeric($purchas->discount) ? (float) $purchas->discount : 0;
            $purchas_total = $grand_total - $discount;
            $temp = array();
            $temp['date']           = $purchas->invoice_date;
            $temp['invoiceNumber']  = $purchas->invoice_no;
            $temp['debit']          = '';
            $temp['credit']         = $purchas_total;
            $temp['total_amount']   = $purchas_total;
            array_push($seller_datas, $temp);
            $returns = PurchaseReturn::where('purchase_id', $purchas->id)->get();
            $return_amount += PurchaseReturn::where('purchase_id', $purchas->id)->whereBetween('return_date', [$startDate, $endDate])->sum('total');
            $prv_return_amount += PurchaseReturn::where('purchase_id', $purchas->id)->where('return_date','<', $startDate)->sum('total');
            foreach ($returns as $return) {
                $temp1 = array();
                $temp1['date']           = $return->return_date;
                $temp1['invoiceNumber']  = $return->invoice_number;
                $temp1['debit']          = $return->total;
                $temp1['credit']         = '';
                $temp1['total_amount']   = $return->total;
                array_push($seller_datas, $temp1);
            }
        }
        $paid_seller = Daybook::where('expense_id','FOR_SUPPLIER')->where('job',$seller->id )->get();
        $prv_opening_balance = $prv_purchases_amount - ( $prv_paid_seller_amount + $prv_return_amount);
        $opening_balance += $prv_opening_balance;
        $balance = $opening_balance;
        foreach($paid_seller as $amount)
        {
            $temp = array();
            $temp['date']          = $amount->date;
            $temp['invoiceNumber'] = 'Paid';
            $temp['debit']         = $amount->amount;
            $temp['credit']        = '';
            $temp['total_amount']  = $amount->amount;
            array_push($seller_datas,$temp);
        }
        $seller_datas = array_filter($seller_datas, function ($data) use ($startDate, $endDate) {
            $date = strtotime($data['date']);
            return $date >= strtotime($startDate) && $date <= strtotime($endDate);
        });
        usort($seller_datas, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $final_seller_datas = array();
        foreach($seller_datas as $data)
        {
            $temp = array();
            $temp['date']          = $data['date'];
            $temp['invoiceNumber'] = $data['invoiceNumber'];
            $temp['debit']         = $data['debit'];
            $temp['credit']        = $data['credit'];
            if ( $data['credit'] == '' ) {
                $balance -= $data['total_amount'];
                $total_credit += $data['total_amount'];
            }elseif ( $data['debit'] == '' ) {
                $balance += $data['total_amount'];
                $total_debit  += $data['total_amount'];
            }
            $temp['balance']       = number_format($balance, 2);
            array_push($final_seller_datas,$temp);
        }
        if ($request->type == "PDF") {
            $pdf = Pdf::loadView('seller.seller_report', compact('seller_name', 'startDate', 'endDate', 'purchases_amount', 'opening_balance', 'return_amount', 'final_seller_datas', 'balance', 'total_debit', 'total_credit'));
            return $pdf->stream($startDate.' to '.$endDate.' - '.$seller_name, array("Attachment" => false));
        }

        if ($request->type == "EXCEL") {
            $fileName = $startDate . ' to ' . $endDate . ' - ' . $seller_name . '.csv';
            return Excel::download(new SellerReportExport($final_seller_datas, $seller_name, $startDate, $endDate), $fileName);
        }
    }
    public function seller_courier($id)
    {
        $seller = Seller::findOrFail($id);
        $pdf = Pdf::loadView('seller.courier_pdf',compact('seller'))->setPaper('a4', 'landscape');
        return $pdf->stream('courier.pdf');
    }
}

