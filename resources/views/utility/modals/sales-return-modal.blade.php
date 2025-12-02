<!-- Suspend Modal -->
<div id="return_modal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="Post" action="{{ route('util_sales_return',$salesDetails->id ) }}">
                @csrf
                    <div class="form-group mb-3">
                        <div class="col-lg-12 text-center">
                            {{-- <i class="dripicons-warning text-danger" style="font-size: 50px;"></i> --}}
                            <h4>Are You Sure ??</h4>
                            <p style="font-weight: 300px;font-size:18px;">this sale will be cancelled!</p>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label>Return Payment Method</label>
                            <select class="form-control" name="payment_method">
                                <option value="CASH" selected>CASH</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-info" id="addtask" onclick="this.disabled=true;this.innerHTML='Cancelling...';this.form.submit();">Yes, Cancel</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
