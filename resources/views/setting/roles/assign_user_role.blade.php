@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
    <div class="row justify-content-center p-4">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Assigning Employee to Role</strong></h3>
          </div>
          <div class="card-body">
          <form action="{{ route('assignRole') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="userSelect" class="col-sm-2 col-form-label" style="color:black;">Employee <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select class="form-control" id="userSelect" name="employee_id" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->firstname }} {{ $employee->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="roleSelect" class="col-sm-2 col-form-label" style="color:black;">Role Name <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                    <select class="form-control" id="roleSelect" name="role_id" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 mt-5">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

          </div>
        </div>

      </div>
    </div>

    <div class="mt-5">
        <h3>Assigned Roles</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employeeRoles as $employee)
                    <tr>
                        <td>{{ $employee->firstname }} {{ $employee->lastname }}</td>
                        <td>
                            @foreach($employee->roles as $role)
                                <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</main>

<script>
function updateImageLabel(input) {
    let fileName = input.files[0].name;
    input.nextElementSibling.innerText = fileName;
}
</script>

@endsection
