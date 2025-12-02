<!-- Modal for add income type -->
                <div id="add_income_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Add Income Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Income Name *</label>
                                        <input id="income_name" name="income_name" type="text" class="form-control" placeholder="" Value="">
                                        <small id="income_nameError" style="display:none" class="text-danger">Income Name cannot be empty</small>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary" onclick="registerIncome()">Add Income</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>