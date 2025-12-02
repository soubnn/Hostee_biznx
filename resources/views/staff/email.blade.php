<!DOCTYPE html>
<html>

<head>
    <title>Salary Disbursement Notification</title>
</head>

<body>
    <p>Salary Disbursement for {{ $mailData['term'] }}</p>
    <p>Dear <b> {{ $mailData['staffName'] }}</b>,</p>
    <p>I trust this email finds you well. We are pleased to inform you that the salary for the month of
        {{ $mailData['term'] }} has been processed and disbursed.</p>
    <p>Attached, you will find your salary statement for this month. Please review the details, and if you have any
        questions or concerns regarding your salary, do not hesitate to contact the HR department at
        accounts@teamtechsoul.com.</p>
    <p>We appreciate your hard work and dedication to<b> Techsoul Cyber Solutions</b>. Your efforts contribute
        significantly to the success of our organization, and we value your commitment.</p>
    <p>Thank you for your continued contributions. If you require any further assistance or have inquiries, feel free to
        reach out.</p>
    <p>Wishing you a great month ahead.</p>
    <p>Best regards,</p>
    <p><b>Fathima Shalu M.K</b> </p>
    <p>Finance Manager</p>
    <p>TECHSOUL CYBER SOLUTIONS</p>
    <p>accounts@teamtechsoul.com</p>
</body>

</html>
