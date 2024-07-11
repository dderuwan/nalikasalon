@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Purchase Orders List</h2>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <a href="{{ route('orderrequests.create') }}" class="btn btn-primary mb-3">Create New Order</a>
        <table class="table table-bordered">
            <tr>
                <th>Order-Request-Code</th>
                <th>Supplier Code</th>
                <th>Date</th>
                <th>Status</th>
                <th width="200px">Action</th>
            </tr>
            @foreach ($orderRequests as $orderRequest)
            <tr>
                <td>{{ $orderRequest->order_request_code }}</td>
                <td>{{ $orderRequest->supplier_code }}</td>
                <td>{{ $orderRequest->date }}</td>
                <td>{{ $orderRequest->status }}</td>
                <td>
                    <!-- Show Button -->
                    <a href="{{ route('orderrequests.show', $orderRequest->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                    <!-- Delete Button -->
                    <button class="btn btn-danger" onclick="confirmDelete({{ $orderRequest->id }})"><i class="fe fe-trash fe-16"></i></button>
                    <form id="delete-form-{{ $orderRequest->id }}" action="{{ route('orderrequests.destroy', $orderRequest->id) }}" method="POST" style="display:none;">
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
    function confirmDelete(orderRequestId) {
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
                document.getElementById('delete-form-' + orderRequestId).submit();
            }
        })
    }
</script>
@endsection
