<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAYMENT RECIEPT</title>
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
    </style>
    <style>
        .page-break {
            page-break-after: always;
        }
        body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .mt-25{
        margin-top:25px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-45{
        width:45%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    /* table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:13px;
    }
    table tr td{
        font-size:11px;
    }
    table{
        border-collapse:collapse;
    } */
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
                                                        {{-- <tr>
                                                            <td colspan="2"
                                                                style="color:#215967;font-size: 20px;font-weight: bolder;text-align: right;padding: 0;">
                                                                RETAIL INVOICE</td>
                                                        </tr> --}}
                                                        <tr style="border-bottom: 2px solid #dddddd;">
                                                            <td style="font-size: 14px;padding-bottom: 12px;">
                                                                <small>Reciept No</small><br /><span class="red" style="color: #c00000;font-weight: bold;">{{ $invoiceDetails->invoice_number ?? '-' }}</span>
                                                            </td>
                                                            <td style="font-size: 14px;padding-bottom: 12px;">
                                                                <small>Date</small><br />
                                                                <span class="red" style="color: #c00000;font-weight: bold;">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr style="border-bottom: 2px solid #dddddd;">
                                                            <td colspan="2"
                                                                style="font-size: 12px;padding-bottom: 12px;">
                                                                <span style="display: block;">Customer Details</span>
                                                                <strong style="display: block;">{{ strtoupper($invoiceDetails->customer_name) }} @if($invoiceDetails->customer_phone), {{$invoiceDetails->customer_phone}}@endif</strong>
                                                            </td>
                                                        </tr>
                                                        <!--<tr>-->
                                                        <!--    <td colspan="2" style="font-size: 12px;" style="margin-top:15px;">-->
                                                        <!--        <span style="display: block;">Payment Method</span>-->
                                                        <!--        <strong style="display: block;">ACCOUNT</strong>-->
                                                        <!--    </td>-->
                                                        <!--</tr>-->
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
                                <div class="head-title" style="margin-top :50px">
                                    <h2 class="text-center m-0 p-0" style="font-size: 18px;">PAYMENT RECIEPT</h2>
                                </div>
                                <div class="w-100 mt-10">
                                    <table class="table w-100" style="margin-top:20px;border: 1px solid #9c9a9a;padding:7px 8px;">
                                        <thead>
                                            <tr>
                                                <th style="font-size: 16px;border: 1px solid #9c9a9a;padding:7px 8px;" align="left">DATE</th>
                                                <th colspan="2" style="font-size: 16px;border: 1px solid #9c9a9a;padding:7px 8px;" align="left">DESCRIPTION</th>
                                                <th colspan="2" style="font-size: 16px;border: 1px solid #9c9a9a;padding:7px 8px;" align="left">PAYMENT METHOD</th>
                                                <th style="font-size: 16px;border: 1px solid #9c9a9a;padding:7px 8px;" align="left">AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentDetails as $payment)
                                            <tr>
                                                <td align="left" style="border: 1px solid #9c9a9a;padding:7px 8px;">
                                                    {{ $payment->date }}
                                                </td>
                                                <td colspan="2" align="left" style="border: 1px solid #9c9a9a;padding:7px 8px;">
                                                    PAYMENT AGAINST INVOICE #{{ $payment->job }}
                                                </td>
                                                <td colspan="2" align="left" style="border: 1px solid #9c9a9a;padding:7px 8px;">
                                                    {{ $payment->accounts }}
                                                </td>
                                                <td align="left" style="border: 1px solid #9c9a9a;padding:7px 8px;">
                                                    {{ $payment->amount }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="margin-top: 40px;">
                                    <thead>
                                        <tr>
                                            <td style="text-align: left;">
                                                {{-- <b>AMOUNT IN WORDS: </b><br>
                                                <b>{{ $amountInWords }} RUPEES ONLY</b> --}}
                                            </td>
                                            <td style="text-align: right;">For
                                                <b>HOSTEE THE PLANNER</b><br/>Authorised Signatory
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="2" style="text-align: left;">
                                                @php
                                                    $printed_by = Auth::user()->name;
                                                    $printed_on = Carbon\carbon::now();
                                                @endphp
                                                <p style="font-size:10px;">generated by {{ $printed_by }} on {{ $printed_on }}</p>
                                            </td>
                                        </tr> --}}
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
