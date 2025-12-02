<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItems;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sail\Console\PublishCommand;
use Illuminate\Support\Facades\Auth;


class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders= PurchaseOrder::where('status','<>','returned')->Where('status','<>','delivered')->where('status','active')->get();
        return view('purchase_order.index',compact('purchase_orders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orderCount = PurchaseOrder::count();
        $year = Carbon::now()->format('y');
        if($orderCount > 0)
        {
            $order = PurchaseOrder::latest('id')->first();
            $orderNumber = $order->purchase_order_number;
            $orderNumberArray = explode("-",$orderNumber);
            $orderCount = $orderNumberArray[1];
            $orderCount++;
            $orderCount = str_pad($orderCount, 5, '0', STR_PAD_LEFT);
            if($year > $orderNumberArray[2]){
                $orderCount = '00001';
                $newOrderNumber = $orderNumberArray[0] . "-" . $orderCount . "-" . $year;
            }
            elseif($year == $orderNumberArray[2]){
                $newOrderNumber = $orderNumberArray[0] . "-" . $orderCount . "-" . $orderNumberArray[2];
            }
        }
        else
        {
            $newOrderNumber = "PUR-00001-".$year;
        }
        return view('purchase_order.create',compact('newOrderNumber'));
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

            'seller_mobile' =>'nullable',
            'seller_name' => 'required'

        ]);
        $data = $request->all();

        $purchase_order_number =  $request->purchase_order_number;
        $purchase_order_date   =  Carbon::now()->format('Y-m-d');
        $seller_name           =  $request->seller_name;
        $seller_mobile         =  $request->seller_mobile;
        $grand_total           =  $request->grand_total;

        $purchase_order_data['purchase_order_number'] = $purchase_order_number;
        $purchase_order_data['purchase_order_date']   = $purchase_order_date;
        $purchase_order_data['seller_name']           = $seller_name;
        $purchase_order_data['seller_mobile']         = $seller_mobile;
        $purchase_order_data['grand_total']           = $grand_total;
        $purchase_order_data['generated_by']          = Auth::user()->name;
        $purchase_order_data['add_date']              = Carbon::now();


        $order_product    =  $request->get('order_product');
        $unit_price       =  $request->get('unitPrice');
        $qty              =  $request->get('qty');
        $total            =  $request->get('total');

        $purchase_order_status = PurchaseOrder::insert($purchase_order_data);

        if($purchase_order_status){
            $purchase_orders_get = PurchaseOrder::orderBy('id','DESC')->first();
            $purchase_order_id = ($purchase_orders_get->id);
            for($i = 0; $i < count($order_product); $i++){
                $datasave = [
                    'purchase_order_id'       =>  $purchase_order_id,
                    'product_name'      =>  $order_product[$i],
                    'unit_price'        =>  $unit_price[$i],
                    'qty'               =>  $qty[$i],
                    'total'             =>  $total[$i]
                ];
                $status = PurchaseOrderItems::insert($datasave);
            }
            if($status){
                Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                return redirect()->route('purchase_order.index');
            }
            else{
                Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->route('purchase_order.index');

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
        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_details = PurchaseOrderItems::where('purchase_order_id',$id)->get();
        return view('purchase_order.show',compact('purchase_order_details','purchase_order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_items = PurchaseOrderItems::where('purchase_order_id',$id)->get();
        return view('purchase_order.edit',compact('purchase_order_items','purchase_order'));
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
        $purchase_order = PurchaseOrder::findOrFail($id);
        $this->validate($request,[
            'customer_phone' =>'nullable',
        ]);
        $data = $request->all();

        $status= $purchase_order->fill($data)->save();
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
    public function delivered()
    {
        $purchase_orders= PurchaseOrder::where('status','<>','returned')->Where('status','<>','delivered')->where('status','approve')->get();
        return view('purchase_order.delivered',compact('purchase_orders'));
    }

    public function delete_purchase_order($id)
    {
        try {
            $purchase_order = PurchaseOrder::where('id', $id)->first();

            if ($purchase_order) {
                PurchaseOrder::where('id', $id)->delete();

                PurchaseOrderItems::where('purchase_order_id', $id)->delete();

                Toastr::success('Deleted Successfully', 'success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            } else {
                Toastr::error('Purchase order not found!', 'error', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('An error occurred: ' . $e->getMessage(), 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function purchase_order_add_item( Request $request )
    {
        $data = $request->all();
        $purchase_order_id = $request->get('purchase_order_id');
        $purchase_order = PurchaseOrder::where('id',$purchase_order_id)->first();
        $purchase_order_total = $purchase_order->grand_total + $request->get('total');
        $data_purchase_order['grand_total'] = number_format( (float) $purchase_order_total, 2, '.', '');

        $status = PurchaseOrderItems::create($data);
        if($status){
            $purchase_order_status = PurchaseOrder::where('id',$purchase_order_id)->update($data_purchase_order);
            Toastr::success('Item Added Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function purchase_order_delete_item($id)
    {
        $purchase_order_item = PurchaseOrderItems::findOrFail($id);
        $purchase_order_id = $purchase_order_item->purchase_order_id;
        $purchase_order = PurchaseOrder::where('id',$purchase_order_id)->first();
        $purchase_order_total = $purchase_order->grand_total - $purchase_order_item->total;
        $data['grand_total'] = $purchase_order_total;

        $status = PurchaseOrderItems::where('id',$id)->delete();
        if($status){
            $purchase_order_status = PurchaseOrder::where('id',$purchase_order_id)->update($data);
            Toastr::success('Deleted Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function purchase_order_item_edit( Request $request, $id)
    {
        $purchase_order_item = PurchaseOrderItems::findOrFail($id);
        $purchase_order_id = $purchase_order_item->purchase_order_id;
        $old_total = $purchase_order_item->total;
        $new_total = $request->total;

        $purchase_order = PurchaseOrder::findOrFail($purchase_order_id);
        $old_grand_total = $purchase_order->grand_total;
        $new_grand_total = $old_grand_total - $old_total + $new_total;

        $data = $request->all();
        $purchase_order_data['grand_total'] = number_format( (float) $new_grand_total, 2, '.', '');

        $status= $purchase_order_item->fill($data)->save();
        $purchase_order_status = PurchaseOrder::where('id',$purchase_order_id)->update($purchase_order_data);

        if($status && $purchase_order_status){
            Toastr::success('Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function approve_purchase_order($id)
    {

        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_data['status'] = 'approve';

        $status = PurchaseOrder::where('id',$id)->update($purchase_order_data);

        if($status){
            Toastr::success('Edited Succesfully', 'success',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
        else{
            Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function purchase_order_report($id)
    {
        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_details = PurchaseOrderItems::where('purchase_order_id',$id)->get();
        $totalQty = PurchaseOrderItems::where('purchase_order_id',$id)->sum('qty');
        return view('purchase_order.purchase_order_report',compact('purchase_order_details','purchase_order','totalQty'));
    }
    public function generate_purchase_order($id)
    {
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
        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_details = PurchaseOrderItems::where('purchase_order_id',$id)->get();
        $total_unit_price = PurchaseOrderItems::where('purchase_order_id',$id)->sum('unit_price');
        $total_qty = PurchaseOrderItems::where('purchase_order_id',$id)->where('product_name','<>','')->sum('qty');
        $generated_by = Auth::user()->name;
        $grand_total_in_words = strtoupper(number_to_word($purchase_order->grand_total));

        $pdf = Pdf::loadView('invoices.purchase_order',compact('purchase_order_details','purchase_order','total_unit_price','total_qty','generated_by','grand_total_in_words'))->setPaper('a4', 'portrait');
        return $pdf->stream('Techsoul - PurchaseOrder.pdf',array("Attachment"=>false));
    }public function whatsappPurchaseOrder($id){
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
        $purchase_order = PurchaseOrder::where('id',$id)->first();
        $purchase_order_details = PurchaseOrderItems::where('purchase_order_id',$id)->get();
        $total_unit_price = PurchaseOrderItems::where('purchase_order_id',$id)->sum('unit_price');
        $total_qty = PurchaseOrderItems::where('purchase_order_id',$id)->where('product_name','<>','')->sum('qty');
        if($purchase_order->generated_by)
        {
            $generated_by = $purchase_order->generated_by;
        }
        else
        {
            $generated_by = Auth::user()->name;
        }
        $grand_total_in_words = strtoupper(number_to_word1($purchase_order->grand_total));

        $pdf = Pdf::loadView('invoices.purchase_order',compact('purchase_order_details','purchase_order','total_unit_price','total_qty','generated_by','grand_total_in_words'))->setPaper('a4', 'portrait');
        return $pdf->download('Techsoul Cyber Solutions - PurchaseOrder.pdf',array("Attachment"=>false));
    }

}

