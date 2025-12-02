<div id="share_modal_{{ $product->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Product Name</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="product_name" id="product_name" value="{{ $product->product_name }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Price</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="product_price" id="product_price" value="{{ $product->product_selling_price }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Warrenty</label>
                    <div class="col-lg-12">
                        @if($product->product_warrenty == '')
                            <input type="text" class="form-control" name="product_warrenty" id="product_warrenty" value="1 YEAR">
                        @else
                            <input type="text" class="form-control" name="product_warrenty" id="product_warrenty" value="{{ $product->product_warrenty }}">
                        @endif
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Whatsapp Contact No</label>
                    <div class="col-lg-12">
                        <input type="number" class="form-control" name="contact" id="contact_1" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-end">
                        <button type="button" class="btn btn-success" id="addtask" onclick="send_message()"><i class="bx bxl-whatsapp" style="font-size:16px;"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
