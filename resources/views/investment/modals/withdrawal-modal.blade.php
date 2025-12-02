<!-- Withdrawal Modal -->
<div id="withdrawal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="withdrawalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdrawal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="withdrawalForm" method="POST" action="{{ route('investor_withdrawal.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="withdrawal_date" class="col-form-label">Date</label>
                        <div class="col-lg-12">
                            <input id="withdrawal_date" name="date" type="text" class="form-control" readonly value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdrawal_description" class="col-form-label">Description</label>
                        <div class="col-lg-12">
                            <input id="withdrawal_description" name="description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdrawal_amount" class="col-form-label">Amount</label>
                        <div class="col-lg-12">
                            <input id="withdrawal_amount" name="amount" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdrawal_account" class="col-form-label">Account</label>
                        <div class="col-lg-12">
                            <select id="withdrawal_account" name="account" class="form-control">
                                <option value="CASH">CASH</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="investor" value="{{ $investor->id }}">
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Submit Withdrawal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
