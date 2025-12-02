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
    $(document).ready(function(){
        $("#datatable").dataTable({
            "pageLength" : 100
        });
    });
    function enable_btn(){
        document.getElementById('submit_btn').disabled = false;
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('daybook.search_personal') }}" id="searchForm">
                                            @csrf
                                            <h4 class="card-title mb-4">Search Daybook</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Select Staff</label>
                                                    <select name="search_value" id="search_value" class="form-control select2" style="width: 100%" onchange="enable_btn()" required>
                                                        <option selected disabled>select</option>
                                                        <option value="ramis">Ramis</option>
                                                        <option value="hashim">Hashim</option>
                                                        <option value="haseeb">Haseeb</option>
                                                        <option value="akhilesh">Akhilesh</option>
                                                        <option value="fawaz">Fawaz</option>
                                                        <option value="fahanas">Fahanas</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label></label>
                                                    <button class="btn btn-success mt-4" id="submit_btn" type="submit" disabled>Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($daybooks)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Daybook</h4>
                                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                                <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th style="white-space: normal;">Debit</th>
                                                    <th style="white-space: normal;">Credit</th>
                                                    <th style="white-space: normal;">Description</th>
                                                    <th>Accounts</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($daybooks as $daybook)

                                                <tr>
                                                    @if($daybook->type == "Expense")
                                                        <td class="text-danger" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td class="text-danger">{{ $daybook->amount }}</td>
                                                        <td></td>
                                                        <td class="text-danger">{{ $daybook->description }}</td>
                                                        <td class="text-danger">{{ $daybook->accounts }}</td>
                                                    @endif
                                                    @if($daybook->type == "Income")
                                                        <td class="text-success" data-sort="">{{ Carbon\carbon::parse($daybook->date)->format('d-m-Y') }}</td>
                                                        <td></td>
                                                        <td class="text-success">{{ $daybook->amount }}</td>
                                                        <td class="text-success">{{ $daybook->description }}</td>
                                                        <td class="text-success">{{ $daybook->accounts }}</td>

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

