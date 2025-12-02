<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle= Vehicle::all();
        return view('vehicle.index',compact('vehicle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicle.create');
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

            'vehicle_number' => 'string|required',

        ]);
        $data = $request->all();
        $data['add_date'] = Carbon::now();
        $data['add_by'] = Auth::user()->name;
        // files upload
        if($request->rc_doc){
            $rc_file= $request->file('rc_doc');
            $rc_fileName=time().'RC_'.$request->vehicle_number.'.'.$request->file('rc_doc')->getClientOriginalExtension();
            $rc_file->storeAs('public/vehicle',$rc_fileName);
            $data['rc_doc']= $rc_fileName;
        }

        if($request->insurance_doc){
            $insurance_file= $request->file('insurance_doc');
            $insurance_fileName=time().'INSURANCE_'.$request->vehicle_number.'.'.$request->file('insurance_doc')->getClientOriginalExtension();
            $insurance_file->storeAs('public/vehicle',$insurance_fileName);
            $data['insurance_doc']= $insurance_fileName;
        }

        if($request->pollution_doc){
            $pollution_file= $request->file('pollution_doc');
            $pollution_fileName=time().'POLLUTION_'.$request->vehicle_number.'.'.$request->file('pollution_doc')->getClientOriginalExtension();
            $pollution_file->storeAs('public/vehicle',$pollution_fileName);
            $data['pollution_doc']= $pollution_fileName;
        }

        if($request->permit_doc){
            $permit_file= $request->file('permit_doc');
            $permit_fileName=time().'PERMIT_'.$request->vehicle_number.'.'.$request->file('permit_doc')->getClientOriginalExtension();
            $permit_file->storeAs('public/vehicle',$permit_fileName);
            $data['permit_doc']= $permit_fileName;
        }

        // files upload end


        $status= Vehicle::create($data);
        if($status){
            Toastr::success('Vehicle Added', 'success',["positionClass" => "toast-bottom-right"]);
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
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle.show',compact('vehicle'));
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
    //start editing

    public function vehicle_edit_number(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'vehicle_number' => 'required',

        ]);
        $data = $request->all();
        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Vehcile No. Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_name(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'vehicle_name' => 'nullable',

        ]);
        $data = $request->all();
        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Vehicle Name Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_model(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'vehicle_model' => 'nullable',

        ]);
        $data = $request->all();
        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Vehicle Model Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"],["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_rc_owner(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'rc_owner' => 'nullable',

        ]);
        $data = $request->all();
        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('RC Owner Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_engine_number(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'engine_number' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Engine No. Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_chasis_number(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'chasis_number' => 'nullable',

        ]);
        $data = $request->all();





        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Chasis No. Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_reg_validity(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'reg_validity' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('RC Validity Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_insurance_number(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'insurance_number' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Insurance No. Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_insurance_validity(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'insurance_validity' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Insurance Validity Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_pollution_validity(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'pollution_validity' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Pollution validity Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_permit_validity(Request $request, $id){
        $vehicle = Vehicle::findOrFail($id);

        $this->validate($request, [

            'permit_validity' => 'nullable',

        ]);
        $data = $request->all();

        $status= $vehicle->fill($data)->save();
        if($status){
            Toastr::success('Permit Validity Edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->back();
    }
    public function vehicle_edit_rcdoc(Request $request, $id){

        $vehcile = Vehicle::findOrFail($id);

        $data = $request->all();

        // file upload
        if($request->rc_doc){
            $rc_file= $request->file('rc_doc');
            $rc_fileName=time().'RC_'.$request->vehicle_number.'.'.$request->file('rc_doc')->getClientOriginalExtension();
            $rc_file->storeAs('public/vehicle',$rc_fileName);
            $data['rc_doc']= $rc_fileName;
        }
        // file upload end
        $status= $vehcile->fill($data)->save();
        if($status){
            Toastr::success('RC Document edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_insurancedoc(Request $request, $id){

        $vehcile = Vehicle::findOrFail($id);

        $data = $request->all();

        // file upload
        if($request->insurance_doc){
            $insurance_file= $request->file('insurance_doc');
            $insurance_fileName=time().'INSURANCE_'.$request->vehicle_number.'.'.$request->file('insurance_doc')->getClientOriginalExtension();
            $insurance_file->storeAs('public/vehicle',$insurance_fileName);
            $data['insurance_doc']= $insurance_fileName;
        }
        // file upload end
        $status= $vehcile->fill($data)->save();
        if($status){
            Toastr::success('Insurance Document edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_pollutiondoc(Request $request, $id){

        $vehcile = Vehicle::findOrFail($id);

        $data = $request->all();

        // file upload
        if($request->pollution_doc){
            $pollution_file= $request->file('pollution_doc');
            $pollution_fileName=time().'POLLUTION_'.$request->vehicle_number.'.'.$request->file('pollution_doc')->getClientOriginalExtension();
            $pollution_file->storeAs('public/vehicle',$pollution_fileName);
            $data['pollution_doc']= $pollution_fileName;
        }
        // file upload end
        $status= $vehcile->fill($data)->save();
        if($status){
            Toastr::success('Pollution Document edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function vehicle_edit_permitdoc(Request $request, $id){

        $vehcile = Vehicle::findOrFail($id);

        $data = $request->all();

        // file upload
        if($request->permit_doc){
            $permit_file= $request->file('permit_doc');
            $permit_fileName=time().'PERMIT_'.$request->vehicle_number.'.'.$request->file('permit_doc')->getClientOriginalExtension();
            $permit_file->storeAs('public/vehicle',$permit_fileName);
            $data['permit_doc']= $permit_fileName;
        }
        // file upload end
        $status= $vehcile->fill($data)->save();
        if($status){
            Toastr::success('Permit Document edited', 'success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }



    // --------------end editing-----------
}
