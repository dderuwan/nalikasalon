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

    <a href="{{ route('creategin') }}" class="btn btn-primary mb-3">GIN Form</a>

    <table class="table table-bordered">
            <tr>
                <th>Date</th>
                <th>GIN Code</th>
                <th>Order Request Code</th>
                <th>Supplier Code</th>
                <th>Total Cost</th>
                <th width="200px">Action</th>
            </tr>
            @foreach ($gins as $gin)
            <tr>
                <td>{{ $gin->date }}</td>
                <td>{{ $gin->gin_code }}</td>
                <td>{{ $gin->order_request_code }}</td>
                <td>{{ $gin->supplier_code }}</td>
                <td>{{ $gin->total_cost_payment }}</td>
                <td>
                    <!-- Show Button -->
                    <a href="{{ route('showogins', $gin->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                    <!-- Delete Button -->
                    <button class="btn btn-danger" onclick="confirmDelete({{ $gin->id }})"><i class="fe fe-trash fe-16"></i></button>
                    <form id="delete-form-{{ $gin->id }}" action="{{ route('deletegins', $gin->id) }}" method="POST" style="display:none;">
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
