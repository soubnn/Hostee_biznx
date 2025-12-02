<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use App\Models\MarketingSummary;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marketings = Marketing::where('status','pending')->where('employee_id',Auth::user()->id)->orderBy('date','DESC')->get();
        return view('marketing.index',compact('marketings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketing.create');
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

            'date' => 'required',
            'customer_name' => 'required',
            'contact_no' => 'required|digits:10',
            'job_role' =>'required',
            'visit' =>'required',
        ]);
        $data = $request->all();
        $data['employee_id']= Auth::user()->id;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $data['date']= $date;

        $customer_name = strtoupper($request->customer_name);
        $data['customer_name']= $customer_name;
        $job_role = strtoupper($request->job_role);
        $data['job_role']= $job_role;
        if($request->company_name){
            $company_name = strtoupper($request->company_name);
            $data['company_name']= $company_name;
        }
        if($request->company_category){
            $company_category = strtoupper($request->company_category);
            $data['company_category']= $company_category;
        }
        if($request->company_place){
            $company_place = strtoupper($request->company_place);
            $data['company_place']= $company_place;
        }
        if($request->remarks){
            $remarks = strtoupper($request->remarks);
            $data['remarks']= $remarks;

        }

        $status= Marketing::create($data);
        if($status){
            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('marketing.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketings = Marketing::findORFail($id);
        return view('marketing.show',compact('marketings'));
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
        $marketing = Marketing::findOrFail($id);

        if($request->status){
            $data['status'] = $request->status;
        }
        if($request->reply){
            $data['reply'] = strtoupper($request->reply);
        }
        if($request->payment_status){
            $data['payment_status'] = strtoupper($request->payment_status);
        }

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Status Updated', 'success',["positionClass" => "toast-bottom-right"]);
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
    public function view_marketing_request()
    {
        $marketings = Marketing::where('status','pending')->orderBy('date','DESC')->get();
        return view('marketing.view_request',compact('marketings'));
    }
    public function view_approved()
    {
        $marketings = Marketing::where('status','APPROVED')->where('employee_id',Auth::user()->id)->orderBy('date','DESC')->get();
        return view('marketing.index',compact('marketings'));
    }
    public function view_rejected()
    {
        $marketings = Marketing::where('status','REJECTED')->where('employee_id',Auth::user()->id)->orderBy('date','DESC')->get();
        return view('marketing.index',compact('marketings'));
    }
    public function view_all_request()
    {
        $marketings = Marketing::where('status','<>','pending')->orderBy('date','DESC')->get();
        return view('marketing.view_all_request',compact('marketings'));
    }

    //edit marketing details

    public function marketing_edit_name(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'customer_name' => 'required',

        ]);
        $data = $request->all();
        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Customer Name Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function marketing_edit_contact(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'contact_no' => 'nullable',

        ]);
        $data = $request->all();
        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Customer Contact Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function marketing_edit_job_role(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'job_role' => 'nullable',

        ]);
        $data = $request->all();
        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Job Role Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"],["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function marketing_edit_company_name(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'company_name' => 'nullable',

        ]);
        $data = $request->all();
        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Compamy Name Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function marketing_edit_company_category(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'company_category' => 'nullable',

        ]);
        $data = $request->all();

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Company Category Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_edit_company_place(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'company_place' => 'nullable',

        ]);
        $data = $request->all();
        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Company Place Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_edit_km_to_location(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'km_to_location' => 'nullable',

        ]);
        $data = $request->all();

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Km to location Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_edit_petrol_amount(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'petrol_amount' => 'nullable',

        ]);
        $data = $request->all();

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Petrol Amount Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_edit_visit(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'visit' => 'nullable',

        ]);
        $data = $request->all();

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('No of Visits Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_edit_remarks(Request $request, $id){
        $marketing = Marketing::findOrFail($id);

        $this->validate($request, [

            'remarks' => 'nullable',

        ]);
        $data = $request->all();

        $status= $marketing->fill($data)->save();
        if($status){
            Toastr::success('Remark Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function marketing_summary()
    {
        return view('marketing.summary');
    }
    public function store_marketing_summary( Request $request)
    {

        $data = $request->all();
        $data['employee_id']= Auth::user()->id;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $data['date']= $date;


        if($request->image){
            $img= $request->file('image');
            $imgName=time().'.'.$request->file('image')->getClientOriginalName();
            $img->storeAs('public/marketing',$imgName);
            $data['image']= $imgName;
        }

        $status= MarketingSummary::create($data);
        if($status){
            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function marketing_view_summary()
    {
        $summaries = MarketingSummary::where('employee_id',Auth::user()->id)->orderBy('date','DESC')->get();
        return view('marketing.view_summary',compact('summaries'));
    }
    public function marketing_view_all_summary()
    {
        $summaries = MarketingSummary::orderBy('date','DESC')->get();
        return view('marketing.view_summary',compact('summaries'));
    }
    public function marketing_view_datewise_request($id)
    {
        $marketings = Marketing::where('status','pending')->where('employee_id',Auth::user()->id)->where('date',$id)->get();
        return view('marketing.index',compact('marketings'));
    }
    public function marketing_view_all_datewise_request($id)
    {
        $marketings = Marketing::where('date',$id)->get();
        return view('marketing.view_request',compact('marketings'));
    }
    public function marketing_approve_all(Request $request, $id)
    {
        $marketing_summary = MarketingSummary::where('id',$id)->first();

        if($request->status){
            $data['status'] = $request->status;
        }
        if($request->reply){
            $data['reply'] = strtoupper($request->reply);
        }
        if($request->payment_status){
            $data['payment_status'] = strtoupper($request->payment_status);
        }
        $summary_data['status'] = 'approved';

        $status = Marketing::where('date', '=', $marketing_summary->date)->update($data);
        $summary_status = DB::table('marketing_summaries')->where('id',$id)->update($summary_data);

        if($status && $summary_status){
            Toastr::success('Status Updated', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

}
