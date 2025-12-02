<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItems;
use App\Models\stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseItemController extends Controller
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
        //
    }


    //For Ajax
    public function addPurchaseItem(Request $request)
    {
        $data = $request->all();
        $data['purchase_id'] = (int)$data['purchase_id'];
        $data['product_id'] = (int)$data['product_id'];
        $status = PurchaseItems::create($data);
        if($status)
        {
            $product_id = $data['product_id'];
            $stock_count = DB::table('stocks')->where('product_id', $product_id)->count();
            $data1 = array();
            if($stock_count>0)
            {

                $existingData = DB::table('stocks')->where('product_id',$product_id)->first();
                $existingData->product_unit_price = $data['unit_price'];
                $newQuantity = (int)$data['product_quantity'];
                $oldQuantity = (int)$existingData->product_qty;
                $quantity = $newQuantity + $oldQuantity;
                $existingData->product_qty = (string)$quantity;

                $status2 = DB::table('stocks')->where('product_id',$product_id)->update(['product_unit_price'=> $existingData->product_unit_price,
                'product_qty'=>$existingData->product_qty]);

                if($status2)
                {
                   return response()->json("Success");
                }
                else
                {
                   return response()->json("Error");
                }
            }
            else
            {
                $data1['product_id'] = $product_id;
                $data1['product_unit_price'] = $data['unit_price'];
                $data1['product_qty'] = $data['product_quantity'];
                $status1 = stock::create($data1);
                if($status1)
                {
                    return response()->json("Success");
                }
                else
                {
                    return response()->json("Error");
                }
            }
        }
        else
        {
            return response()->json("Error");
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
}
