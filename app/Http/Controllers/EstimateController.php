<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\Estimate_item;
use Brian2694\Toastr\Facades\Toastr;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimates= Estimate::orderBy('id','DESC')->get();
        foreach ( $estimates as $estimate ) {
            $message = "Dear " . $estimate->customer_name . ",
    Your Estimate has been generated.";
            $message = urlencode($message);
            $url = "https://api.whatsapp.com/send/?phone=91$estimate->customer_phone&text=$message";
            $estimate->url = $url;
        }
        return view('estimate.index',compact('estimates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estimate.create');
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

            'customer_phone' =>'nullable',
            'customer_name' => 'required'

        ]);
        $data = $request->all();

        $estimate_date   =  Carbon::now()->format('Y-m-d');
        $estimate_type   = 'Product';
        $valid_upto      =  $request->get('valid_upto');
        $customer_name   =  $request->get('customer_name');
        $customer_phone  =  $request->get('customer_phone');
        $grand_total     =   $request->get('grand_total');

        $estimate_data['estimate_type']     = $estimate_type;
        $estimate_data['estimate_date']     = $estimate_date;
        $estimate_data['valid_upto']        = $valid_upto;
        $estimate_data['customer_name']     = $customer_name;
        $estimate_data['customer_phone']    = $customer_phone;
        $estimate_data['grand_total']       = $grand_total;
        $estimate_data['generated_by']      = Auth::user()->name;
        $estimate_data['add_date']          = Carbon::now();


        $estimate_product   =   $request->get('estimate_product');
        // $warrenty           =   $request->get('warrenty');
        $unit_price         =   $request->get('unitPrice');
        $qty                =   $request->get('qty');
        $product_tax        =   $request->get('product_tax');
        $total              =   $request->get('total');

        // $estimate_get = DB::table('estimates')->orderBy('id','DESC')->first();
        // $estimate_id = ($estimate_get->id)+1;
        $estimate_status = DB::table('estimates')->insert($estimate_data);

        if($estimate_status){
            $estimate_get = DB::table('estimates')->orderBy('id','DESC')->first();
            $estimate_id = ($estimate_get->id);
            for($i = 0; $i < count($estimate_product); $i++){
                $datasave = [
                    'estimate_id'       =>  $estimate_id,
                    'product_name'      =>  $estimate_product[$i],
                    // 'warrenty'          =>  $warrenty[$i],
                    'unit_price'        =>  $unit_price[$i],
                    'product_tax'       =>  $product_tax[$i],
                    'qty'               =>  $qty[$i],
                    'total'             =>  $total[$i]
                ];

                $status = DB::table('estimate_items')->insert($datasave);
            }
            if($status){
                Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                return redirect()->route('estimate.index');
            }
            else{
                Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
                return redirect()->back();

            }
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->route('estimate.index');

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
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_details = DB::table('estimate_items')->where('estimate_id',$id)->get();
        return view('estimate.show',compact('estimate_details','estimate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_items = DB::table('estimate_items')->where('estimate_id',$id)->get();
        return view('estimate.edit',compact('estimate_items','estimate'));
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
        $estimate = Estimate::findOrFail($id);
        $this->validate($request,[
            'customer_phone' =>'nullable',
        ]);
        $data = $request->all();

        $status= $estimate->fill($data)->save();
        if($status){
            Toastr::success('Edited Successfully', 'success',["positionClass" => "toast-bottom-right"]);
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
    public function camera_estimate()
    {
        return view('estimate.estimate_camera');
    }
    public function estimate_report($id)
    {
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_details = DB::table('estimate_items')->where('estimate_id',$id)->get();
        $gst_count = DB::table('estimate_items')->where('estimate_id',$id)->where('product_tax','>',0)->count();

        return view('estimate.estimate_report',compact('estimate_details','estimate','gst_count'));
    }
    public function getCategoryProduct( Request $request)
    {

        $get_category = DB::table('product_categories')->where('category_name',$request->category)->first();
        $category_id = $get_category->id;
        $products = DB::table('products')->where('category_id',$category_id)->get();
        return response()->json($products);
    }
    public function get_product_categories( Request $request)
    {

        $categories = DB::table('product_categories')->get();
        return response()->json($categories);
    }
    public function getEstimateProductDetails( Request $request)
    {

        $product_id = $request->product;

        $product_details = DB::table('products')->join('product_categories','products.category_id','=','product_categories.id')->where('products.id',$product_id)->first();
        return response()->json($product_details);
    }
    public function store_system_estimate( Request $request)
    {
        $this->validate($request,[

            'customer_phone' =>'nullable',
            'system_customer_name' => 'required'

        ]);

        $data = $request->all();

        $estimate_date   =  Carbon::now()->format('Y-m-d');
        $estimate_type = 'System';
        $valid_upto   =  $request->get('system_valid_upto');
        $customer_name   =  $request->get('system_customer_name');
        $customer_phone   =  $request->get('system_customer_phone');
        $grand_total  =   $request->get('system_grand_total');

        $estimate_data['estimate_type'] = $estimate_type;
        $estimate_data['estimate_date'] = $estimate_date;
        $estimate_data['valid_upto'] = $valid_upto;
        $estimate_data['customer_name'] = $customer_name;
        $estimate_data['customer_phone'] = $customer_phone;
        $estimate_data['grand_total'] = $grand_total;

        $product_category =  $request->get('product_category');
        $estimate_product =  $request->get('system_product_name');
        $warrenty       =   $request->get('system_warrenty');
        $unit_price          =   $request->get('system_unit_price');
        $qty            =   $request->get('system_product_qty');
        $total            =   $request->get('system_total');


        $estimate_status = DB::table('estimates')->insert($estimate_data);

        if($estimate_status){
            // $estimate_get = DB::table('estimates')->latest()->first();
            $estimate_get = DB::table('estimates')->orderBy('id','DESC')->first();
            $estimate_id = ($estimate_get->id);
            for($i = 0; $i < count($estimate_product); $i++){

                $datasave = [
                    'estimate_id'       =>  $estimate_id,
                    'product_category'  =>  $product_category[$i],
                    'product_name'      =>  $estimate_product[$i],
                    'warrenty'          =>  $warrenty[$i],
                    'unit_price'        =>  $unit_price[$i],
                    'qty'               =>  $qty[$i],
                    'total'             =>  $total[$i]
                ];

                $status = DB::table('estimate_items')->insert($datasave);
            }
            if($status){
                Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                return redirect()->route('estimate.index');
            }
            else{
                Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();

        }
    }
    public function enable_estimate( Request $request, $id)
    {
        $valid_upto   =  Carbon::parse($request->get('valid_upto'))->format('d-M-Y');

        $estimate = DB::table('estimates')->where('id',$id)->first();

        $estimate_data['valid_upto'] = $valid_upto;
        $estimate_data['status'] = 'active';

        $status = DB::table('estimates')->where('id',$id)->update($estimate_data);

        if($status){
            Toastr::success('Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function disable_estimate($id)
    {

        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_data['status'] = 'disabled';

        $status = DB::table('estimates')->where('id',$id)->update($estimate_data);

        if($status){
            Toastr::success('Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function estimate_item_edit( Request $request, $id)
    {
        $estimate_item = Estimate_item::findOrFail($id);
        $estimate_id = $estimate_item->estimate_id;
        $old_total = $estimate_item->total;
        $new_total = $request->total;

        $estimate = Estimate::findOrFail($estimate_id);
        $old_grand_total = $estimate->grand_total;
        $new_grand_total = $old_grand_total - $old_total + $new_total;

        $data = $request->all();
        $estimate_data['grand_total'] = number_format( (float) $new_grand_total, 2, '.', '');

        $status= $estimate_item->fill($data)->save();
        $estimate_status = DB::table('estimates')->where('id',$estimate_id)->update($estimate_data);

        if($status && $estimate_status){
            Toastr::success('Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function estimate_add_item( Request $request )
    {
        $data = $request->all();
        $estimate_id = $request->get('estimate_id');
        $estimate = DB::table('estimates')->where('id',$estimate_id)->first();
        $estimate_total = $estimate->grand_total + $request->get('total');
        $data_estimate['grand_total'] = number_format( (float) $estimate_total, 2, '.', '');

        $status = Estimate_item::create($data);
        if($status){
            $estimate_status = DB::table('estimates')->where('id',$estimate_id)->update($data_estimate);
            Toastr::success('Item Added Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function estimate_delete_item($id)
    {
        $estimate_item = Estimate_item::findOrFail($id);
        $estimate_id = $estimate_item->estimate_id;
        $estimate = DB::table('estimates')->where('id',$estimate_id)->first();
        $estimate_total = $estimate->grand_total - $estimate_item->total;
        $data['grand_total'] = $estimate_total;

        $status = DB::table('estimate_items')->where('id',$id)->delete();
        if($status){
            $estimate_status = DB::table('estimates')->where('id',$estimate_id)->update($data);
            Toastr::success('Deleted Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function generate_estimate($id){
        function number_to_word(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');

            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }

            $d = 0;
            while( $d < $decimal_length ) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d += $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str2[] = null;
            }

            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_details = DB::table('estimate_items')->where('estimate_id',$id)->get();
        $total_unit_price = DB::table('estimate_items')->where('estimate_id',$id)->sum('unit_price');
        $total_qty = DB::table('estimate_items')->where('estimate_id',$id)->where('product_name','<>','')->sum('qty');
        $gst_count = DB::table('estimate_items')->where('estimate_id',$id)->where('product_tax','>',0)->count();
        $generated_by = Auth::user()->name;
        $grand_total_in_words = strtoupper(number_to_word($estimate->grand_total));

        $pdf = Pdf::loadView('invoices.estimate',compact('estimate_details','estimate','total_unit_price','total_qty','generated_by','grand_total_in_words','gst_count'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee the Planner - Estimate.pdf',array("Attachment"=>false));
    }
    public function view_request(){
        $estimate_requests = DB::table('estimate_request')->get();
        return view('estimate.requests',compact('estimate_requests'));
    }

    public function whatsappEstimate($id){
        function number_to_word1(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');

            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }

            $d = 0;
            while( $d < $decimal_length ) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d += $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str2[] = null;
            }

            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_details = DB::table('estimate_items')->where('estimate_id',$id)->get();
        $total_unit_price = DB::table('estimate_items')->where('estimate_id',$id)->sum('unit_price');
        $gst_count = DB::table('estimate_items')->where('estimate_id',$id)->where('product_tax','>',0)->count();
        $total_qty = DB::table('estimate_items')->where('estimate_id',$id)->where('product_name','<>','')->sum('qty');
        if($estimate->generated_by)
        {
            $generated_by = $estimate->generated_by;
        }
        else
        {
            $generated_by = Auth::user()->name;
        }
        $grand_total_in_words = strtoupper(number_to_word1($estimate->grand_total));

        $pdf = Pdf::loadView('invoices.estimate',compact('estimate_details','estimate','total_unit_price','gst_count','total_qty','generated_by','grand_total_in_words'))->setPaper('a4', 'portrait');
        return $pdf->download('Hostee the Planner - Estimate.pdf',array("Attachment"=>false));
    }

    public function userEstimate($id){
        function number_to_word2(float $number)
        {
            $no = floor($number);
            $decimal = round($number - $no, 2) * 100;
            $decimal_part = $decimal;
            $hundred = null;
            $hundreds = null;
            $digits_length = strlen($no);
            $decimal_length = strlen($decimal);
            $i = 0;
            $str = array();
            $str2 = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');

            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }

            $d = 0;
            while( $d < $decimal_length ) {
                $divider = ($d == 2) ? 10 : 100;
                $decimal_number = floor($decimal % $divider);
                $decimal = floor($decimal / $divider);
                $d += $divider == 10 ? 1 : 2;
                if ($decimal_number) {
                    $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                    $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                    @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str2[] = null;
            }

            $Rupees = implode('', array_reverse($str));
            $paise = implode('', array_reverse($str2));
            $paise = ($decimal_part > 0) ? $paise . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }
        $estimate = DB::table('estimates')->where('id',$id)->first();
        $estimate_details = DB::table('estimate_items')->where('estimate_id',$id)->get();
        $total_unit_price = DB::table('estimate_items')->where('estimate_id',$id)->sum('unit_price');
        $gst_count = DB::table('estimate_items')->where('estimate_id',$id)->where('product_tax','>',0)->count();
        $total_qty = DB::table('estimate_items')->where('estimate_id',$id)->where('product_name','<>','')->sum('qty');
        if($estimate->generated_by)
        {
            $generated_by = $estimate->generated_by;
        }
        else if(Auth::user())
        {
            $generated_by = Auth::user()->name;
        }
        else
        {
            $generated_by = "";
        }
        $grand_total_in_words = strtoupper(number_to_word2($estimate->grand_total));

        $pdf = Pdf::loadView('invoices.estimate',compact('estimate_details','estimate','total_unit_price','gst_count','total_qty','generated_by','grand_total_in_words'))->setPaper('a4', 'portrait');
        return $pdf->stream('Hostee the Planner - Estimate.pdf',array("Attachment"=>false));
    }
}
