@extends('layouts.layout')
@section('content')
<script>
    $(document).ready(function() {
        $("input[type='text']").keyup(function() {
            this.value = this.value.toUpperCase();
        });

        function updateTaskDescription() {
            var selectedItems = [];
            $('input[id^="item_product_name"]').each(function() {
                selectedItems.push($(this).val());
            });
            $('#taskdescription').val(selectedItems.join(', '));
        }

        function calculateUnitPrice() {
            var total = parseFloat($('#tasktotel').val());
            var gst = parseFloat($('#taskgst').val());
            var unitPrice = total / (1 + gst / 100);
            $('#taskunit_price').val(unitPrice.toFixed(2)); 
        }

        updateTaskDescription();

        calculateUnitPrice();

        $('#taskgst').change(function() {
            calculateUnitPrice();
        });
    });
</script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ isset($consolidate_bill) ? 'Edit Consolidate Invoice' : 'Create Consolidate Invoice' }}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ isset($consolidate_bill) ? route('consolidate.update', $consolidate_bill->id) : route('consolidate.store') }}" method="POST">
                                @csrf
                                @if(isset($consolidate_bill))
                                    @method('PUT') <!-- Use PUT method for update -->
                                @endif

                                @foreach($salesItems as $item)
                                    <input type="hidden" id="item_product_name[]" value="{{ $item->product_name }}">
                                @endforeach

                                <div class="form-group row mb-3">
                                    <div class="col-lg-4">
                                        <label for="taskdescription" class="col-form-label">Product Description</label>
                                        @if (isset($consolidate_bill))
                                            <input  name="description" type="text" class="form-control validate" value="{{ $consolidate_bill->description }}" required>
                                        @else
                                            <input id="taskdescription" name="description" type="text" class="form-control validate" value="{{ old('description') }}" required>
                                        @endif
                                        @error('description')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="taskunit_price" class="col-form-label">Unit Price</label>
                                        <input id="taskunit_price" type="text" class="form-control validate" value="{{ old('unit_price') }}" readonly required>
                                        <input type="hidden" name="sales_id" value="{{ $salesItems[0]->sales_id }}">
                                        @error('unit_price')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="taskqty" class="col-form-label">Quantity</label>
                                        <input id="taskqty" type="text" class="form-control validate" value="1" readonly required>
                                        @error('qty')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="taskgst" class="col-form-label">GST Percentage</label>
                                        <select class="form-control" name="gst" id="taskgst" style="width:100%;">
                                            @foreach([0, 3, 5, 12, 18, 28] as $gstOption)
                                                <option value="{{ $gstOption }}" {{ isset($consolidate_bill) && $consolidate_bill->gst == $gstOption ? 'selected' : '' }}>{{ $gstOption }}</option>
                                            @endforeach
                                        </select>
                                        @error('gst')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="tasktotel" class="col-form-label">Total</label>
                                        <input id="tasktotel" type="text" class="form-control validate" value="{{ $sale->grand_total }}" readonly required>
                                        @error('totel')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ isset($consolidate_bill) ? 'Update' : 'Submit' }}</button>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection
