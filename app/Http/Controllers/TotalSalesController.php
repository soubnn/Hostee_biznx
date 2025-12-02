<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use App\Models\DirectSales;
use App\Models\SalesItems;
use App\Models\stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TotalSalesController extends Controller
{
    public function totalSalesLoginView()
    {
        return view('total_sale.login');
    }
    public function totalSalesLogin(Request $request)
    {
        $password = $request->input('password');
        if ($password === '1123') {
            $request->session()->put('total_sales_logged_in', true);
            $days = 30;
            $minutes = 60 * 24 * $days;
            $cookie = cookie('total_sales_logged_in', true, $minutes);
            Toastr::success('Welcome to biznx Current Works', 'success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('loginsubmit.dashboard')->withCookie($cookie);
        } else {
            Toastr::error('Invalid password. Please try again!', 'error', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    public function getTotalSalesDetailsMobile()
    {
        $previousMonth  = Carbon::now()->subMonth();
        $currentMonth   = Carbon::now();
        $today          = Carbon::now();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        $previousMonthSales = DirectSales::whereMonth('sales_date', $previousMonth->month)->whereYear('sales_date', $previousMonth->year)->get();
        $previousMonthSaleItemProductAmount = 0;
        foreach( $previousMonthSales as $previousMonthSale ){
            $previousMonthSaleItems = SalesItems::where('sales_id', $previousMonthSale->id)->get();
            foreach( $previousMonthSaleItems as $previousMonthSaleItem ){
                if($previousMonthSaleItem->product_id == '159'){
                    if($previousMonthSale->invoice_number == null){
                        $previousMonthSaleItemProductAmount += 0;
                    }else{
                        $previousMonthConsignment = DB::table('consignments')->where('invoice_no',$previousMonthSale->invoice_number)->first();
                        if(!empty($previousMonthConsignment)){
                            $previousMonthChiplevel = DB::table('chiplevels')->where('jobcard_id',$previousMonthConsignment->id)->first();
                            if ($previousMonthChiplevel) {
                                if ($previousMonthChiplevel->service_charge) {
                                    $previousMonthSaleItemProductAmount += $previousMonthChiplevel->service_charge;
                                } else {
                                    $previousMonthSaleItemProductAmount += 0;
                                }
                            } else {

                                $previousMonthSaleItemProductAmount += 0;
                            }
                        }else{
                            $previousMonthSaleItemProductAmount += 0;
                        }
                    }
                }else{
                    $productUnitPrice = stock::where('product_id', $previousMonthSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $previousMonthSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $previousMonthSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $previousMonthSalesGrandTotal   = DirectSales::whereMonth('sales_date', $previousMonth->month)->whereYear('sales_date', $previousMonth->year)->sum('grand_total');
        $previousMonthSalesDiscount     = DirectSales::whereMonth('sales_date', $previousMonth->month)->whereYear('sales_date', $previousMonth->year)->sum('discount');
        $previousMonthSalesTotal        = $previousMonthSalesGrandTotal - $previousMonthSalesDiscount;
        $previousMonthSalesTotalProfit  = $previousMonthSalesTotal - $previousMonthSaleItemProductAmount;

        $currentMonthSales = DirectSales::whereMonth('sales_date', $currentMonth->month)->whereYear('sales_date', $currentMonth->year)->get();
        $currentMonthSaleItemProductAmount = 0;
        foreach( $currentMonthSales as $currentMonthSale ){
            $currentMonthSaleItems = SalesItems::where('sales_id', $currentMonthSale->id)->get();
            foreach( $currentMonthSaleItems as $currentMonthSaleItem ){
                if( $currentMonthSaleItem->product_id == '159'){
                    if($currentMonthSale->invoice_number == null){
                        $currentMonthSaleItemProductAmount += 0;
                    }else{
                        $currentMonthConsignment = DB::table('consignments')->where('invoice_no',$currentMonthSale->invoice_number)->first();
                        if(!empty($currentMonthConsignment)){
                            $currentMonthChiplevel = DB::table('chiplevels')->where('jobcard_id',$currentMonthConsignment->id)->first();
                            if ($currentMonthChiplevel) {
                                if ($currentMonthChiplevel->service_charge) {
                                    $currentMonthSaleItemProductAmount += $currentMonthChiplevel->service_charge;
                                } else {
                                    $currentMonthSaleItemProductAmount += 0;
                                }
                            } else {

                                $currentMonthSaleItemProductAmount += 0;
                            }
                        }else{
                            $currentMonthSaleItemProductAmount += 0;
                        }
                    }
                }else{
                    $productUnitPrice = stock::where('product_id', $currentMonthSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $currentMonthSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $currentMonthSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $currentMonthSalesGrandTotal = DirectSales::whereMonth('sales_date', $currentMonth->month)->whereYear('sales_date', $currentMonth->year)->sum('grand_total');
        $currentMonthSalesDiscount = DirectSales::whereMonth('sales_date', $currentMonth->month)->whereYear('sales_date', $currentMonth->year)->sum('discount');
        $currentMonthSalesTotal = $currentMonthSalesGrandTotal - $currentMonthSalesDiscount;
        $currentMonthSalesTotalProfit = $currentMonthSalesTotal - $currentMonthSaleItemProductAmount;

        // Sales for the Current Week
        $weekSales = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->get();
        $weekSaleItemProductAmount = 0;
        foreach( $weekSales as $weekSale ){
            $weekSaleItems = SalesItems::where('sales_id', $weekSale->id)->get();
            foreach( $weekSaleItems as $weekSaleItem ){
                if( $weekSaleItem->product_id == '159'){
                    if($weekSale->invoice_number == null){
                        $weekSaleItemProductAmount += 0;
                    }else{
                        $weekConsignment = DB::table('consignments')->where('invoice_no',$weekSale->invoice_number)->first();
                        if(!empty($weekConsignment)){
                            $weekChiplevel = DB::table('chiplevels')->where('jobcard_id',$weekConsignment->id)->first();
                            if ($weekChiplevel) {
                                if ($weekChiplevel->service_charge) {
                                    $weekSaleItemProductAmount += $weekChiplevel->service_charge;
                                } else {
                                    $weekSaleItemProductAmount += 0;
                                }
                            } else {

                                $weekSaleItemProductAmount += 0;
                            }
                        }else{
                            $weekSaleItemProductAmount += 0;
                        }
                    }
                }else{
                    $productUnitPrice = stock::where('product_id', $weekSaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $weekSaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $weekSaleItemProductAmount += 0;
                    }
                }
            }
        }
        $weekSalesGrandTotal = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->sum('grand_total');
        $weekSalesDiscount = DirectSales::whereBetween('sales_date', [$startOfWeek, $endOfWeek])->sum('discount');
        $weekSalesTotal = $weekSalesGrandTotal - $weekSalesDiscount;
        $weekSalesTotalProfit = $weekSalesTotal - $weekSaleItemProductAmount;

        $todaySales = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->get();
        $todaySaleItemProductAmount = 0;
        foreach( $todaySales as $todaySale ){
            $todaySaleItems = SalesItems::where('sales_id', $todaySale->id)->get();
            foreach( $todaySaleItems as $todaySaleItem ){
                if( $todaySaleItem->product_id == '159'){
                    if($todaySale->invoice_number == null){
                        $todaySaleItemProductAmount += 0;
                    }else{
                        $todayConsignment = DB::table('consignments')->where('invoice_no',$todaySale->invoice_number)->first();
                        if(!empty($todayConsignment)){
                            $todayChiplevel = DB::table('chiplevels')->where('jobcard_id',$todayConsignment->id)->first();
                            if ($todayChiplevel) {
                                if ($todayChiplevel->service_charge) {
                                    $todaySaleItemProductAmount += $todayChiplevel->service_charge;
                                } else {
                                    $todaySaleItemProductAmount += 0;
                                }
                            } else {

                                $todaySaleItemProductAmount += 0;
                            }
                        }else{
                            $todaySaleItemProductAmount += 0;
                        }
                    }
                }else{
                    $productUnitPrice = stock::where('product_id', $todaySaleItem->product_id)->first();
                    if ($productUnitPrice) {
                        $gst = ($productUnitPrice->product_details->product_cgst + $productUnitPrice->product_details->product_sgst) / 100;
                        $todaySaleItemProductAmount += $productUnitPrice->product_unit_price * (1 + $gst);
                    } else {
                        $todaySaleItemProductAmount += 0;
                    }
                }
            }
        }
        $todaySalesGrandTotal = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->sum('grand_total');
        $todaySalesDiscount = DirectSales::whereDate('sales_date', $today->format('Y-m-d'))->sum('discount');
        $todaySalesTotal = $todaySalesGrandTotal - $todaySalesDiscount;
        $todaySalesTotalProfit = $todaySalesTotal - $todaySaleItemProductAmount;

        return view('total_sale.mobile',compact('previousMonth','previousMonthSalesTotal','previousMonthSalesTotalProfit','currentMonth','currentMonthSalesTotal','currentMonthSalesTotalProfit','startOfWeek','endOfWeek','weekSalesTotal','weekSalesTotalProfit','today','todaySalesTotal','todaySalesTotalProfit'));
    }
    public function logout(Request $request)
    {
        $cookie = \Cookie::forget('total_sales_logged_in');
        return redirect()->route('total_sales.details.mobile')->withCookie($cookie)->with('success', 'Successfully logged out.');
    }
}
