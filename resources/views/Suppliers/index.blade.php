@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container">
    <h2>Suppliers List</h2>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <a href="{{ route('createcustomer') }}" class="btn btn-primary mb-3">Create New Supplier</a>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Account Details</th>
            <th>Supplier Code</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->address }}</td>
            <td>{{ $supplier->contact_number }}</td>
            <td>{{ $supplier->account_details }}</td>
            <td>{{ $supplier->supplier_code }}</td>
            <td>
                <!-- Show Button -->
                <a href="{{ route('showsupplier', $supplier->id) }}" class="btn btn-secondary">Show</a>

                <!-- Edit Button -->
                <a href="{{ route('editsupplier', $supplier->id) }}" class="btn btn-primary">Edit</a>

                <!-- Delete Button -->
                <button class="btn btn-danger" onclick="confirmDelete({{ $supplier->id }})">Delete</button>
                <form id="delete-form-{{ $supplier->id }}" action="{{ route('deletesupplier', $supplier->id) }}" method="POST" style="display:none;">
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
    function confirmDelete(supplierId) {
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
                document.getElementById('delete-form-' + supplierId).submit();
            }
        })
    }
</script>
@endsection
