<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <!--<img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="50" style="margin-left: -40px;">-->
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/biznx_white.png') }}" alt="logo" height="75" style="margin-left: -25px;">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-dots-grid" style="font-size:24px;"></i>
                </button>
                <div class="dropdown-menu dropdown-megamenu">
                    <div class="row">
                        @if(Auth::user()->role == 'intern')
                        <div class="col-md-3">
                            <a href="{{ route('consignment.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-cards text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Jobcard</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('field.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-map text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Field Work</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('profile') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bxs-user-detail text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Profile</h5>
                                </div>
                            </a>
                        </div>
                        @else
                        <div class="col-md-3">
                            <a href="{{ route('consignment.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-cards text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Jobcard</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('purchase.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-store text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Purchase</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('directSales.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-cart text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Sales</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('daybook.createIncome') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-cash-plus text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Income</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('daybook.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="mdi mdi-cash-minus text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Expense</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-smile text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">CRM</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('products.view') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-shopping-bag text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Product</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('estimate.create') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-news text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Estimate</h5>
                                </div>
                            </a>
                        </div>
                        @if(Auth::user()->role == 'admin')
                            <div class="col-md-3">
                                <a href="{{ route('marketing.view_all_summary') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bx-chat text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Marketing</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('staff.index') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bx-user-check text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Staffs</h5>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <a href="{{ route('stock.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-detail text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Stock</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('field.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-map text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Field Work</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.credit_list') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-receipt text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Credit</h5>
                                </div>
                            </a>
                        </div>
                        @if(Auth::user()->role == 'admin')
                            <div class="col-md-3">
                                <a href="{{ route('staff.request') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bx-street-view text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Job Request</h5>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <a href="{{ route('seller.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-building-house text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Suppliers</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('vehicle.index') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bx-car text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Vehicles</h5>
                                </div>
                            </a>
                        </div>
                        @if(Auth::user()->role == 'admin')
                            <div class="col-md-3">
                                <a href="{{ route('utility_login') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bx-lock text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Utilities</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('contact.index') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bxs-contact text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Enquiries</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('monthlyReport') }}">
                                    <div class="social-source text-center mt-3">
                                        <div class="avatar-xs mx-auto mb-3">
                                            <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                                <i class="bx bxs-file text-white"></i>
                                            </span>
                                        </div>
                                        <h5 style="font-size: 13px;">Monthly Report</h5>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <a href="{{ route('profile') }}">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle font-size-16" style="background-color: rgb(81, 98, 134)">
                                            <i class="bx bxs-user-detail text-white"></i>
                                        </span>
                                    </div>
                                    <h5 style="font-size: 13px;">Profile</h5>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @php
                    $profile=Auth::user();
                @endphp
                    <img class="rounded-circle header-profile-user" src="{{ asset('storage/images/'.$profile->image) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>



        </div>
    </div>

</header>
