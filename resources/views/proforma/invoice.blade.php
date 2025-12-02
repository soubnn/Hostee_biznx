<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PROFORMA INVOICE</title>
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet"> --}}
    <style type="text/css">
        /* cyrillic-ext */

        body {
            font-family: Calibri, Arial, sans-serif;
            margin: 0;
        }

        .top_headder {
            width: 100%;
            height: auto;
            padding: 0 0 0 0;
            background: #FFF;
        }

        .banner_body {
            padding: 0px 0px;
            background: #fff;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .container_banner {

            margin: auto;
            /*padding: 0px 10px 0px 10px;*/
            /*width: 19cm;*/
            /*height: 27.7cm;*/
            /*width: 840px;*/
            /*height: auto;*/
        }

        div,
        p,
        a,
        li,
        td {
            -webkit-text-size-adjust: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            mso-table-lspace: 0;
            mso-table-rspace: 0;
        }

        table td,
        th {
            border-collapse: collapse;
            mso-table-lspace: 0;
            mso-table-rspace: 0;
            padding: 5px;
            font-size: 11px;
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        td {
            word-break: break-word;
        }

        a {
            word-break: break-word;
            text-decoration: none;
            color: inherit;
        }

        body .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        body .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        body {
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        html {
            background-color: #ffffff;
            width: 100%;
        }

        body img {
            user-drag: none;
            -moz-user-select: none;
            -webkit-user-drag: none;
        }

        body td img:hover {
            opacity: 0.85;
            filter: alpha(opacity=85);
        }

        body a.rotator img {
            -webkit-transition: all 1s ease-in-out;
            -moz-transition: all 1s ease-in-out;
            -o-transition: all 1s ease-in-out;
            -ms-transition: all 1s ease-in-out;
        }

        body a.rotator img:hover {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
        }

        body .hover:hover {
            opacity: 0.85;
            filter: alpha(opacity=85);
        }

        body .jump:hover {
            opacity: 0.75;
            filter: alpha(opacity=75);
            padding-top: 10px !important;
        }

        body #logoTop img {
            width: 160px;
            height: auto;
        }

        body .image147 img {
            width: 118px;
            height: auto;
        }

        .invtable td {
            border-right: 1px solid;
        }

        @media print {
            div.red {
                page-break-inside: auto !important;
                color: red !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /*@page{*/
        /*size: 5cm 20cm landscape;*/
        /*}*/
    </style>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="top_headder" style="padding: 0;margin-left:-15px;">
        <div class="container_banner">
            <div class="banner_body">
                <table border="0" class="table topbanner mystyle" style="margin-bottom:10px;width: 100%" width="100%">
                    <tbody>
                        <tr>
                            <td style="padding: 0;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td align="center" width="60%" style="padding: 0;">
                                                <img src="{{ asset('assets/images/invoice/logo.png') }}" width="320" style="width: 320px;margin: auto;">
                                                {{-- <img src="https://techsoul.biznx.in/assets/images/invoice/logo.png" style="width: 320px;margin: auto;"> --}}
                                                <p style="font-size: 11px;font-weight: 600;margin: 0;font-family: Arial, Helvetica, sans-serif;">
                                                    GSTIN : 32ADNPO8730B1ZO<br />
                                                    OPP.TRUST HOSPITAL ROOM NO: 20/792, RM-VENTURES, RANDATHANI.PO<br />
                                                    MALAPPURAM-KERALA Tel: +918891989842<br />
                                                    email: service@teamtechsoul.com
                                                </p>
                                            </td>
                                            <td width="40%" valign="top" style="padding: 0;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2" style="color:#215967;font-size: 20px;font-weight: bolder;text-align: right;padding: 0;">
                                                                INVOICE
                                                            </td>
                                                        </tr>
                                                        <tr style="border-bottom: 2px solid #dddddd;">
                                                            <td style="font-size: 14px;padding-bottom: 10px;">
                                                                @php
                                                                    $current_month = Carbon\carbon::now()->format('m');
                                                                    $current_year = Carbon\carbon::now()->format('y');
                                                                    if($current_month > 4){
                                                                        $next_year = $current_year+1;
                                                                        $est_string = $current_year.$next_year;
                                                                    }
                                                                    else{
                                                                        $prev_year = $current_year-1;
                                                                        $est_string = $prev_year.$current_year;
                                                                    }

                                                                @endphp
                                                                <small>Invoice No</small><br /><span class="red" style="color: #c00000;font-weight: bold;">{{ $estimate->invoice_number }}</span>
                                                            </td>
                                                            <td style="font-size: 14px;padding-bottom: 10px;">
                                                                <small>Date</small><br /><span class="red" style="color: #c00000;font-weight: bold;">
                                                                    {{ Carbon\carbon::parse($estimate->invoice_date)->format('d F Y')  }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-bottom: 2px solid #dddddd;">
                                                            <td colspan="2"
                                                                style="font-size: 12px;padding-bottom: 10px;">
                                                                <span style="display: block;">Customer Details</span>
                                                                <strong style="display: block;">
                                                                    {{ $estimate->customer_name }}<br>{{ $estimate->customer_phone }} <br>
                                                                </strong>
                                                                @if($estimate->gst_available == 'Yes')
                                                                    <p style="margin: 0;padding: 0;"><b>GSTIN : <span>{{ $estimate->gst_number }}</span></b></p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-size: 12px;">
                                                                <span style="display: block;">Payment Method</span>
                                                                <strong style="display: block;">CASH</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            @if ($gst_count > 0)
                                <td style="padding: 0;margin: 0;">
                                    <table width="100%" class="invtable" border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;border-left: 1px solid #918f8e;margin: 0;margin-top:15px;">
                                        <thead>
                                            <tr style="height: 30px;">
                                                <th rowspan="2" width="13" style="border: 1px solid;text-align: center;">SL.<br/>NO</th>
                                                <th rowspan="2" width="128" style="border: 1px solid;">Description of Goods</th>
                                                <th rowspan="2" width="38" style="border: 1px solid;">Warrenty</th>
                                                <th rowspan="2" width="40" style="border: 1px solid;">Unit Price</th>
                                                <th rowspan="2" width="15" style="border: 1px solid;">Qty</th>
                                                <th rowspan="2" width="35" style="border: 1px solid;">Amount</th>
                                                <th rowspan="2" width="35" style="border: 1px solid;">Taxable<br/>Value</th>
                                                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">SGST</th>
                                                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">CGST</th>
                                                <th rowspan="2" width="50" style="border: 1px solid;">Grand Total</th>
                                            </tr>
                                            <tr>
                                                <th width="18" style="border: 1px solid;">Rate</th>
                                                <th width="33" style="border: 1px solid;">Amount</th>
                                                <th width="18" style="border: 1px solid;">Rate</th>
                                                <th width="33" style="border: 1px solid;">Amount</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                            $row_length = 0;
                                            $sgst_total=0;
                                            $cgst_total=0;
                                            $taxable_total = 0;
                                        @endphp
                                        <tbody style="vertical-align: top;" valign="top">
                                            @foreach ( $estimate_details as $estimate_details)
                                                @if($estimate_details->product_name)
                                                    <tr>
                                                        <td style="text-align: center;">{{ $no }}</td>
                                                        @php
                                                            if (is_numeric($estimate_details->product_name) && ctype_digit(strval($estimate_details->product_name))) {
                                                                $get_product = DB::table('products')->where('id', $estimate_details->product_name)->first();
                                                            } else {
                                                                $get_product = null;
                                                            }
                                                        @endphp
                                                        @if ($get_product)
                                                            @php
                                                            $name_length = strlen($get_product->product_name);
                                                            @endphp
                                                            @if ($name_length > 50 && $name_length < 100)
                                                                @php
                                                                    $product_name1 = substr($get_product->product_name,0,50);
                                                                    $product_name2 = substr($get_product->product_name,50);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                @php
                                                                    $row_length= $row_length+28;
                                                                @endphp
                                                            @elseif($name_length > 100)
                                                                @php
                                                                    $product_name1 = substr($get_product->product_name,0,50);
                                                                    $product_name2 = substr($get_product->product_name,50,50);
                                                                    $product_name3 = substr($get_product->product_name,100);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+38;
                                                                    @endphp
                                                            @else
                                                                <td>{{ $get_product->product_name }}</td>
                                                                @php
                                                                    $row_length= $row_length+18;
                                                                @endphp
                                                            @endif
                                                        @else
                                                            @php
                                                                $name_length = strlen($estimate_details->product_name);
                                                            @endphp
                                                            @if ($name_length > 50 && $name_length <= 100)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+28;
                                                                    @endphp
                                                            @elseif($name_length > 100 && $name_length <= 150)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+38;
                                                                    @endphp
                                                            @elseif($name_length > 150 && $name_length <= 200)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+48;
                                                                    @endphp
                                                            @elseif($name_length > 200 && $name_length <= 250)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+58;
                                                                    @endphp
                                                            @elseif($name_length > 250 && $name_length <= 300)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+68;
                                                                    @endphp
                                                            @elseif($name_length > 300 && $name_length <= 350)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+78;
                                                                    @endphp
                                                            @elseif($name_length > 350)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+88;
                                                                    @endphp
                                                        {--    @elseif($name_length > 500)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350,50);
                                                                    $product_name9 = substr($estimate_details->product_name,400,50);
                                                                    $product_name10 = substr($estimate_details->product_name,450,50);
                                                                    $product_name11 = substr($estimate_details->product_name,500);
                                                                @endphp
                                                                    <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}<br>{{ $product_name9 }}<br>{{ $product_name10 }}<br>{{ $product_name11 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+118;
                                                                    @endphp --}
                                                            @else
                                                                <td>{{ $estimate_details->product_name }}</td>
                                                                @php
                                                                    $row_length= $row_length+18;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                        <td>{{ $estimate_details->warrenty }}</td>
                                                        @php
                                                            $unit_price = number_format((float)$estimate_details->unit_price, 2, '.', '');
                                                        @endphp
                                                        <td>{{ $unit_price }}</td>
                                                        <td>{{ $estimate_details->qty }}</td>
                                                        @php
                                                            $amount = round($estimate_details->qty * $estimate_details->unit_price,2);
                                                        @endphp
                                                        <td>{{ number_format((float)$amount, 2, '.', '') }}</td>
                                                        <td>{{ number_format((float)$amount, 2, '.', '') }}</td>
                                                        @php
                                                            $sgst = $cgst = ($estimate_details->product_tax)/2;
                                                        @endphp
                                                        <td style="text-align: right;">{{ $sgst }}</td>
                                                        @php
                                                            $sgst_value = round(($amount*$sgst)/100,2);
                                                        @endphp
                                                        <td style="text-align: right;">{{ number_format((float)$sgst_value, 2, '.', '') }}</td>
                                                        <td style="text-align: right;">{{ $cgst }}</td>
                                                        @php
                                                            $cgst_value = round(($amount*$cgst)/100,2);
                                                        @endphp
                                                        <td style="text-align: right;">{{ number_format((float)$cgst_value, 2, '.', '') }}</td>
                                                        <td>{{ $estimate_details->total }}</td>
                                                    </tr>
                                                    @php
                                                        $no++;
                                                        $sgst_total = $sgst_total+$sgst_value;
                                                        $cgst_total = $cgst_total+$cgst_value;
                                                        $taxable_total = $taxable_total+$amount;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @php
                                                $row_limit = 315-$row_length;
                                            @endphp
                                            <tr>
                                                <td style="height:{{ $row_limit }} !important;"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="border: 1px solid"></td>
                                                <td colspan="2" style="text-align: right;border: 1px solid">
                                                    <b>TOTAL</b>
                                                </td>
                                                <td style="border: 1px solid">{{ number_format((float) $total_unit_price, 2, '.', '') }}</td>
                                                <td style="border: 1px solid">{{ $total_qty }}</td>
                                                <td style="border: 1px solid"></td>
                                                <td style="border: 1px solid">{{ number_format($taxable_total, 2, '.', '') }}</td>
                                                <td style="border: 1px solid"></td>
                                                <td style="border: 1px solid">{{ number_format($sgst_total, 2, '.', '') }}</td>
                                                <td style="border: 1px solid"></td>
                                                <td style="border: 1px solid">{{ number_format($cgst_total, 2, '.', '') }}</td>
                                                <td style="text-align: right;border: 1px solid">
                                                    <b>{{ number_format((float) $estimate->grand_total, 2, '.', '') }}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            @else
                                <td style="padding: 0;margin: 0;">
                                    <table width="100%" class="invtable" border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;border-left: 1px solid #918f8e;margin: 0;margin-top:15px;">
                                        <thead>
                                            <tr style="height: 30px;">
                                                <th colspan="2" style="border: 1px solid;text-align: center;">SL. NO</th>
                                                <th width="135" colspan="3" style="border: 1px solid;">Description of Goods</th>
                                                <th width="35" colspan="2" style="border: 1px solid;">Warrenty</th>
                                                <th width="35" colspan="2" style="border: 1px solid;">Unit Price</th>
                                                <th width="35" style="border: 1px solid;">Qty</th>
                                                <th width="50" colspan="2" style="border: 1px solid;">Total</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                            $row_length = 0;
                                        @endphp
                                        <tbody style="vertical-align: top;" valign="top">
                                            @foreach ( $estimate_details as $estimate_details)
                                                @if($estimate_details->product_name)
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;">{{ $no }}</td>
                                                        @php
                                                            if (is_numeric($estimate_details->product_name) && ctype_digit(strval($estimate_details->product_name))) {
                                                                $get_product = DB::table('products')->where('id', $estimate_details->product_name)->first();
                                                            } else {
                                                                $get_product = null;
                                                            }
                                                        @endphp
                                                        @if ($get_product)
                                                            @php
                                                            $name_length = strlen($get_product->product_name);
                                                            @endphp
                                                            @if ($name_length > 50 && $name_length < 100)
                                                                @php
                                                                    $product_name1 = substr($get_product->product_name,0,50);
                                                                    $product_name2 = substr($get_product->product_name,50);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                @php
                                                                    $row_length= $row_length+28;
                                                                @endphp
                                                            @elseif($name_length > 100)
                                                                @php
                                                                    $product_name1 = substr($get_product->product_name,0,50);
                                                                    $product_name2 = substr($get_product->product_name,50,50);
                                                                    $product_name3 = substr($get_product->product_name,100);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+38;
                                                                    @endphp
                                                            @else
                                                                <td colspan="3">{{ $get_product->product_name }}</td>
                                                                @php
                                                                    $row_length= $row_length+18;
                                                                @endphp
                                                            @endif
                                                        @else
                                                            @php
                                                                $name_length = strlen($estimate_details->product_name);
                                                            @endphp
                                                            @if ($name_length > 50 && $name_length <= 100)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+28;
                                                                    @endphp
                                                            @elseif($name_length > 100 && $name_length <= 150)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+38;
                                                                    @endphp
                                                            @elseif($name_length > 150 && $name_length <= 200)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+48;
                                                                    @endphp
                                                            @elseif($name_length > 200 && $name_length <= 250)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+58;
                                                                    @endphp
                                                            @elseif($name_length > 250 && $name_length <= 300)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+68;
                                                                    @endphp
                                                            @elseif($name_length > 300 && $name_length <= 350)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+78;
                                                                    @endphp
                                                            @elseif($name_length > 350 && $name_length <= 400)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+88;
                                                                    @endphp
                                                                @elseif($name_length > 400 && $name_length <= 450)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350,50);
                                                                    $product_name9 = substr($estimate_details->product_name,400);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}<br>{{ $product_name9 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+98;
                                                                    @endphp
                                                                @elseif($name_length > 450 && $name_length <= 500)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350,50);
                                                                    $product_name9 = substr($estimate_details->product_name,400,50);
                                                                    $product_name10 = substr($estimate_details->product_name,450);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}<br>{{ $product_name9 }}<br>{{ $product_name10 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+108;
                                                                    @endphp
                                                                @elseif($name_length > 500)
                                                                @php
                                                                    $product_name1 = substr($estimate_details->product_name,0,50);
                                                                    $product_name2 = substr($estimate_details->product_name,50,50);
                                                                    $product_name3 = substr($estimate_details->product_name,100,50);
                                                                    $product_name4 = substr($estimate_details->product_name,150,50);
                                                                    $product_name5 = substr($estimate_details->product_name,200,50);
                                                                    $product_name6 = substr($estimate_details->product_name,250,50);
                                                                    $product_name7 = substr($estimate_details->product_name,300,50);
                                                                    $product_name8 = substr($estimate_details->product_name,350,50);
                                                                    $product_name9 = substr($estimate_details->product_name,400,50);
                                                                    $product_name10 = substr($estimate_details->product_name,450,50);
                                                                    $product_name11 = substr($estimate_details->product_name,500);
                                                                @endphp
                                                                    <td colspan="3">{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}<br>{{ $product_name7 }}<br>{{ $product_name8 }}<br>{{ $product_name9 }}<br>{{ $product_name10 }}<br>{{ $product_name11 }}</td>
                                                                    @php
                                                                        $row_length= $row_length+118;
                                                                    @endphp
                                                            @else
                                                                <td colspan="3">{{ $estimate_details->product_name }}</td>
                                                                @php
                                                                    $row_length= $row_length+18;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                        <td colspan="2">{{ $estimate_details->warrenty }}</td>
                                                        <td colspan="2">{{ number_format((float) $estimate_details->unit_price, 2, '.', '') }}</td>
                                                        <td>{{ $estimate_details->qty }}</td>
                                                        <td colspan="2">{{ $estimate_details->total }}</td>
                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @php
                                                $row_limit = 340-$row_length;
                                            @endphp
                                            <tr>
                                                <td colspan="2" style="height:{{ $row_limit }} !important;"></td>
                                                <td colspan="3"></td>
                                                <td colspan="2"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="border: 1px solid"></td>
                                                <td colspan="5" style="text-align: right;border: 1px solid">
                                                    <b>TOTAL</b>
                                                </td>
                                                <td  colspan="2" style="border: 1px solid">{{ number_format((float) $total_unit_price, 2, '.', '') }}</td>
                                                <td style="border: 1px solid">{{ $total_qty }}</td>
                                                <td colspan="2" style="text-align: right;border: 1px solid">
                                                    <b>{{ number_format((float) $estimate->grand_total, 2, '.', '') }}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            @endif

                        </tr>
                        <tr>
                            <td style="padding: 0;margin: 0;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                    style="margin: 0;">
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid">ESTIMATE GENERATED BY</td>
                                            <td style="border: 1px solid" colspan="3">
                                                <b>{{ $generated_by }}</b>
                                            </td>
                                            <!--<td style="text-align: right;border: 1px solid;">ROUND OF</td>-->
                                            <!--<td style="text-align: right;border: 1px solid;" width="60"></td>-->
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid">BANK DETAILS</td>
                                            <td style="border: 1px solid">
                                                <b>BANK</b> : HDFC BANK &nbsp;&nbsp;<b>BRANCH</b> :
                                                PUTHANATHANI<br />
                                                <b>ACCOUNT NUMBER</b> : 50100595803085 &nbsp;&nbsp;<b>IFSC</b> :
                                                HDFC0000977
                                            </td>
                                            <td
                                                style="text-align: right;border: 1px solid;font-size: 14px;font-weight: bold">
                                                GRAND TOTAL </td>
                                            <td style="text-align: right;border: 1px solid #000000;border-bottom: 1px solid #918f8e;border-right: 1px solid #918f8e;font-size: 15px;font-weight: bold;color: #c00000" width="60">
                                                {{ number_format((float) $estimate->grand_total, 2, '.', '') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid"><b>GRAND TOTAL IN WORDS</b></td>
                                            <td style="border: 1px solid" colspan="3">
                                                <b>{{ $grand_total_in_words }} ONLY</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;padding: 8px 0;">
                                <b>TERMS AND CONDITIONS : (1)</b> There will be no warranty or replacement for physical
                                or external damages like:- lightning, mishandling, electric short circuit, warranty seal
                                broken,
                                cover broken or damages caused by courier service. or Without proper Invoice <b>(2)</b>
                                After the payment due date, fine at 24% per month will be charged on the amount overdue.
                                <b>(3)</b>
                                RS 500 will be charged per cheque, if it bounced. <b>(4)</b> The cheque has to be given
                                within 5 days of purchase. If the cheque is not given, the account will be blocked by
                                the account
                                section. <b>(5)</b> Items sold will not be taken back or exchanged. <b>(6)</b> It is the
                                responsibility of the customer to check whether the items are damaged or not. <b>(7)</b>
                                Only the warranty as per
                                manufactures warranty policy will be applicable for the items sold. <b>(8)</b> There is
                                no guarantee for Data
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                    align="center">
                                    <thead>
                                        <tr>
                                            <td width="50%"></td>
                                            <td style="text-align: right;">
                                                For <b>TECHSOUL CYBER SOLUTIONS</b><br />Authorised Signatory
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <img src="" width="60" height="60" style="width:60px;height:60px;margin: 0;">
                                                @php
                                                    $printed_by = Auth::user()->name;
                                                    $printed_on = Carbon\carbon::now();
                                                @endphp
                                                <p style="font-size:10px;">generated by {{ $printed_by }} on {{ $printed_on }}&nbsp;&nbsp; {{ $estimate->id }}</p>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>
