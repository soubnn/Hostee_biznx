<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Models\Seller;
use App\Models\stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock.index');
    }


    public function getProductDetailsFromStock(Request $request)
    {
        $productId = $request->productId;

        $products = DB::table('stocks')->where('product_id',$productId)->first();

        $productDetails = DB::table('products')->where('id', $productId)->first();

        $data = array();
        $data['product_id'] = $productId;
        $data['product_name'] = $productDetails->product_name;
        $data['product_price'] = $products->product_unit_price;
        $data['max_qty'] = $products->product_qty;

        return response()->json($data);
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

    public function checkStock(Request $request)
    {
        $productId = $request->product;
        $quantity = (float)$request->quantity;
        $stock = DB::table('stocks')->where('product_id',$productId)->first();
        $currentQuantity = (float) $stock->product_qty;
        if($currentQuantity >= $quantity)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function view_stockout_product()
    {
        $stocks = DB::table('stocks')->where('product_qty','<','1')->get();
        return view('stock.stockout_index',compact('stocks'));
    }
    public function export(Request $request){

        $stock = stock::all();
        $stock_count = DB::table('stocks')->count();
        $stock_balance = DB::table('stocks')->select(DB::raw('sum(product_unit_price * product_qty) as total'))->get();

        for($i=0;$i<$stock_count;$i++){
            $stocks[$i] = [
                'product_name'      => $stock[$i]->product_details->product_name,
                'product_code'      => $stock[$i]->product_details->product_code,
                'category'          => $stock[$i]->product_details->category_details->category_name,
                'price'             => $stock[$i]->product_unit_price,
                'quantity'          => $stock[$i]->product_qty
            ];
        }
        $stocks[$stock_count] = [
            'product_name'   => '',
            'product_code'   => '',
            'category'       => '',
            'price'          => '',
            'quantity'       => ''
        ];
        $stocks[$stock_count+1] = [
            'product_name'   => '',
            'product_code'   => '',
            'category'       => 'Stock Balance',
            'price'          => $stock_balance[0]->total,
            'quantity'       => ''
        ];
        return Excel::download(new StockExport($stocks), 'Stocks.csv');
        // return Excel::store(new StockExport($stocks), 'stock.csv', 'local');
    }
}
