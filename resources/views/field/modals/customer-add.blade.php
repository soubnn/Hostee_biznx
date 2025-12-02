<!-- new customer modal -->
<div id="newCustomerModal" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="NewtaskForm" method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Name</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="name" type="text" class="form-control validate" placeholder="" Value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Mobile</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="mobile" type="text" class="form-control validate" placeholder="" Value="{{ old('mobile') }}">
                            @error('mobile')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Place</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="place" type="text" class="form-control validate" placeholder="" Value="{{ old('place') }}">
                            @error('place')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Email</label>
                        <div class="col-lg-12">
                            <input id="email" name="email" type="email" class="form-control validate" placeholder="" Value="{{ old('email') }}" style="text-transform:lowercase;">
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">GST No</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="gst_no" type="text" class="form-control validate" placeholder="" Value="{{ old('gst_no') }}">
                            @error('gst_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Save Details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
