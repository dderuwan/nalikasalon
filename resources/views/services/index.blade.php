@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-md-6" >
                     <h2>Services</h2>
                </div>
                <div class="col-md-6">
                    @if ($message = Session::get('succes'))
                    <div class='alert alert-success'>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <a href="{{ route('addservice') }}" class="btn btn-primary mb-3">Add Service</a>
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
                                        <th style="color: black;">Id</th>
                                        <th style="color: black;">Image</th>
                                        <th style="color: black;">Service Code</th>
                                        <th style="color: black;">Service Name</th>
                                        <th style="color: black;">Description</th>
                                        <th style="color: black;" width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td style="text-align:center; vertical-align:middle;">
                                            @if($service->image)
                                                <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->service_name }}" style="height: 50px; display: block; margin: 0 auto;" class="img-fluid">
                                            @endif
                                        </td>
                                        <td>{{ $service->service_code }}</td>
                                        <td>{{ $service->service_name }}</td>
                                        <td>{{ $service->description }}</td>
                                        <td>
                                            <!-- Show Button -->
                                            <a href="{{ route('showservices', $service->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('editservices', $service->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger" onclick="confirmDelete({{ $service->id }})"><i class="fe fe-trash fe-16"></i></button>
                                            <form id="delete-form-{{ $service->id }}" action="{{ route('deleteservices', $service->id) }}" method="POST" style="display:none;">
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
