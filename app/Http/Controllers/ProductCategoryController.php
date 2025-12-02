<?php

namespace App\Http\Controllers;

use App\Models\product_categories;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product_categories.create');
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
        $data = $request->all();

        $this->validate($request, [
            'category_name' => 'required|unique:product_categories'
        ]);
        $data['category_name'] = strtoupper($request->category_name);
        $status = product_categories::create($data);
        if($status){
            Toastr::success("Category Added Successfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else{

            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('product_category.index');
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
        $category = product_categories::findOrFail($id);
        $this->validate($request, [
            'category_name'=> 'required'
        ]);

        $data = $request->all();
        $status =$category->fill($data)->save();
        if($status){
            Toastr::success("Details Edited Successfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('product_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = product_categories::findOrFail($id)->delete();
        if($status){
            Toastr::success("Details Removed Succesfully","success",["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error("Please try again!!","error",["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('product_category.index');
    }
    public function add_category(Request $request)
    {

        $data = $request->all();

        $get_category_count = DB::table('product_categories')->where('category_name',$request->category_name)->count();

            if( $get_category_count == 0){

                $status = product_categories::create($data);

            }

        if($status){

            $category_status = DB::table('product_categories')->latest('id')->first();
        }
        else{

            $category_status = "Error";
        }
        return response()->json($category_status);
    }
}
