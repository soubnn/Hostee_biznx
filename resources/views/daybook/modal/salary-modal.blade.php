<div id="salary_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Add Salary Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mb-3 col-md-6">
                        <label class="col-form-label">Staff</label>
                        <br>
                        <select id="staff" name="staff" class="form-control select2" onchange="getSalaryDetails(this.value)" data-dropdown-parent="#salary_modal" style="width: 100%">
                            <option value="">Select Staff</option>
                            @php
                                $staffs = DB::table('staffs')->get();
                            @endphp
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Monthly Salary</th>
                                </tr>
                            </thead>
                            <tbody id="salary_tbody">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group mt-5 col-md-6" id="salary_div" style="display: none">
                        <label class="col-form-label">Salary Amount *</label>
                        <input id="salary_amount" name="salary_amount" type="number" class="form-control">
                        <small id="salary_emptyError" style="display:none" class="text-danger">Salary Amount cannot be empty or less than 1</small>
                        <small id="salary_amountError" style="display:none" class="text-danger">Salary amount cannot be greater than pending commission</small>
                    </div>
                </div>
                <div class="row mt-3" id="salary_submit_div" style="display: none">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary" onclick="addSalaryInput()">Add</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>