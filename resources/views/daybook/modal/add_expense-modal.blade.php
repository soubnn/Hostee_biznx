<!-- Modal for add expense type -->
                <div id="add_expense_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Add Expense Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Expense Name *</label>
                                        <input id="expense_name" name="expense_name" type="text" class="form-control" placeholder="" Value="">
                                        <small id="expense_nameError" style="display:none" class="text-danger">Expense Name cannot be empty</small>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Expense Catgeory *</label>
                                        <select class="select2 form-control" name="expense_category" id="expense_category" data-dropdown-parent="#add_expense_modal" style="width:100%;">
                                            <option selected disabled>Select</option>
                                            <option value="Expense">Expense</option>
                                            <option value="Deposit/Others">Deposit/Others</option>
                                        </select>
                                        <small id="expense_categoryError" style="display:none" class="text-danger">Expense Category cannot be empty</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary" onclick="registerExpense()">Add Expense</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>