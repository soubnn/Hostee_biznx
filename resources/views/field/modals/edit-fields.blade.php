<!-- Edit Modal -->
<div id="edit_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Edit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('field.update',$work->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <div class="row mb-4">
                        <label for="projectname" class="col-form-label col-lg-2">Date</label>
                        <div class="col-lg-10">
                            <input type="date" name="date" class="form-control" value="{{ Carbon\Carbon::parse($work->date)->format('Y-m-d')}}" >
                            @error('date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="projectname" class="col-form-label col-lg-2">Customer</label>
                        <div class="col-lg-10">
                            <select id="customer" name="customer" class="form-control select2" data-dropdown-parent="#edit_modal" style="width:100%;" onchange="set_name_select(this.value)">
                                <option selected disabled>Select Customer</option>
                                @php
                                    $customers = DB::table('customers')->get();
                                @endphp
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if($work->customer == $customer->id) selected @endif>{{ $customer->name }}, {{ $customer->place }}</option>
                                @endforeach
                                <option value="new">New Customer</option>
                            </select>
                            @error('customer')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="billing-phone" class="col-md-2 col-form-label">Phone</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $work->phone }}" placeholder="Enter Phone no.">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-md-2 col-form-label">Place</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="place" id="place" value="{{ $work->place }}" placeholder="Enter Place">
                            @error('place')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-form-label col-lg-2">Work</label>
                        <div class="col-lg-10">
                            <input name="work" type="text" placeholder="Enter Work" class="form-control" value="{{ $work->work }}" onkeyup="this.value = this.value.toUpperCase()">
                            @error('work')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="projectbudget" class="col-form-label col-lg-2">Estimate</label>
                        <div class="col-lg-10">
                            @php
                                $estimates = DB::table('estimates')->get();
                            @endphp
                            <select class="form-control select2" name="estimate" data-dropdown-parent="#edit_modal" style="width:100%;">
                                <option selected disabled>select</option>
                                @foreach ( $estimates as $estimate)
                                    <option value="{{ $estimate->id }}" @if($estimate->id == $work->estimate) selected @endif>{{ $estimate->id }},[ {{ $estimate->customer_name }} ]</option>
                                @endforeach
                            </select>
                            @error('estimate')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-primary" id="addtask">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function enable_btn() {
        var customer = $('#customer').val();
        var phone = $('#phone').val();
        var place = $('#place').val();
        var isDisabled = (customer === 'new' && (phone.length < 10 || place === '')) || (customer !== 'new' && (phone === '' || place === ''));
        $('#addtask').prop('disabled', isDisabled);
    }

    function set_name_select(customer) {
        if (customer === 'new') {
            $("#phone, #place").val('').hide();
        } else {
            $("#phone, #place").show();
            $.ajax({
                type: "GET",
                url: "{{ route('getCustomerDetails') }}",
                data: { customer: customer },
                success: function(res) {
                    $("#phone").val(res.mobile);
                    $("#place").val(res.place);
                    enable_btn();
                }
            });
        }
    }

    $(document).ready(function() {
        $('#edit_modal .select2').select2({
            dropdownParent: $('#edit_modal')
        });
    });
</script>
