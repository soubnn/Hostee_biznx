{{-- enable modal start --}}

<div id="enable_estimate_modal{{$estimate->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enable Estimate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <form method="POST" action="{{ route('enable_estimate',$estimate->id) }}">
            @csrf
                <div class="form-group mb-3">
                    <label for="profilename" class="col-form-label" style="float:left;">New Expiry Date</label>
                    <div class="col-lg-12">
                        <input type="date" name="valid_upto" class="form-control" min="{{ Carbon\carbon::now()->format('Y-m-d') }}">
                        @error('valid_upto')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-end">
                        <button type="submit" class="btn btn-primary" id="addtask">Update</button>
                    </div>
                </div>
            </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- modal end --}}
