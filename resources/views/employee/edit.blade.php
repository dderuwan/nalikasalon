@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="page-title">Edit Employee</h2>
        <p class="text-muted"></p>

        <div class="card-deck"> 
          <div class="card shadow mb-4">
            <div class="card-header">
              <strong class="card-title">Edit Employee</strong>
            </div>
            <div class="card-body">
              <form method="post" action="{{ route('updateemp', $employee->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="firstname" value="{{ old('firstname', $employee->firstname) }}" placeholder="First Name">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputMiddleName">Middle Name</label>
                    <input type="text" class="form-control" id="inputMiddleName" name="middlename" value="{{ old('middlename', $employee->middlename) }}" placeholder="Middle Name">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="lastname" value="{{ old('lastname', $employee->lastname) }}" placeholder="Last Name">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputDOB">Date of Birth</label>
                    <input type="date" class="form-control" id="inputDOB" name="DOB" value="{{ old('DOB', $employee->DOB) }}" placeholder="Date of Birth">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputNIC">NIC</label>
                    <input type="text" class="form-control" id="inputNIC" name="NIC" value="{{ old('NIC', $employee->NIC) }}" placeholder="NIC">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputContactNo">Contact No</label>
                    <input type="text" class="form-control" id="inputContactNo" name="contactno" value="{{ old('contactno', $employee->contactno) }}" placeholder="Contact No">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="Email" value="{{ old('Email', $employee->email) }}" placeholder="Email">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" value="{{ old('address', $employee->address) }}" placeholder="Address">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity" name="city" value="{{ old('city', $employee->city) }}" placeholder="City">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputZipCode">Zip Code</label>
                    <input type="text" class="form-control" id="inputZipCode" name="zipecode" value="{{ old('zipecode', $employee->zipecode) }}" placeholder="Zip Code">
                  </div>
                </div>

                <!-- Password -->
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <x-input-label for="password" :value="__('Password *')" />
                    <x-text-input id="password" class="form-control"
                                    type="password"
                                    name="password"
                                    autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                  </div>

                  <!-- Confirm Password -->
                  <div class="form-group col-md-6">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password *')" />
                    <x-text-input id="password_confirmation" class="form-control"
                                    type="password"
                                    name="password_confirmation" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="roles">Roles</label>
                  <select name="roles[]" class="form-control" multiple>
                      <option value="">Select Role</option>
                      @foreach($roles as $role)
                          <option value="{{ $role }}" {{ in_array($role, $employee->roles->pluck('name')->toArray()) ? 'selected' : '' }}>{{ $role }}</option>
                      @endforeach
                  </select>
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
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
</main> <!-- main -->
@endsection
