@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Edit Supplier</h2>
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $supplier->address) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number', $supplier->contact_number) }}" required>
            </div>

            <div class="form-group">
                <label for="account_details">Account Details</label>
                <input type="text" name="account_details" id="account_details" class="form-control" value="{{ old('account_details', $supplier->account_details) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Supplier</button>
        </form>
    </div>
</main>
@endsection
