@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Add Role</strong></h3>
          </div>
          <div class="card-body">
            <form action="{{ route('storeRole') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="inputTitle" class="col-sm-2 col-form-label" style="color:black;">Role Name <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputTitle" name="role_name" placeholder="Role name" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputDescription" class="col-sm-2 col-form-label" style="color:black;">Description</label>
                <div class="col-sm-8">
                  <textarea class="form-control" id="inputDescription" name="description" placeholder="Description" rows="2"></textarea>
                </div>
              </div>

              @foreach($permissions as $category => $groupedPermissions)
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label" style="color:black;">{{ ucfirst($category) }} Permissions</label>
                  <div class="col-sm-8">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Permission</th>
                          <th>Select</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($groupedPermissions as $permission)
                          <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                              <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}">
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              @endforeach

              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Add Role</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection
