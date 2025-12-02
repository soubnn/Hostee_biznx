<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
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

    public function addSales(Request $request)
    {
        $data = $request->all();
        // return $request->product_id;
        // return $data;
        $get_product = DB::table('products')->where('id',$request->product_id)->first();
        if($get_product == Null){

            $status = Sales::create($data);

            if($status)
            {
                return response()->json("Success");
            }
        }
        else{
            // return $request->product_id;
            $data['qty'] = (int)$data['qty'];
            $get_stock_count = DB::table('stocks')->where('product_id', $data['product_id'])->first();
            $get_stock_count->product_qty = (int)$get_stock_count->product_qty;

            if($data['qty'] <= $get_stock_count->product_qty)
            {
                $status = Sales::create($data);
                if($status)
                {

                    $get_stock_count->product_qty = $get_stock_count->product_qty - $data['qty'];
                    $update = DB::table('stocks')->where('product_id',$data['product_id'])->update(['product_qty'=>$get_stock_count->product_qty]);
                    if($update)
                    {
                        return response()->json("Success");
                    }


                }
            }

        }
        //return response()->json($get_stock_count);
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
        $job_card_id  =   $request->get('job_card_id');
        $product_id   =   $request->get('product_id');
        $serial   =   $request->get('serial');
        $price        =   $request->get('price');
        $qty          =   $request->get('qty');
        $tax          =   $request->get('tax');
        $gst          =   $request->get('gst');
        $total        =   $request->get('total');
        for($i = 0; $i < count($product_id); $i++){
            $datasave = [
                'job_card_id'   =>  $job_card_id,
                'product_id'    =>  $product_id[$i],
                'serial'    =>  $serial[$i],
                'price'         =>  $price[$i],
                'qty'           =>  $qty[$i],
                'tax'           =>  $tax[$i],
                'gst'           =>  $gst[$i],
                'total'         =>  $total[$i],
                'date'          => Carbon::now(),
                'add_by'        => Auth::user()->name,
            ];
            $get_product = DB::table('products')->where('id',$product_id[$i])->first();
            if($get_product != Null){
                $get_stock_details = DB::table('stocks')->where('product_id',$product_id[$i])->first();
                $sales_qty = (float) $qty[$i];
                $stock_qty = (float) $get_stock_details->product_qty;
                if($sales_qty <= $stock_qty){
                    $new_qty = $stock_qty - $sales_qty;
                    $update_stock = DB::table('stocks')->where('product_id',$product_id[$i])->update(['product_qty' => $new_qty]);
                }
                else{
                    Toastr::error('stock mismatch!', 'error',["positionClass" => "toast-bottom-right"]);
                    return redirect()->back();
                }
            }
            else{
                $update_stock = 'success';
            }
            $status = DB::table('sales')->insert($datasave);
        }
        if($status && $update_stock){
            Toastr::success('Item Added', 'success',["positionClass" => "toast-bottom-right"]);
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
        $salesItems = DB::table('sales')->where('job_card_id',$id)->get();
        return view('direct_sales.sales_show', compact('salesItems'));
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
    public function delete_accessories(Request $request)
    {
        $sale_id = $request->sale_id;
        $get_sales = DB::table('sales')->where('id',$sale_id)->first();
        $sales_qty = $get_sales->qty;
        $get_product = DB::table('products')->where('id',$get_sales->product_id)->first();
        if($get_product == Null){
            $sales_status = DB::table('sales')->where('id',$sale_id)->delete();
            if($sales_status){
                return response()->json('Success');
            }
            else{
                return response()->json('Error');
            }
        }
        else{

            $get_stocks = DB::table('stocks')->where('product_id',$get_sales->product_id)->first();
            $old_stock = $get_stocks->product_qty;
            $new_stock = $old_stock + $sales_qty;
            $update_data['product_qty'] = $new_stock;

            // return $sales_qty.' '.$old_stock.' '.$new_stock;

            $stock_status = DB::table('stocks')->where('product_id',$get_sales->product_id)->update($update_data);
            $sales_status = DB::table('sales')->where('id',$sale_id)->delete();

            if($stock_status && $sales_status){
                return response()->json('Success');
            }
            else{
                return response()->json('Error');
            }

        }
    }
}
