@extends('layouts.layout')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @php
                    $profile = Auth::user();
                @endphp
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Dashboard</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <img src="{{ asset('storage/images/'.$profile->image) }}" alt="" style="object-fit: cover" class="img-thumbnail rounded-circle">
                                        </div>
                                        @if($profile->role == "intern")
                                        <h5 class="font-size-15">user</h5>
                                        @else
                                        <h5 class="font-size-15">{{ $profile->role }}</h5>
                                        @endif
                                        <p class="text-muted mb-0">{{ $profile->name }}</p>
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="pt-4 text-right">

                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="font-size-15">{{ $staff_count }}</h5>
                                                    <p class="text-muted mb-0">Staffs</p>
                                                </div>
                                                {{-- <div class="col-6">
                                                    <h5 class="font-size-15">{{ $product_count }}</h5>
                                                    <p class="text-muted mb-0">Products</p>
                                                </div> --}}
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('profile') }}" class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @if($profile->role == 'marketing' || $profile->role == 'intern')
                    @else
                        {{-- <div class="card">
                            <div class="card-body">
                                @if( $profile->role == 'super-admin' )
                                    <input type="date" id="salesDate" class="form-control mb-3" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Total Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody id="previousMonth">
                                                <!-- Sales Data Will Be Loaded Here Dynamically -->
                                            </tbody>
                                            <tbody id="currentMonth">
                                                <!-- Sales Data Will Be Loaded Here Dynamically -->
                                            </tbody>
                                            <tbody id="currentWeek">
                                                <!-- Sales Data Will Be Loaded Here Dynamically -->
                                            </tbody>
                                            <tbody id="salesData">
                                                <!-- Sales Data Will Be Loaded Here Dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Pending Job Cards</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jobcards as $jobcard)
                                                    <tr>
                                                        <td>{{ $jobcard->customer_detail->name  }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{ route('consignment.index') }}" style="float:right;">view all</a>
                                    </div>
                                @endif
                            </div>
                        </div> --}}
                        {{-- <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered nowrap w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Recent Out Of Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stocks as $stock)
                                                <tr class="text-danger">
                                                    <td style="white-space: normal">{{ $stock->product_details->product_name  }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ route('stockout_product') }}" style="float:right;">view all</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-xl-8">
                    @if($profile->role!="intern")
                        <div class="row">
                            <div class="col-2">
                                <a href="{{ route('directSales.create') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle bg-pink font-size-16">
                                                <i class="mdi mdi-cart text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Sales</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('daybook.createIncome') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(63, 207, 63)">
                                                <i class="mdi mdi-cash-plus text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Income</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('daybook.create') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(255, 83, 52)">
                                                <i class="mdi mdi-cash-minus text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Expense</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('customers.index') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(228, 228, 53)">
                                                <i class="bx bx-smile text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">CRM</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                        <div class="row">
                            @if( $profile->role == 'admin' || $profile->role == 'super-admin' )
                                <div class="col-md-4">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body" style="padding-top: 14px;padding-bottom: 14px">
                                            <form method="get" action="{{ route('date_report') }}">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Daily Report</p>
                                                        <input type="date" name="report_date" class="form-control" style="width: 85%" required>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <button type="submit" class="btn btn-primary avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-calendar font-size-24"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <a @if($profile->role!="intern")href="{{ route('customers.credit_list') }}" @endif>
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium text-danger">Credit</p>
                                                    <h4 class="mb-0 text-danger">{{ $sales_balance }}</h4>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-archive-in font-size-24"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="yearSelect">Select Year:</label>
                                    <select id="yearSelect" class="form-control">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-sm-flex flex-wrap">
                                    <h4 class="card-title mb-4">Average Sales Graph</h4>
                                </div>
                                <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- @if (\Carbon\Carbon::parse(\App\Models\DaybookBalance::report_date())->format('Y-m-d') < \Carbon\Carbon::now()->format('Y-m-d'))
        @include('daybook_warning_modal')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('daybookWarningModal'));
                myModal.show();
            });
        </script>
    @endif --}}
@endsection

@push('chartData')
    <script>
        var availableYears = <?php echo json_encode($years); ?>;
        var selectedYear = <?php echo json_encode($currentYear); ?>;
        var consignmentData = <?php echo json_encode($consignmentData); ?>;
        var directSalesData = <?php echo json_encode($directSalesData); ?>;
    </script>
    <script>
        $(document).ready(function(){
            function fetchSalesData() {
                let selectedDate = $('#salesDate').val();

                $.ajax({
                    url: "{{ route('fetch.sales.data') }}",
                    method: "GET",
                    data: { date: selectedDate },
                    success: function(response){
                        $('#previousMonth').html(response.previousMonthRow);
                        $('#currentMonth').html(response.currentMonthRow);
                        $('#currentWeek').html(response.currentWeekRow);
                        $('#salesData').html(response.salesRow);
                    },
                    error: function(xhr, status, error) {
                        console.log("Error fetching sales data:", error);
                    }
                });
            }
            var today = new Date().toISOString().split('T')[0];
            $('#salesDate').val(today);
            fetchSalesData();
            $('#salesDate').change(fetchSalesData);
        });
    </script>



@endpush

