
@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Good In Details</h1>
        <div class="mb-3">
            <a href="{{ route('ginreport') }}" class="btn btn-secondary"><i class="fe fe-arrow-left fe-16"></i></a>
            <button class="btn btn-danger" onclick="confirmDelete({{ $gin->id }})"><i class="fe fe-trash fe-16"></i></button>
             <form id="delete-form-{{ $gin->id }}" action="{{ route('gindestroy', $gin->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <p><strong>GIN Code:</strong> {{ $gin->gin_code }}</p>
        <p><strong>Order Request Code:</strong> {{ $gin->order_request_code }}</p>
        <p><strong>Supplier Code:</strong> {{ $gin->supplier_code }}</p>
        <p><strong>Date:</strong> {{ $gin->date }}</p>
        <p><strong>Total Cost:</strong> {{ $gin->total_cost_payment }}</p>

        <h2>Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Pack Size</th>
                    <th>Unit Price</th>
                    <th>In Quentity</th>
                    <th>Total Cost</th>
                    <th>Payment</th>

                </tr>
            </thead>
            <tbody>
                @foreach($gin->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->packsize }}</td>
                        <td>{{ $item->unit_price }}</td>
                        <td>{{ $item->in_quantity }}</td>
                        <td>{{ $item->total_cost }}</td>
                        <td>{{ $item->payment }}</td>
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
