<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DaybookService;
use App\Models\DirectSales;
use App\Models\Field;
use App\Models\FieldPurchase;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heading = 'Pending';
        $works = Field::where('status','pending')->orderBy('id','DESC')->get();
        return view('field.index',compact('works','heading'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();
        return view('field.create', compact('customers'));
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
            'date'=> 'required',
            'customer'=> 'required',
            'phone'=> 'required|digits:10',
            'place'=> 'required',
            'work'=> 'required'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['add_by'] = Auth::user()->name;
            $status = Field::create($data);

            if ($status) {
                $today = Carbon::now()->format('Y-m-d');
                $daybookService = DaybookService::where('date',$today)->where('daybook_service',$status->customer)->first();
                if(empty($daybookService)){
                    $datasave = new DaybookService();
                    $datasave->date = $today;
                    $datasave->daybook_service = $status->customer;
                    $datasave->save();
                }
                DB::commit();
                Toastr::success('Work Added', 'success', ["positionClass" => "toast-bottom-right"]);
            } else {
                DB::rollBack();
                Toastr::error('Failed to add work!', 'error', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }

            $field = DB::table('fields')->latest()->first();
            return redirect()->route('field.show', $field->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Work Creation Error: ' . $e->getMessage());
            Toastr::error('An error occurred while adding the work. Please try again!', 'error', ["positionClass" => "toast-bottom-right"]);
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
        $work = Field::findOrFail($id);
        $invoices = DirectSales::where('customer_id',$work->customer)->orderBy('id', 'desc')->get();
        return view('field.show',compact('work','invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $work = Field::findOrFail($id);
        $this->validate($request, [
            'date'=> 'required',
            'customer'=> 'required',
            'phone'=> 'required',
            'place'=> 'required',
            'work'=> 'required'
        ]);
        $data = $request->all();
        // unset($data['_token']);
        // unset($data['_method']);

        $status = $work->fill($data)->save();
        if ($status) {
            $today = Carbon::now()->format('Y-m-d');

            $daybookService = DaybookService::where('date', $today)
                ->where('daybook_service', $request->customer)
                ->first();

            if (empty($daybookService)) {
                $datasave = new DaybookService();
                $datasave->date = $today;
                $datasave->daybook_service = $request->customer;
                $datasave->save();
            }
            Toastr::success('Work Edited', 'success',["positionClass" => "toast-bottom-right"]);
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
    public function view_delivered($id)
    {
        $date = Carbon::parse($id)->format('Y-m-d');
        $filteredWorks = Field::where('status', 'delivered')->orderBy('id', 'DESC')->get();
        $works = [];
        foreach ($filteredWorks as $work) {
            $formattedDate = Carbon::parse($work->delivered_date)->format('Y-m-d');
            if ($date == $formattedDate) {
                $works[] = $work;
            }
        }
        $heading = 'Completed';

        return view('field.index', compact('works', 'heading'));
    }
    public function view_date_delivered()
    {
        $works = Field::where('status', 'delivered')->orderBy('id', 'DESC')->get();
        $dates = [];
        foreach ($works as $work) {
            $formattedDate = Carbon::parse($work->delivered_date)->format('d-m-Y');
            $dates[] = $formattedDate;
        }
        $dates = array_unique($dates);
        return view('field.delivered', compact('dates'));
    }
    public function view_canceled()
    {
        $heading = 'Canceled';
        $works = Field::where('status','canceled')->orderBy('id','DESC')->get();
        return view('field.index',compact('works','heading'));
    }
    public function view_all()
    {
        $heading = 'Canceled';
        $works = Field::orderBy('id','DESC')->get();
        return view('field.index',compact('works','heading'));
    }
    public function view_approved()
    {
        $heading = 'Approved';
        $works = Field::where('status','approved')->orderBy('id','DESC')->get();
        return view('field.index',compact('works','heading'));
    }
    public function store_purchase(Request $request, $id){
        $this->validate($request, [
            'date'=> 'required',
            'seller'=> 'required',
            'amount'=> 'required',
            'qty'=> 'required',
        ]);
        $data = $request->all();
        $data['field_id'] = $id;

        if($request->bill){
            $bill= $request->file('bill');
            $billName=time().'.'.$request->file('bill')->getClientOriginalName();
            $bill->storeAs('public/field/',$billName);
            $data['bill']= $billName;
        }
        $data['add_date'] = Carbon::now();
        $data['add_by']   = Auth::user()->name;
        
        $status = FieldPurchase::create($data);
        if($status){
            Toastr::success('Purchase Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function store_invoice(Request $request, $id)
    {
        $this->validate($request, [
            'invoice' => 'required|exists:direct_sales,id',
        ]);

        $work = Field::findOrFail($id);
        $work->invoice_date = Carbon::now();
        $work->invoice_add_by   = Auth::user()->name;
        $invoiceId = $request->input('invoice');
        $work->invoice = $invoiceId;
        $status = $work->save();

        if ($status) {
            Toastr::success('Invoice Added', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }

    public function update_purchase(Request $request, $id)
    {
        $purchase = FieldPurchase::findOrFail($id);
        $this->validate($request, [
            'date'=> 'required',
            'seller'=> 'required',
            'amount'=> 'required',
        ]);
        $data = $request->all();
        if($request->bill){
            $bill= $request->file('bill');
            $billName=time().'.'.$request->file('bill')->getClientOriginalName();
            $bill->storeAs('public/field/',$billName);
            $data['bill']= $billName;
        }
        $status = $purchase->fill($data)->save();

        if($status){
            Toastr::success('Purchase Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function deliver($id)
    {
        try {
            DB::beginTransaction();
            $data['delivered_staff'] = Auth::user()->name;
            $data['delivered_date'] = Carbon::now()->format('Y-m-d\TH:i');
            $data['status'] = 'delivered';
            $statusUpdate = Field::where('id', $id)->update($data);

            if ($statusUpdate) {
                $work = Field::findOrFail($id);
                $today = Carbon::now()->format('Y-m-d');
                $daybookService = DaybookService::where('date',$today)->where('daybook_service',$work->customer)->first();
                if(empty($daybookService)){
                    $datasave = new DaybookService();
                    $datasave->date = $today;
                    $datasave->daybook_service = $work->customer;
                    $datasave->save();
                }
                DB::commit();
                Toastr::success('Work Delivered', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->route('field.index');
            } else {
                DB::rollBack();
                Toastr::error('Failed to update work status!', 'error', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delivery Error: ' . $e->getMessage());
            Toastr::error('An error occurred while delivering the work. Please try again!', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function cancel($id){
        $data['delivered_staff'] = Auth::user()->name;
        $data['delivered_date'] = Carbon::now()->format('Y-m-d\TH:i');
        $data['status'] = 'canceled';
        $status = DB::table('fields')->where('id',$id)->update($data);
        if($status){
            Toastr::success('Work Canceled', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->route('field.index');
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function approve($id){
        $feild_work = Field::findOrFail($id);
        $feild_work->status = 'approved';
        $status = $feild_work->save();
        if($status){
            Toastr::success('Work Approved', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }

    }
    public function approve_date($id){
        $date = Carbon::parse($id)->format('Y-m-d');
        $filteredWorks = Field::where('status', 'delivered')->orderBy('id', 'DESC')->get();
        $status = true;
        foreach ($filteredWorks as $work) {
            $formattedDate = Carbon::parse($work->delivered_date)->format('Y-m-d');
            if ($date == $formattedDate) {
                $work->status = 'approved';
                if (!$work->save()) {
                    $status = false;
                }
            }
        }
        if ($status) {
            Toastr::success('Work Approved', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    //ajax
    public function getCustomers(Request $request)
    {
        $contact = $request->get('contact');
        $customers = Customer::where('mobile', 'like', '%' . $contact . '%')->get();

        return response()->json($customers);
    }
}
