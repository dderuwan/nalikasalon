@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <i class="fas fa-home"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-success text-white" href="#">New Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="#">On Going Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-info text-white" href="#">Online Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="#">Today Order</a>
                </li>
            </ul>
        </div>
    </nav>
</main>
@endsection