@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h4><strong class="card-title">Update Leave Type</strong></h4>
          </div>
          <div class="card-body">
            <form action="{{ route('update_leave_type', $leave_type->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="leaveTypeInput" class="col-sm-2 col-form-label" style="color:black;">Leave Type <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="leave_type" name="leave_type" placeholder="Enter Leave Type" value="{{ $leave_type->leave_type }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="numberOfDays" class="col-sm-2 col-form-label" style="color:black;">Number of Days<i class="text-danger">*</i></label>
                <div class="col-sm-8">
                <input type="number" class="form-control" id="leave_days" name="leave_days" placeholder="Enter Number of Days" value="{{ $leave_type->leave_days }}">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-10 mt-5">
                  <button type="submit" class="btn btn-primary">Update</button>
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

@endsection
