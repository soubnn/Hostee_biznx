<!doctype html >
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>INVOICE</title>
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
body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;}
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
                        NEAR LANCOR CONCEPTS, CHERUSHOLA ROAD, SWAGATHAMAD<br />
                        MALAPPURAM-KERALA Pin : 676503 Tel: +91 85929 24592 /<br /> +91 85929 24692
                        email: hosteetheplanner@gmail.com<br />
                        www.hosteetheplanner.in
                    </p>
                  </td>
                  <td width="40%" valign="top" style="padding: 0;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <thead>
                      <tr>
                        <td colspan="2" style="color:#215967;font-size: 20px;font-weight: bolder;text-align: right;padding: 0;">RETAIL INVOICE</td>
                      </tr>
                      <tr style="border-bottom: 2px solid #dddddd;">
                        <td style="font-size: 14px;padding-bottom: 10px;"><small>Invoice No</small><br/><span class="red" style="color: #c00000;font-weight: bold;">{{ $completeReportDetails['invoice_number'] }}</span></td>
                        <td style="font-size: 14px;padding-bottom: 10px;"><small>Date</small><br/><span class="red" style="color: #c00000;font-weight: bold;">{{ $completeReportDetails['invoice_date'] }}</span></td>
                      </tr>
                      <tr style="border-bottom: 2px solid #dddddd;">
                        <td colspan="2" style="font-size: 12px;padding-bottom: 10px;">
                          <span style="display: block;">Customer Details</span>
                          <strong style="display: block;">{{ $completeReportDetails['customer_name'] }}, {{ $completeReportDetails['customer_place'] }}</strong>
                          <p style="margin: 0;padding: 0;"><b>GSTIN : @if($completeReportDetails['gst_number'])<span>{{ $completeReportDetails['gst_number'] }}</span>@endif</b></p>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="font-size: 12px;">
                          <span style="display: block;">Payment Method</span>
                          <strong style="display: block;">{{ $completeReportDetails['pay_method'] }}</strong>
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
            <table width="100%" class="invtable" border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;border-left: 1px solid #918f8e;margin: 0;margin-top:15px;">
              <thead>
              <tr style="height: 30px;">
                <th rowspan="2" style="border: 1px solid;text-align: center;">SL.<br/>NO</th>
                <th rowspan="2"  width="135" style="border: 1px solid;">Description of Goods</th>
                <th rowspan="2"  width="35" style="border: 1px solid;">HSN CODE <br/>(GST)</th>
                <th rowspan="2"  width="15" style="border: 1px solid;">Qty</th>
                <th rowspan="2"  width="35" style="border: 1px solid;">Unit Price</th>
                <th rowspan="2"  width="35" style="border: 1px solid;">Amount</th>
                <th rowspan="2"  width="35" style="border: 1px solid;">Taxable<br/>Value</th>
                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">SGST</th>
                <th colspan="2" width="50" style="text-align: center;border: 1px solid;font-weight: bold">CGST</th>
                <th rowspan="2" width="50" style="border: 1px solid;">Grand Total</th>
              </tr>
                <tr>
                  <th width="15" style="border: 1px solid;">Rate</th>
                  <th width="30" style="border: 1px solid;">Amount</th>
                  <th width="15" style="border: 1px solid;">Rate</th>
                  <th width="30" style="border: 1px solid;">Amount</th>
                </tr>
              </thead>
              @php
                $no = 1;
                $row_length = 0;
                $sgst_total=0;
                $cgst_total=0;
              @endphp
            <tbody style="vertical-align: top;" valign="top">
            @foreach($completeReportDetails['sales_items'] as $item)
                @php
                    $productDetails = DB::table('products')->where('id',$item['product_id'])->first();
                    if($item['product_id'] == 159)
                    {
						$product_name = strtoupper($item['serial_number']);
                    }
					else
					{
						if($item['serial_number'] != '')
						{
                            $product_name = $productDetails->product_name.' - '.strtoupper($item['serial_number']);
                    	}
                    	else
                    	{
                    	    $product_name = $productDetails->product_name;
                    	}
					}
                @endphp
              <tr>
                <td style="text-align: center;">{{ $no }}</td>
                @php
                    $name_length = strlen($product_name);
                @endphp
                    {{ $name_length }}
                @if ($name_length > 25 && $name_length <= 50)
                    @php
                        $product_name1 = substr($product_name,0,25);
                        $product_name2 = substr($product_name,25);
                    @endphp
                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}</td>
                    @php
                        $row_length= $row_length+28;
                    @endphp
                @elseif($name_length > 50 && $name_length <= 75)
                    @php
                        $product_name1 = substr($product_name,0,25);
                        $product_name2 = substr($product_name,25,25);
                        $product_name3 = substr($product_name,50);
                    @endphp
                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}</td>
                    @php
                        $row_length= $row_length+38;
                    @endphp
                @elseif($name_length > 75 && $name_length <= 100)
                    @php
                        $product_name1 = substr($product_name,0,25);
                        $product_name2 = substr($product_name,25,25);
                        $product_name3 = substr($product_name,50,25);
                        $product_name4 = substr($product_name,75);
                    @endphp
                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}</td>
                    @php
                        $row_length= $row_length+48;
                    @endphp
                @elseif($name_length > 100 && $name_length <= 125)
                    @php
                        $product_name1 = substr($product_name,0,25);
                        $product_name2 = substr($product_name,25,25);
                        $product_name3 = substr($product_name,50,25);
                        $product_name4 = substr($product_name,75,25);
                        $product_name5 = substr($product_name,100);
                    @endphp
                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}</td>
                    @php
                        $row_length= $row_length+58;
                    @endphp
                @elseif($name_length > 125)
                    @php
                        $product_name1 = substr($product_name,0,25);
                        $product_name2 = substr($product_name,25,25);
                        $product_name3 = substr($product_name,50,25);
                        $product_name4 = substr($product_name,75,25);
                        $product_name5 = substr($product_name,100,25);
                        $product_name6 = substr($product_name,125);
                    @endphp
                        <td>{{ $product_name1 }}<br>{{ $product_name2 }}<br>{{ $product_name3 }}<br>{{ $product_name4 }}<br>{{ $product_name5 }}<br>{{ $product_name6 }}</td>
                    @php
                        $row_length= $row_length+68;
                    @endphp
                @else
                    <td>{{ $product_name }}</td>
                    @php
                        $row_length= $row_length+18;
                    @endphp
                @endif
                <td>{{ $productDetails->hsn_code }}</td>
                <td>{{ $item['product_quantity'] }}</td>
                @php
                    $unit_price = number_format((float)$item['unit_price'], 2, '.', '');
                @endphp
                <td>{{ $unit_price }}</td>
                @php
                    $amount = round($item['product_quantity'] * $item['unit_price'],2);
                @endphp
                <td>{{ number_format((float)$amount, 2, '.', '') }}</td>
                <td>{{ number_format((float)$amount, 2, '.', '') }}</td>
                @php
                    $sgst = $cgst = ($item['gst_percent'])/2;
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
                <td style="text-align: right;"> {{ $item['sales_price'] }}</td>
            </tr>
              @php
                  $no++;
                  $sgst_total = $sgst_total+$sgst_value;
                  $cgst_total = $cgst_total+$cgst_value;
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
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td style="border: 1px solid"></td>
                  <td colspan="2" style="text-align: right;border: 1px solid"><b>TOTAL</b></td>
                  <td style="border: 1px solid">{{ $completeReportDetails['qty_total'] }}</td>
                  <td style="border: 1px solid"></td>
                  <td style="border: 1px solid"></td>
                  <td style="border: 1px solid">{{ $completeReportDetails['net_total'] }}</td>
                  <td style="border: 1px solid"></td>
                  <td style="border: 1px solid">{{ number_format($sgst_total, 2, '.', '') }}</td>
                  <td style="border: 1px solid"></td>
                  <td style="border: 1px solid">{{ number_format($cgst_total, 2, '.', '') }}</td>
                  <td style="text-align: right;border: 1px solid"><b>{{ $completeReportDetails['grand_total'] }}</b></td>
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
                  <td style="border: 1px solid">SALES PERSON</td>
                  <td style="border: 1px solid" colspan="3"><b>{{ $completeReportDetails['sales_staff'] }}</b></td>
                  <!--<td style="text-align: right;border: 1px solid;"></td>-->
                  <!--<td style="text-align: right;border: 1px solid;" width="60"></td>-->
                </tr>
                <tr>
                  <td style="border: 1px solid">BILL GENERATED/ACCOUNTANT</td>
                  <td style="border: 1px solid"><b>{{ $completeReportDetails['bill_generated_staff'] }}</b></td>
                  <td style="text-align: right;border: 1px solid;">ROUND OFF</td>
                  <td style="text-align: right;border: 1px solid;" width="60">{{ $completeReportDetails['discount'] }}</td>
                </tr>
                <tr>
                  <td style="border: 1px solid">BANK DETAILS</td>
                  <td style="border: 1px solid">
                    <b>BANK</b> : FEDERAL BANK &nbsp;&nbsp;<b>BRANCH</b> : PUTHANATHANI<br/>
                    <b>ACCOUNT NUMBER</b> : 15430200007260 &nbsp;&nbsp;<b>IFSC</b> : FDRL0001543

                  </td>
                  <td style="text-align: right;border: 1px solid;font-size: 14px;font-weight: bold">GRAND TOTAL </td>
                  <td style="text-align: right;border: 1px solid #000000;border-bottom: 1px solid #918f8e;border-right: 1px solid #918f8e;font-size: 15px;font-weight: bold;color: #c00000" width="60">{{ number_format((float)$completeReportDetails['discounted_total'], 2, '.', '') }}</td>
                </tr>
                <tr>
                  <td style="border: 1px solid"><b>GRAND TOTAL IN WORDS</b></td>
                  <td style="border: 1px solid" colspan="3"><b>{{ $completeReportDetails['grand_total_words'] }} ONLY</b></td>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td style="font-size: 11px;padding: 8px 0;">
              <b>TERMS AND CONDITIONS : (A)</b> The advance payment will be 50% of total development cost. <b>(B)</b>Unless otherwise specified, payments are due thirty (30) days after the date of invoice.<b>(C)</b> Any unpaid due amounts will be subject to penalty charges at 1.5% per month, or, if less, the maximum rate allowed by law. <b>(D)</b> Seller shall not be liable under any warranty stated herein if the purchase price has not been paid in full. <b>(E)</b> Seller may offset amounts Seller owes to Buyer against amounts Buyer owes to Seller, whether under the same or a different Purchase Order.
            </td>
          </tr>
        <tr>
          <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
              <thead>
                <tr>
                  <td width="50%">Certified that all the particulars shown in the above
                    invoice are true and correct and Recived the item(s) in Good condition </td>
                  <td style="text-align: right;">This is a system generated invoice<br/>Hence, no signature is required.
                  </td>
                </tr>
              <tr>
                <td colspan="2">
                  @php
                  $url = "https://hostee.biznx.in/index.php/userInvoice/" . $completeReportDetails['sales_id'] ;
                  @endphp
                  {{--  <!--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($url)) !!} " width="60" height="60" style="width:60px;height:60px;margin: 0;">-->  --}}
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
<!--<div class="page-break"></div>-->
</body>
</html>
