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
    width: 30px; 
    height: 30px; 
    line-height: 30px; 
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
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3><strong class="card-title">Leave type</strong></h3>
            <div>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLeaveType">
                <i class="fe fe-plus"></i>Add Leave type
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:10%; color:black;">ID</th>
                  <th style="width:35%; color:black;">Leave Type</th>
                  <th style="width:15%; color:black;">Total Leave Days</th>
                  <th class="text-center" style="color: black; width:10%">Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($leave_types as $index=> $leave_type)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $leave_type->leave_type}}</td>
                  <td>{{ $leave_type->leave_days}}</td>
                  <td>
                      <div class="action-icons">
                          <a href="{{ route('leave_type.edit', $leave_type->id) }}" class="action-icon edit-icon" title="Edit">
                            <i class="fe fe-edit text-primary"></i>
                          </a>
                        <button class="action-icon delete-icon" onclick="confirmDelete('{{ $leave_type->id }}')" title="Delete">
                            <i class="fe fe-trash-2 text-danger"></i>
                        </button>
                            <form id="delete-form-{{ $leave_type->id }}" action="{{ route('leave_type.destroy',  $leave_type->id) }}" method="POST" style="display: none;">
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
      </div>
    </div>
  </div>

    <!-- Add leave type modal -->
    <div class="modal fade" id="addLeaveType" tabindex="-1" role="dialog" aria-labelledby="addLeaveTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeaveTypeModalLabel">Add Leave Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Leave_type.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="leaveTypeInput" style="color:black;">Leave Type<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="leave_type" name="leave_type" placeholder="Enter Leave Type" required>
                        </div>
                        <div class="form-group">
                            <label for="numberOfDaysInput" style="color:black;">Number of Days<i class="text-danger">*</i></label>
                            <input type="number" class="form-control" id="leave_days" name="leave_days" placeholder="Enter Number of Days" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" style="color:white; background-color:green;" class="btn">Add</button>
                        </div>
                    </form>
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
                    Are you sure you want to delete this Leave Type?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmDelete(LeaveTypeId) {
        const deleteForm = document.getElementById('delete-form-' + LeaveTypeId);
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

        $('#deleteModal').modal('show');

        confirmDeleteButton.onclick = function() {
            deleteForm.submit();
        }
    }
</script>

@endsection
