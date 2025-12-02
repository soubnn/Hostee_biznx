@extends('layouts.layout')
@section('content')
<script>
    $(document).ready(function(){
        printDiv1();
    });
    function printDiv1() {

        var printContents = document.getElementById('recieptBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Receipt</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card" id="recieptBody">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <img src="{{ asset('assets/images/tslogo-dark.png') }}" alt="logo" height="40"/>
                                        </div>
                                        <h2 class="text-center"><strong>PAYMENT RECEIPT</strong></h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Payment Date: <strong>{{$paymentDetails->date}}</strong></h6>
                                                <h6>Receipt No: <strong>{{$paymentDetails->id}}</strong></h6>
                                                <h6>Customer: <strong>{{ strtoupper($invoiceDetails->customer_name) }} @if($invoiceDetails->customer_phone), {{$invoiceDetails->customer_phone}}@endif</strong></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <table class="table w-100 nowrap">
                                                <thead>
                                                    <th>PARTICULARS</th>
                                                    <th>PAYMENT METHOD</th>
                                                    <th>AMOUNT</th>
                                                </thead>
                                                <tbody>
                                                    <td>PAYMENT AGAINST INVOICE #{{ $paymentDetails->job }}</td>
                                                    <td>{{ $paymentDetails->accounts }}</td>
                                                    <td>₹ {{ $paymentDetails->amount }}</td>
                                                </tbody>
                                            </table>
                                            <br>
                                            Amount in Words
                                            <br><strong>{{ $amountInWords }} Rupees</strong>
                                        </div>
                                        <div class="col-md-12 text-end">
                                            Authorised Signature<br>(for Techsoul Cyber Solutions)
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection
