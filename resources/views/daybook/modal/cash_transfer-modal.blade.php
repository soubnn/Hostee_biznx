<!-- Modal for cash transfer -->
                <div id="cash_transfer_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Cash Transfer Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('cashTransfer') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group mb-3 col-md-3">
                                            <label class="col-form-label">From *</label>
                                            <select id="fromSelect" name="fromSelect" class="form-control select2" required style="width: 100%" data-dropdown-parent="#cash_transfer_modal">
                                                <option disabled selected>Select</option>
                                                <option value="CASH">CASH</option>
                                                <option value="ACCOUNT">ACCOUNT</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 col-md-3">
                                            <label class="col-form-label">To *</label>
                                            <select id="toSelect" name="toSelect" class="form-control select2" required style="width: 100%" data-dropdown-parent="#cash_transfer_modal">
                                                <option disabled selected>Select</option>
                                                <option value="CASH">CASH</option>
                                                <option value="ACCOUNT">ACCOUNT</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 col-md-3">
                                            <label class="col-form-label">Amount *</label>
                                            <input id="amount" name="amount" type="number" class="form-control" required>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" type="submit" onclick="this.disabled=true;this.innerHTML='Saving...';this.form.submit();">Transfer&nbsp;&nbsp;&nbsp;<i class="bx bx-transfer"></i></button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="transferDate" id="transferDate" value="{{ Carbon\carbon::now()->format('d-m-Y')}}">
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>