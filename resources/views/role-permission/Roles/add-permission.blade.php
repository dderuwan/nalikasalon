@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Role: {{ $role->name }}</h1>

        
        <form action="{{ route('givePermissionToRole', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="permissions">Permissions</label>
                <div class="permissions-list">
                    @foreach($permissions as $permission)
                        <div class="permission-item">
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->id }}" 
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                />
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
</main>

@endsection

@section('styles')
<style>
    .permissions-list {
        margin-top: 10px;
    }
    .permission-item {
        margin-bottom: 10px;
    }
</style>
@endsection
