@extends('layouts.main.master')

@section('content')
<style>
.action-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.action-icon {
    display: inline-block;
    width: 36px; 
    height: 36px; 
    line-height: 36px; 
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 5px; 
}

.edit-icon {
    background-color: #f0f0f0; 
}

.delete-icon {
    background-color: #f8d7da; 
}

</style>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">All Employees</h2>
                <p class="card-text"></p>
                <div class="card-header">

                    <button type="button" class="btn btn-primary float-end" onclick="window.location.href='{{ route('createemployee') }}'">
                        Add Employee
                    </button>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th>Contact No</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                    <tr>

                                        <td>{{ $employee->firstname }} </td>
                                        <td>{{ $employee->DOB }}</td>
                                        <td>{{ $employee->contactno }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            @if(!empty($employee->getRoleNames()))
                                            @foreach($employee->getRoleNames() as $rolename)
                                            <label class="badge badge-info"> {{$rolename}}</label>
                                            @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $employee->status == 1 ? 'Active' : 'Inactive' }}</td>
                                      <td>
                                        <div class="action-icons">
                                            <a href="{{ route('editemployee', $employee->id) }}" class="btn btn-warning"><i class="fe fe-edit fe-16"></i></a>
                                            <button class="btn btn-danger" onclick="confirmDelete({{ $employee->id }})"><i class="fe fe-trash fe-16"></i></button>
                                            <form id="delete-form-{{ $employee->id }}" action="{{ route('deleteemployee', $employee->id) }}" method="POST" style="display:none;">
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
        </div>
    </div>

</main>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(itemId) {
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
                document.getElementById('delete-form-' + itemId).submit();
            }
        })
    }
</script>
