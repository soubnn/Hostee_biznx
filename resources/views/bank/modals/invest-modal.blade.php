<!-- Invest Modal -->
<div id="invest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="investModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="investForm" method="POST" action="{{ route('banks.invest') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="invest_date" class="col-form-label">Date</label>
                        <div class="col-lg-12">
                            <input id="invest_date" name="date" type="text" class="form-control" readonly value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="invest_description" class="col-form-label">Description</label>
                        <div class="col-lg-12">
                            <input id="invest_description" name="description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="invest_amount" class="col-form-label">Amount</label>
                        <div class="col-lg-12">
                            <input id="invest_amount" name="amount" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="invest_account" class="col-form-label">Account</label>
                        <div class="col-lg-12">
                            <select id="invest_account" name="account" class="form-control">
                                <option value="CASH">CASH</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="bank" value="{{ $bank->id }}">
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Submit Invest</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div id="withdraw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdraw</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="withdrawForm" method="POST" action="{{ route('banks.withdraw') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="withdraw_date" class="col-form-label">Date</label>
                        <div class="col-lg-12">
                            <input id="withdraw_date" name="date" type="text" class="form-control" readonly value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdraw_description" class="col-form-label">Description</label>
                        <div class="col-lg-12">
                            <input id="withdraw_description" name="description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdraw_amount" class="col-form-label">Amount</label>
                        <div class="col-lg-12">
                            <input id="withdraw_amount" name="amount" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="withdraw_account" class="col-form-label">Account</label>
                        <div class="col-lg-12">
                            <select id="withdraw_account" name="account" class="form-control">
                                <option value="CASH">CASH</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="bank" value="{{ $bank->id }}">
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Submit Withdraw</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
