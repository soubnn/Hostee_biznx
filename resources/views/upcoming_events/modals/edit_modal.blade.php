<!-- Edit Modal -->
<div id="edit_modal{{ $event->id }}" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Upcoming Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form method="POST" action="{{ route('upcoming_events.update', $event->id) }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $event->title }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" value="{{ $event->location }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" value="{{ $event->date }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ $event->description }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        <small class="text-muted">Leave blank to keep current image</small>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
