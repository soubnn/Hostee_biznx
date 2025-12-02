<!-- Edit Modal -->
    <div class="modal fade" id="editServicerModal{{ $third_party->id }}" tabindex="-1" aria-labelledby="editServicerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServicerModalLabel">Edit Servicer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update_servicer', $third_party->id) }}" method="POST">
                        @csrf
                        @method('POST') 
                        <div class="mb-3">
                            <label for="edit_servicer_name" class="col-form-label">Servicer Name:</label>
                            <input type="text" class="form-control" id="edit_servicer_name" name="servicer_name" value="{{ old('servicer_name', $third_party->servicer_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_servicer_contact" class="col-form-label">Servicer Contact:</label>
                            <input type="text" class="form-control" id="edit_servicer_contact" name="servicer_contact" value="{{ old('servicer_contact', $third_party->servicer_contact) }}" required pattern="\d{10}" title="Please enter a 10-digit phone number.">
                        </div>
                        <div class="mb-3">
                            <label for="edit_servicer_place" class="col-form-label">Servicer Place:</label>
                            <input type="text" class="form-control" id="edit_servicer_place" name="servicer_place" value="{{ old('servicer_place', $third_party->servicer_place) }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button> <!-- Moved inside the form -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>