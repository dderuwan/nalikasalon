@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container">
    <h2>Customer List</h2>
    @if ($message = Session::get('succes'))
        <div class='alert alert-success'>
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{ route('createcustomer') }}" class="btn btn-primary mb-3">Add New Customer</a>
    <table class="table table-bordered">
        <tr>
            <th>Customer Code</th>
            <th>Name</th>
            <th>Contact Number 1</th>
            <th>Contact Number 2</th>
            <th>Address</th>
            <th>Date Of Birth</th>
            <th width="200px">Action</th>
        </tr>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ $customer->supplier_code }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->contact_number_1 }}</td>
            <td>{{ $customer->contact_number_2 }}</td>
            <td>{{ $customer->address }}</td>
            <td>{{ $customer->date_of_birth }}</td>
            <td>
                <!-- Show Button -->
                <a href="{{ route('showcustomer', $customer->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                <!-- Edit Button -->
                <a href="{{ route('editcustomer', $customer->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>

                <!-- Delete Button -->
                <button class="btn btn-danger" onclick="confirmDelete({{ $customer->id }})"><i class="fe fe-trash fe-16"></i></button>
                <form id="delete-form-{{ $customer->id }}" action="{{ route('deletecustomer', $customer->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(supplier_code) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + supplier_code).submit();
            }
        })
    }
</script>
@endsection