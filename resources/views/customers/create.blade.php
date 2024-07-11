@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container">
    <h2>Create Customer</h2>
    <div class="card-body">
        <form action="{{ route('insertcustomer') }}" method="POST">
            @csrf
            
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
            </div>

            <div class="form-group col-md-6">
                <label for="contact_number_1">Contact Number 1 : </label>
                <input type="text" class="form-control" id="contact_number_1" name="contact_number_1" placeholder="Contact Number" required>
            </div>

            <div class="form-group col-md-6">
                <label for="contact_number_2">Contact Number 2 : </label>
                <input type="text" class="form-control" id="contact_number_2" name="contact_number_2" placeholder="Contact Number" >
            </div>
            
            <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
            </div>

            <div class="form-group col-md-6">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" required>
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</main>
@endsection
