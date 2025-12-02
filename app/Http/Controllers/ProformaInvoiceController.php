<?php

namespace App\Http\Controllers;

use App\Models\ProformaInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProformaInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices= ProformaInvoice::orderBy('id','DESC')->get();
        return view('proforma.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proforma.create');
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
            'customer_name' => 'required',
            'invoice_number' => 'required'


        ]);
        $data = $request->all();

        $estimate_data['invoice_number']    = $request->invoice_number;
        $estimate_data['invoice_date']      = $request->invoice_date;
        $estimate_data['customer_name']     = $request->customer_name;
        $estimate_data['gst_available']     = $request->gst_available;
        $estimate_data['customer_phone']    = $request->customer_phone;
        $estimate_data['gst_number']        = $request->gst_number;
        $estimate_data['grand_total']       = $request->grand_total;
        $estimate_data['generated_by']      = Auth::user()->name;
        $estimate_data['add_date']          = Carbon::now();


        $estimate_product   =   $request->get('estimate_product');
        $warrenty           =   $request->get('warrenty');
        $unit_price         =   $request->get('unitPrice');
        $qty                =   $request->get('qty');
        $product_tax        =   $request->get('product_tax');
        $total              =   $request->get('total');


        // $estimate_get = DB::table('estimates')->orderBy('id','DESC')->first();
        // $Proforma_id = ($estimate_get->id)+1;
        $estimate_status = DB::table('proforma_invoices')->insert($estimate_data);
        if($estimate_status){
            $estimate_get = DB::table('proforma_invoices')->orderBy('id','DESC')->first();
            $Proforma_id = ($estimate_get->id);
            for($i = 0; $i < count($estimate_product); $i++){
                $datasave = [
                    'Proforma_id'       =>  $Proforma_id,
                    'product_name'      =>  $estimate_product[$i],
                    'warrenty'          =>  $warrenty[$i],
                    'unit_price'        =>  $unit_price[$i],
                    'product_tax'       =>  $product_tax[$i],
                    'qty'               =>  $qty[$i],
                    'total'             =>  $total[$i]
                ];
                $status = DB::table('proforma_invoice_items')->insert($datasave);
            }

            if($status){
                Toastr::success('Details Added', 'success',["positionClass" => "toast-bottom-right"]);
                return redirect()->route('generate_invoice',['id' => $Proforma_id]);
            }
            else{
                Toastr::error('please try again!', 'error',["positionClass" => "toast-bottom-right"]);
                return redirect()->back();

            }
        }
        else{
            Toastr::error('try again!', 'error',["positionClass" => "toast-bottom-right"]);
            return redirect()->route('generate_invoice',['id' => $Proforma_id]);

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
        $estimate = DB::table('proforma_invoices')->where('id',$id)->first();
        $estimate_details = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->get();
        return view('proforma.show',compact('estimate_details','estimate'));
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

    public function invoice_report($id)
    {
        $estimate = DB::table('proforma_invoices')->where('id',$id)->first();
        $estimate_details = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->get();
        $gst_count = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->where('product_tax','>',0)->count();

        return view('proforma.invoice_report',compact('estimate_details','estimate','gst_count'));
    }

    public function generate_invoice($id){
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
        $estimate = DB::table('proforma_invoices')->where('id',$id)->first();
        $estimate_details = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->get();
        $total_unit_price = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->sum('unit_price');
        $total_qty = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->where('product_name','<>','')->sum('qty');
        $gst_count = DB::table('proforma_invoice_items')->where('Proforma_id',$id)->where('product_tax','>',0)->count();
        $generated_by = Auth::user()->name;
        $grand_total_in_words = strtoupper(number_to_word($estimate->grand_total));

        $pdf = Pdf::loadView('proforma.invoice',compact('estimate_details','estimate','total_unit_price','total_qty','generated_by','grand_total_in_words','gst_count'))->setPaper('a4', 'portrait');
        return $pdf->stream('Techsoul Cyber Solutions - Proforma Invoice.pdf',array("Attachment"=>false));
    }
}
