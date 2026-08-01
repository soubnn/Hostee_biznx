<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Debit Note</title>
        {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet"> --}}
        <style type="text/css">
        /* cyrillic-ext */

        body { font-family:Calibri, Arial,sans-serif; margin: 0; }
        .top_headder { width: 100%; height: auto; padding: 0 0 0 0; background: #FFF; }
        .banner_body { padding: 0px 0px; background: #fff; background-position: center center; background-repeat: no-repeat; }
        .container_banner {

            margin: auto;
            /*padding: 0px 10px 0px 10px;*/
            /*width: 19cm;*/
            /*height: 27.7cm;*/
          /*width: 840px;*/
          /*height: auto;*/
        }

        div, p, a, li, td { -webkit-text-size-adjust:none; }
        table {border-collapse: collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;}
        table td, th{border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:5px;font-size: 11px;}
        *{-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
        td{word-break: break-word;}
        a{word-break: break-word; text-decoration: none; color: inherit;}
        body .ReadMsgBody
        {width: 100%; background-color: #ffffff;}
        body .ExternalClass
        {width: 100%; background-color: #ffffff;}
        body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased; font-family: 'Dejavu Sans'}
        html{ background-color:#ffffff; width: 100%;}
        body img {user-drag: none; -moz-user-select: none; -webkit-user-drag: none;}
        body td img:hover {opacity:0.85;filter:alpha(opacity=85);}
        body a.rotator img {-webkit-transition: all 1s ease-in-out;-moz-transition: all 1s ease-in-out; -o-transition: all 1s ease-in-out; -ms-transition: all 1s ease-in-out; }
        body a.rotator img:hover { -webkit-transform: rotate(360deg); -moz-transform: rotate(360deg); -o-transform: rotate(360deg);-ms-transform: rotate(360deg); }
        body .hover:hover {opacity:0.85;filter:alpha(opacity=85);}
        body .jump:hover {opacity:0.75; filter:alpha(opacity=75); padding-top: 10px!important;}
        body #logoTop img {width: 160px; height: auto;}
        body .image147 img {width: 118px; height: auto;}
        .invtable td{border-right: 1px solid;}
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
                                                    <img src="{{ public_path('assets/images/invoice/logo.png') }}" width="320"
                                                        style="width: 290px; margin: auto;">
                                                    <p
                                                        style="font-size: 11px; font-weight: 600; margin: 10px 0 0 0; font-family: Arial, Helvetica, sans-serif;">
                                                        {{-- GSTIN : 32ADNPO8730B1ZO<br /> --}}
                                                        NEAR LANSOR CONSEPTS, CHERUSSOLA ROAD, SWAGATHAMAD<br />
                                                        MALAPPURAM-KERALA Pin : 676503 Tel: +91 85929 24592 /<br /> +91 85929 24692
                                                        email: hosteetheplanner@gmail.com<br />
                                                        www.hosteetheplanner.in
                                                    </p>
                                                </td>
                                                <td width="40%" valign="top" style="padding: 0;">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="2" style="color:#a50d14;font-size: 14px;font-weight: bolder;text-align: right;padding: 0;">DEBIT NOTE</td>
                                                            </tr>
                                                            <tr style="border-bottom: 2px solid #dddddd;">
                                                                <td style="font-size: 13px;padding-bottom: 10px;"><small>Debit Note No</small><br/><span class="red" style="color: #c00000;font-weight: bold;">{{ $invoice_details['debit_no'] }}</span></td>
                                                                <td style="font-size: 14px;padding-bottom: 10px;"><small>Date</small><br/><span class="red" style="color: #c00000;font-weight: bold;">{{ $invoice_details['return_date'] }}</span></td>
                                                            </tr>
                                                            <tr style="border-bottom: 2px solid #dddddd;">
                                                                <td style="font-size: 13px;padding-bottom: 10px;" colspan="2">
                                                                    <small>Against Invoice No</small><br/><span style="font-weight: bold;">{{ $invoice_details['invoice_no'] }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size: 12px;padding-bottom: 10px;">
                                                                    <span style="display: block;">Supplier</span>
                                                                    <strong style="display: block;">{{ $invoice_details['supplier_name'] }}, {{ $invoice_details['supplier_city'] }}</strong>
                                                                    <p style="margin: 0;padding: 0;"> @if($invoice_details['gst_number'])<b>GSTIN : <span>{{ $invoice_details['gst_number'] }}</span></b>@endif</p>
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
                                <td style="padding: 0;margin: 0;">
                                    <table width="100%" class="invtable" border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;margin: 0;margin-top:15px;">
                                        <thead>
                                            <tr style="height: 30px;">
                                                <th rowspan="2" style="border: 1px solid;text-align: center;">SL.<br/>NO</th>
                                                <th rowspan="2" width="135" style="border: 1px solid;">Description of Goods</th>
                                                <th rowspan="2" width="35" style="border: 1px solid;">HSN CODE <br/>(GST)</th>
                                                <th rowspan="2" width="15" style="border: 1px solid;">Qty</th>
                                                <th rowspan="2" width="35" style="border: 1px solid;">Unit Price</th>
                                                {{-- <th rowspan="2" width="35" style="border: 1px solid;">Amount</th> --}}
                                                <th rowspan="2" width="35" style="border: 1px solid;">Taxable<br/>Value</th>
                                                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">SGST</th>
                                                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">CGST</th>
                                                <th rowspan="2" width="50" style="border: 1px solid;">Total</th>
                                            </tr>
                                            <tr>
                                                <th width="15" style="border: 1px solid;">Rate</th>
                                                <th width="30" style="border: 1px solid;">Amount</th>
                                                <th width="15" style="border: 1px solid;">Rate</th>
                                                <th width="30" style="border: 1px solid;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody style="vertical-align: top;" valign="top">
                                            @php
                                                $no = 1;
                                                $row_length = 0;
                                                $net_qty = 0;
                                            @endphp
                                            @foreach ( $invoice_details['purchase_items'] as $item)
                                                <tr>
                                                    @php
                                                        $product = DB::table('products')->where('id',$item->product)->first();
                                                    @endphp
                                                    <td style="text-align: center;">{{ $no }}</td>
                                                    <td style="white-space: normal">{{ $product->product_name }}</td>
                                                    <td style="text-align: right;">{{ $product->hsn_code }}</td>
                                                    <td style="text-align: right;">{{ $item->quantity }}</td>
                                                    <td style="text-align: right;">{{ round($item->unit_price,2) }}</td>
                                                    @php
                                                        $net_qty += $item->quantity;
                                                    @endphp
                                                    <td style="text-align: right;">{{ round($item->amount,2) }}</td>
                                                    {{-- <td style="text-align: right;">{{ round($item->amount,2) }}</td> --}}
                                                    <td style="text-align: right;">{{ $item->gst_percentage }}</td>
                                                    <td style="text-align: right;">{{ round($item->tax,2) }}</td>
                                                    <td style="text-align: right;">{{ $item->gst_percentage }}</td>
                                                    <td style="text-align: right;">{{ round($item->tax,2) }}</td>
                                                    <td style="text-align: right;">{{ round($item->total,2) }}</td>
                                                </tr>
                                                @php
                                                    $row_length= $row_length+18;
                                                    $no++;
                                                @endphp
                                            @endforeach
                                            @php
                                                $row_limit = 286-$row_length;
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
                                                {{-- <td></td> --}}
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;border: 1px solid"><b>TOTAL</b></td>
                                                <td style="text-align: right;border: 1px solid"><b>{{ $net_qty }}</b></td>
                                                <td style="text-align: right;border: 1px solid"></td>
                                                {{-- <td style="text-align: right;border: 1px solid"></td> --}}
                                                <td style="text-align: right;border: 1px solid"><b>{{ round($invoice_details['sub_total'],2) }}</b></td>
                                                <td style="text-align: right;border: 1px solid"></td>
                                                <td style="text-align: right;border: 1px solid"><b>{{ round($invoice_details['net_tax'],2) }}</b></td>
                                                <td style="text-align: right;border: 1px solid"></td>
                                                <td style="text-align: right;border: 1px solid"><b>{{ round($invoice_details['net_tax'],2) }}</b></td>
                                                <td style="text-align: right;border: 1px solid"><b>{{ round($invoice_details['net_total'],2) }}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0;margin: 0;">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0;">
                                        <tbody>
                                            <tr>
                                                <td width="130" style="text-align: right;border: 1px solid;font-size: 14px;font-weight: bold" colspan="3">GRAND TOTAL</td>
                                                <td style="text-align: right;border: 2px solid #918f8e;border-top: 1px solid #918f8e;font-size: 15px;font-weight: bold;color: #c00000" width="100">{{ round($invoice_details['grand_total'],2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;padding: 8px 0;">
                                    <b>TERMS AND CONDITIONS : </b> 1. This debit note is issued to correct a billing error in the invoice referenced above. The recipient is kindly requested to review the details and make the necessary adjustments.
                                    2. The recipient agrees to process the adjustment within 30 days from the date of this debit note. Failure to do so may result in additional charges as per the agreement.
                                    3. Any supporting documentation, such as product return authorization or photos of damaged goods, should be attached along with the adjustment.
                                    4. In case of any dispute regarding the debit note, both parties agree to resolve the matter through mediation in accordance with the laws.
                                    5. The recipient acknowledges the receipt and acceptance of this debit note by signing below or confirming electronically.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
                                        <thead>
                                            <tr>
                                                <td width="50%">Certified that all the particulars shown in the above
                                                  invoice are true and correct and Recived the item(s) in Good condition
                                                </td>
                                                <td style="text-align: right;">
                                                    For <b>HOSTEE THE PLANNER</b><br/>Authorised Signatory
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
