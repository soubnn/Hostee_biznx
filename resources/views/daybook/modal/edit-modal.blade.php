<div id="edit_modal_{{ $entry->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Daybook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('daybook.update',$entry->id) }}">
            @csrf
            @method('PATCH')
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Date</label>
                    <div class="col-lg-12">
                        <input class="form-control" type="date" value="{{ $entry->date }}" name="date" readonly>
                    </div>
                </div>
                @if($entry->type == "Expense")
                    @if ( $entry->expense_id == "FOR_SUPPLIER")    
                        <div class="form-group mb-3">
                            <label class="col-form-label" style="float:left;">Suppliers</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control" data-dropdown-parent="#edit_modal_{{ $entry->id }}" name="expense_id" style="width: 100%;">
                                    @foreach ( $suppliers as $supplier )
                                        <option value="{{ $supplier->id }}" {{ $supplier->id == $entry->job ? 'selected' : '' }}>{{ $supplier->seller_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="form-group mb-3">
                            <label class="col-form-label" style="float:left;">Expense</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control" data-dropdown-parent="#edit_modal_{{ $entry->id }}" name="expense_id" style="width: 100%;">
                                    @foreach ( $expenses as $expense )
                                        <option value="{{ $expense->id }}" {{ $expense->id == $entry->expense_id ? 'selected' : '' }}>{{ $expense->expense_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                @elseif($entry->type == "Income")
                    <div class="form-group mb-3">
                        <label class="col-form-label" style="float:left;">Customer Name</label>
                        <div class="col-lg-12">
                            <select class="select2 form-control" data-dropdown-parent="#edit_modal_{{ $entry->id }}" name="income_id" style="width: 100%;">
                                @foreach ( $incomes as $income )
                                    <option value="{{ $income->id }}" {{ $income->id == $entry->income_id ? 'selected' : '' }}>{{ $income->income_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Amount</label>
                    <div class="col-lg-12">
                        <input class="form-control" type="number" value="{{ $entry->amount }}" name="amount" min='0' step="0.01">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="col-form-label" style="float:left;">Account Name</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="accounts" style="width: 100%;">
                            <option value="CASH" {{ $entry->accounts == 'CASH'? 'selected' : '' }}>CASH</option>
                            <option value="ACCOUNT" {{ $entry->accounts == 'ACCOUNT'? 'selected' : '' }}>ACCOUNT</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-end">
                        <button type="submit" class="btn btn-primary">Update Changes</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
