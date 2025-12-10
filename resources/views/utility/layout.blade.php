<!doctype html>
<html lang="en">
<head>

        <meta charset="utf-8" />
        <title>Utility Mode </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Hostee" name="author" />
        <!-- App favicon -->
        {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"> --}}

         <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- select2 css -->
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- dropzone css -->
        <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Sweet Alert-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">
        <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">


        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>

    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{ route('util_dash') }}" class="logo logo-light">
                                {{-- <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="30" style="margin-left: -25px;">
                                </span> --}}
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/biznx_white.png') }}" alt="" height="70" style="margin-left: -25px;">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li>
                                <a href="{{ route('util_dash') }}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-title" key="t-menu">Menu</li>
                            <!--<li>-->
                            <!--    <a href="{{ route('util_dash') }}" class="waves-effect">-->
                            <!--        <i class="bx bx-shopping-bag"></i>-->
                            <!--        <span key="t-dashboards">Stock Editor</span>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-cart"></i>
                                    <span key="t-dashboards">Purchase</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('util_purchase') }}" key="t-dashboard-list">Purchase Edit</a></li>
                                    <li><a href="{{ route('utility.purchase.return') }}" key="t-dashboard-list">Return Purchase</a></li>
                                    <li><a href="{{ route('utility.return.index') }}" key="t-dashboard-list">Returned Purchase</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-cart"></i>
                                    <span key="t-tasks">Sales</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('util_sales.edit') }}" key="t-task-list">Sales Edit</a></li>
                                    <li><a href="{{ route('util_sales.cancel') }}" key="t-task-list">Sales Cancel</a></li>
                                    <li><a href="{{ route('utility.sales.return') }}" key="t-task-list">Sales Return</a></li>
                                    <li><a href="{{ route('utility.sale_return.index') }}" key="t-task-list">Returned Sales</a></li>
                                </ul>
                            </li>
                            {{-- <li>
                                <a href="{{ route('util_convert_data') }}" class="waves-effect">
                                    <i class="bx bx-data"></i>
                                    <span key="t-dashboards">Data Convertion</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ route('dashboard') }}" class="waves-effect">
                                    <i class="bx bx-exit"></i>
                                    <span key="t-dashboards">Logout</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->



            @yield('content')


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Hostee the Planner.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Designed & Developed by Team Techsoul
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

         <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <!-- apexcharts -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        @stack('chartData')
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
        <script src="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.js') }}"></script>
        <!-- form advanced init -->
        <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <!-- Required datatable js -->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <!-- Datatable init js -->
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
        <!-- select 2 plugin -->
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
        <!-- Table Editable plugin -->
        <script src="{{ asset('assets/libs/table-edits/build/table-edits.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/table-editable.int.js') }}"></script>
        <!-- dropzone plugin -->
        <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
        <!-- init js -->
        <script src="{{ asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
        <!-- materialdesign icon js-->
        <script src="{{ asset('assets/js/pages/materialdesign.init.js') }}"></script>
        <!-- Bootrstrap touchspin -->
        <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/ecommerce-cart.init.js') }}"></script>
         <!-- Sweet Alerts js -->
         <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- Sweet alert init js-->
        <script src="{{ asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
        <script src="{{ asset('assets/js/pages/project-overview.init.js') }}"></script>
        <script>chart.redraw();</script>
        @stack('script')
        @stack('indian-state-script')

        <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}

    </body>
</html>
