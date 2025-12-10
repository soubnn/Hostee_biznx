<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    @php
        $profile = Auth::user();
    @endphp
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ url('/dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                @if($profile->role != 'intern')
                    @if ($profile->role == 'super-admin')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user-check"></i>
                                <span key="t-invoices">Staffs</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('staff.create') }}" key="t-invoice-list">Staff Registration</a></li>
                                <li><a href="{{ route('staff.index') }}" key="t-invoice-list">View Staffs</a></li>
                                {{-- <li><a href="{{ route('user.index') }}" key="t-invoice-list">View User</a></li> --}}
                                <li><a href="{{ route('staff.payments') }}" key="t-invoice-detail">Staff Payments</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="menu-title" key="t-apps">Apps</li>

                    @if ($profile->role != 'intern')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-star"></i>
                                <span key="t-view-requests">Upcoming Events</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('upcoming_events.create') }}" key="t-task-requests">Add Event</a></li>
                                <li><a href="{{ route('upcoming_events.index') }}" key="t-task-requests">View Events</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-shopping-bag"></i>
                                <span key="t-ecommerce">Products</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if ($profile->role != 'intern')
                                    <li><a href="{{ route('product.create') }}" key="t-products">Product Registration</a>
                                    </li>
                                    {{-- <li><a href="{{ route('product_category.index') }}" key="t-products">Product
                                            Category</a></li> --}}
                                @endif
                                {{-- <li><a href="{{ route('products.view') }}" key="t-product-detail">View Products</a></li> --}}
                                {{-- @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                                    <li><a href="{{ route('products.summary') }}" key="t-product-detail">Product
                                            Summary</a></li>
                                @endif --}}

                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-receipt"></i>
                                <span key="t-invoices">Projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('project.create') }}" key="add-project">Add Project</a></li>
                                <li><a href="{{ route('project.index') }}" key="view-projects">view Projects</a></li>
                                <li><a href="{{ route('project.delivered') }}" key="delivered-projects">Delivered Projects</a></li>
                                <li><a href="{{ route('project.rejected') }}" key="returned-projects">Rejected Projects</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-store"></i>
                                <span key="t-ecommerce">Purchase</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ url('/purchase/create') }}" key="t-products">Add Purchase</a></li>
                                <li><a href="{{ route('purchase.index') }}" key="t-product-detail">View Purchase</a>
                                </li>
                                {{-- <li><a href="{{ route('purchase.return.index') }}" key="t-product-detail">Returned
                                        Purchase</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-cart"></i>
                                <span key="t-ecommerce">Sales</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('directSales.create') }}" key="t-products">Add Sales</a></li>
                                <li><a href="{{ route('directSales.index') }}" key="t-product-detail">View Sales</a></li>
                                {{-- <li><a href="{{ route('direct_sales.view_all') }}" key="t-product-detail">All
                                        Sales</a></li>
                                <li><a href="{{ route('searchBySerial') }}" key="t-product-detail">Search By
                                        Serial</a></li>
                                <li><a href="{{ route('direct_sales.return.index') }}"
                                        key="t-product-detail">Returned Sales</a></li> --}}
                            </ul>
                        </li>
                    @endif

                    @if ($profile->role != 'intern')

                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-bank"></i>
                                <span key="t-tasks">Banks</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('banks.create') }}" key="t-add-product">Add Banks</a></li>
                                <li><a href="{{ route('banks.index') }}" key="t-task-list">View Banks</a></li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-add-to-queue"></i>
                                <span key="t-tasks">Day Book</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('daybook.createIncome') }}" key="t-add-product">Add Income</a>
                                </li>
                                <li><a href="{{ route('daybook.create') }}" key="t-add-product">Add Expense</a></li>
                                <li><a href="{{ route('daybook.index') }}" key="t-task-list">View Daybook</a></li>
                                {{-- <li><a href="{{ route('daybook.all_index') }}" key="t-task-list">All Daybook</a></li>
                                @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                                    <li><a href="{{ route('daybook.view_personal') }}" key="t-task-list">View
                                            Personal Report</a></li>
                                @endif
                                <li><a href="{{ url('date_report') }}?report_date={{ \App\Models\DaybookBalance::report_date() }}"
                                        key="t-task-list">Daily Report</a></li> --}}
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-news"></i>
                            <span key="t-tasks">Estimate</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('estimate.create') }}" key="Add Estimate">Add Estimate</a></li>
                            <li><a href="{{ route('estimate.index') }}" key="View Estimate">View Estimate</a></li>
                            {{-- @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                                <li><a href="{{ route('estimate.request') }}" key="View Requset">View Request</a>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-file"></i>
                                <span key="t-tasks">Proforma Invoice</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('proforma.create') }}" key="Add Estimate">Add Invoice</a></li>
                                <li><a href="{{ route('proforma.index') }}" key="View Estimate">View Invoice</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ($profile->role != 'intern')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-smile"></i>
                                <span key="t-tasks">CRM</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('customers.index') }}" key="t-task-list">View Customers</a>
                                </li>
                                <li><a href="{{ route('customers.credit_list') }}" key="t-task-list">View Credit
                                        List</a></li>
                            </ul>
                        </li>
                    @endif

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-news"></i>
                            <span key="t-view-requests">News & Events</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('news_events.create') }}" key="t-task-requests">Add Event</a></li>
                            <li><a href="{{ route('news_events.index') }}" key="t-task-requests">View Events</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-tasks">Supplier</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('seller.create') }}" key="t-add-product">Add Supplier</a></li>
                            <li><a href="{{ route('seller.index') }}" key="t-task-list">View Supplier</a></li>
                        </ul>
                    </li>
                    {{-- @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-file"></i>
                                <span key="t-tasks">Reports</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('monthlyReport') }}" key="t-task-list">Monthly Report</a></li>
                                <li><a href="{{ route('reports.profit_summary') }}" key="t-task-list">Profit
                                        Summary</a></li>
                                <li><a href="{{ route('reports.monhtly_summary') }}" key="t-task-list">Monthly
                                        Summary</a></li>
                            </ul>
                        </li>
                    @endif --}}
                @endif
                <li class="menu-title" key="t-apps">Profile</li>
                @if ($profile->role == 'admin' || $profile->role == 'super-admin')
                    <li>
                        <a href="{{ route('utility_login') }}" class="waves-effect">
                            <i class="bx bxs-lock"></i>
                            <span key="t-profile">Utilities</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact.index') }}" class="waves-effect">
                            <i class="bx bxs-contact"></i>
                            <span key="t-profile">Enquiries</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-profile">View Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="waves-effect">
                        <i class="bx bx-log-out"></i>
                        <span key="t-logout">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
