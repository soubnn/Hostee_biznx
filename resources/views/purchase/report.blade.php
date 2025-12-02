<!DOCTYPE html>
<html>
<head>
    <title>Purchase GST Report - Techsoul Cyber Solutions</title>
</head>
<style type="text/css">
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
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .w-3{
        width: 3%
    }
    .w-5{
        width: 5%
    }
    .w-10{
        width: 10%
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
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:6px 6px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:14px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
    .page-break {
        page-break-after: always;
    }
    .footer {
        position: fixed;
        bottom: 0px;
    }
</style>
<body>
<div class="head-title">
    <div>
        <h3 class="m-0 p-0 w-100" style="text-align: right">Purchase GST Report</h3>
        <h5 class="m-0 p-0 w-100" style="text-align: right">{{ carbon\Carbon::parse($fromDate)->format('d-m-Y') }} to {{ carbon\Carbon::parse($toDate)->format('d-m-Y') }}</h5>
        <h2 class="m-0 p-0 w-50">TECHSOUL CYBER SOLUTIONS</h2>
        <h5 class="m-0 p-0">GSTIN : 32ADNPO8730B1ZO</h5>
        <h5 class="m-0 p-0">OPP.TRUST HOSPITAL ROOM NO: 20/792, RM-VENTURES, RANDATHANI.PO</h5>
    </div>
    <div style="width: 50%; text-align: right">
    </div>
</div>
<!--<div class="page-break"></div>-->
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10" style="table-layout:fixed">
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 7%">Invoice #</th>
                <th style="width: 8%">Date</th>
                <th style="width: 4%">B2C<br>/B2B</th>
                <th style="width: 8%">GSTIN<br>/TIN</th>
                <th style="width: 12%">Customer</th>
                <th style="width: 10%">Place</th>
                <th style="width: 9%">Product</th>
                <th style="width: 6%">HSN</th>
                <th style="width: 3%">Qty</th>
                <th style="width: 6%">Taxable</th>
                <th style="width: 2%">Tax</th>
                <th style="width: 6%">CGST</th>
                <th style="width: 6%">SGST</th>
                <th style="width: 2%">IG<br>ST</th>
                <th style="width: 2%">CE<br>SS</th>
                <th style="width: 6%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tableData as $data)
                <tr style="text-align:center">
                    @if($data['invoice'] != '')
                        <td>{{ $loop->index + 1 }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ substr($data['invoice'],0,7) }}<br>{{ substr($data['invoice'],7,10) }}</td>
                    @if($data['date'] != '')
                        <td>{{ carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $data['invoiceType'] }}</td>
                    <td>{{ substr($data['GSTIN'],0,7) }}<br>{{ substr($data['GSTIN'],7,8) }}</td>
                    <td>{{ $data['customer'] }}</td>
                    <td>{{ substr($data['place'],0,10) }}<br>{{ substr($data['place'],10,10) }}</td>
                    <td>{{ $data['product'] }}</td>
                    <td>{{ substr($data['hsn'],0,5) }}<br>{{ substr($data['hsn'],5,10) }}</td>
                    <td>{{ $data['qty'] }}</td>
                    <td>{{ $data['taxable'] }}</td>
                    <td>{{ $data['tax'] }}</td>
                    <td>{{ $data['cgst'] }}</td>
                    <td>{{ $data['sgst'] }}</td>
                    <td>{{ $data['igst'] }}</td>
                    <td>{{ $data['cess'] }}</td>
                    <td>{{ $data['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        @php
            $printed_by = Auth::user()->name;
            $printed_on = Carbon\carbon::now();
        @endphp
        <p>generated by {{ $printed_by }} on {{ $printed_on }}</p>
    </div>
</div>
</html>
