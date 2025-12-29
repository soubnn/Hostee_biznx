<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 100%;
            padding: 20px;
            padding-top: 80px;
            box-sizing: border-box;
        }
        .from, .to {
            width: 45%;
            padding: 20px;
            box-sizing: border-box;
        }
        .from {
            float: left;
        }
        .to {
            float: right;
            margin-top: 80px;
        }
        h3 {
            margin-top: 0;
            margin-bottom: 0px;
            font-size: 19px;
        }
        p {
            margin: 5px 0;
            font-size: 17px;
        }
        img {
            margin-bottom: 10px;
            width: 250px
        }
    </style>
</head>
<body>
    <div style="text-align: right">
        <!--<img src="assets/images/tslogo-dark.png" alt="Company Logo">-->
        {{-- Uncomment the line below if using Laravel --}}
        <img src="{{ asset('assets/images/invoice/logo.png') }}" alt="Company Logo">
    </div>
    <div class="container">
        <div class="from">
            <p style="margin-left: -35px;margin-bottom: 10px;">From:</p>
            <h3>HOSTEE THE PLANNER</h3>
            {{-- <p>GSTIN: 32ADNPO8730B1ZO</p> --}}
            <p>NEAR LANCOR CONCEPTS, CHERUSHOLA ROAD, SWAGATHAMAD</p>
            <p>MALAPPURAM-KERALA, Pin: 676503</p>
            <p>Tel: +91 85929 24592</p>
            <p>Tel: +91 85929 24692</p>
            <p>Email: hosteetheplanner@gmail.com</p>
            <p>Website: www.hosteetheplanner.com</p>
        </div>
        <div class="to">
            <p style="margin-left: -35px;margin-bottom: 10px;">To:</p>
            <h3>{{ $seller->seller_name }}</h3>
            @php
                $address_parts = explode('\ ', $seller->courier_address);
            @endphp
            <p>
                @foreach($address_parts as $part)
                    {{ $part }}<br>
                @endforeach
            </p>
            {{--  @if ($seller->seller_phone)
                <p>Tel: {{ $seller->seller_phone }}</p>
            @endif
            @if ($seller->seller_mobile)
                <p>Tel: {{ $seller->seller_mobile }}</p>
            @endif  --}}
        </div>
    </div>
</body>
</html>
