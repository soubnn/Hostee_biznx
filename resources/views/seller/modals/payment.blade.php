<!-- Modal -->
<div id="payModal{{$seller->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Balance Amount : <strong>{{ $seller->total_balance }}</strong></h6>
                <form id="NewtaskForm" method="POST" action="{{ route('addSupplierPayment') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="col-lg-12">
                            <input type="date" class="form-control" name="date" value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}" readonly>
                            @error('date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">Payment Amount</label>
                        <div class="col-lg-12">
                            <input type="number" name="amount" min="0" step="0.01" value="{{ $seller->total_balance }}" placeholder="Amount" class="form-control">
                            <input type="hidden" name="expense_id" value="FOR_SUPPLIER">
                            <input type="hidden" name="job" value="{{ $seller->id }}">
                            <input type="hidden" name="type" value="Expense">
                            @error('amount')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">Accounts Type</label>
                        <div class="col-lg-12">
                            <select name="accounts" class="form-control select2" style="width: 100%" data-dropdown-parent="#payModal{{$seller->id}}">
                                <option disabled selected>Select</option>
                                <option value="CASH">CASH</option>
                                <option value="ACCOUNT">ACCOUNT</option>
                            </select>
                            @error('accounts')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-primary">Add Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
