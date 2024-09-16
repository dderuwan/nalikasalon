@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Bridel Sub Package</h1>
        <form action="{{ route('updatebridelsubcategory', $bridelsubcategories->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Include method PUT for update -->

            <div class="form-group">
                <label for="package_name">Sub Package Name *</label>
                <input type="text" name="package_name" class="form-control" value="{{ old('package_name', $bridelsubcategories->subcategory_name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $bridelsubcategories->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
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

