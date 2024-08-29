@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Permission</h1>
        <form action="{{ route('updatePermission', $permission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" placeholder="Enter Permission Name" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Permission</button>
        </form>
    </div>
</main>

@endsection
