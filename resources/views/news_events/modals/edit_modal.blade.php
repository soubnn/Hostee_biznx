<!-- Edit Modal -->
                                    <div id="edit_modal{{ $event->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $event->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $event->id }}">Edit News Event</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('news_events.update', $event->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-group mb-3">
                                                            <label for="title" class="col-form-label">Title</label>
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control" name="title" value="{{ $event->title }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="location" class="col-form-label">Location</label>
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control" name="location" value="{{ $event->location }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="date" class="col-form-label">Date</label>
                                                            <div class="col-lg-12">
                                                                <input type="date" class="form-control" name="date" value="{{ $event->date }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="description" class="col-form-label">Description</label>
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control" name="description" rows="4">{{ $event->description }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="photo" class="col-form-label">Photo</label>
                                                            <div class="col-lg-12">
                                                                <input type="file" class="form-control" name="photo">
                                                                <small>Leave blank to keep the current photo</small>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12 text-end">
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
