<!-- In resources/views/setting/userd.blade.php -->
@extends('layouts.main.master')


@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>User Details</h1>
        
        <div class="card">
            <div class="card-header">
                User Information
            </div>
            <div class="card-body">
                <p><strong>First Name:</strong> {{ $user->firstname }}</p>
                <p><strong>Middle Name:</strong> {{ $user->middlename }}</p>
                <p><strong>Last Name:</strong> {{ $user->lastname }}</p>
                <p><strong>Date of Birth:</strong> {{ $user->DOB }}</p>
                <p><strong>NIC:</strong> {{ $user->NIC }}</p>
                <p><strong>Contact Number:</strong> {{ $user->contactno }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Address:</strong> {{ $user->address }}</p>
                <p><strong>City:</strong> {{ $user->city }}</p>
                <p><strong>Zip Code:</strong> {{ $user->zipecode }}</p>
            </div>
        </div>
    </div>
</main>
@endsection
