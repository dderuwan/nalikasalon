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
