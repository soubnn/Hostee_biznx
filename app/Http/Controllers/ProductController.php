<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\SalesItems;
use App\Models\stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= Product::orderBy('product_name','ASC')->get();
        return view('products.index',compact('products'));
    }

    //For Ajax
    public function addProduct(Request $request)
    {
        $data = $request->all();
        $data['product_name'] = strtoupper($data['product_name']);
        $data['date']         = Carbon::now();
        $data['add_by']       = Auth::user()->name;


        if($request->product_image)
        {
            $product_image = $request->file('product_image');
            $image_name = time() . "_image." . $product_image->getClientOriginalExtension();
            $product_image = Image::make($product_image);
            $product_image->resize(500, 500);
            $path = $product_image->save(storage_path('app/public/products/'.$image_name));
            $data['product_image'] = $image_name;
        }
        $createProductStatus = Product::create($data);
        if($createProductStatus)
        {
            $product = DB::table('products')->latest('id')->first();
            return response()->json($product);
        }
        else
        {
            return response()->json("Error");
        }
    }

    //For Ajax
    public function getProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }

    //For Ajax
    public function getProductsInStock()
    {
        $productsArray = array();
        $productsInStock = DB::table('stocks')->where('product_qty','>',0)->get();
        foreach ($productsInStock as $products)
        {
            $temp = array();
            $product = DB::table('products')->where('id',$products->product_id)->first();
            $stock = stock::where('product_id',$product->id)->first();
            $product->stock = $stock->product_qty;
            array_push($productsArray, $product);
        }
        return response()->json($productsArray);
    }

    //For Ajax
    public function getProductDetails(Request $request)
    {
        $productId = $request->product;
        $productDetails = product::find($productId);
        $products = stock::where('product_id',$productId)->first();

        $data = array();
        $data['product_id'] = $productId;
        $data['product_name'] = $productDetails->product_name;
        $data['product_sgst'] = $productDetails->product_sgst;
        $data['product_cgst'] = $productDetails->product_cgst;
        if($products){
            $data['product_price'] = $products->product_unit_price;
            $data['stock_qty'] = $products->product_qty;
        }else{
            $data['product_price'] = $productDetails->product_price;
        }
        $data['hsn_code'] = $productDetails->hsn_code;

        return response()->json($data);
    }

    // For Editing Start
    public function product_edit_code(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_code' => 'required']);

        $data = $request->all();
        $data['product_code'] = strtoupper($data['product_code']);
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Product Code Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_name(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_name' => 'required']);

        $data = $request->all();
        $data['product_name'] = strtoupper($data['product_name']);
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Product Name Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_hsn(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['hsn_code' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Product HSN Code Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_unit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_unit_details' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Unit Details Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_tax_schedule(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_schedule' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Tax Schedule Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_category(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['category_id' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Category Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }
    public function product_edit_warrenty(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_warrenty' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Warrenty Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_max_stock(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_max_stock' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Maximum Stock Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_expiry(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //$this->validate($request, ['product_expiry_date' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Expiry Date Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_price(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_price' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Price Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_selling_price(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_selling_price' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Price Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_mrp(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, ['product_mrp' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Price Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_supplier(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //$this->validate($request, ['product_supplier' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Supplier Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_brand(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //$this->validate($request, ['product_supplier' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Brand Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_description(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //$this->validate($request, ['product_supplier' => 'required']);

        $data = $request->all();
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Description Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    public function product_edit_image(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        //$this->validate($request, ['product_supplier' => 'required']);

        $data = $request->all();
        if($request->product_image)
        {
            $product_image = $request->file('product_image');
            $image_name = time() . "_image." . $product_image->getClientOriginalExtension();
            $product_image = Image::make($product_image);
            $product_image->resize(500, 500);
            $path = $product_image->save(storage_path('app/public/products/'.$image_name));
            $data['product_image'] = $image_name;
        }
        else
        {
            $data['product_image'] = null;
        }
        $status = $product->fill($data)->save();
        if($status){
            Toastr::success('Image Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            'category_id' => 'nullable',
            'product_name' => 'required',
            'hsn_code' => 'required',
            'product_price' => 'required',
            'product_schedule' => 'required',
            'image' => 'nullable'
        ]);

        $data = $request->all();
        $data['product_name'] = strtoupper($data['product_name']);
        $data['date']         = Carbon::now();
        $data['add_by']       = Auth::user()->name;

        if($request->product_image)
        {
            $product_image = $request->file('product_image');
            $image_name = time() . "_image." . $product_image->getClientOriginalExtension();
            $product_image = Image::make($product_image);
            $product_image->resize(500, 500);
            $path = $product_image->save(storage_path('app/public/products/'.$image_name));
            $data['product_image'] = $image_name;
        }

        $createProductStatus = Product::create($data);

        if($createProductStatus)
        {
            Toastr::success('Product Added Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else
        {
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('product.create');
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
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
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
        $product = Product::findOrFail($id);
        $this->validate($request,[
            'category_id' => 'required',
            'product_name' => 'required',
            'brand' =>'required',
            'price' =>'numeric|required',
            'tax_percentage' => 'numeric|required',
            'HSNcode' => 'required',
            'seller' => 'required',
            'features' => 'max:150|string|nullable',
            'description' => 'string|nullable',
            'image' => 'nullable'

        ]);
        $data = $request->all();
        // image upload
        if($request->file('image'))
        {
        $img= $request->file('image');
        $imgName=time().'.'.$request->file('image')->getClientOriginalName();
        $img->storeAs('public/images',$imgName);
        $data['image']= $imgName;
        }
        // image upload end
        $status= $product->fill($data)->save();
        if($status){
            Toastr::success('Details Edited Successfully','success',["positionClass" => "toast-bottom-right"]);
        }
        else{
            Toastr::error('Please try again!!','error',["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('product.index');
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
    public function view_products(Request $request)
    {
        $query = Product::orderBy('product_name','ASC');

        // Apply search filter if a search term is provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                ->orWhere('product_selling_price', 'LIKE', "%{$search}%");
            });
        }

        // Paginate results
        $products = $query->paginate(20)->appends(['search' => $request->search]);

        foreach($products as $product){
            $stockDetails = stock::where('product_id',$product->id)->first();
            if($stockDetails){
                $product->stockDetails = $stockDetails;
            }else{
                $product->stockDetails = [];
            }
        }

        return view('products.index',compact('products'));
    }
    public function product_summary()
    {
        $products = Product::with('category_details')->withCount('salesItems')->get();
        return view('products.summary',compact('products'));
    }
    public function product_summary_items($id)
    {
        $year = Carbon::now()->format('y');
        $direct_sales = DB::table('direct_sales')->join('sales_items','direct_sales.id', '=', 'sales_items.sales_id')->where('sales_items.product_id', $id)->get();
        $purchase_returns = DB::table('purchase_returns')->join('purchase_return_items','purchase_returns.id', '=', 'purchase_return_items.return_id')->where('purchase_return_items.product', $id)->get();
        $sales = Sales::where('product_id',$id)->get();
        $purchase_details = DB::table('purchases')->join('purchase_items','purchases.id','=','purchase_items.purchase_id')->where('purchase_items.product_id',$id)->get();
        return view('products.summary_items',compact('direct_sales','sales','purchase_details','purchase_returns','year'));
    }
}
