<!-- Modal -->
<div id="returnPayModal{{$sales_return->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Balance Amount : <strong>{{round($sales_return->payment_sales_return_balance,2)}}</strong></h6>
                <form method="POST" action="{{ route('addSalesReturnInvoicePayment') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Payment Date</label>
                        <div class="col-lg-12">
                            <input type="date" name="date" class="form-control" value="{{ Carbon\carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') }}" readonly>
                            @error('date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Payment Amount</label>
                        <div class="col-lg-12">
                            <input type="number" name="amount" min="0" step="0.01" max="{{ round($sales_return->payment_sales_return_balance,2) }}" value="{{ round($sales_return->payment_sales_return_balance,2) }}" placeholder="Amount" class="form-control">
                            <input type="hidden" name="expense_id" value="SALE_RETURN">
                            <input type="hidden" name="job" value="{{ $sales_return->invoice_number }}">
                            <input type="hidden" name="type" value="Expense">
                            @error('amount')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Accounts Type</label>
                        <div class="col-lg-12">
                            <select name="accounts" class="form-control select2" style="width: 100%" data-dropdown-parent="#returnPayModal{{$sales_return->id}}">
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
                            <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Paymenting...';this.form.submit();">Add Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->