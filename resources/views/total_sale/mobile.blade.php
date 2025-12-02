<!doctype html>
<html lang="en">
    @include('layouts.head')

    <body data-topbar="dark">
        <div id="layout-wrapper">
            <div>

                <div style="margin-top: 20px;">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="row align-items-center mb-4">
                                                    <div class="col">
                                                        <h4 class="card-title mb-0" style="color: #0d3157;">Total Sales</h4>
                                                    </div>
                                                    <div class="col text-end">
                                                        <a href="{{ route('total_sales.logout') }}" class="btn btn-danger text-end">
                                                            <i class="fas fa-sign-out-alt"></i> Logout
                                                        </a>
                                                    </div>
                                                </div>

                                                <div id="task-2">
                                                    <div id="inprogress-task" class="pb-1 task-list">
                                                        <div class="card task-box border-0 shadow-sm" id="intask-1">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-hover table-striped table-bordered dt-responsive nowrap w-100" id="workPlanTable" style="background-color: #f8f9fa; font-family: Arial, sans-serif;">
                                                                                <thead style="background-color: #0d3157; color: white; text-transform: uppercase;">
                                                                                    <tr>
                                                                                        <th>Total Sales</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <b>Previous Month</b> ({{ $previousMonth->format('M Y') }}) <br> {{ number_format($previousMonthSalesTotal, 2) }} / {{ number_format($previousMonthSalesTotalProfit, 2) }} (
                                                                                            @if( number_format($previousMonthSalesTotalProfit - 150000, 2) > 0)
                                                                                                <b class="text-success">{{ number_format($previousMonthSalesTotalProfit - 150000, 2) }}</b>
                                                                                            @else
                                                                                                <b class="text-danger">{{ number_format($previousMonthSalesTotalProfit - 150000, 2) }}</b>
                                                                                            @endif
                                                                                            )
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <b>Current Month</b>({{ $currentMonth->format('M Y') }}) <br> {{ number_format($currentMonthSalesTotal, 2) }} / {{ number_format($currentMonthSalesTotalProfit, 2) }} (
                                                                                            @if( number_format($currentMonthSalesTotalProfit - 150000, 2) > 0)
                                                                                                <b class="text-success">{{ number_format($currentMonthSalesTotalProfit - 150000, 2) }}</b>
                                                                                            @else
                                                                                                <b class="text-danger">{{ number_format($currentMonthSalesTotalProfit - 150000, 2) }}</b>
                                                                                            @endif
                                                                                            )
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <b>Current Week</b> ({{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}) <br> {{ number_format($weekSalesTotal, 2) }} / {{ number_format($weekSalesTotalProfit, 2) }} (
                                                                                            @if( number_format($weekSalesTotalProfit - 35000, 2) > 0)
                                                                                                <b class="text-success">{{ number_format($weekSalesTotalProfit - 35000, 2) }}</b>
                                                                                            @else
                                                                                                <b class="text-danger">{{ number_format($weekSalesTotalProfit - 35000, 2) }}</b>
                                                                                            @endif
                                                                                            )
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <b>Today</b>({{ $today->format('d M Y') }}) <br> {{ number_format($todaySalesTotal, 2) }} / {{ number_format($todaySalesTotalProfit, 2) }} (
                                                                                            @if( number_format($todaySalesTotalProfit - 5000, 2) > 0)
                                                                                                <b class="text-success">{{ number_format($todaySalesTotalProfit - 5000, 2) }}</b>
                                                                                            @else
                                                                                                <b class="text-danger">{{ number_format($todaySalesTotalProfit - 5000, 2) }}</b>
                                                                                            @endif
                                                                                            )
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- card task-box -->
                                                    </div> <!-- inprogress-task -->
                                                </div> <!-- task-2 -->
                                            </div> <!-- card-body -->
                                        </div> <!-- card -->
                                    </div> <!-- col-xl-12 -->
                                </div> <!-- row -->
                            </div> <!-- col-xl-12 -->
                        </div> <!-- row -->
                    </div> <!-- container-fluid -->
                </div> <!-- margin top -->
            </div>
        </div> <!-- layout-wrapper -->

        @include('layouts.script')

    </body>
</html>
