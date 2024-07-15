@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6" >
                     <h2>GIN List</h2>
                </div>
                <div class="col-md-6">
                    @if ($message = Session::get('succes'))
                    <div class='alert alert-success'>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <a href="{{ route('creategin') }}" class="btn btn-primary mb-3">GIN Form</a>
                </div>
            </div>
            <p class="card-text"></p>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th style="color: black;">Date</th>
                                        <th style="color: black;">GIN Code</th>
                                        <th style="color: black;">Order Request Code</th>
                                        <th style="color: black;">Supplier Code</th>
                                        <th style="color: black;">Total Cost</th>
                                        <th style="color: black;" width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
