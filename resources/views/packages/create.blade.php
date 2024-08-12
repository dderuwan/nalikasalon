@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create Package</h1>
        <form action="{{ route('storepackages') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="service_code">Service *</label>
                <select name="service_code" class="form-control" required>
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->service_code }}">{{ $service->service_code }}-{{ $service->service_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="package_name">Package Name *</label>
                <input type="text" name="package_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Selling Price *</label>
                <input type="text" name="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</main>

<!-- CKEditor CSS -->
<link href="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.css" rel="stylesheet">
@endsection

@section('scripts')
<!-- CKEditor JS -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
