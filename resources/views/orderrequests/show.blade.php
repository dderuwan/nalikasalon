<!-- orderrequests/show.blade.php -->
@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Order Request Details</h1>
        <div class="mb-3">
            <a href="{{ route('allorderrequests') }}" class="btn btn-secondary"><i class="fe fe-arrow-left fe-16"></i></a>
            <button class="btn btn-danger" onclick="confirmDelete({{ $orderRequest->id }})"><i class="fe fe-trash fe-16"></i></button>
             <form id="delete-form-{{ $orderRequest->id }}" action="{{ route('orderrequests.destroy', $orderRequest->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <p><strong>Order Request Code:</strong> {{ $orderRequest->order_request_code }}</p>
        <p><strong>Supplier Code:</strong> {{ $orderRequest->supplier_code }}</p>
        <p><strong>Date:</strong> {{ $orderRequest->date }}</p>

        <h2>Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>In Stock</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderRequest->items as $item)
                    <tr>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->instock }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
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
