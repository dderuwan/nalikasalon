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
        <i class="fe fe-user fe-16"></i>
          <a href="{{route('allsupplier')}}" class="sidebar_text" >
            <span class="ml-3 item-text">Suppliers</span><span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item sidebar_li">
            <i class="fe fe-box fe-16"></i></i>
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
            <i class="fe fe-users fe-16"></i>
          <a href="{{route('allcustomer')}}" class="sidebar_text"  >
            <span class="ml-3 item-text">Customers</span><span class="sr-only">(current)</span>
          </a>
        </li>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
              <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                <i class="fe fe-shopping-cart fe-16 mb-2"></i>
                <span class="ml-3 item-text">Purchase Managment</span><span class="sr-only">(current)</span>
              </a>
              <ul class="collapse list-unstyled pl-1 w-100 ml-4" id="dashboard">
                <li class="nav-item mb-2">
                <a href="{{route('allorderrequests')}}" class="sidebar_text"  >
                  <span class="ml-3 item-text">Request Order</span><span class="sr-only">(current)</span>
                </a>
                </li>

                <li class="nav-item active">
                <a href="{{route('allgins')}}" class="sidebar_text"  >
                  <span class="ml-3 item-text">GIN</span><span class="sr-only">(current)</span>
                </a>
                </li>
                
              </ul>
            </li>
          </ul>



      </ul>

    </nav>
  </aside>
