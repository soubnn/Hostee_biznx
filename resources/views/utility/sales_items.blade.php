@extends('utility.layout')
@section('content')
    <script>
        var gTotal = 0;

        function calculateTaxable(row)
        {
            var unitPrice = parseFloat($("#unit_price_" + row).val());
            var qty = parseFloat($("#qty_" + row).val());
            var taxable = unitPrice * qty;
            console.log(taxable);
            $("#taxable_" + row).val(taxable.toFixed(2));
            calculateTax(row);
        }

        function calculateTax(row)
        {
            var taxable = parseFloat($("#taxable_" + row).val());
            var gstPercent = parseFloat($("#gstPercent_" + row).val());
            var tax = (taxable * gstPercent) / 100;
            $("#tax_value_" + row).val(tax.toFixed(2));
            var total = taxable + tax;
            $("#total_" + row).val(total.toFixed(2));
        }

        function addCustomProduct(productValue,row)
        {
            $.ajax({
                url : "{{ route('getProductDetails') }}",
                type : "get",
                data : {product: productValue},
                success : function(res)
                {
                    console.log(res);
                    $("#unit_price_" + row).val(res.product_price);
                    $("#taxable_" + row).val(res.product_price);
                    $("#qty_" + row).val('1');
                }
            });
        }
        function get_discounted_total(discount){
            let discounted_total = 0;
            let grand_total = 0;
            grand_total = document.getElementById('grand_total').value;
            if(parseFloat(discount) <= parseFloat(grand_total)){
                document.getElementById('discount_error').style.display = 'none';
                discounted_total = parseFloat(grand_total) - parseFloat(discount);
            }
            else{
                document.getElementById('discount_error').style.display = 'block';
            }
            document.getElementById('discounted_total').value = discounted_total.toFixed(2);
        }

    </script>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Sales Management</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('utility_update_sales') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label>Invoice Number</label>
                                                    <input type="text" value="{{ $salesDetails->invoice_number }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label>Sales Date</label>
                                                    <input type="text" value="{{ carbon\Carbon::parse($salesDetails->sales_date)->format('d-m-Y') }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label>Customer</label>
                                                    @php
                                                        $customer = DB::table('customers')->where('id',$salesDetails->customer_id)->first();
                                                    @endphp
                                                    <input type="text" value="{{ $customer->name }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label>Sales Person</label>
                                                    <select class="form-control select2" name="sales_staff" style="width: 100%">
                                                        <option disabled selected>Select Staff</option>
                                                        @php
                                                            $staffs = DB::table('staffs')->get();
                                                        @endphp
                                                        @foreach ($staffs as $staff)
                                                            <option value="{{ $staff->id }}" {{ old('sales_staff', $salesDetails->sales_staff) == $staff->id ? 'selected' : '' }}>{{ $staff->staff_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @php
                                                    $amountPaid = DB::table('daybooks')->where('type','Income')->where('job',$salesDetails->invoice_number)->where('income_id','FROM_INVOICE')->sum('amount');
                                                @endphp
                                                <div class="col-md-3 mb-3">
                                                    <label>Total</label>
                                                    <input type="text" value="{{ $salesDetails->grand_total }}" class="form-control" id="grand_total" readonly>
                                                </div>
                                                @if ( $salesDetails->payment_status != 'paid' )
                                                    <div class="col-md-3 mb-3">
                                                        <label>Discount</label>
                                                        <input type="number" step="0.01" value="{{ $salesDetails->discount }}" class="form-control" name="discount" onkeypress="get_discounted_total(this.value)" onkeyup="get_discounted_total(this.value)" onchange="get_discounted_total(this.value)">
                                                        @error('discount')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                @endif
                                                <div class="col-md-3 mb-3">
                                                    <label>Grand Total</label>
                                                    <input type="text" value="{{ ($salesDetails->grand_total) - ($salesDetails->discount) }}" id="discounted_total" class="form-control" readonly>
                                                    <span class="text-danger" id="discount_error" style="display: none;">discount can't be greater than total</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="salesId" value="{{ $salesDetails->id }}">
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <button class="btn btn-success" type="submit" onclick="this.disabled=true;this.innerHTML='Updating...';this.form.submit();">Save Details</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            {{-- <div class="col-md-2 mt-3">
                                                <button class="btn btn-danger" onclick="confirmReturn()" type="button">Return Sales</button>
                                            </div> --}}
                                            <div class="col-md-2 mt-3">
                                                <form action="{{ route('util_convert_invoice') }}" method="get">
                                                    <input type="hidden" value="{{ $salesDetails->invoice_number }}" name="invoice">
                                                    <button class="btn btn-success" type="submit" onclick="this.disabled=true;this.innerHTML='Converting...';this.form.submit();">Convert to B2C/B2B</button>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <h4>Sales Items</h4>
                                        <br>
                                        <table class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Serial Number</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Taxable</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $row = 0;
                                            @endphp
                                            @foreach($sales as $item)
                                                <tr>
                                                    <td>
                                                        @php
                                                            $product=DB::table('products')->where('id',$item->product_id)->first();
                                                        @endphp
                                                        {{ $product->product_name }}</td>
                                                    <td>
                                                    {{ $item->serial_number }}</td>
                                                    <td>₹ {{ $item->unit_price }}</td>
                                                    <td>{{ $item->product_quantity }}</td>
                                                    <td>₹ {{ $item->unit_price * $item->product_quantity }}</td>
                                                    <td>₹ {{ round(($item->unit_price * $item->product_quantity * $item->gst_percent)/100,2) }}</td>
                                                    <td>₹ {{ $item->sales_price }}</td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            @if(($salesDetails->pay_method == "CREDIT") && ($amountPaid == 0))
                                                                <i class="mdi mdi-pencil text-success font-size-16" title="Edit Item" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#purchase{{$item->id}}"></i>
                                                                <a href="#" onclick="deleteConfirmation({{ $row }})"><i class="mdi mdi-delete text-danger font-size-16" title="Delete Item"></i></a>
                                                            @else
                                                                <i class="mdi mdi-pencil text-secondary font-size-16" title="Disabled"></i>
                                                                <i class="mdi mdi-delete text-secondary font-size-16" title="Disabled"></i>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <!-- Modal -->
                                                    <div id="purchase{{ $item->id }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title add-task-title">Edit Sales</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="salesItemForm_{{ $row }}" action="{{ route('util_update_sales_item') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-3">
                                                                                <label>Product</label>
                                                                                @php
                                                                                    $productDetails = DB::table('products')->where('id',$item->product_id)->first();
                                                                                @endphp
                                                                                <input value="{{ $productDetails->product_name }}" readonly class="form-control">
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label>Serial / Description</label>
                                                                                <input name="serial_number" value="{{ $item->serial_number }}" class="form-control" style="text-transform: uppercase">
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label>Quantity</label>
                                                                                <input type="number" step="0.01" name="product_quantity" id="qty_{{ $row }}" value="{{ $item->product_quantity }}" class="form-control" onchange="calculateTaxable({{ $row }})" onkeyup="calculateTaxable({{ $row }})" readonly>
                                                                                <h6 class="text-danger">Editing Quantity is disabled due to stock restrictions</h6>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label>Unit Price</label>
                                                                                <input type="number" step="0.01" name="unit_price" id="unit_price_{{ $row }}" value="{{ $item->unit_price }}" class="form-control" onchange="calculateTaxable({{ $row }})" onkeyup="calculateTaxable({{ $row }})">
                                                                            </div>
                                                                            <div class="col-md-3 mb-3">
                                                                                <label>Taxable Value</label>
                                                                                <input type="number" step="0.01" id="taxable_{{ $row }}" class="form-control" value="{{ $item->unit_price * $item->product_quantity }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-3 mb-3">
                                                                                <label>Tax Percentage</label>
                                                                                <select name="gst_percent" id="gstPercent_{{ $row }}" class="form-control select2" style="width: 100%" data-dropdown-parent="#purchase{{ $item->id }}" onchange="calculateTax({{ $row }})">
                                                                                    <option selected disabled>Select Tax Percent</option>
                                                                                    <option value="0" {{ old('gst_percent', $item->gst_percent) == 0 ? 'selected' : '' }}>0</option>
                                                                                    <option value="3" {{ old('gst_percent', $item->gst_percent) == 3 ? 'selected' : '' }}>3</option>
                                                                                    <option value="5" {{ old('gst_percent', $item->gst_percent) == 5 ? 'selected' : '' }}>5</option>
                                                                                    <option value="12" {{ old('gst_percent', $item->gst_percent) == 12 ? 'selected' : '' }}>12</option>
                                                                                    <option value="18" {{ old('gst_percent', $item->gst_percent) == 18 ? 'selected' : '' }}>18</option>
                                                                                    <option value="28" {{ old('gst_percent', $item->gst_percent) == 28 ? 'selected' : '' }}>28</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3 mb-3">
                                                                                <label>Tax</label>
                                                                                <input type="number" step="0.01" id="tax_value_{{ $row }}" class="form-control" value="{{ round(($item->unit_price * $item->product_quantity * $item->gst_percent)/100,2) }}" readonly>
                                                                            </div>
                                                                            <div class="col-md-3 mb-3">
                                                                                <label>Total</label>
                                                                                <input type="number" step="0.01" id="total_{{ $row }}" name="sales_price" class="form-control" value="{{ round($item->sales_price,2) }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            function submitForm(row)
                                                                            {
                                                                                document.getElementById("btnUpdate_" + row).disabled = true;
                                                                                document.getElementById("btnUpdate_" + row).innerHTML = "Updating...";
                                                                                document.getElementById("salesItemForm_" + row).submit();
                                                                            }

                                                                            function deleteConfirmation(row)
                                                                            {
                                                                                if(confirm("Are you sure to delete?"))
                                                                                {
                                                                                    $("#deleteForm_" + row).submit();
                                                                                }
                                                                            }
                                                                        </script>
                                                                        <input type="hidden" value="{{ $item->sales_id }}" name="sales_id">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 mt-3">
                                                                                <button type="submit" class="btn btn-primary" id="btnUpdate_{{ $row }}" onclick="submitForm({{ $row }})">Update Changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <form id="deleteForm_{{ $row }}" action="{{ route('util_delete_sales_item') }}" method="get">
                                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </tr>
                                                @php
                                                    $row++;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <button class="btn btn-success" type="button" href="#" id="taskedit" data-id="#uptask-1" data-bs-toggle="modal" data-bs-target="#newItemModal">New Item</button>
                                        @if($salesDetails->payment_status == 'not_paid')
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#returnModal">Cancel</button>
                                        @endif
                                    </div>
                                </div>
                                <!-- Suspend Modal -->
                                <div id="returnModal" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="Post" action="{{ route('util_unpaid_sales_return',$salesDetails->id ) }}">
                                                @csrf
                                                    <div class="form-group mb-3">
                                                        <div class="col-lg-12 text-center">
                                                            <i class="dripicons-warning text-danger" style="font-size: 50px;"></i>
                                                            <h4>Are You Sure ??</h4>
                                                            <p style="font-weight: 300px;font-size:18px;">this sale will be cancelled!</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-end">
                                                            <button type="submit" class="btn btn-info" id="addtask" onclick="this.disabled=true;this.innerHTML='cancelling...';this.form.submit();">Yes, Cancel</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Modal -->
                                <div id="newItemModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title add-task-title">Add Sales Item</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="newItemForm" action="{{ route('util_new_sales_item') }}" method="POST">
                                                    @csrf
                                                    @php
                                                        $row = $row + 50;
                                                    @endphp
                                                    @if(sizeof($sales)>0)
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label>Product</label>
                                                            @php
                                                                $inStockProducts = DB::table('stocks')->where('product_qty','>',0)->get();
                                                                $products = array();
                                                                foreach($inStockProducts as $stockProducts)
                                                                {
                                                                    $product = DB::table('products')->where('id',$stockProducts->product_id)->first();
                                                                    array_push($products,$product);
                                                                }
                                                            @endphp
                                                            <select name="product_id" class="form-control select2" data-dropdown-parent="#newItemModal" style="width: 100%" onchange="addCustomProduct(this.value,{{ $row }})">
                                                                <option selected disabled>Select Product</option>
                                                                @foreach ($products as $prod)
                                                                    <option value="{{ $prod->id }}">{{ $prod->product_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Serial / Description</label>
                                                            <input name="serial_number" value="{{ $item->serial_number }}" class="form-control" style="text-transform: uppercase">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Quantity</label>
                                                            <input type="number" step="0.01" name="product_quantity" id="qty_{{ $row }}" value="" class="form-control" onchange="calculateTaxable({{ $row }})" onkeyup="calculateTaxable({{ $row }})">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Unit Price</label>
                                                            <input type="number" step="0.01" name="unit_price" id="unit_price_{{ $row }}" value="" class="form-control" onchange="calculateTaxable({{ $row }})" onkeyup="calculateTaxable({{ $row }})">
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Taxable Value</label>
                                                            <input type="number" step="0.01" id="taxable_{{ $row }}" class="form-control" value="" readonly>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Tax Percentage</label>
                                                            <select name="gst_percent" id="gstPercent_{{ $row }}" class="form-control select2" style="width: 100%" data-dropdown-parent="#newItemModal" onchange="calculateTax({{ $row }})">
                                                                <option selected disabled>Select Tax Percent</option>
                                                                <option value="0">0</option>
                                                                <option value="3">3</option>
                                                                <option value="5">5</option>
                                                                <option value="12">12</option>
                                                                <option value="18">18</option>
                                                                <option value="28">28</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Tax</label>
                                                            <input type="number" step="0.01" id="tax_value_{{ $row }}" class="form-control" value="" readonly>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Total</label>
                                                            <input type="number" step="0.01" id="total_{{ $row }}" name="sales_price" class="form-control" value="" readonly>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function submitNewItemForm()
                                                        {
                                                            document.getElementById("newItemAddButton").disabled = true;
                                                            document.getElementById("newItemAddButton").innerHTML = "Updating...";
                                                            document.getElementById("newItemForm").submit();
                                                        }
                                                    </script>
                                                    @if(sizeof($sales)>0)
                                                    <input type="hidden" value="{{ $item->sales_id }}" name="sales_id">
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-lg-12 mt-3">
                                                            <button type="submit" class="btn btn-primary" id="newItemAddButton" onclick="submitNewItemForm()">Update Changes</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
