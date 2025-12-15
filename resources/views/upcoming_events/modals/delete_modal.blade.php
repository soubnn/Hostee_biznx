<!-- Delete Modal -->
<div id="delete_modal{{ $event->id }}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('upcoming_events.destroy', $event->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="form-group mb-3">
                        <div class="col-lg-12 text-center">
                            <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                            <h4>Are You Sure?</h4>
                            <p style="font-weight: 300px;font-size:18px;">This event will be deleted!</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-info" id="delete_event">Yes, delete</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
