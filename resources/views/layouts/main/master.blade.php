<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="favicon.ico">

        <title>NALIKA SALON</title>

    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="css/styles.css">
    
    @include('layouts.main.css')



  </head>
  <body class="vertical  light  ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <div class="wrapper">
    {{-- navbar --}}
      @include('layouts.main.header')
      {{-- sidebar --}}
      @include('layouts.main.sidebar')
      {{-- main content --}}
        @yield('content')
    </div> <!-- .wrapper -->
    {{-- jquery --}}
    @include('layouts.main.script')
    {{-- Yield for additional scripts --}}
    @yield('scripts')
    <x-notify::notify />


  </body>
</html>
