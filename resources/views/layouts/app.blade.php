<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NALIKA SALON</title>
    <title>{{ config('app.name', 'NALIKA SALON') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @include('layouts.web.css')

  <style>
    .navbar-nav .nav-link {
        text-transform: uppercase;
        color: black;
        font-size: 15px;
        
        font-family: 'Poppins', sans-serif;
    }

    .navbar {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    }

    .btn-login {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
    }
  </style>

</head>
<body>
    <div id="app">

    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container">
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand mt-2 mt-lg-0 me-5" href="{{ route('home') }}">
          <img src="/images/logo.png" height="30" width="170" />
        </a>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link me-3" href="{{ route('store') }}">Store</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('showApp') }}">Appointments</a>
          </li>
        </ul>
      </div>

      <div class="dropdown me-3">
        <a id="navbarDropdown" class="text-reset dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <div class="icon-circle">
                @if (Auth::check() && Auth::user()->name)
                    {{ Auth::user()->name[0] }}
                @else
                    <i class="fas fa-user-circle"></i> <!-- Or any default icon -->
                @endif
            </div>
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    </div>
  </nav>



        <main class="mb-5">
            @yield('content')
            
        </main>
    </div>


    @include('layouts.web.script')
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>