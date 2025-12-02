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
                                    <h4 class="mb-sm-0 font-size-18">View All Daybook</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('generateDaybook') }}">
                                            @csrf
                                            <h4 class="card-title mb-4">Search Daybook</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Start Date</label>
                                                    <input type="date" name="startDate" class="form-control" max="{{ Carbon\carbon::now()->format('Y-m-d')}}" value="{{ old('startDate') }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>End Date</label>
                                                    <input type="date" name="endDate" class="form-control" max="{{ Carbon\carbon::now()->format('Y-m-d')}}" value="{{ old('endDate') }}">
                                                    @error('endDate')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        @if($daybook)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Daybook {{ Carbon\Carbon::parse($startDate)->format('d-m-Y') }} To {{ Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</h4>
                                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                                <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th style="white-space: normal;">Expense</th>
                                                    <th style="white-space: normal;">Income</th>
                                                    <th style="white-space: normal;">Description</th>
                                                    <th>Amount</th>
                                                    <th>Accounts</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($daybook as $daybook)

                                                <tr>
                                                    @if($daybook->type == "Expense")
                                                        <td class="text-danger" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        @if ($daybook->expense_id == 'staff_salary')
                                                            @php
                                                                $staffDetails = DB::table('staffs')->where('id',$daybook->staff)->first();
                                                                $salaryPayments = DB::table('salary_payments')->where('daybook_id',$daybook->id)->first();
                                                                if ($salaryPayments) {
                                                                    $term_array = explode('-',$salaryPayments->term);
                                                                    if($term_array[0] < 10){
                                                                        $term_month_no = '0'.$term_array[0];
                                                                    }
                                                                    else{
                                                                        $term_month_no = $term_array[0];
                                                                    }
                                                                    if (strlen($term_month_no) == 3) {
                                                                      $term_month_no = substr($term_month_no, 1);
                                                                    }
                                                                    $year = Carbon\carbon::now()->format('Y');
                                                                    $years = 20 . $term_array[2];
                                                                    $term_month = Carbon\carbon::parse('01-'.$term_month_no.'-'.$year)->format('F');
                                                                    $salaryPayment = $years . '-' . $term_month . '-' . $term_array[1];
                                                                }else {
                                                                    $salaryPayment = '';
                                                                }
                                                                $edit_status = 'no';
                                                            @endphp
                                                            <td class="text-danger" style="white-space: normal;">Staff Salary <br>[ Staff: {{$staffDetails->staff_name}} ]{{ $salaryPayment }}</td>
                                                        @elseif($daybook->expense_id == 'staff_incentive')
                                                            @php
                                                                $staffDetails = DB::table('staffs')->where('id',$daybook->staff)->first();
                                                                $edit_status = 'no';
                                                            @endphp
                                                            <td class="text-danger" style="white-space: normal;">Incentive <br>[ Staff: {{$staffDetails->staff_name}} ]</td>
                                                        @elseif($daybook->expense_id == "SALE_RETURN")
                                                            @php
                                                                $edit_status = 'no';
                                                            @endphp
                                                            <td class="text-danger" style="white-space: normal;">FOR INVOICE #{{ $daybook->job }}</td>
                                                        @elseif($daybook->expense_id == "FOR_SUPPLIER")
                                                            @php
                                                                $supplierDetails = DB::table('sellers')->where('id',$daybook->job)->first();
                                                                $edit_status = 'no';
                                                            @endphp
                                                            <td class="text-danger" style="white-space: normal;">FOR SUPPLIER - <br>{{ $supplierDetails->seller_name }}</td>
                                                        @elseif($daybook->expense_id == "INVESTOR_WITHDRAWAL")
                                                            @php
                                                                $investorDetails = DB::table('investors')->where('id',$daybook->staff)->first();
                                                            @endphp
                                                            <td style="white-space: normal;" class="text-danger">INVESTOR_WITHDRAWAL <br>{{ $investorDetails->name }}</td>
                                                        @elseif($daybook->expense_id == "INVEST_BANK")
                                                            <td style="white-space: normal;" class="text-danger">
                                                                WITHDRAW IN BANK <br> {{ $daybook->bank_detail->bank_name}}
                                                                @if ($daybook->bank_detail->book_no)
                                                                    [No. {{$daybook->bank_detail->book_no}}]
                                                                @endif
                                                            </td>
                                                        @else
                                                            @php
                                                                $get_expense = DB::table('expenses')->where('id',$daybook->expense_id)->first();
                                                                $edit_status = 'yes';
                                                            @endphp
                                                            <td class="text-danger" style="white-space: normal;">{{ $get_expense->expense_name }}</td>
                                                        @endif
                                                        <td></td>
                                                        <td class="text-danger" style="white-space: normal;">{{ $daybook->description }}</td>
                                                        <td class="text-danger">{{ $daybook->amount }}</td>
                                                        <td class="text-danger">{{ $daybook->accounts }}</td>
                                                    @endif
                                                    @if($daybook->type == "Income")
                                                        <td class="text-success" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td></td>
                                                        @if($daybook->income_id == "FROM_INVOICE")
                                                            <td class="text-success" style="white-space: normal;">FROM INVOICE <br>#{{ $daybook->job }}</td>
                                                            @php
                                                                $daybook->description = $daybook->sales_detail->customer_detail->name;
                                                                $edit_status = 'no';
                                                            @endphp
                                                        @elseif($daybook->income_id == "PURCHASE_RETURN")
                                                            @php
                                                                $edit_status = 'no';
                                                            @endphp
                                                            <td class="text-success" style="white-space: normal;">FOR SUPPLIER <br>#{{ $daybook->job }}</td>
                                                        @elseif($daybook->income_id == "add_income")
                                                            @php
                                                                $edit_status = 'yes';
                                                            @endphp
                                                            <td class="text-success" style="white-space: normal;">Income</td>
                                                        @elseif($daybook->income_id == "INVESTOR_INVESTMENT")
                                                            @php
                                                                $investorDetails = DB::table('investors')->where('id',$daybook->staff)->first();
                                                            @endphp
                                                            <td style="white-space: normal;" class="text-success">INVESTOR_INVESTMENT<br>{{ $investorDetails->name }}</td>
                                                            <td style="white-space: normal;" class="text-success">{{ $daybook->description }}</td>
                                                        @elseif($daybook->income_id == "WITHDRAW_BANK")
                                                            <td style="white-space: normal;" class="text-success">
                                                                WITHDRAW IN BANK <br> {{ $daybook->bank_detail->bank_name}}
                                                                @if ($daybook->bank_detail->book_no)
                                                                    [No. {{$daybook->bank_detail->book_no}}]
                                                                @endif
                                                            </td>
                                                            <td style="white-space: normal;" class="text-success">{{ $daybook->description }}</td>
                                                        @else
                                                            @php
                                                                $get_income = DB::table('incomes')->where('id',$daybook->income_id)->first();
                                                                $edit_status = 'yes';
                                                            @endphp
                                                            <td class="text-success" style="white-space: normal;">{{ $get_income->income_name }}</td>
                                                        @endif
                                                        <td class="text-success" style="white-space: normal;">{{ $daybook->description }}</td>
                                                        <td class="text-success">{{ $daybook->amount }}</td>
                                                        <td class="text-success">{{ $daybook->accounts }}</td>
                                                    @endif
                                                    @if($daybook->type == "Transfer")
                                                        @php
                                                            $edit_status = 'no';
                                                        @endphp
                                                        <td data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td></td>
                                                        <td>CASH TRANSFER</td>
                                                        <td>{{ $daybook->description }}</td>
                                                        <td>{{ $daybook->amount }}</td>
                                                        <td>{{ $daybook->accounts }}</td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        @endif
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


@endsection

