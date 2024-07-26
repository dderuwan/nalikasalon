
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
      <!-- nav bar -->
      <div class="w-100 mb-4 d-flex">
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
          <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
            <g>
              <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
              <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
              <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
            </g>
          </svg>
        </a>
      </div>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item active sidebar_li">
            <i class="fe fe-home fe-16"></i>
          <a href="{{route('/')}}" class="sidebar_text" >
            <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item sidebar_li">
          <i class="fa-solid fa-user-tie"></i>
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

            <li class="nav-item dropdown">
              <a href="#customer" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fa-solid fa-users"></i>
                <span class="ml-3 item-text">Customers</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="customer">
                <li class="nav-item mb-2">
                <a href="{{route('allcustomer')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Customer List</span><span class="sr-only ">(current)</span>
                </a>
                </li>

              </ul>
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
              <a href="#invoice" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fa-solid fa-scale-balanced"></i>
                <span class="ml-3 item-text">Invoices</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="invoice">
                <li class="nav-item mb-2">
                <a href="{{route('pospage')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">POS Invoice</span><span class="sr-only">(current)</span>
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
                <a href="{{route('addservice')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Add Services</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="{{route('packages')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Packages List</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item mb-2">
                <a href="{{route('addpackages')}}" class="sidebar_text text-decoration-none"  >
                  <span class="ml-3 item-text">Add Packages</span><span class="sr-only">(current)</span>
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
