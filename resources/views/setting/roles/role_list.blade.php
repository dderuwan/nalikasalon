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
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Role List</strong></h3>
          </div>
          <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:5%">Sl</th>
                                <th>Role Name</th>
                                <th style="width:50%">Description</th>
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="action-icons">
                                    <a href="{{ route('role_edit') }}" class="action-icon edit-icon" title="Edit">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a>
                                    <button class="action-icon delete-icon" onclick="confirmDelete('')" title="Delete">
                                        <i class="fe fe-trash-2 text-danger"></i>
                                    </button>
                                        <form id="" action="" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                    Are you sure you want to delete this User?
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
