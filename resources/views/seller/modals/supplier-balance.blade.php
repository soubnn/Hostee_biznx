<div id="balance_modal" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Supplier Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="col-form-label">Current Supplier Balance</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control validate" placeholder="" value="{{ $sellers->sum('total_balance') }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
