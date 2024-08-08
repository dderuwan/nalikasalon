@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Roles List</strong></h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Role Name</th>
                  <th>Description</th>
                  <th>Permissions</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($roles as $role)
                  <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                      <ul>
                        @foreach($role->permissions as $permission)
                          <li>{{ $permission->name }}</li>
                        @endforeach
                      </ul>
                    </td>
                    <td>
                      <div class="action-icons">
                        <a href="{{ route('editRole', $role->id) }}" class="action-icon edit-icon" style="font-size:18px" title="Edit">
                          <i class="fe fe-edit text-primary"></i>
                        </a>
                        <button class="action-icon delete-icon" onclick="confirmDelete('{{ $role->id }}')" style="font-size:18px; margin-left:20px" title="Delete">
                          <i class="fe fe-trash-2 text-danger"></i>
                        </button>
                        <form id="delete-form-{{ $role->id }}" action="{{ route('deleteRole', $role->id) }}" method="POST" style="display: none;">
                          @csrf
                          @method('DELETE')
                        </form>
                      </div>
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
</main>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(roleId) {
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
                document.getElementById('delete-form-' + roleId).submit();
            }
        })
    }
</script>
@endsection
