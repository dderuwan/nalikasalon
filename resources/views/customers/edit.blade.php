@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Edit Customer</h2>
        <form action="{{ route('updatecustomer', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ $customer->id}}" name="id">
            <div class="form-group">
                <label for="supplier_code">Customer code</label>
                <input type="text" name="supplier_code" id="supplier_code" class="form-control" value="{{ old('supplier_code', $customer->supplier_code) }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_number_1">Contact Number 1</label>
                <input type="text" name="contact_number_1" id="contact_number_1" class="form-control" value="{{ old('contact_number_1', $customer->contact_number_1) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_number_2">Contact Number 2</label>
                <input type="text" name="contact_number_2" id="contact_number_2" class="form-control" value="{{ old('contact_number_2', $customer->contact_number_2) }}" >
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $customer->address) }}" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date Of Birth</label>
                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $customer->date_of_birth) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
</main>
@endsection
