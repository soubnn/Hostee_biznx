<!DOCTYPE html>
<html>

<head>
    <title>Salary Slip</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        h1 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .p,
        p {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
            margin: 0pt;
        }

        .a,
        a {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s1 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: 400;
            text-decoration: none;
            font-size: 8pt;
        }

        .s2 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 7pt;
        }

        .s3 {
            color: #0462c1;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 8pt;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }

        body {
            margin: 0;
            padding: 0;
        }

        page {
            background-image: url('assets/images/techsoull_letter_head.png');
            background-size: cover;
            background-position: center;
            display: block;
            /* margin: 0 auto; */
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            size: A4;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }
        @media print {
            page[size="A4"] {
                width: 210mm;
                height: 297mm;
                size: A4;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }
        }
    </style>
</head>

<body>
    <page size="A4">
        <p style="text-indent: 0pt; text-align: left;height: 140px;"><br /></p>
        <div style="width: 610px;margin-left: 68px;">
            <h1 style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">To:</h1>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                {{ $staff->staff_name }} <br>{{ $staff_categorie }}
            </p>
            <p style="text-indent: 0pt; text-align: left;height: 30px;"><br /></p>
            <h1 style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                Date : <span class="p">{{ $date }}</span>
            </h1>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <h1 style="padding-left: 5pt;text-indent: 0pt;line-height: 180%;text-align: left;">
                Subject:<span class="p">Salary Disbursement for {{ $termData }} </span>
            </h1>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <h1 style="padding-left: 5pt;text-indent: 0pt;line-height: 180%;text-align: left;">
                <span class="p">Dear {{ $staff->staff_name }},</span>
            </h1>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p style="padding-left: 5pt;text-indent: 0pt;line-height: 107%;text-align: left;">
                I trust this email finds you well. We are pleased to inform you that the
                salary for the month of {{ $termData }} has been processed and
                disbursed.
            </p>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p style="padding-left: 5pt;text-indent: 0pt;line-height: 108%;text-align: left;">
                <a href="mailto:hosteetheplanner@gmail.com" class="a" target="_blank">Attached, you will find your salary
                    statement for this month. Please
                    review the details, and if you have any questions or concerns regarding
                    your salary, do not hesitate to contact the HR department at
                </a>
                <a href="mailto:hosteetheplanner@gmail.com" target="_blank">hosteetheplanner@gmail.com.</a>
            </p>
            <p style="padding-top: 7pt;padding-left: 5pt;text-indent: 0pt;line-height: 109%;text-align: left;">
                We appreciate your hard work and dedication to Hostee the Planner.
                Your efforts contribute significantly to the success of our organization,
                and we value your commitment.
            </p>
            <p style="padding-top: 7pt;padding-left: 5pt;text-indent: 0pt;line-height: 180%;text-align: left;">
                Thank you for your continued contributions. If you require any further
                assistance or have inquiries, feel free to reach out.
            </p>
            <p style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;line-height: 180%;text-align: left;">
                Wishing you a greatmonth ahead.
            </p>
            <p style="text-indent: 0pt; text-align: left;height: 30px;"><br /></p>
            <table style="border-collapse: collapse; margin-left: 6.075pt" cellspacing="0">
                <tr style="height: 15pt">
                    <td style="width: 96pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Employee Code
                        </p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            {{ $staff->employee_code }}
                        </p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Total Working Days
                        </p>
                    </td>
                    <td style="width: 117pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            15
                        </p>
                    </td>
                </tr>
                <tr style="height: 15pt">
                    <td style="width: 96pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Designation
                        </p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            {{ $staff_categorie }}
                        </p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Leave
                        </p>
                    </td>
                    <td style="width: 117pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">{{ $leaveDays }}</p>
                    </td>
                </tr>
                <tr style="height: 15pt">
                    <td style="width: 96pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Payment Method
                        </p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">{{ $paymentMethod }}</p>
                    </td>
                    <td style="width: 115pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                            Transaction ID
                        </p>
                    </td>
                    <td style="width: 117pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">{{ $bankReferenceId }}</p>
                    </td>
                </tr>
                <tr style="height: 15pt">
                    <td style="width: 211pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="2">
                        <p class="s2" style="padding-left: 89pt;padding-right: 89pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                            Income
                        </p>
                    </td>
                    <td style="width: 232pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="2">
                        <p class="s2" style="padding-left: 92pt;padding-right: 91pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                            Deductions
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="2">
                        <table cellspacing="0" style="width: 100%;">
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Particulars
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Amount
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Basic Salary
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-left: 46pt;padding-right: 46pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                                        {{ $basicSalary }}
                                    </p>
                                </td>
                            </tr>
                            @foreach ($dataArray as $item)
                                <tr style="height: 15pt">
                                    <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                        <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                            {{ $item['name'] }}
                                        </p>
                                    </td>
                                    <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                        <p class="s2" style="padding-left: 46pt;padding-right: 46pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                                            {{ $item['amount'] }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Total
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-right: 5pt;text-indent: 0pt;line-height: 11pt;text-align: right;">
                                        {{ $totalIncomAmount }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="2">
                        <table cellspacing="0" style="width: 100%;">
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Particulars
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Amount
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Leave
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-left: 46pt;padding-right: 46pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                                        {{ $leaveAmount }}
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s1" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Paid Amount
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-left: 46pt;padding-right: 46pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                                        {{ $paidAmount }}
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 15pt">
                                <td style="width: 96pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                                    <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                                        Total
                                    </p>
                                </td>
                                <td style="width: 115pt;border-bottom-style: solid;border-bottom-width: 1pt;">
                                    <p class="s2" style="padding-right: 5pt;text-indent: 0pt;line-height: 11pt;text-align: right;">
                                        {{ $deductions }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="height: 15pt">
                    <td style="width: 326pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="3">
                        <p class="s2" style="padding-left: 137pt;padding-right: 137pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                            Total Salary
                        </p>
                    </td>
                    <td style="width: 117pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;">
                        <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 11pt;text-align: left;">{{ $grandTotalAmount }}</p>
                    </td>
                </tr>
                <tr style="height: 15pt">
                    <td style="width: 326pt;border-top-style: solid;border-top-width: 1pt;border-left-style: solid;border-left-width: 1pt;border-bottom-style: solid;border-bottom-width: 1pt;border-right-style: solid;border-right-width: 1pt;" colspan="4">
                        <p class="s2" style="padding-left: 137pt;padding-right: 137pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                            {{ $grandTotalAmountWords }} ONLY
                        </p>
                    </td>
                </tr>
            </table>
            <p style="text-indent: 0pt; text-align: left;height: 20px;"><br /></p>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                Best regards,
            </p>
            <p style="text-indent: 0pt; text-align: left"><br /></p>
            <h1 style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                {{-- Fathima Shalu M.K --}}
            </h1>
            <p style="padding-top: 1pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">
                Finance Manager
            </p>
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                Hostee the Planner
            </p>
            <p style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                <a href="mailto:hosteetheplanner@gmail.com" class="s3">hosteetheplanner@gmail.com</a>
            </p>
        </div>
    </page>
</body>

</html>
