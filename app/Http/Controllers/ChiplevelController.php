<?php

namespace App\Http\Controllers;

use App\Models\Chiplevel;
use App\Models\ChiplevelServicer;
use App\Models\Warrenty;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class ChiplevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // $this->validate($request,[

        //     'service_date' => 'required',
        //     'servicer_name' => 'required',
        //     'servicer_contact' =>'required|digits:10',
        //     'staff_name' =>'required',


        // ]);
        $data = $request->all();
        // return $data;
        // $service_date = Carbon::parse($request->service_date)->format('Y-m-d');
        // $data['service_date']= $service_date;

        $status= Chiplevel::create($data);
        if($status){
            Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function service_store(Request $request , $id)
    {

        // if($service_type == 'chiplevel'){
            $this->validate($request,[
                'service_date' => 'required',
                // 'servicer_name' => 'required',
                'servicer_contact' =>'required|digits:10',
                'staff_name' =>'required',
                'courier_delivery' => 'required',
                'courier_bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
            // return $data;
            $service_type = $request->product_service_type;
            if($service_type == 'chiplevel'){

                $chiplevel_data['jobcard_id'] = $id;
                $chiplevel_data['servicer_name'] = $request->chip_servicer_name;
                $chiplevel_data['servicer_contact'] = $request->servicer_contact;
                $chiplevel_data['staff_name'] = $request->staff_name;
                $chiplevel_data['courier_delivery'] = $request->courier_delivery;
                if ($request->hasFile('courier_bill')) {
                    $file = $request->file('courier_bill');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $img = Image::make($file);
                    $img->resize(500, 500);
                    $img->save(storage_path('app/public/courier_bills/' . $fileName));
                    $chiplevel_data['courier_bill'] = $fileName;
                }
                $service_date = Carbon::parse($request->service_date)->format('Y-m-d');
                $chiplevel_data['service_date']= $service_date;

                $status= Chiplevel::create($chiplevel_data);
                if($status){
                    Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                }
                else{
                    Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
                }
            }
            else{
                $warrenty_data['jobcard_id'] = $id;
                $warrenty_data['shop_name'] = $request->warrenty_servicer_name;
                $warrenty_data['servicer_contact'] = $request->servicer_contact;
                $warrenty_data['staff_name'] = $request->staff_name;
                $warrenty_data['courier_delivery'] = $request->courier_delivery;
                if ($request->hasFile('courier_bill')) {
                    $file = $request->file('courier_bill');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $img = Image::make($file);
                    $img->resize(500, 500);
                    $img->save(storage_path('app/public/courier_bills/' . $fileName));
                    $warrenty_data['courier_bill'] = $fileName;
                }
                $service_date = Carbon::parse($request->service_date)->format('Y-m-d');
                $warrenty_data['service_date']= $service_date;

                $status= Warrenty::create($warrenty_data);
                if($status){
                    Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                }
                else{
                    Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
                }            }

        // }

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
        $this->validate($request,[
            'handover_staff' => 'required',
            'service_charge' => 'required',
            'return_date' => 'required',
        ]);
        $chiplevel = Chiplevel::findOrFail($id);
        $data = $request->all();
        if($request->return_date){
            $data['return_date'] = Carbon::parse($request->return_date)->format('Y-m-d');
            $data['status'] = 'completed';
        }
        $status= $chiplevel->fill($data)->save();
        if($status){
            Toastr::success('Details added', 'success',["positionClass" => "toast-bottom-right"]);
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
    public function store_servicer(Request $request)
    {
        $data = $request->all();
        // return $data;

        $status= ChiplevelServicer::create($data);

        return response()->json($data);
    }
    public function update_warrenty(Request $request, $id)
    {
        $warrenty = Warrenty::findOrFail($id);
        $data = $request->all();
        if($request->return_date){
            $data['return_date'] = Carbon::parse($request->return_date)->format('Y-m-d');
            $data['status'] = 'completed';
        }
        $status= $warrenty->fill($data)->save();
        if($status){
            Toastr::success('Details added', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function get_servicer(Request $request)
    {
        $get_servicer = DB::table('sellers')->where('id',$request->servicer)->first();

        return response()->json($get_servicer);
    }
    public function get_seller(Request $request)
    {
        $get_seller = DB::table('sellers')->where('id',$request->seller)->first();

        return response()->json($get_seller);
    }
    public function add_servicer()
    {
        return view('third_party.create');
    }
    public function view_servicer()
    {
        $third_partis = ChiplevelServicer::get();
    return view('third_party.index', compact('third_partis'));
    }
    public function update_servicer(Request $request, $id)
    {
        $request->validate([
            'servicer_name' => 'required|string|max:255',
            'servicer_contact' => 'required|numeric|digits:10',
            'servicer_place' => 'required|string|max:255',
        ]);
        $servicer = ChiplevelServicer::findOrFail($id);
        $servicer->servicer_name      = $request->servicer_name;
        $servicer->servicer_contact   = $request->servicer_contact;
        $servicer->servicer_place     = $request->servicer_place;
        
        $status = $servicer->save();
        
        if($status){
            Toastr::success('Servicer updated successfully.', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }
        
        return redirect()->back();
    }
    public function store_servicer_single(Request $request)
    {
        $request->validate([
            'servicer_name' => 'required|string|max:255',
            'servicer_contact' => 'required|numeric|digits:10',
            'servicer_place' => 'required|string|max:255',
        ]);
        $servicer = new ChiplevelServicer();
        $servicer->servicer_name      = $request->servicer_name;
        $servicer->servicer_contact   = $request->servicer_contact;
        $servicer->servicer_place     = $request->servicer_place;
        
        $status = $servicer->save();
        
        if($status){
            Toastr::success('Servicer add successfully.', 'success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }
        
        return redirect()->back();
    }
}
