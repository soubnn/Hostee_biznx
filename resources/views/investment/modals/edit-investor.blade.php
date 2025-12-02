<!-- Edit Investor Modal -->
<div id="editInvestorModal{{ $investor->id }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Edit Investor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('investor.update', $investor->id) }}">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-3">
                        <label for="name{{ $investor->id }}" class="col-form-label">Name</label>
                        <div class="col-lg-12">
                            <input id="name{{ $investor->id }}" name="name" type="text" class="form-control validate" value="{{ $investor->name }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number{{ $investor->id }}" class="col-form-label">Phone Number</label>
                        <div class="col-lg-12">
                            <input id="phone_number{{ $investor->id }}" name="phone_number" type="text" class="form-control validate" value="{{ $investor->phone_number }}">
                            @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="designation{{ $investor->id }}" class="col-form-label">Designation</label>
                        <div class="col-lg-12">
                            <input id="designation{{ $investor->id }}" name="designation" type="text" class="form-control validate" value="{{ $investor->designation }}">
                            @error('designation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Update Investor</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
