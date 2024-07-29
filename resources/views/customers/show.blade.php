@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Supplier Details</h2>
        <div class="mb-3">
            <a href="{{ route('allcustomer') }}" class="btn btn-secondary"><i class="fe fe-arrow-left fe-16"></i></a>
            <a href="{{ route('editcustomer',$customer->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>
            <form action="{{ route('deletecustomer', $customer->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" class="btn btn-danger"><i class="fe fe-trash fe-16"></i></button>
            </form>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Customer Code</th>
                <td>{{ $customer->customer_code }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $customer->name }}</td>
            </tr>
            
            <tr>
                <th>Contact Number 1</th>
                <td>{{ $customer->contact_number_1 }}</td>
            </tr>
            <tr>
                <th>Contact Number 2</th>
                <td>{{ $customer->contact_number_2 }}</td>
            </tr>
            <tr>
                <th>Date Of Birth </th>
                <td>{{ $customer->contact_number_2 }}</td>
            </tr>
            <tr>
                <th>Account Details</th>
                <td>{{ $customer->date_of_birth }}</td>
            </tr> 
            <tr>
                <th>Address</th>
                <td>{{ $customer->address }}</td>
            </tr>
        </table>
    </div>
</main>
@endsection
