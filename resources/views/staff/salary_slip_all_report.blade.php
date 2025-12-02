<!DOCTYPE html>
<html>
    <head>
        <title>Salary Slip</title>
        {{-- <style>
            * {
                margin: 0;
                padding: 0;
                text-indent: 0;
            }

            .s1 {
                color: black;
                font-family: Calibri, sans-serif;
                font-style: normal;
                font-weight: bold;
                text-decoration: none;
                font-size: 15px;
            }

            .s2 {
                color: black;
                font-family: Calibri, sans-serif;
                font-style: normal;
                font-weight: normal;
                text-decoration: none;
                font-size: 13px;
            }

            .s3 {
                color: black;
                font-family: Calibri, sans-serif;
                font-style: normal;
                font-weight: bold;
                text-decoration: none;
                font-size: 13px;
            }

            .s4 {
                color: black;
                font-family: Calibri, sans-serif;
                font-style: normal;
                font-weight: bold;
                text-decoration: none;
                font-size: 13px;
            }

            table,
            tbody {
                vertical-align: top;
                overflow: visible;
            }
            body {
              background: rgb(204,204,204);
            }
            page {
              background: white;
              display: block;
              margin: 0 auto;
              margin-bottom: 0.5cm;
              box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            }
            page[size="A4"] {
              width: 21cm;
              height: 29.7cm;
            }

            @media print {
              body, page {
                background: white;
                margin: 0;
                box-shadow: 0;
              }
            }
        </style> --}}
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                vertical-align: middle;
            }

            .header {
                background-color: #4085C0;
                color: white;
                text-align: center;
                font-weight: bold;
            }

            .sub-header {
                background-color: #478ac373;
                font-weight: bold;
                text-align: center;
            }

            .title {
                text-align: center;
                font-weight: bold;
                font-size: 14px;
            }

            .text-left {
                text-align: left;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <page size="A4">
            @foreach ($salaryPayment as $salaryPayment)
                {{-- <p style="text-indent: 0pt;text-align: left;"><br /></p> --}}
                {{-- <table style="border-collapse:collapse;margin-left: 25px;margin-right: 25px;margin: 25px;" cellspacing="0">
                    <tr>
                        <td style="width:712px;background-color: #4085C0 ;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                            colspan="4" >
                            <p style="text-indent: 0pt;text-align: left;"><br /></p>
                            <p style="padding-left: 431pt;text-indent: 0pt;text-align: left;"><span>
                                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                        <tr>
                                            <td style="text-align: right;">
                                                <img src="assets/images/logo.png" width="100%" style="margin: 5px;margin-right: 26px;margin-top: -10px;">
                                            </td>
                                        </tr>
                                    </table>
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:26px">
                        <td style="border-top-style:solid;background-color: #478ac373 ;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                            colspan="4">
                            <p class="s1" style="text-align: center;">Salary Slip</p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="width:20%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Employee Name</p>
                        </td>
                        <td style="width:30%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s3" style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">{{ $staff->staff_name }}</p>
                        </td>
                        <td style="width:30%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Date
                            </p>
                        </td>
                        <td style="width:20%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s4" style="padding-top: 3pt;padding-left: 14pt;padding-right: 13pt;text-indent: 0pt;line-height: 14pt;text-align: center;">{{ Carbon\carbon::parse($salaryPayment['date'])->format('d-m-Y') }}</p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Employee Code</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s3" style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">{{ $staff->employee_code }}</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Term</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s4" style="padding-top: 3pt;padding-left: 14pt;padding-right: 13pt;text-indent: 0pt;line-height: 14pt;text-align: center;">{{ $salaryPayment['termData'] }}</p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2"
                                style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Designation</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s3" style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">{{ $staffCategorie }}</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Total Days</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s4" style="padding-top: 3pt;padding-left: 14pt;padding-right: 13pt;text-indent: 0pt;line-height: 14pt;text-align: center;">15</p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2"
                                style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Payment Method</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s3" style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">{{ $salaryPayment['payment_method'] }}</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Leave</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s4" style="padding-top: 3pt;padding-left: 14pt;padding-right: 13pt;text-indent: 0pt;line-height: 14pt;text-align: center;">{{ $salaryPayment['leave'] }}</p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2"
                                style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Transaction ID</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s3" style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">{{ $salaryPayment['bankReference'] }}</p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;"><br></p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s4" style="padding-top: 3pt;padding-left: 14pt;padding-right: 13pt;text-indent: 0pt;line-height: 14pt;text-align: center;"><br></p>
                        </td>
                    </tr>
                    <tr style="height:15px">
                        <td style="width:100%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                            colspan="4">
                            <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        </td>
                    </tr>
                    <tr style="height:26px">
                        <td style="width:50%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;background-color: #4085C0;" colspan="2">
                            <p class="s1" style="text-align: center;color: aliceblue;">Income</p>
                        </td>
                        <td style="width:50%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;background-color: #4085C0;" colspan="2">
                            <p class="s1"style="text-align: center;color: aliceblue;">Deductions</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%;border-right-style:solid;border-right-width:1pt;border-left-style:solid;border-left-width:1pt;" colspan="2">
                            <table style="width:100%" cellspacing="0">
                                <tr style="height:25px">
                                    <td style="width:60%;border-bottom-style:solid;border-bottom-width:1pt;background-color: #478ac373 ;" >
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Particulars
                                        </p>
                                    </td>
                                    <td style="width:40%;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;background-color: #478ac373 ;" >
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Amount</p>
                                    </td>
                                </tr>
                                <tr style="height:24px">
                                    <td
                                        style="border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Basic Salary</p>
                                    </td>
                                    <td
                                        style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s4" style="padding-top: 3pt;padding-left: 52pt;padding-right: 51pt;text-indent: 0pt;line-height: 14pt;text-align: center;">
                                            {{ $salaryPayment['basic_salary'] }}
                                        </p>
                                    </td>
                                </tr>
                                @foreach ($salaryPayment['dataArray'] as $item)
                                    <tr style="height:24px">
                                        <td
                                            style="border-bottom-style:solid;border-bottom-width:1pt;">
                                            <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">
                                                {{ $item['name'] }}
                                            </p>
                                        </td>
                                        <td
                                            style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                            <p class="s4" style="padding-top: 3pt;padding-left: 52pt;padding-right: 51pt;text-indent: 0pt;line-height: 14pt;text-align: center;">
                                                {{ $item['amount'] }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="height:24px">
                                    <td
                                        style="border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Total</p>
                                    </td>
                                    <td
                                        style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s1" style="padding-right: 4pt;text-indent: 0pt;line-height: 16pt;text-align: right;">{{ $salaryPayment['totalIncomAmount'] }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%;border-right-style:solid;border-right-width:1pt" colspan="2">
                            <table style="width:100%" cellspacing="0">
                                <tr style="height:25px">
                                    <td style="width:60%;border-bottom-style:solid;border-bottom-width:1pt;background-color: #478ac373 ;">
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Particulars
                                        </p>
                                    </td>
                                    <td style="width:40%;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;background-color: #478ac373 ;">
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Amount</p>
                                    </td>
                                </tr>
                                <tr style="height:24px">
                                    <td style="border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Leave</p>
                                    </td>
                                    <td style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s4" style="padding-top: 3pt;padding-left: 52pt;padding-right: 51pt;text-indent: 0pt;line-height: 14pt;text-align: center;">{{ $salaryPayment['leaveAmount'] }}</p>
                                    </td>
                                </tr>
                                <tr style="height:24px">
                                    <td style="border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s2" style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">Paid Amount</p>
                                    </td>
                                    <td style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s4" style="padding-top: 3pt;padding-left: 52pt;padding-right: 51pt;text-indent: 0pt;line-height: 14pt;text-align: center;">{{ $salaryPayment['paidAmount'] }}</p>
                                    </td>
                                </tr>
                                <tr style="height:24px">
                                    <td style="border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Total</p>
                                    </td>
                                    <td style="border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;">
                                        <p class="s1" style="padding-right: 4pt;text-indent: 0pt;line-height: 16pt;text-align: right;">{{ $salaryPayment['deductions'] }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="height:15px">
                        <td style="width:100%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                            colspan="4">
                            <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        </td>
                    </tr>
                    <tr style="height:26px">
                        <td style="width:70%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;background-color: #4085C0;" colspan="3">
                            <p class="s1" style="text-align: center;color: aliceblue;">Net Salary</p>
                        </td>
                        <td style="width:30%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                            <p class="s1" style="padding-left: 13pt;padding-right: 13pt;text-indent: 0pt;line-height: 16pt;text-align: center;">
                                {{ $salaryPayment['amount'] }}
                            </p>
                        </td>
                    </tr>
                    <tr style="height:65px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"colspan="2">
                            <p style="text-indent: 0pt;text-align: left;"><br></p>
                            <p style="text-indent: 0pt;text-align: left;"><br></p>
                            <p style="text-indent: 0pt;text-align: left;"><br></p>
                        </td>
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt; position: relative;" colspan="2">
                            <p style="text-indent: 0pt;text-align: left; position: relative;">
                                <img src="assets/images/ceosign.png" style="height: 110px;position: absolute;top: -22px;left: 161px;">
                            </p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
                            <p class="s1" style="padding-left: 64pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Employee Signature</p>
                        </td>
                        <td style="width:290pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
                            <p class="s1" style="padding-left: 87pt;text-indent: 0pt;line-height: 16pt;text-align: left;">Employer Signature</p>
                        </td>
                    </tr>
                </table> --}}
                <table>
                    <tr>
                        <td colspan="4" class="header">
                            <img src="assets/images/logo.png" width="350" style="margin: 5px auto; display:block;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="title sub-header">Salary Slip</td>
                    </tr>

                    <tr>
                        <td>Employee Name</td>
                        <td style="font-weight: 700">{{ $staff->staff_name }}</td>
                        <td>Date</td>
                        <td class="text-center" style="font-weight: 700">{{ Carbon\Carbon::parse($salaryPayment['date'])->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Employee Code</td>
                        <td style="font-weight: 700">{{ $staff->employee_code }}</td>
                        <td>Term</td>
                        <td class="text-center" style="font-weight: 700">{{ $salaryPayment['termData'] }}</td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td style="font-weight: 700">{{ $staffCategorie }}</td>
                        <td>Total Days</td>
                        <td class="text-center" style="font-weight: 700">15</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td style="font-weight: 700">{{ $salaryPayment['payment_method'] }}</td>
                        <td>Leave</td>
                        <td class="text-center" style="font-weight: 700">{{ $salaryPayment['leave'] }}</td>
                    </tr>
                    <tr>
                        <td>Transaction ID</td>
                        <td colspan="3" style="font-weight: 700">{{ $salaryPayment['bankReference'] }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th colspan="2" class="header">Income</th>
                        <th colspan="2" class="header">Deductions</th>
                    </tr>
                    <tr class="sub-header">
                        <td>Particulars</td>
                        <td>Amount</td>
                        <td>Particulars</td>
                        <td>Amount</td>
                    </tr>

                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-right" style="font-weight: 700">{{ $salaryPayment['basic_salary'] }}</td>
                        <td>Leave</td>
                        <td class="text-right" style="font-weight: 700">{{ $salaryPayment['leaveAmount'] }}</td>
                    </tr>
                    @foreach ($salaryPayment['dataArray'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-right">{{ $item['amount'] }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="text-right"><b>Total</b></td>
                        <td class="text-right"><b>{{ $salaryPayment['totalIncomAmount'] }}</b></td>
                        <td>Paid Amount</td>
                        <td class="text-right"><b>{{ $salaryPayment['paidAmount'] }}</b></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>Total</b></td>
                        <td class="text-right"><b>{{ $salaryPayment['deductions'] }}</b></td>
                    </tr>
                </table>

                <table>
                    <tr class="header">
                        <td colspan="3">Net Salary</td>
                        <td class="text-center" style="background: none; color: #000">{{ $salaryPayment['amount'] }}</td>
                    </tr>
                </table>

                {{-- <br><br> --}}

                <table style="margin-top: 1px;">
                    <tr class="text-center" style="font-weight: 700">
                        <td colspan="2" style="height: 70px;">Employee Signature</td>
                        <td colspan="2" style="position: relative; height: 70px;">
                            <img src="assets/images/ceosign.png"
                                style="height:80px; position:absolute; bottom: 1px; right:120px;">
                            Employer Signature
                        </td>
                    </tr>
                </table>
                <br><br>
                <div style="page-break-after: auto;"></div>
            @endforeach
        </page>
    </body>
</html>
