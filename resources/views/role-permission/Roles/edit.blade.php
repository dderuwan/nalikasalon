@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Role</h1>
        <form action="{{ route('updateRole', $role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" placeholder="Enter Role Name" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
</main>

@endsection
