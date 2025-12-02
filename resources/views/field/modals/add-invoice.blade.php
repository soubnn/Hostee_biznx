<div id="invoice_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-task-title">Add Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('field.store_invoice', $work->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <label for="invoice" class="col-form-label col-lg-2">Invoice</label>
                        <div class="col-lg-10">
                            <select class="select2 form-control" name="invoice" data-dropdown-parent="#invoice_modal" style="width: 100%">
                                <option selected disabled>Select</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}">
                                        {{ $invoice->invoice_number }},
                                        Amount - {{ $invoice->grand_total - $invoice->discount }} 
                                        ({{ \Carbon\Carbon::parse($invoice->sales_date)->format('d-m-Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('invoice')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
