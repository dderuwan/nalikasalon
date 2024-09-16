@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-4">

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
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Company Details</strong></h3>
          </div>
          <div class="card-body">
            <!-- Display company details -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Title:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->title ?? 'No Title Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Address:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->address ?? 'No Address Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Email:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->email ?? 'No Email Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Contact:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->contact ?? 'No Contact Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Logo:</label>
              <div class="col-sm-8">
                @if($companyDetail && $companyDetail->logo)
                    <img src="{{ asset('images/logos/' . $companyDetail->logo) }}" class="img-thumbnail" style="max-width: 100px;">
                @else
                    <p>No Logo Available</p>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Website:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->website ?? 'No Website Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Powered By Text:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->poweredbytext ?? 'No Powered By Text Available' }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" style="color:black;">Footer Text:</label>
              <div class="col-sm-8">
                <p>{{ $companyDetail->footertext ?? 'No Footer Text Available' }}</p>
              </div>
            </div>

            <!-- Edit Button -->
            <div class="form-group row">
              <div class="col-sm-10 mt-5">
                <a href="{{ route('company.edit', $companyDetail->id) }}" class="btn btn-primary">Edit</a>
              </div>
            </div>

          </div>
        </div>

        

      </div>
    </div>
  </div>
</main>

@endsection
