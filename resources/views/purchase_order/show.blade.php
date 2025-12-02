@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
<script>
$(document).ready(function(){
    $("#datatable").dataTable({
        "pageLength" : 100
    });
});
function whatsappPurchaseOrder()
{
    var website = $("#hiddenURL").val();
    window.open(website, '_blank');
    document.getElementById("downloadPurchaseOrderForm").submit();
}
function change_total(id){
    var unit_price = document.getElementById('unit_price_'+id).value;
    var qty = document.getElementById('qty_'+id).value;
    var total = unit_price * qty;
    total_input = document.getElementById('total_'+id);
    total_hidden_input = document.getElementById('total_hidden_'+id);
    total_input.value = total.toFixed(2);
    total_hidden_input.value = total.toFixed(2);
}
</script>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">View Purchase Order Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h4 class="card-title mb-4">Purchase Order Details</h4>
                                        </div>
                                        <div class="col-md-6">
                                            @php
                                                $message = "Dear " . $purchase_order->customer_name . ",Please proceed with your purchase using this link: https://techsoul.biznx.in/userPurchaseOrder/" . $purchase_order->id."";
                                                $message = urlencode($message);
                                                $url = "https://api.whatsapp.com/send/?phone=91$purchase_order->seller_mobile&text=$message";
                                            @endphp
                                            <div class="d-flex flex-wrap gap-2" style="float: right ;">
                                                <a href="{{ route('purchase_order_report',$purchase_order->id) }}">
                                                    <button type="button" class="btn btn-success waves-effect waves-light">Generate Purchase Order</button>
                                                </a>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2" style="float: right;margin-right:10px;">
                                                <button type="button" class="btn btn-success waves-effect waves-light me-1" onclick="whatsappPurchaseOrder()"><i class="bx bxl-whatsapp"></i>
                                                    <span style="font-weight:500;">Whatsapp</span>
                                                </button>
                                            </div>
                                            <input type="hidden" id="hiddenURL" value="{{ $url }}">
                                            <form action="{{ route('whatsappPurchaseOrder',$purchase_order->id) }}" id="downloadPurchaseOrderForm">
                                            </form>
                                        </div>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($purchase_order_details as $purchase_order_detail)
                                                <tr>
                                                    @php
                                                        $get_product = DB::table('products')->where('id',$purchase_order_detail->product_name)->first();
                                                    @endphp
                                                    @if ($get_product)
                                                        <td style="white-space: normal">{{ $get_product->product_name }}</td>
                                                    @else
                                                        <td style="white-space: normal">{{ $purchase_order_detail->product_name }}</td>
                                                    @endif
                                                    <td>{{ $purchase_order_detail->unit_price }}</td>
                                                    <td>{{ $purchase_order_detail->qty }}</td>
                                                    <td>{{ $purchase_order_detail->total }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

@endsection
