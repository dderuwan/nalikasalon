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

                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Date of Birth</th>
                                            <th>NIC</th>
                                            <th>Contact No</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Zip Code</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                    <tr>

                                        <td>{{ $employee->firstname }}</td>
                                        <td>{{ $employee->middlename }}</td>
                                        <td>{{ $employee->lastname }}</td>
                                        <td>{{ $employee->DOB }}</td>
                                        <td>{{ $employee->NIC }}</td>
                                        <td>{{ $employee->contactno }}</td>
                                        <td>{{ $employee->Email }}</td>
                                        <td>{{ $employee->address }}</td>
                                        <td>{{ $employee->city }}</td>
                                        <td>{{ $employee->zipecode }}</td>
                                        <td>{{ $employee->status == 1 ? 'Active' : 'Inactive' }}</td>
                                      <td>
                      <div class="action-icons">
                          <a href="{{ route('editemployee', $employee->id) }}" class="action-icon edit-icon" title="Edit">
                            <i class="fe fe-edit text-primary"></i>
                          </a>
                        <button class="action-icon delete-icon" onclick="confirmDelete('{{ $employee->id }}')" title="Delete">
                            <i class="fe fe-trash-2 text-danger"></i>
                        </button>
                            <form id="delete-form-{{ $employee->id }}" action="{{ route('deleteemployee', $employee->id) }}" method="POST" style="display: none;">
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

   <!-- Delete Confirmation Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script>
    function confirmDelete(holidayId) {
        const deleteForm = document.getElementById('delete-form-' + holidayId);
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

        $('#deleteModal').modal('show');

        confirmDeleteButton.onclick = function() {
            deleteForm.submit();
        }
    }
</script>
@endsection
