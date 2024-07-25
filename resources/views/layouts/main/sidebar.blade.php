
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- Navbar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item active sidebar_li">
                <i class="fe fe-home fe-16"></i>
                <a href="{{ route('/') }}" class="sidebar_text">
                    <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item sidebar_li">
                <i class="fe fe-user fe-16"></i>
                <a href="{{ route('allsupplier') }}" class="sidebar_text">
                    <span class="ml-3 item-text">Suppliers</span><span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item sidebar_li">
                <i class="fe fe-box fe-16"></i>
                <a href="{{ route('allitems') }}" class="sidebar_text">
                    <span class="ml-3 item-text">Items</span><span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item sidebar_li">
                <i class="fe fe-box fe-16"></i>
                <a href="{{ route('masterstock') }}" class="sidebar_text">
                    <span class="ml-3 item-text">Master Stock</span><span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item sidebar_li">
                <i class="fe fe-user fe-16"></i>
                <a href="{{ route('allcustomer') }}" class="sidebar_text">
                    <span class="ml-3 item-text">Customers</span><span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item sidebar_li">
                <i class="fe fe-user fe-16"></i>
                <a href="{{route('employee')}}" class="sidebar_text">
                    <span class="ml-3 item-text">Employee</span><span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-shopping-cart fe-16 mb-2"></i>
                    <span class="ml-3 item-text">Purchase Management</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="dashboard">
                    <li class="nav-item mb-2">
                        <a href="{{ route('allorderrequests') }}" class="sidebar_text">
                            <span class="ml-3 item-text">Request Order</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="{{ route('allgins') }}" class="sidebar_text">
                            <span class="ml-3 item-text">GIN</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#HR" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-users fe-16 mb-2"></i>
                    <span class="ml-3 item-text">Human Resource</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-1 w-100" id="HR">
                    <li class="nav-item dropdown">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <span class="ml-3 item-text">Attendance</span><span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="attendance">
                        <li class="nav-item mb-2">
                            <a href="{{route('attendance_list')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Attendance List</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a href="{{route('attendance_reports')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Attendance Reports</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-1 w-100" id="HR">
                    <li class="nav-item dropdown">
                        <a href="#Leave" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <span class="ml-3 item-text">Leave</span><span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="Leave">
                        <li class="nav-item mb-2">
                            <a href="{{route('weekly_holiday')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Weekly Holiday</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active mb-2">
                            <a href="{{route('holiday')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Holiday</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active mb-2">
                            <a href="{{route('add_leave_type')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Add Leave Type</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active mb-2">
                            <a href="{{route('leave_application')}}" class="sidebar_text">
                                <span class="ml-3 item-text">Leave Application</span><span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                    </li>
                </ul>
            </li>


            <li class="nav-item dropdown">
                <a href="#setting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-settings fe-16 mb-2"></i>
                    <span class="ml-3 item-text">Settings</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="setting">
                    <li class="nav-item mb-2">
                        <a href="{{ route('company.index') }}" class="sidebar_text">
                            <span class="ml-3 item-text">Manage Company</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active mb-2">
                        <a href="{{ route('user.index') }}" class="sidebar_text">
                            <span class="ml-3 item-text">Add User</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active mb-2">
                        <a href="{{ route('user.show') }}" class="sidebar_text">
                            <span class="ml-3 item-text">User List</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active mb-2">
                        <a href="{{route('add_roles')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Add Role</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active mb-2">
                        <a href="{{route('role_list')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Role List</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item active mb-2">
                        <a href="{{route('assign_user_role')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Assign User Roles</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
