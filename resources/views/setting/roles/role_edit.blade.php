@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Edit Role</strong></h3>
          </div>
          <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="inputTitle" class="col-sm-2 col-form-label" style="color:black;"> Role Name <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputTitle" name="role_name" placeholder="Role name" value="" required>
                </div>
              </div>
              <div class="form-group row">
                    <label for="inputDescription" class="col-sm-2 col-form-label" style="color:black;">Description</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="inputDescription" name="sescription" placeholder="Description" rows="2"></textarea>
                    </div>
                </div>
                <div class="container mt-5">
                    <h5>Customer</strong></h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Menu Title</th>
                                <th>
                                    <input type="checkbox"  id="checkAllCreate"> Can Create
                                </th>
                                <th>
                                    <input type="checkbox" id="checkAllRead"> Can Read
                                </th>
                                <th>
                                    <input type="checkbox" id="checkAllEdit"> Can Edit
                                </th>
                                <th>
                                    <input type="checkbox" id="checkAllDelete"> Can Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Menu 1</td>
                                <td><input type="checkbox" class="canCreate"></td>
                                <td><input type="checkbox" class="canRead"></td>
                                <td><input type="checkbox" class="canEdit"></td>
                                <td><input type="checkbox" class="canDelete"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              <div class="form-group row">
                <div class="col-sm-10 mt-5">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
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
</main>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#checkAllCreate').click(function() {
            $('.canCreate').prop('checked', this.checked);
        });
        $('#checkAllRead').click(function() {
            $('.canRead').prop('checked', this.checked);
        });
        $('#checkAllEdit').click(function() {
            $('.canEdit').prop('checked', this.checked);
        });
        $('#checkAllDelete').click(function() {
            $('.canDelete').prop('checked', this.checked);
        });
    });
</script>
@endsection
