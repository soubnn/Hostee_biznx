<div id="incentive_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title add-task-title">Add Incentive Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group mb-3 col-md-6">
                                        <label class="col-form-label">Staff</label>
                                        <br>
                                        <select id="staff" name="staff" class="form-control select2" onchange="getIncentiveDetails(this.value)" data-dropdown-parent="#incentive_modal" style="width: 100%">
                                            <option value="">Select Staff</option>
                                            @php
                                                $staffs = DB::table('staffs')->get();
                                            @endphp
                                            @foreach ($staffs as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" id="incentive_div">
                                        <label class="col-form-label">Incentive Amount *</label>
                                        <input id="incentive_amount" name="incentive_amount" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary" onclick="addIncentiveInput()">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>