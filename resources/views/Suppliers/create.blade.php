@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container">
    <h2>Create Supplier</h2>
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" required>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
            </div>
            <div class="form-group">
                <label for="account_details">Account Details</label>
                <input type="text" class="form-control" id="account_details" name="account_details" placeholder="Account Details" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</main>
@endsection
