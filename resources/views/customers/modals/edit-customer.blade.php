<div id="edit_customer_{{$customer->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="NewtaskForm" method="POST" action="{{ route('customers.update',$customer->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Name</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="name" type="text" class="form-control validate" placeholder="" Value="{{ $customer->name }}">
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Mobile</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="mobile" type="text" class="form-control validate" placeholder="" Value="{{ $customer->mobile }}">
                            @error('mobile')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Place</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="place" type="text" class="form-control validate" placeholder="" Value="{{ $customer->place }}">
                            @error('place')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">Customer Email</label>
                        <div class="col-lg-12">
                            <input id="email" name="email" type="email" class="form-control validate" placeholder="" Value="{{ $customer->email }}">
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="taskname" class="col-form-label">GST No</label>
                        <div class="col-lg-12">
                            <input id="taskname" name="gst_no" type="text" class="form-control validate" placeholder="" Value="{{ $customer->gst_no }}">
                            @error('gst_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-primary" id="addtask" onclick="this.disabled=true;this.innerHTML='Saving..';this.form.submit();">Update Details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
