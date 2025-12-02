@extends('layouts.layout')
@section('content')
<script>
    $(function() {
            $("input[type='text']").keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
    });
</script>
<script>
    // $(document).ready(function(){
    //     $("#datatable").dataTable({
    //         "pageLength" : 100
    //     });
    // });

    function getTypes(type)
    {
        if(type == 'Expense'){
            $("#sort_type_div").css('display','block');
            $("#item_total_div").css('display','block');
            $("#sort_start_div").css('display','none');
            $("#sort_end_div").css('display','none');
            $("#item_total_2_div").css('display','none');
            $("#expense_name_div").css('display','none');
            $("#date_div").css('display','none');
        }
        else{
            $("#sort_type_div").css('display','none');
            $("#item_total_div").css('display','none');
            $("#sort_start_div").css('display','none');
            $("#sort_end_div").css('display','none');
            $("#item_total_2_div").css('display','none');
            $("#expense_name_div").css('display','none');
            $("#date_div").css('display','none');
        }
        $.ajax({
            type : "get",
            url : "{{ route('getDaybookValues') }}",
            data : { type : type},
            success: function(res)
            {
                var selectElement = document.getElementById("search_value");
                var options = "<option selected disabled>Select</option>";
                for(var i=0;i<res.length;i++)
                {
                    options += "<option value='" + res[i].id +"'>" + res[i].name + "</option>";
                }
                selectElement.innerHTML = options;
            }
        });
    }
</script>
<script>
    function show_divs(sort)
    {
        if(sort == 'all'){
            $("#item_total_div").css('display','block');
            $("#item_total_2_div").css('display','none');
            $("#expense_name_div").css('display','none');
            $("#date_div").css('display','none');
            $("#sort_start_div").css('display','none');
            $("#sort_end_div").css('display','none');
        }
        else if(sort == 'datewise'){
            $("#item_total_div").css('display','block');
            $("#item_total_2_div").css('display','none');
            $("#expense_name_div").css('display','none');
            $("#date_div").css('display','none');
            $("#sort_start_div").css('display','block');
            $("#sort_end_div").css('display','block');
        }
    }
    function get_total(value){
        let sort_type = document.getElementById("sort_type").value;
        console.log(sort_type);
        if(sort_type == 'all'){
            $.ajax({
                type : "get",
                url : "{{ route('daybook.get_item_total') }}",
                data : { expense : value, sort_type : sort_type },
                success: function(res)
                {
                    console.log(res);
                    let item_total = document.getElementById("item_total");
                    item_total.value = res;
                }
            });
        }
        else if(sort_type == 'datewise'){
            let sort_start = document.getElementById("sort_start").value;
            let sort_end = document.getElementById("sort_end").value;
            console.log(sort_start+' and '+sort_end);
            $.ajax({
                type : "get",
                url : "{{ route('daybook.get_item_total') }}",
                data : { expense : value, sort_type : sort_type,start_date : sort_start,end_date : sort_end },
                success: function(res)
                {
                    console.log(res);
                    let item_total = document.getElementById("item_total");
                    item_total.value = res;
                }
            });
        }


    }
</script>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">View Daybook</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="get" action="{{ route('date_report') }}">
                                            <h4 class="card-title mb-4">Daily Report</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Select Date</label>
                                                    <input type="date" name="report_date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <button type="submit" class="btn btn-primary">View Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('generateDaybookReport') }}" target="_blank">
                                            @csrf
                                            <h4 class="card-title mb-4">Generate Report</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Start Date</label>
                                                    <input type="date" name="startDate" class="form-control" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>End Date</label>
                                                    <input type="date" name="endDate" class="form-control">
                                                    @error('endDate')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <button type="submit" class="btn btn-primary">Generate Report</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('daybookSearch') }}" id="searchForm">
                                            @csrf
                                            <h4 class="card-title mb-4">Search Daybook</h4>
                                            <div class="row">
                                                <div class="col-md-3 mt-3">
                                                    <label>Type</label>
                                                    <select name="search_type" class="form-control select2" style="width: 100%" required onchange="getTypes(this.value)">
                                                        <option selected disabled>Select Type</option>
                                                        <option value="Income">Income</option>
                                                        <option value="Expense">Expense</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-3" id="sort_type_div" style="display: none">
                                                    <label>Sort</label>
                                                    <select name="sort_type" class="form-control select2" style="width: 100%" id="sort_type" onchange="show_divs(this.value)">
                                                        <option value="all" selected>All</option>
                                                        <option value="datewise">Date-Wise</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3  mt-3" id="sort_start_div" style="display:none;">
                                                    <label>Start Date</label>
                                                    <input type="date" name="sort_start" id="sort_start" class="form-control">
                                                </div>
                                                <div class="col-md-3  mt-3" id="sort_end_div" style="display:none;">
                                                    <label>End Date</label>
                                                    <input type="date" name="sort_end" id="sort_end" class="form-control">
                                                    @error('sort_end')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mt-3" id="search_value_div">
                                                    <label>Value</label>
                                                    <select name="search_value" id="search_value" class="form-control select2" style="width: 100%" onchange="get_total(this.value)" required>
                                                        <option selected disabled>select</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-3" id="item_total_div" style="display:none;">
                                                    <label>Item Wise Total</label>
                                                    <input type="txet" class="form-control" name="item_total" id="item_total" readonly>
                                                </div>
                                                <div class="col-md-3 mt-3">
                                                    <label></label>
                                                    <button class="btn btn-success mt-4" type="submit">Search</button>
                                                </div>
                                                @if($total != Null)
                                                    <div class="col-md-4 mt-5" id="expense_name_div">
                                                        <h5>Expense Name : {{ $expense_name }}</h5>
                                                    </div>
                                                    @if($start_date != Null && $end_date != Null)
                                                        <div class="col-md-8 mt-5" id="date_div">
                                                            <h5>From : {{ Carbon\carbon::parse($start_date)->format('d-M-Y') }} &nbsp;&nbsp; To : {{ Carbon\carbon::parse($end_date)->format('d-M-Y') }}</h5>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-4 mt-3" id="item_total_2_div">
                                                        <label>Item Wise Total</label>
                                                        <input type="txet" class="form-control" value="{{ $total }}" readonly>
                                                    </div>

                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Daybook</h4>
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" style="text-transform: uppercase;">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th style="white-space: normal;">Expense</th>
                                                    <th style="white-space: normal;">Income</th>
                                                    <th style="white-space: normal;">Description</th>
                                                    <th>Amount</th>
                                                    <th>Accounts</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($daybook as $entry)
                                                    <tr>
                                                        @if($entry->type == "Expense")
                                                            <td class="text-danger" data-sort="">{{ Carbon\carbon::parse($entry->date)->format('d-m-Y') }}</td>
                                                            <td class="text-danger" style="white-space: normal;">{!! $entry->expense_name !!}</td>
                                                            <td></td>
                                                            <td class="text-danger" style="white-space: normal;">{{ $entry->description }}</td>
                                                            <td class="text-danger">{{ $entry->amount }}</td>
                                                            <td class="text-danger">{{ $entry->accounts }}</td>
                                                        @elseif($entry->type == "Income")
                                                            <td class="text-success" data-sort="">{{ Carbon\carbon::parse($entry->date)->format('d-m-Y') }}</td>
                                                            <td></td>
                                                            <td class="text-success" style="white-space: normal;">{!! $entry->expense_name !!}</td>
                                                            <td class="text-success" style="white-space: normal;">{{ $entry->description }}</td>
                                                            <td class="text-success">{{ $entry->amount }}</td>
                                                            <td class="text-success">{{ $entry->accounts }}</td>
                                                        @elseif($entry->type == "Transfer")
                                                            <td data-sort="">{{ Carbon\carbon::parse($entry->date)->format('d-m-Y') }}</td>
                                                            <td></td>
                                                            <td>CASH TRANSFER</td>
                                                            <td>{{ $entry->description }}</td>
                                                            <td>{{ $entry->amount }}</td>
                                                            <td>{{ $entry->accounts }}</td>
                                                        @endif
                                                        <td>
                                                            @if ($entry->date == $entry->today && $entry->edit_status == 'yes')
                                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit_modal_{{ $entry->id }}">
                                                                    <i class="bx bx-pencil"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @include('daybook.modal.edit-modal')
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection

