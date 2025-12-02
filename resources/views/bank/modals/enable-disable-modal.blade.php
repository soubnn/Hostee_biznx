<!-- Disable Modal -->
<div id="disableModal{{ $bank->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('banks.disable', $bank->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <div class="col-lg-12 text-center">
                            <i class="mdi mdi-block-helper text-danger" style="font-size: 50px;"></i>
                            <h4>Are You Sure?</h4>
                            <p style="font-size: 18px;">You are about to <strong>disable</strong> <strong>{{ $bank->bank_name }}</strong>.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-danger">Yes, Disable</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Enable Modal -->
<div id="enableModal{{ $bank->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('banks.enable', $bank->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <div class="col-lg-12 text-center">
                            <i class="mdi mdi-check-circle text-success" style="font-size: 50px;"></i>
                            <h4>Are You Sure?</h4>
                            <p style="font-size: 18px;">You are about to <strong>enable</strong> <strong>{{ $bank->bank_name }}</strong>.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-success">Yes, Enalble</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

