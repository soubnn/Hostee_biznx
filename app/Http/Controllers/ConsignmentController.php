<?php

namespace App\Http\Controllers;

use App\Models\Consignment;
use App\Models\ConsignmentAssessment;
use App\Models\Customer;
use App\Models\Daybook;
use App\Models\Sales;
use App\Models\Worktype;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Image;

class ConsignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consignments= DB::table('consignments')->where('status','<>','returned')->Where('status','<>','delivered')->where('approve_status','approved')->get();
        $consignment_count = DB::table('consignments')->where('status','<>','returned')->Where('status','<>','delivered')->where('approve_status','approved')->count();
        $page_headline = 'Approved Jobcards';
        return view('consignments.index',compact('consignments','consignment_count','page_headline'));
    }
    public function allJobcards()
    {
        $jobcard_numbers = Consignment::get();
        $customer_names = Customer::get();
        return view('consignments.search_jobcard', compact('jobcard_numbers', 'customer_names'));
    }
    public function searchJobcards(Request $request)
    {
        $request->validate([
            'search_type' => 'required',
        ]);

        $results = collect();

        if ($request->search_type == 'jobcard_number') {
            $request->validate([
                'jobcard_number' => 'required',
            ]);

            $results = Consignment::where('id', $request->jobcard_number)->get();

            if ($results->isEmpty()) {
                Toastr::error('No job card found for the selected Jobcard Number.', 'Error', ["positionClass" => "toast-bottom-right"]);
            }
        }
        elseif ($request->search_type == 'customer_name') {
            $request->validate([
                'customer_name' => 'required',
            ]);

            $results = Consignment::where('customer_name', $request->customer_name)->get();

            if ($results->isEmpty()) {
                Toastr::error('This customer does not have any job cards!', 'Error', ["positionClass" => "toast-bottom-right"]);
            }
        }

        $jobcard_numbers = Consignment::get();
        $customer_names = Customer::get();

        return view('consignments.search_jobcard', compact('jobcard_numbers', 'customer_names', 'results'));
    }
    // public function allJobcards()
    // {
    //     $consignments= DB::table('consignments')->get();
    //     $page_headline = 'All Jobcards';
    //     return view('consignments.allJobs',compact('consignments','page_headline'));
    // }
    public function pending_index()
    {
        $page_headline = 'Pending Jobcards';
        $consignments = DB::table('consignments')->whereNotIn('status', ['returned', 'rejected', 'delivered', 'informed'])->where('approve_status', 'pending')->get();
        $consignment_count = DB::table('consignments')->whereNotIn('status', ['returned', 'rejected', 'delivered', 'informed'])->where('approve_status', 'pending')->count();

        return view('consignments.index',compact('consignments','consignment_count','page_headline'));
    }
    public function informed_index()
    {
        $page_headline = 'Informed Jobcards';
        $consignments = DB::table('consignments')->where('status', '<>', 'returned')->Where('status', 'informed')->where('approve_status', 'pending')->get();
        $consignment_count = DB::table('consignments')->where('status', '<>', 'returned')->Where('status','informed')->where('approve_status', 'pending')->count();

        return view('consignments.index', compact('consignments', 'consignment_count', 'page_headline'));
    }
    public function rejected_index()
    {
        $page_headline = 'Rejected Jobcards';
        $consignments = DB::table('consignments')->where('status',  'rejected')->get();
        $consignment_count = DB::table('consignments')->where('status',  'rejected')->count();

        return view('consignments.index', compact('consignments', 'consignment_count', 'page_headline'));
    }
    public function thirdparty()
    {
        $page_headline = 'Third-Party Jobcards';
        $chiplevels = DB::table('chiplevels')->join('consignments','chiplevels.jobcard_id','=','consignments.id')->where('chiplevels.status','active')->whereIn('consignments.status',['pending','informed'])->get();
        $warrenties = DB::table('warrenties')->join('consignments','warrenties.jobcard_id','=','consignments.id')->where('warrenties.status','active')->whereIn('consignments.status',['pending','informed'])->get();
        return view('consignments.thirdparty',compact('chiplevels','warrenties','page_headline'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job_id = 0;
        return view('consignments.create',compact('job_id'));
        // return view('pages-maintenance');
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
            'email' =>'email|nullable',
            'phone' =>'required|digits:10',
            'customer_type' => 'string|required',
            'work_location' => 'required|string',
            'service_type' => 'required|string',
            'product_name' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'warranty_type' => 'required|string',
            'serial_no' => 'required|string',
            'accessories' => 'required|array|nullable',
            'physical_condition' => 'array|nullable',
            'complaints' => 'required|array|nullable',
            'remarks' => 'required|array|nullable',
            'image1' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            // return $data;
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $data['date']= $date;
            $data['add_by'] = Auth::user()->name;

            $product_name = strtoupper($request->product_name);
            $data['product_name']= $product_name;
            $serial_no = strtoupper($request->serial_no);
            $data['serial_no']= $serial_no;
            $multipleFields = [
                'accessories',
                'physical_condition',
                'complaints',
                'remarks'
            ];

            foreach ($multipleFields as $field) {
                if ($request->$field) {
                    $data[$field] = implode(", ", $request->$field);
                }
            }

            if($request->components){
                $data['components'] = implode(", ",$request->components);
            }
            if($request->image1){
                $img = $request->file('image1');
                $imgName = time() . '_' . uniqid() .'.'. $img->getClientOriginalName();
                $img = Image::make($img);
                $img->resize(500, 500);
                $path = $img->save(storage_path('app/public/images/'.$imgName));
                $data['image1']= $imgName;
            }
            if($request->image2){
                $img = $request->file('image2');
                $imgName=time() . '_' . uniqid() . '.' . $img->getClientOriginalName();
                $img = Image::make($img);
                $img->resize(500, 500);
                $path = $img->save(storage_path('app/public/images/'.$imgName));
                $data['image2']= $imgName;
            }
            if($request->image3){
                $img= $request->file('image3');
                $imgName=time() . '_' . uniqid() . '.' . $img->getClientOriginalName();
                $img = Image::make($img);
                $img->resize(500, 500);
                $path = $img->save(storage_path('app/public/images/'.$imgName));
                $data['image3']= $imgName;
            }
            if($request->image4){
                $img= $request->file('image4');
                $imgName=time() . '_' . uniqid() . '.' . $img->getClientOriginalName();
                $img = Image::make($img);
                $img->resize(500, 500);
                $path = $img->save(storage_path('app/public/images/'.$imgName));
                $data['image4']= $imgName;
            }
            if($request->image5){
                $img= $request->file('image5');
                $imgName=time() . '_' . uniqid() . '.' . $img->getClientOriginalName();
                $img = Image::make($img);
                $img->resize(500, 500);
                $path = $img->save(storage_path('app/public/images/'.$imgName));
                $data['image5']= $imgName;
            }

            $status= Consignment::create($data);

            if($status){
                // $latestJob = Consignment::latest('id')->first();
                $latestJob = $status;
                $customerDetails = DB::table('customers')->where('id',$request->customer_name)->first();

                $pdf = Pdf::loadView('consignments.details', compact('latestJob'));
                // return $pdf->stream('jobcard_preview.pdf');

                $folderPath = storage_path('app/public/jobcards/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                $shortTime = date('His');
                $fileName = 'Techsoul_Jobcard_' . $latestJob->jobcard_number . '_' . $shortTime . '.pdf';
                $pdfPath = $folderPath . $fileName;
                $pdf->save($pdfPath);

                $publicUrl = asset('storage/jobcards/' . $fileName);

                if (strlen($customerDetails->mobile) == 10) {
                    $numbers = $customerDetails->mobile;

                    $param1 = trim($customerDetails->name);
                    $param1 = explode(' ', $param1)[0];
                    $param2 = $latestJob->product_name;
                    $param3 = $latestJob->add_by;
                    $param4 = $latestJob->jobcard_number;

                    $url = "https://bhashsms.com/api/sendmsgutil.php?user=Techsoul_BW&pass=123456&sender=BUZWAP&phone=$numbers&text=service_slip&priority=wa&stype=normal&Params=$param1,$param2,$param3,$param4&htype=document&url=$publicUrl";

                    // dd([
                    //     'phone' => $numbers,
                    //     'param1' => $param1,
                    //     'param2' => $param2,
                    //     'param3' => $param3,
                    //     'param4' => $param4,
                    //     'publicUrl' => $publicUrl,
                    //     'apiUrl' => $url
                    // ]);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    // Optional: log response
                    // \Log::info('BhashSMS JobCard SMS Response: ' . $response);
                }

                DB::commit();
                Toastr::success('Job Card Added', 'success',["positionClass" => "toast-bottom-right"]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Consignment creation error: ' . $e->getMessage());
            Toastr::error('Error creating job card. Please try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('consignment.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consignments = Consignment::findOrFail($id);
        return view('consignments.show',compact('consignments'));
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
    public function view_returned()
    {
        $consignments= DB::table('consignments')->where('status','returned')->orderBy('updated_at','DESC')->get();
        return view('consignments.return',compact('consignments'));
    }
    public function view_delivered()
    {
        $consignments= DB::table('consignments')->where('status','delivered')->orderBy('updated_at','DESC')->get();
        return view('consignments.delivered',compact('consignments'));
    }
    public function approve_jobcard($id)
    {
        $consignment = Consignment::findOrFail($id);
        $data['approve_status'] = 'approved';
        $data['approved_date'] = Carbon::now();
        $data['approved_staff'] = Auth::user()->name;
        $status = $consignment->fill($data)->save();
        if($status){
            Toastr::success('jobcard approved', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function reject_jobcard($id)
    {
        $consignment = Consignment::findOrFail($id);
        // $data['approve_status'] = 'rejected';
        $data['status']         = 'rejected';
        $data['rejected_date']  = Carbon::now();
        $data['rejected_staff'] = Auth::user()->name;
        $status = $consignment->fill($data)->save();
        if ($status) {
            Toastr::success('jobcard approved', 'success', ["positionClass" => "toast-bottom-right"]);
        }
        else {
            Toastr::error('try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function print_details($id)
    {
        $latestJob = Consignment::findOrFail($id);
        $pdf = Pdf::loadView('consignments.details',compact('latestJob'));
        return $pdf->stream($latestJob->jobcard_number.'- Jobcard Details.pdf',array("Attachment"=>false));
    }
    // --------------------------------------------------------------------------------
    public function inform_consignment(Request $request, $id)
    {
        $consignments = Consignment::findOrFail($id);
        $data = $request->all();
        $data['status'] = 'informed';
        $data['informed_date'] = Carbon::now();
        $data['informed_staff'] = Auth::user()->name;

        $status = $consignments->fill($data)->save();
        if($status){
            Toastr::success('informed to customer', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function assessment_consignment(Request $request, $id)
    {
        $this->validate($request, [
            'complaint_details' => 'required',
        ]);
        $assessment_consignment = new ConsignmentAssessment();
        $assessment_consignment->consignment_id = $id;
        $assessment_consignment->staff          = Auth::user()->name;
        $assessment_consignment->date           = Carbon::now();
        $assessment_consignment->description    = $request->complaint_details;

        $status = $assessment_consignment->save();
        if ($status) {
            Toastr::success('Consignment assessment successfully recorded', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function return_consignment(Request $request, $id)
    {

        $consignments = Consignment::findOrFail($id);
        $sale_table_count = DB::table('sales')->where('job_card_id',$id)->count();


        $data = $request->all();
        if($request->gst_no){
            $data['gst_no'] = strtoupper($request->gst_no);
        }

        $data['status']         = 'returned';
        $data['return_date']    = Carbon::now();
        $data['return_staff']   = Auth::user()->name;

        $status= $consignments->fill($data)->save();

        if($sale_table_count>0){

            $sales = DB::table('sales')->where('job_card_id',$id)->get();
            if($status){
                Toastr::success('consignment returned', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
            return view('consignments.invoice',compact('consignments','sales'));
        }
        else{

            if($status){
                Toastr::success('consignment returned', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
            return redirect()->back();
        }
    }

    // ----------------------------------------------------------------------------------
    public function jobcard_edit_name(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'customer_name' => 'nullable',

        ]);
        $data = $request->all();
        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Customer Name Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_phone(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'phone' => 'required|digits:10',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Customer Phone', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_place(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'customer_place' => 'nullable',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Customer Place edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_email(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'email' => 'nullable',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Customer Email edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_customer_type(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'customer_type' => 'nullable',

        ]);

        $data = $request->all();
        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Customer Type edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }

        return redirect()->back();
    }
    public function jobcard_edit_work_location(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'work_location' => 'nullable',

        ]);

            $data = $request->all();
            $status= $consignment->fill($data)->save();

            if($status){
                Toastr::success('Work Location edited', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }

        return redirect()->back();
    }
    public function jobcard_edit_service_type(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'service_type' => 'nullable',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Service Type edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_product_name(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'product_name' => 'nullable',

        ]);
        $data = $request->all();
        $data['product_name'] = strtoupper($request->product_name);

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Product Name edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_serial_num(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'serial_no' => 'nullable',

        ]);
        $data = $request->all();
        $data['serial_no'] = strtoupper($request->serial_no);

        $status= $consignment->fill($data)->save();
        if($status){
                Toastr::success('Serial No. edited', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
        return redirect()->back();
    }
    public function jobcard_edit_complaints(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'complaints' => 'nullable',

        ]);
        $data = $request->all();


        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Complaints Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function jobcard_edit_components_recieved(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'components' => 'nullable',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Recieved Components edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_remarks(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'remarks' => 'nullable',

        ]);
        $data = $request->all();

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Remarks edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_advance(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $this->validate($request, [

            'advance' => 'nullable',

        ]);
        $data = $request->all();
        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Advance edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_image1(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $data = $request->all();

        if($request->image1){
            $img = $request->file('image1');
            $imgName = time().'.'.$img->getClientOriginalName();
            $img = Image::make($img);
            $img->resize(500, 500);
            $path = $img->save(storage_path('app/public/images/'.$imgName));
            $data['image1']= $imgName;
        }


        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Image edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function jobcard_edit_image2(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $data = $request->all();

        if($request->image2){
            $img = $request->file('image2');
            $imgName = time().'.'.$img->getClientOriginalName();
            $img = Image::make($img);
            $img->resize(500, 500);
            $path = $img->save(storage_path('app/public/images/'.$imgName));
            $data['image1']= $imgName;
        }


        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Image edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_image3(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $data = $request->all();

        if($request->image3){
            $img = $request->file('image3');
            $imgName = time().'.'.$img->getClientOriginalName();
            $img = Image::make($img);
            $img->resize(500, 500);
            $path = $img->save(storage_path('app/public/images/'.$imgName));
            $data['image1']= $imgName;
        }


        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Image edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_image4(Request $request, $id){

        $consignment = Consignment::findOrFail($id);

        $data = $request->all();

        if($request->image4){
            $img = $request->file('image4');
            $imgName = time().'.'.$img->getClientOriginalName();
            $img = Image::make($img);
            $img->resize(500, 500);
            $path = $img->save(storage_path('app/public/images/'.$imgName));
            $data['image1']= $imgName;
        }

        $status= $consignment->fill($data)->save();
        if($status){
            Toastr::success('Image edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function jobcard_edit_accessories(Request $request, $id){


        $sale_id = $request->sale_id;
        $get_sales = DB::table('sales')->where('job_card_id',$id)->where('id',$sale_id)->first();
        $sales_qty = $get_sales->qty;
        $get_product = DB::table('products')->where('id',$get_sales->product_id)->first();
        if($get_product == Null){
            $sales_status = DB::table('sales')->where('job_card_id',$id)->where('id',$sale_id)->delete();
            if($sales_status){
                Toastr::success('Accessories edited', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
        }
        else{

            $get_stocks = DB::table('stocks')->where('product_id',$get_sales->product_id)->first();
            $old_stock = $get_stocks->product_qty;
            $new_stock = $old_stock + $sales_qty;
            $update_data['product_qty'] = $new_stock;

            // return $sales_qty.' '.$old_stock.' '.$new_stock;

            $stock_status = DB::table('stocks')->where('product_id',$get_sales->product_id)->update($update_data);
            $sales_status = DB::table('sales')->where('job_card_id',$id)->where('id',$sale_id)->delete();

            if($stock_status && $sales_status){
                Toastr::success('Accessories edited', 'success',["positionClass" => "toast-bottom-right"]);
            }
            else{
                Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            }
        }
        return redirect()->back();
    }
// --------------------------------------------------------------------------------------------
    public function rework($id)
    {
        // $consignments = Consignment::findOrFail($id);
        $job_id = $id;
        return view('consignments.create',compact('job_id'));
    }


// -------------------------------------------------------------------
    public function invoice(Request $request , $id)
    {
        $consignments = Consignment::findOrFail($id);
        $consignment_id = $id;
        $customer = Customer::findOrFail($consignments->customer_name);
        $sales = DB::table('sales')->where('job_card_id',$id)->get();
        $invoice_date = Carbon::now()->format('Y-m-d');
        $amount = DB::table('sales')->where('job_card_id',$id)->sum('total');

        $data = $request->all();
        // $data_invoice['jobcard_id'] = $id;

        if($request->gst_no){
            $data['gst_no'] = strtoupper($request->gst_no);

            $invoiceCount = DB::table('invoices')->where('is_gst','Yes')->count();
            if($invoiceCount > 0)
            {
                $invoice = DB::table('invoices')->where('is_gst','Yes')->latest('id')->first();
                $invoiceNumber = $invoice->invoice_no;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                $data['invoice_no'] = $newInvoiceNumber;
                // $data_invoice['invoice_no'] = $newInvoiceNumber;
            }
            else
            {
                $data['invoice_no'] = "B2B-00001-22";
                // $data_invoice['invoice_no'] = "B2B-00001-22";
            }
            // $data_invoice['is_gst'] = 'Yes';
        }
        else{

            $invoiceCount = DB::table('invoices')->where('is_gst','No')->count();
            if($invoiceCount > 0)
            {
                $invoice = DB::table('invoices')->where('is_gst','No')->latest('id')->first();
                $invoiceNumber = $invoice->invoice_no;
                $invoiceNumberArray = explode("-",$invoiceNumber);
                $invoiceCount = $invoiceNumberArray[1];
                $invoiceCount++;
                $invoiceCount = str_pad($invoiceCount, 5, '0', STR_PAD_LEFT);
                $newInvoiceNumber = $invoiceNumberArray[0] . "-" . $invoiceCount . "-" . $invoiceNumberArray[2];
                $data['invoice_no'] = $newInvoiceNumber;
                // $data_invoice['invoice_no'] = $newInvoiceNumber;

            }
            else
            {
                $data['invoice_no'] = "B2C-00001-22";
                // $data_invoice['invoice_no'] = "B2C-00001-22";

            }
            // $data_invoice['is_gst'] = 'No';
        }
        // if($request->payment_status){
        //     $data['payment_status'] = strtoupper($request->payment_status);
        //     if($request->payment_status == 'paid'){
        //         $data['payment_method'] = strtoupper($request->payment_method);
        //         if($request->payment_method == "cash")
        //         {
        //             $data3 = array();
        //             $data3['income_id'] = "FROM_INVOICE";
        //             $data3['type'] = "Income";
        //             $data3['accounts'] = "CASH";
        //             $data3['date'] = $invoice_date;
        //             $data3['job'] = $data['invoice_no'];
        //             $data3['amount'] = $amount;
        //             $status3 = Daybook::create($data3);
        //         }
        //         if($request->payment_method == "account")
        //         {
        //             $data3 = array();
        //             $data3['income_id'] = "FROM_INVOICE";
        //             $data3['type'] = "Income";
        //             $data3['accounts'] = "ACCOUNT";
        //             $data3['date'] = $invoice_date;
        //             $data3['job'] = $data['invoice_no'];
        //             $data3['amount'] = $amount;
        //             $status3 = Daybook::create($data3);
        //         }
        //         if($request->payment_method == "ledger")
        //         {
        //             $data3 = array();
        //             $data3['income_id'] = "FROM_INVOICE";
        //             $data3['type'] = "Income";
        //             $data3['accounts'] = "LEDGER";
        //             $data3['date'] = $invoice_date;
        //             $data3['job'] = $data['invoice_no'];
        //             $data3['amount'] = $amount;
        //             $status3 = Daybook::create($data3);
        //         }
        //     }
        //     elseif($request->payment_status == 'not paid'){
        //         $user = DB::table('customers')->where('id',$consignments->customer_name)->first();
        //         if($user)
        //         {
        //             $userBalance = (float) $user->balance;
        //             $newBalance = $userBalance + $amount;
        //             $updateBalance = DB::table('customers')->where('id',$user->id)->update(['balance'=>$newBalance]);
        //         }
        //     }
        // }
        // if($consignments->status != 'printed'){
        //     $data['status'] = 'delivered';
        // }
        $status= $consignments->fill($data)->save();
        // $invoice_status = Invoice::create($data_invoice);

        return view('consignments.summary',compact('consignments','sales','customer','consignment_id'));
    }
    public function view_invoice($id)
    {
        $consignments = Consignment::findOrFail($id);
        $sales = DB::table('direct_sales')->where('invoice_number',$consignments->invoice_no)->first();

        return redirect()->route('directSales.show',$sales->id);
    }
// -------------------------------------------------------------------------------------
    public function jobcard_report()
    {
        return view('consignments.report');
    }

    public function jobcard_report_view(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

         $this->validate($request, [

            'end_date' => 'required|after:start_date',

        ]);

        $sales_count = 0;
        $total_sales_charge = 0;
        $total_service_charge = 0;
        $sales_count = 0;
        $service_count = 0;


        $get_jobcard = Consignment::whereBetween('date', [$start_date, $end_date])->get();

        $jobcard_count = Consignment::whereBetween('date', [$start_date, $end_date])->count();

        foreach( $get_jobcard as $jobcard){
            $get_sales = DB::table('sales')->where('job_card_id',$jobcard->id)->get();
            foreach( $get_sales as $sales ){
                $get_products = DB::table('products')->where('id',$sales->product_id)->first();
                if($get_products == Null){
                    $total_service_charge = $total_service_charge + $sales->total;
                    $service_count = $service_count + 1;
                }
                else{
                    $total_sales_charge = $total_sales_charge + $sales->total;
                    $sales_count = $sales_count + 1;
                }
            }
        }
        $total_amount = $total_service_charge+$total_sales_charge;

        return view('consignments.view_report',compact('start_date','end_date','get_jobcard','jobcard_count','total_service_charge','sales_count','service_count','total_sales_charge','total_amount'));
    }
    public function get_customer(Request $request)
    {

        $customer = DB::table('consignments')->distinct()->pluck('customer_name');
        return $customer;
    }
    public function deliver_without_invoice($id)
    {
        $consignments = Consignment::findOrFail($id);
        if($consignments->status != 'printed'){
            $data['status'] = 'delivered';
            $data['delivered_date']    = Carbon::now();
            $data['delivered_staff']   = Auth::user()->name;
            $status= $consignments->fill($data)->save();
        }

        return redirect()->back();
    }
    public function userJob($id)
    {
        $consignment = Consignment::findOrFail($id);
        $pdf = Pdf::loadView('consignments.details', compact('consignment'));
        return $pdf->stream('Techsoul Cyber Solutions - Jobcard Details.pdf', array("Attachment"=>false));
    }
}
