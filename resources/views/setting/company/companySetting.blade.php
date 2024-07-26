@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center p-4">
      <div class="col-12">
        <div class="card shadow mb-4 p-2 pl-3">
          <div class="card-header">
            <h3><strong class="card-title">Manage Company</strong></h3>
          </div>
          <div class="card-body">
            <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <label for="inputTitle" class="col-sm-2 col-form-label" style="color:black;"> Title <i class="text-danger">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" value="{{ $companyDetail->title ?? '' }}" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputAddress" class="col-sm-2 col-form-label" style="color:black;">Address</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputAddress" name="address" placeholder="Address" value="{{ $companyDetail->address ?? '' }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="color:black;">Email</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" value="{{ $companyDetail->email ?? '' }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputContact" class="col-sm-2 col-form-label" style="color:black;">Contact</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputContact" name="contact" placeholder="Contact Number" value="{{ $companyDetail->contact ?? '' }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputFile" class="col-sm-2 col-form-label" style="color:black;">Logo</label>
                <div class="col-sm-8">
                      <br>
                      @if($companyDetail && $companyDetail->logo)
                          <img src="{{ asset('images/logos/' . $companyDetail->logo) }}" class="img-thumbnail" style="max-width: 100px;">
                      @else
                          <p>No logo available</p>
                      @endif
                      <br>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputFile" name="logo" accept="image/*" onchange="updateImageLabel(this)">
                    <label class="custom-file-label" for="inputFile">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputWebsite" class="col-sm-2 col-form-label" style="color:black;">Website</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputWebsite" name="website" placeholder="Website" value="{{ $companyDetail->website ?? '' }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPoweredByText" class="col-sm-2 col-form-label" style="color:black;">Powered By Text</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputPoweredByText" name="poweredByText" placeholder="Powered By Text" value="{{ $companyDetail->poweredbytext ?? '' }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputFootertext" class="col-sm-2 col-form-label" style="color:black;">Footer Text</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputFootertext" name="footertext" placeholder="Footer Text" value="{{ $companyDetail->footertext ?? '' }}">
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
