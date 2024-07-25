
@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Good In Details</h1>
        <div class="mb-3">
            <a href="{{ route('allgins') }}" class="btn btn-secondary"><i class="fe fe-arrow-left fe-16"></i></a>
            <button class="btn btn-danger" onclick="confirmDelete({{ $order->id }})"><i class="fe fe-trash fe-16"></i></button>
             <form id="delete-form-{{ $order->id }}" action="{{ route('deletepos', $order->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
        <p><strong>Customer Code:</strong> {{ $order->customer_code }}</p>
        <p><strong>Payment Type:</strong> {{ $order->payment_type }}</p>
        <p><strong>Date:</strong> {{ $order->date }}</p>
        <p><strong>Total Cost:</strong> {{ $order->total_cost_payment }}</p>

        <h2>Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Quentity</th>
                    <th>Total Cost</th>

                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->item_code}}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->total_cost }}</td>
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
