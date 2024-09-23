
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
      <!-- nav bar -->
      <div class="w-100 mb-4 ml-3 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">
    <img src="{{ asset('images/logo.png') }}"
    style="width:auto; height: 35px;" class="mt-2" alt="Company Logo">
</a>

      </div>

      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item active sidebar_li">
            <i class="fe fe-home fe-16"></i>
          <a href="{{route('wellcome')}}" class="sidebar_text" >
            <span class="ml-3 item-text">Dashboard</span><span class="sr-only"> (current)</span>
          </a>
        </li>
        <li class="nav-item sidebar_li">
        <i class="fa-solid fa-truck"></i>
          <a href="{{route('allsupplier')}}" class="sidebar_text" >
            <span class="ml-3 item-text">Suppliers</span><span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item sidebar_li">
          <i class="fa-solid fa-box"></i>
          <a href="{{route('allitems')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">Items</span><span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item sidebar_li">
            <i class="fe fe-box fe-16"></i>
          <a href="{{route('masterstock')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">Master Stock</span><span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="nav-item sidebar_li">
          <i class="fa-solid fa-box"></i>
          <a href="{{route('bridelItems')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">Saloon Items</span><span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="nav-item sidebar_li">
          <i class="fa-solid fa-users"></i>
          <a href="{{route('allcustomer')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">Customers</span><span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="nav-item sidebar_li">
          <i class="fa-solid fa-scale-balanced"></i>
          <a href="{{route('pospage')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">POS Invoice</span><span class="sr-only">(current)</span>
          </a>
        </li>



            <li class="nav-item dropdown">
              <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="ml-3 item-text">Purchase Managment</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="dashboard">
                <li class="nav-item mb-2">
                <a href="{{route('allorderrequests')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Request Order</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item active">
                <a href="{{route('allgins')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">GIN</span><span class="sr-only">(current)</span>
                </a>
                </li>

              </ul>
            </li>



            <li class="nav-item dropdown">
              <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fa-solid fa-book-open"></i>
                <span class="ml-3 item-text">Reports</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="reports">
                <li class="nav-item mb-2">

                <a href="{{route('customerreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Customer Report</span><span class="sr-only">(current)</span>
                </a>

                </li>

                <li class="nav-item mb-2">

                <a href="{{route('supplierreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Supplier Report</span><span class="sr-only">(current)</span>
                </a>

                </li>

                <li class="nav-item mb-2">

                <a href="{{route('productreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Products Report</span><span class="sr-only">(current)</span>
                </a>

                </li>

                <li class="nav-item mb-2">

                <a href="{{route('purchaseorderreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Purchase Order Report</span><span class="sr-only">(current)</span>
                </a>

                </li>

                <li class="nav-item mb-2">

                <a href="{{route('ginreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">GIN Report</span><span class="sr-only">(current)</span>
                </a>

                </li>

                <li class="nav-item mb-2">

                <a href="{{route('orderreport')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Sales Report</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item mb-2">
                  <a href="{{route('PreOrderReport')}}" class="sidebar_text text-decoration-none"  >
                    <span class="ml-3 item-text">Bridel Appoinments Report</span><span class="sr-only">(current)</span>
                  </a>
                </li>

                <li class="nav-item mb-2">
                  <a href="{{route('RealOrderReport')}}" class="sidebar_text text-decoration-none"  >
                    <span class="ml-3 item-text">Salon & Thretment Report</span><span class="sr-only">(current)</span>
                  </a>
                </li>

                <li class="nav-item mb-2">
                  <a href="{{route('SalaryReport')}}" class="sidebar_text text-decoration-none"  >
                    <span class="ml-3 item-text">Salary Report</span><span class="sr-only">(current)</span>
                  </a>
                </li>

                <li class="nav-item mb-2">
                  <a href="{{route('MoyhlyFinalReport')}}" class="sidebar_text text-decoration-none"  >
                    <span class="ml-3 item-text">Monthly Final Report</span><span class="sr-only">(current)</span>
                  </a>
                </li>
                
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a href="#services" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fa-solid fa-scale-balanced"></i>
                <span class="ml-3 item-text">Services</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="services">
                <li class="nav-item mb-2">
                <a href="{{route('services')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Services List</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="{{route('packages')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Packages List</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="{{route('bridelsubcategory')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Bridel Sub Packages</span><span class="sr-only">(current)</span>
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
                        
                    </ul>
                    </li>
                </ul>
                <ul class="collapse list-unstyled pl-1 w-100" id="HR">
                    <li class="nav-item dropdown">
                        <a href="#Leave" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <span class="ml-3 item-text">Leave</span><span class="sr-only">(current)</span>
                    </a>
                    <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="Leave">
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

                    <li class="nav-item sidebar_li">
                        <a href="{{route('salary')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Salary Managment</span><span class="sr-only">(current)</span>
                        </a>
                    </li>

                    <li class="nav-item sidebar_li">
                        <a href="{{route('employee')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Employee</span><span class="sr-only">(current)</span>
                        </a>
                    </li>

                    <li class="nav-item sidebar_li">
                        <a href="{{route('commissions-list')}}" class="sidebar_text">
                            <span class="ml-3 item-text">Commissions</span><span class="sr-only">(current)</span>
                        </a>
                    </li>

                    
                </ul>
            </li>

            <li class="nav-item dropdown">
                  <a href="#Bridelappoinment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                      <i class="fe fe fe-calendar fe-16"></i>
                      <span class="ml-3 item-text">Bridel Appointments</span><span class="sr-only">(current)</span>
                  </a>
                  <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="Bridelappoinment">
                      <li class="nav-item mb-2">
                          <a href="{{ route('appointments') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Bridel Pre Order</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item mb-2">
                          <a href="{{ route('showPreOrders') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Bridel Pre Order List</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item active mb-2">
                          <a href="{{ route('RealTimepage1') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Order Closing Form</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item active mb-2">
                          <a href="{{ route('RealTimeOrderList') }}" class="sidebar_text">
                              <span class="ml-3 item-text">All Bridel Appoinments</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                  </ul>
            </li>   


            <li class="nav-item dropdown">
                  <a href="#appoinment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                      <i class="fe fe fe-calendar fe-16"></i>
                      <span class="ml-3 item-text">Saloon Appointments</span><span class="sr-only">(current)</span>
                  </a>
                  <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="appoinment">

                      <li class="nav-item mb-2">
                          <a href="{{ route('calender') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Saloon Pre Orders</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item mb-2">
                          <a href="{{ route('SalonThretment') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Saloon Pre Order List</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item mb-2">
                          <a href="{{ route('RealSalonThretment') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Salon Real Time Order</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                  </ul>
            </li> 
            
            <li class="nav-item dropdown">
                  <a href="#giftvoucher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                  <i class="fe fe-gift fe-16"></i>
                    <span class="ml-3 item-text">Gift Vouchers & Promotions</span><span class="sr-only">(current)</span>
                  </a>
                  <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="giftvoucher">
                      <li class="nav-item mb-2">
                          <a href="{{ route('GiftVoucher') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Gift Vouchers</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item mb-2">
                          <a href="{{ route('Promotion') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Promotions</span><span class="sr-only">(current)</span>
                          </a>
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
                              <span class="ml-3 item-text">Company Details</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      
                      
                      <li class="nav-item active mb-2">
                          <a href="{{ route('addPermission') }}" class="sidebar_text">
                              <span class="ml-3 item-text">Add Permission</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                      
                     
                      <li class="nav-item active mb-2">
                          <a href="{{route('addRole')}}" class="sidebar_text">
                              <span class="ml-3 item-text">Add Role</span><span class="sr-only">(current)</span>
                          </a>
                      </li>

                      <li class="nav-item active mb-2">
                          <a href="{{route('assign_user_role')}}" class="sidebar_text">
                              <span class="ml-3 item-text">Assigned User Roles</span><span class="sr-only">(current)</span>
                          </a>
                      </li>
                  </ul>
            </li>        
      </ul>
      </div>
    </nav>
</aside>
