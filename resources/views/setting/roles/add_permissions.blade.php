@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Add Permission</h1>
        <form action="{{ route('storePermission') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission Name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Permission</button>
        </form>

    </div>
    <br><br><br>
    <div class="container">
        <h1>All Permissions</h1>
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
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                        <a href="{{ route('addPermission', $permission->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $permission->id }})">Delete</button>
                        <form id="delete-form-{{ $permission->id }}" action="{{ route('deletePermission', $permission->id) }}" method="POST" style="display:none;">
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