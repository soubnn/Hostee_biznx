<!-- Disabe Modal -->
<div id="disable_estimate_modal{{$estimate->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="Post" action="{{ route('disable_estimate',$estimate->id) }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="col-lg-12 text-center">
                                <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                <h4>Are You Sure ??</h4>
                                <p style="font-weight: 300px;font-size:18px;">The Estimate will be Disabled..</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-info" id="addtask">Yes, Disable</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
