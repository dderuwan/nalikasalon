@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-4">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Assigning User to Role</strong></h3>
          </div>
          <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="userSelect" class="col-sm-2 col-form-label" style="color:black;">User <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="userSelect" name="user_id" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="roleSelect" class="col-sm-2 col-form-label" style="color:black;">Role Name <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="roleSelect" name="role_id" required>
                            <option value="">Select Role Name</option>
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

<script>
function updateImageLabel(input) {
    let fileName = input.files[0].name;
    input.nextElementSibling.innerText = fileName;
}
</script>

@endsection
