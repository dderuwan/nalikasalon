@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-2">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h4><strong class="card-title">Update</strong></h4>
          </div>
          <div class="card-body">
            <form action="{{ route('leave.update') }}" method="POST">
              @csrf
              <div class="form-group row">
                <label for="weeklyHoliday" class="col-sm-2 col-form-label" style="color:black;">Weekly Leave Day<i class="text-danger">*</i></label>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="friday" name="weekly_leave[]" value="Friday">
                    <label class="form-check-label" for="friday">Friday</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="saturday" name="weekly_leave[]" value="Saturday">
                    <label class="form-check-label" for="saturday">Saturday</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sunday" name="weekly_leave[]" value="Sunday">
                    <label class="form-check-label" for="sunday">Sunday</label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-10 mt-3">
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
