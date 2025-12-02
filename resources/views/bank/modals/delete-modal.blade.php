<div id="deleteModal{{ $bank->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('banks.destroy', $bank->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="form-group mb-3">
                        <div class="col-lg-12 text-center">
                            <i class="dripicons-trash text-danger" style="font-size: 50px;"></i>
                            <h4>Are You Sure?</h4>
                            <p style="font-weight: 300px; font-size:18px;">
                                This will delete <strong>{{ $bank->bank_name }}</strong> permanently.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
