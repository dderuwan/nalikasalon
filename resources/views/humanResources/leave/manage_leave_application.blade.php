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
                        <h2 class="page-title">Manage Leave Application</h2>
                    </div>
                </div>
                <p class="card-text"></p>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables table-bordered" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th style="color: black;">SL</th>
                                            <th style="color: black; width:20%">Name</th>
                                            <th style="color: black;">Employee ID</th>
                                            <th style="color: black;">Application Start Date</th>
                                            <th style="color: black;">Application End Date</th>
                                            <th style="color: black;">Approve Start Date</th>
                                            <th style="color: black;">Approved End Date</th>
                                            <th style="color: black; width:10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leave_applications as $index => $leave_app)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $leave_app->employee->firstname }} {{ $leave_app->employee->lastname }}</td>
                                                <td>{{ $leave_app->employee->id }}</td>
                                                <td>{{ $leave_app->apply_strt_date }}</td>
                                                <td>{{ $leave_app->apply_end_date }}</td>
                                                <td>{{ $leave_app->leave_aprv_strt_date }}</td>
                                                <td>{{ $leave_app->leave_aprv_end_date }}</td>  
                                                <td>
                                                    <div class="action-icons">
                                                        <a href="{{ route('leave_app_edit', $leave_app->id) }}" class="action-icon edit-icon" title="Edit">
                                                            <i class="fe fe-edit text-primary"></i>
                                                        </a>
                                                        
                                                        <!-- Delete form (hidden) -->
                                                        <form id="delete-form-{{ $leave_app->id }}" action="{{ route('destroyapplication', $leave_app->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action-icon delete-icon" title="Delete" onclick="return confirm('Are you sure you want to delete this Leave Application?');">
                                                                <i class="fe fe-trash-2 text-danger"></i>
                                                            </button>
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
                    Are you sure you want to delete this Leave Application?
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
    let leaveAppId;

    // When the delete button is clicked, store the ID of the leave application
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        leaveAppId = button.data('id'); // Extract info from data-* attributes

        var modal = $(this);
        modal.find('.modal-body').text('Are you sure you want to delete this leave application?');
    });

    // When the confirmation button is clicked, submit the associated form
    $('#confirmDeleteButton').on('click', function () {
        if (leaveAppId) {
            $('#delete-form-' + leaveAppId).submit();
        }
    });
</script>



@endsection
