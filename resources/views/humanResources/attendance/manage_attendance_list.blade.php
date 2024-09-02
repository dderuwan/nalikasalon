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
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h2 class="page-title">Attendance List</h2>
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
                <p class="card-text"></p>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables table-bordered" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th style="color: black; width:5%">SL</th>
                                            <th style="color: black; width:30%">Name</th>
                                            <th style="color: black;">Date</th>
                                            <th style="color: black; width:15%">Check In</th>
                                            <th style="color: black; width:15%">Check Out</th>
                                            <th style="color: black; width:15%">Stayed Time</th>
                                            <th class="text-center" style="color: black; width:10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendance_list as $index => $attendance)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>@if($attendance->employee)
                                                    {{ $attendance->employee->firstname }} {{ $attendance->employee->lastname }}
                                                @else
                                                    No Employee Assigned
                                                @endif
                                            </td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $attendance->sign_in }}</td>
                                            <td>{{ $attendance->sign_out }}</td>
                                            <td>{{ $attendance->stayed_time }}</td>
                                            <td>
                                                <div class="action-icons">
                                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="action-icon edit-icon" title="Edit">
                                                    <i class="fe fe-edit text-primary"></i>
                                                </a>
                                                <button class="action-icon delete-icon" onclick="confirmDelete('{{ $attendance->id }}')" title="Delete">
                                                    <i class="fe fe-trash-2 text-danger"></i>
                                                </button>
                                                    <form id="delete-form-{{ $attendance->id }}" action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                            @endforeach                                          
                                        </tr>
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
                    Are you sure you want to delete?
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
    function confirmDelete(purchaseId) {
        const deleteForm = document.getElementById('delete-form-' + purchaseId);
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

        $('#deleteModal').modal('show');

        confirmDeleteButton.onclick = function() {
            deleteForm.submit();
        }
    }
</script>

@endsection
