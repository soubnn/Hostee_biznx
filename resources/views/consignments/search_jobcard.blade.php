@extends('layouts.layout')
@section('content')

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('#search_select_wrapper').hide();
        $('input[name="search_type"]').change(function() {
            let searchType = $(this).val();
            $('#search_select_wrapper').show();

            if (searchType === 'jobcard_number') {
                $('#search_label').text('Select Jobcard Number:');
                $('#search_select').attr('name', 'jobcard_number');
                $('#search_select').empty();
                @foreach($jobcard_numbers as $jobcard_number)
                    $('#search_select').append('<option value="{{ $jobcard_number->id }}">{{ $jobcard_number->jobcard_number }}</option>');
                @endforeach
            } else if (searchType === 'customer_name') {
                $('#search_label').text('Select Customer:');
                $('#search_select').attr('name', 'customer_name');
                $('#search_select').empty();
                @foreach($customer_names as $customer)
                    $('#search_select').append('<option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->place }}</option>');
                @endforeach
            }
            $('#search_select').select2();
        });
    });
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 100,
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
                        <h4 class="mb-sm-0 font-size-18">View Job Cards</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Search Job Cards</h4>
                            <form action="{{ route('search.jobcards') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <div class="mb-3">
                                            <div>
                                                <label class="me-2">Search By:</label>
                                                <input type="radio" id="jobcard_number" name="search_type" value="jobcard_number"
                                                    {{ old('search_type') == 'jobcard_number' ? 'checked' : '' }}>
                                                <label for="jobcard_number" class="me-2">Jobcard Number</label>

                                                <input type="radio" id="customer_name" name="search_type" value="customer_name"
                                                    {{ old('search_type') == 'customer_name' ? 'checked' : '' }}>
                                                <label for="customer_name">Customer Name</label>
                                            </div>
                                            @error('search_type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-center">
                                        <div class="mb-3" id="search_select_wrapper" style="display: none;">
                                            <label id="search_label" for="search_select"></label>
                                            <select id="search_select" class="select2 form-control" style="width: 50%; margin: 0 auto;">
                                                <option value="">Select</option>
                                            </select>
                                            @error('jobcard_number')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            @error('customer_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>


                            @if(isset($results) && $results->isNotEmpty())
                                <div class="mt-4">
                                    <h4>Search Results:</h4>
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100" style="text-transform: uppercase;">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Job Card No</th>
                                                <th>Phone</th>
                                                <th>Product</th>
                                                <th>Status</th>
                                                <th>Picked On</th>
                                                <th>Delivered On</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $result)
                                                <tr>
                                                    <td>{{ $result->customer_detail->name }}</td>
                                                    <td>{{ $result->jobcard_number }}</td>
                                                    <td>{{ $result->phone }}</td>
                                                    <td>{{ $result->product_name }}</td>
                                                    <td>
                                                        @if ($result->status == 'delivered')
                                                            <span class="text-success">Delivered</span>
                                                        @elseif ($result->status == 'returned')
                                                            <span class="text-danger">Returned</span>
                                                        @elseif ($result->status == 'pending')
                                                            <span class="text-warning">Pending</span>
                                                        @elseif ($result->status == 'informed')
                                                            <span class="text-info">Informed</span>
                                                        @else
                                                            <span class="text-secondary">{{ $result->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ Carbon\carbon::parse($result->date)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if($result->delivered_date)
                                                            {{ Carbon\carbon::parse($result->delivered_date)->format('d-m-Y') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route( 'consignment.show',$result->id ) }}">
                                                            <button type="button" class="btn btn-light waves-effect text-info">View</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
