<?php

namespace App\Http\Controllers;

use App\Models\Consoulidate;
use App\Models\Customer;
use App\Models\DirectSales;
use App\Models\Invoice;
use App\Models\SalesItems;
use App\Models\staffs;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsoulidateController extends Controller
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
        $request->validate([
            'description' => 'required|string',
            'gst' => 'nullable|integer',
            'sales_id' => 'required|string',
        ]);

        $consoulidate = new Consoulidate();
        $consoulidate->sales_id = $request->sales_id;
        $consoulidate->gst = $request->gst;
        $consoulidate->description = $request->description;

        $status = $consoulidate->save();

        if ($status) {
            Toastr::success('Invoice Added', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Try again!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->route('directSales.show', $request->sales_id);
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
        $request->validate([
            'description' => 'required|string',
            'gst' => 'nullable|integer',
        ]);

        $consoulidate = Consoulidate::findOrFail($id);
        $consoulidate->description = $request->description;
        $consoulidate->gst = $request->gst;
        $status = $consoulidate->save();

        if ($status) {
            Toastr::success('Invoice Updated Successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        } else {
            Toastr::error('Error in updating invoice!', 'Error', ["positionClass" => "toast-bottom-right"]);
        }

        return redirect()->route('directSales.show', $consoulidate->sales_id);
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
    public function consolidates_create($id)
    {
        $consolidate_bill = Consoulidate::where('sales_id', $id)->first();
        $sale = DirectSales::findOrFail($id);
        $salesItems = SalesItems::where('sales_id', $id)->get();
        if($consolidate_bill) {
            // return $consolidate_bill;
            return view('consolidate.create', compact('salesItems', 'sale', 'consolidate_bill'));
        } else {
            foreach($salesItems as $item){
                $item->product_name = $item->product_detail->product_name .' '. $item->serial_number;
            }
            return view('consolidate.create', compact('salesItems', 'sale'));
        }
    }
    public function consolidates_invoice($id)
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
        $salesDetails = DirectSales::where('id',$id)->first();
        $completeReportDetails = array();
        $qtyTotal = 1;
        $completeReportDetails['invoice_number'] = $salesDetails->invoice_number;
        $completeReportDetails['invoice_date'] = Carbon::createFromFormat('Y-m-d',$salesDetails->sales_date)->format('d-m-Y');
        $get_customer = Customer::where('id',$salesDetails->customer_id)->first();
        $completeReportDetails['customer_name'] = $get_customer->name;
        $completeReportDetails['pay_method'] = $salesDetails->pay_method;
        $completeReportDetails['customer_place'] = $get_customer->place;
        $getInvoice = Invoice::where('sales_id',$id)->latest('id')->first();
        if($getInvoice->is_gst == "Yes")
        {
            $completeReportDetails['gst_number'] = $salesDetails->gst_number;
        }
        else
        {
            $completeReportDetails['gst_number'] = "";
        }
        $completeReportDetails['qty_total'] = $qtyTotal;
        $getConsoulidate = Consoulidate::where('sales_id',$id)->get();
        $gst_amount = 0.00;
        $netTotal = 0.00;
        $getSoldItems = array();
        foreach($getConsoulidate as $item)
        {
            $unitPrice = number_format((float) $salesDetails->grand_total / (1 + $item->gst / 100), 2, '.', '');  
            $unitQty = 1;
            $gstPercent = number_format((float) $item->gst , 2, '.', '');

            $total = $unitPrice * $unitQty;
            $gst = ($unitPrice * $unitQty * $gstPercent) / 100;

            $gst_amount += $gst;
            $netTotal += $total;
            $getSoldItems[] = [
                'product_id' => "159", 
                'serial_number' => $item->description,
                'product_quantity' => "1",
                'unit_price' => $unitPrice,
                'gst_percent' => $gstPercent,
                'sales_price' => $salesDetails->grand_total,
            ];
        }
        $completeReportDetails['net_total'] = number_format((float)$netTotal, 2, '.', '');
        $discount = number_format((float) $salesDetails->discount, 2, '.', '');
        $grandTotal = number_format((float) $salesDetails->grand_total, 2, '.', '');
        $discounted_total = $grandTotal-$salesDetails->discount;
        $completeReportDetails['gst_amount'] = $gst_amount;
        $completeReportDetails['discount'] = $salesDetails->discount;
        $completeReportDetails['grand_total'] = $grandTotal;
        $completeReportDetails['discounted_total'] = $discounted_total;
        $grand_total_in_words = number_to_word($discounted_total);
        $completeReportDetails['grand_total_words'] = strtoupper($grand_total_in_words);
        $completeReportDetails['sales_items'] = $getSoldItems;
        $get_sales_staff = staffs::where('id',$salesDetails->sales_staff)->first();
        $completeReportDetails['sales_staff'] = $get_sales_staff->staff_name;
        $invoice_details = Invoice::where('sales_id',$id)->first();
        if($invoice_details->bill_generated == Null){
            $data['bill_generated'] = strtoupper(Auth::user()->name);
            $status = Invoice::where('id',$invoice_details->id)->update($data);
            $bill_generated = strtoupper(Auth::user()->name);
        }
        else{
            $bill_generated = $invoice_details->bill_generated;
        }
        $completeReportDetails['bill_generated_staff'] = $bill_generated;
        $completeReportDetails['sales_id'] = $id;
        // return $completeReportDetails;
        $pdf = Pdf::loadView('consolidate.invoice',compact('completeReportDetails'));

        return $pdf->stream($salesDetails->invoice_number.'-Techsoul Cyber Solution.pdf',array("Attachment"=>false));
    }
    public function WhatsappConsolidateInvoice($id)
    {
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
        $salesDetails = DirectSales::where('id',$id)->first();
        $completeReportDetails = array();
        $qtyTotal = 1;
        $completeReportDetails['invoice_number'] = $salesDetails->invoice_number;
        $completeReportDetails['invoice_date'] = Carbon::createFromFormat('Y-m-d',$salesDetails->sales_date)->format('d-m-Y');
        $get_customer = Customer::where('id',$salesDetails->customer_id)->first();
        $completeReportDetails['customer_name'] = $get_customer->name;
        $completeReportDetails['pay_method'] = $salesDetails->pay_method;
        $completeReportDetails['customer_place'] = $get_customer->place;
        $getInvoice = Invoice::where('sales_id',$id)->latest('id')->first();
        if($getInvoice->is_gst == "Yes")
        {
            $completeReportDetails['gst_number'] = $salesDetails->gst_number;
        }
        else
        {
            $completeReportDetails['gst_number'] = "";
        }
        $completeReportDetails['qty_total'] = $qtyTotal;
        $getConsoulidate = Consoulidate::where('sales_id',$id)->get();
        $gst_amount = 0.00;
        $netTotal = 0.00;
        $getSoldItems = array();
        foreach($getConsoulidate as $item)
        {
            $unitPrice = number_format((float) $salesDetails->grand_total / (1 + $item->gst / 100), 2, '.', '');
            $unitQty = 1;
            $gstPercent = number_format((float) $item->gst , 2, '.', '');

            $total = $unitPrice * $unitQty;
            $gst = ($unitPrice * $unitQty * $gstPercent) / 100;

            $gst_amount += $gst;
            $netTotal += $total;
            $getSoldItems[] = [
                'product_id' => "159",
                'serial_number' => $item->description,
                'product_quantity' => "1",
                'unit_price' => $unitPrice,
                'gst_percent' => $gstPercent,
                'sales_price' => $salesDetails->grand_total,
            ];
        }
        $completeReportDetails['net_total'] = number_format((float)$netTotal, 2, '.', '');
        $discount = number_format((float) $salesDetails->discount, 2, '.', '');
        $grandTotal = number_format((float) $salesDetails->grand_total, 2, '.', '');
        $discounted_total = $grandTotal-$salesDetails->discount;
        $completeReportDetails['gst_amount'] = $gst_amount;
        $completeReportDetails['discount'] = $salesDetails->discount;
        $completeReportDetails['grand_total'] = $grandTotal;
        $completeReportDetails['discounted_total'] = $discounted_total;
        $grand_total_in_words = number_to_word1($discounted_total);
        $completeReportDetails['grand_total_words'] = strtoupper($grand_total_in_words);
        $completeReportDetails['sales_items'] = $getSoldItems;
        $get_sales_staff = staffs::where('id',$salesDetails->sales_staff)->first();
        $completeReportDetails['sales_staff'] = $get_sales_staff->staff_name;
        $invoice_details = Invoice::where('sales_id',$id)->first();
        if($invoice_details->bill_generated == Null){
            $data['bill_generated'] = strtoupper(Auth::user()->name);
            $status = Invoice::where('id',$invoice_details->id)->update($data);
            $bill_generated = strtoupper(Auth::user()->name);
        }
        else{
            $bill_generated = $invoice_details->bill_generated;
        }
        $completeReportDetails['bill_generated_staff'] = $bill_generated;
        $completeReportDetails['sales_id'] = $id;
        $fileName = "Techsoul Cyber Solutions - #" . $salesDetails->invoice_number. ".pdf";
        $pdf = Pdf::loadView('consolidate.userInvoice',compact('completeReportDetails'));
        return $pdf->download($fileName,array("Attachment"=>false));
    }
}
