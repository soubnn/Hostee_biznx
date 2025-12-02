<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Card - Techsoul</title>

    <style type="text/css">

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
            font-size: 14px;
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

        .border_black {
            border-top: 1px solid !important;
        }
    </style>
</head>

<body>

    <div class="top_headder" style="padding: 0;margin-left:-15px;">
        <div class="container_banner">
            <div class="banner_body">
                <table border="0" class="table topbanner mystyle" style="width: 100%" width="100%">
                    <tbody>
                        <tr>
                            <td style="padding: 0;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #d3d3d3">
                                    <thead>
                                        <tr>
                                            <td align="center" width="60%" style="padding: 0; padding-bottom: 10px;">
                                                <img src="https://techsoul.biznx.in/assets/images/invoice/logo.png" width="320"
                                                    style="width: 320px;margin: auto;">
                                                {{-- <img src="{{ asset('assets/images/invoice/logo.png') }}" width="320"
                                                    style="width: 320px;margin: auto;"> --}}
                                                <p style="font-size: 11px;font-weight: 600;margin: 0;font-family: Arial, Helvetica, sans-serif;">
                                                    GSTIN : 32ADNPO8730B1ZO<br />
                                                    OPP.TRUST HOSPITAL ROOM NO: 20/792, RM-VENTURES, RANDATHANI.PO<br />
                                                    MALAPPURAM-KERALA Pin : 676510 Tel: +918891989842<br />
                                                    email: service@teamtechsoul.com<br />
                                                    www.teamtechsoul.com
                                                </p>

                                            </td>
                                            <td width="30%" valign="top" style="padding: 0;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="3"
                                                                style="color:#215967;font-size: 20px;font-weight: bolder;text-align: right;padding: 0;">
                                                                Job card</td>
                                                        </tr>
                                                        <tr style="border-bottom: 2px solid #dddddd;">
                                                            <td style="font-size: 14px;padding-bottom: 10px;">
                                                                <small>Jobcard No</small><br /><span class="red"
                                                                    style="color: #c00000;font-weight: bold;">{{ $latestJob->jobcard_number }}</span>
                                                            </td>
                                                            <td style="font-size: 14px;padding-bottom: 10px;">
                                                                <small>Date</small><br /><span class="red"
                                                                    style="color: #c00000;font-weight: bold;">{{ $latestJob->date }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            @php
                                                                $customer = DB::table('customers')->where('id', $latestJob->customer_name)->first();
                                                            @endphp
                                                            <td colspan="3"
                                                                style="font-size: 11px;padding-bottom: 8px;">
                                                                <span style="display: block;">Customer Details</span>
                                                                <strong style="display: block;">{{ $customer->name }}, {{ $customer->place }}</strong>
                                                                <p style="margin: 0;padding: 0;"><b>{{ $latestJob->phone }}</b></p>
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
                            <td style="padding: 20px 0 10px 0; text-align: center;">
                                <strong style="display: block; margin-bottom: 10px; text-align: left; margin-left: 20px">Items / Services:-</strong>
                                <table width="80%" border="0" cellspacing="0" cellpadding="5" style=" margin: 0 auto; text-align: left; border-collapse: collapse;">
                                    <tr>
                                        {{-- <td class="no">01</td> --}}
                                        <td class="desc"><strong>Work Location</strong></td>
                                        <td class="unit">: {{ $latestJob->work_location }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">02</td> --}}
                                        <td class="desc"><strong>Service Type</strong></td>
                                        <td class="unit">: {{ $latestJob->service_type }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">03</td> --}}
                                        <td class="desc"><strong>Product Name</strong></td>
                                        <td class="unit">: {{ $latestJob->product_name }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">04</td> --}}
                                        <td class="desc"><strong>Product Brand</strong></td>
                                        <td class="unit">: {{ $latestJob->brand }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">05</td> --}}
                                        <td class="desc"><strong>Serial No</strong></td>
                                        <td class="unit">: {{ $latestJob->serial_no }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">06</td> --}}
                                        <td class="desc"><strong>Complaints</strong></td>
                                        <td class="unit">: {{ $latestJob->complaints }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">07</td> --}}
                                        <td class="desc"><strong>Initial Check Remarks</strong></td>
                                        <td class="unit">: {{ $latestJob->remarks }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">08</td> --}}
                                        <td class="desc"><strong>Accessories Received</strong></td>
                                        <td class="unit">: {{ $latestJob->accessories }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="no">09</td>
                                        <td class="desc"><strong>Physical Condition</strong></td>
                                        <td class="unit">: {{ $latestJob->physical_condition }}</td>
                                    </tr> --}}
                                    <tr>
                                        {{-- <td class="no">10</td> --}}
                                        <td class="desc"><strong>Estimated Amount <br><span style="font-weight: lighter; font-size: 12px">(final amount may vary based on parts and labour)</span></strong></td>
                                        <td class="unit">: Rs: {{ $latestJob->estimate }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">11</td> --}}
                                        <td class="desc"><strong>Advance Received</strong></td>
                                        <td class="unit">: Rs: {{ $latestJob->advance }}</td>
                                    </tr>
                                    <tr>
                                        {{-- <td class="no">12</td> --}}
                                        <td class="desc"><strong>Estimated Delivery Date <br> <span style="font-weight: lighter; font-size: 12px">(may change depending on item availability and service schedule) </span></strong></td>
                                        <td class="unit">: {{ $latestJob->estimate_delivery }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        {{-- <tr>
                            <td style="padding-top: 20px; padding-left: 40px;">
                                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @if($latestJob->image1)
                                        <img src="{{ asset('storage/images/'.$latestJob->image1) }}" alt="" style="width: 120px; height: auto; object-fit: cover;">
                                    @endif
                                    @if($latestJob->image2)
                                        <img src="{{ asset('storage/images/'.$latestJob->image2) }}" alt="" style="width: 120px; height: auto; object-fit: cover;">
                                    @endif
                                    @if($latestJob->image3)
                                        <img src="{{ asset('storage/images/'.$latestJob->image3) }}" alt="" style="width: 120px; height: auto; object-fit: cover;">
                                    @endif
                                    @if($latestJob->image4)
                                        <img src="{{ asset('storage/images/'.$latestJob->image4) }}" alt="" style="width: 120px; height: auto; object-fit: cover;">
                                    @endif
                                </div>
                            </td>
                        </tr> --}}

                        <tr>
                            <td style="font-size: 11px; padding: 2px 0;">
                                <b>TERMS & CONDITIONS:</b>
                                <ul style="padding-left: 20px; margin: 5px 0;">
                                    <li>Service is Undertaken at owner's risk only.</li>
                                    <li>If any item is brought with a specific defect, our estimate will be for rectifying that defect only unless we are asked to improve the general performance.</li>
                                    <li>Delivery time is only approximate; we will not be liable for any delay for reasons beyond our control.</li>
                                    <li>Customer shall verify the working condition of the instrument before taking delivery. We are not responsible for any defect that might arise after delivery unless otherwise agreed upon.</li>
                                    <li>Estimates given by us are provisional and not binding on us. They are liable to be revised; in that case, work will be proceeded on approval of the revised estimate by the customer.</li>
                                    <li>Taxes and other levies are extra with estimated charges.</li>
                                    <li>The customer is requested to call after 16 working hours to know the status of the equipment. Customers are also requested to allow an 8 working hour gap for the next call. The request should be made to the corresponding branches.</li>
                                    <li>Reimbursement of collected service charge (if not repairable) will be done only with the next bill.</li>
                                    <li>The customer must take delivery within one month. TECHSOUL is not responsible for the material after three months.</li>
                                    <li>Five Hundred Rupees will be collected as inspection charge in case the customer returns the material without agreeing with the revised estimate (if any).</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                    align="center">
                                    <thead>
                                        <tr>
                                            <td style="text-align: right;">
                                                @php
                                                    $printed_by = Auth::user()->name;
                                                @endphp
                                                <p>Accepted by: {{ $printed_by }} </p>
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
