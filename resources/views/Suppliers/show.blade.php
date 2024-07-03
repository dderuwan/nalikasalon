@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Supplier Details</h2>
        <div class="mb-3">
            <a href="{{ route('allsupplier') }}" class="btn btn-secondary">Back to List</a>
            <a href="{{ route('editsupplier',$supplier->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('deletesupplier', $supplier->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this supplier?')" class="btn btn-danger">Delete</button>
            </form>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $supplier->name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $supplier->address }}</td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>{{ $supplier->contact_number }}</td>
            </tr>
            <tr>
                <th>Account Details</th>
                <td>{{ $supplier->account_details }}</td>
            </tr>
            <tr>
                <th>Supplier Code</th>
                <td>{{ $supplier->supplier_code }}</td>
            </tr>
        </table>
    </div>
</main>
@endsection
