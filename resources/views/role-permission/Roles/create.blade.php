@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Add Role</h1>

        
        <!-- Display status message -->
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif


        <form action="{{ route('storeRole') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission Name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Role</button>
        </form>

    </div>
    <br><br><br>
    <div class="container">
        <h1>All Roles</h1>
        <div class="card-body">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th style="color: black;">#</th>
                    <th style="color: black;">Name</th>
                    <th style="color: black;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('addPermitionToRole', $role->id) }}" class="btn btn-sm btn-warning">Add / Edit Role Permission</a>
                            <a href="{{ route('editRole', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $role->id }})">Delete</button>
                            <form id="delete-form-{{ $role->id }}" action="{{ route('deleteRole', $role->id) }}" method="POST" style="display:none;">
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