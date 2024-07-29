@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="page-title">Update Employee</h2>
        <p class="text-muted"></p>

        <div class="card-deck">
          <div class="card shadow mb-4">
            <div class="card-header">
              <strong class="card-title">Update</strong>
            </div>
            <div class="card-body">
              <form method="post" action="{{ route('updateemployee', $employee->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="firstname" value="{{ old('firstname', $employee->firstname) }}" placeholder="First Name">
                    @error('firstname')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputMiddleName">Middle Name</label>
                    <input type="text" class="form-control" id="inputMiddleName" name="middlename" value="{{ old('middlename', $employee->middlename) }}" placeholder="Middle Name">
                    @error('middlename')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="lastname" value="{{ old('lastname', $employee->lastname) }}" placeholder="Last Name">
                    @error('lastname')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputDOB">Date of Birth</label>
                    <input type="date" class="form-control" id="inputDOB" name="DOB" value="{{ old('DOB', $employee->DOB) }}" placeholder="Date of Birth">
                    @error('DOB')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputNIC">NIC</label>
                    <input type="text" class="form-control" id="inputNIC" name="NIC" value="{{ old('NIC', $employee->NIC) }}" placeholder="NIC">
                    @error('NIC')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputContactNo">Contact No</label>
                    <input type="text" class="form-control" id="inputContactNo" name="contactno" value="{{ old('contactno', $employee->contactno) }}" placeholder="Contact No">
                    @error('contactno')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="Email" value="{{ old('Email', $employee->Email) }}" placeholder="Email">
                    @error('Email')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" value="{{ old('address', $employee->address) }}" placeholder="Address">
                    @error('address')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity" name="city" value="{{ old('city', $employee->city) }}" placeholder="City">
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputZipCode">Zip Code</label>
                    <input type="text" class="form-control" id="inputZipCode" name="zipecode" value="{{ old('zipecode', $employee->zipecode) }}" placeholder="Zip Code">
                    @error('zipecode')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputStatus">Status</label>
                  <select class="form-control" id="inputStatus" name="status">
                      <option value="1" {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>Inactive</option>
                  </select>
                  @error('status')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
              </form>
            </div>
          </div>
        </div> <!-- / .card-deck -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
</main> <!-- main -->
@endsection
