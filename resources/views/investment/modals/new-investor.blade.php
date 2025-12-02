<!-- New Investor Modal -->
<div id="newInvestor" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">New Investor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="NewtaskForm" method="POST" action="{{ route('investor.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Name</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="name" type="text" class="form-control validate" placeholder="" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <div class="col-lg-12">
                            <input id="phone_number" name="phone_number" type="text" class="form-control validate" placeholder="" value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="designation" class="col-form-label">Designation</label>
                        <div class="col-lg-12">
                            <input id="designation" name="designation" type="text" class="form-control validate" placeholder="" value="{{ old('designation') }}">
                            @error('designation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Add Investor</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
