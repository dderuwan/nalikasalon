<style>
    .btn-login {
        background-color: #007bff;
        color: white;
        padding: 5px 15px; /* Adjusted for better alignment */
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        line-height: 1.5; /* Ensures the button's height matches the nav items */
        font-size: 14px; /* Ensures text size consistency */
        margin-top: 18px; /* Align vertically with other nav items */

    }

    .btn-login:hover{
        color:white;
        text-decoration: none;  
    }

    .nav-item .btn-login {
        margin-right: 15px; /* Align with other nav items' spacing */
    }

    .nav-link {
        display: flex;
        align-items: center;
        height: 100%; /* Ensure the height matches the navbar height */
    }
</style>


<nav class="topnav navbar navbar-light">


    <!-- Sidebar Toggle Button -->
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <!-- Search Form -->
    <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
    </form>

    <!-- Navigation Items -->
    <ul class="nav">
        <!-- Light/Dark Mode Toggle -->
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>

        <!-- Shortcuts Modal Trigger -->
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" data-toggle="modal" data-target=".modal-shortcut">
                <span class="fe fe-grid fe-16"></span>
            </a>
        </li>

        <!-- Notifications Modal Trigger -->
        <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="#" data-toggle="modal" data-target=".modal-notif">
                <span class="fe fe-bell fe-16"></span>
                <span class="dot dot-md bg-success"></span>
            </a>
        </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            @auth
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <!-- Display the authenticated user's avatar -->
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/avatars/face-1.jpg') }}" alt="{{ Auth::user()->name }}" class="avatar-img rounded-circle">
                </span>

                <span class="ml-2">{{ Auth::user()->name }}</span>
            </a>

            
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <!-- Display the authenticated user's name -->
                <a class="dropdown-item" href="{{ route('user.details', ['user' => Auth::user()->id]) }}">
                    <i class="fe fe-user mr-2"></i> Profile
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fe fe-log-out mr-2"></i> Log Out
                    </button>
                </form>
            </div>
            @endauth
            @guest
            <!-- Guest Options -->
            <a href="{{ route('login') }}" class="btn-login me-3">
              Login
            </a>
            @endguest
        </li>
    </ul>
</nav>

<!-- Responsive Navigation Menu -->
<div class="navbar-collapse collapse" id="navbarResponsive">
    <ul class="navbar-nav ms-auto">
        <!-- Navigation Links -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <!-- Add more nav links as needed -->
    </ul>
</div>
