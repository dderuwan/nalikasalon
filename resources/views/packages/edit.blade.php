@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Package</h1>
        <form action="{{ route('updatepackage', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="service_code">Service *</label>
                <select name="service_code" class="form-control" required>
                    @foreach($services as $service)
                        <option value="{{ $service->service_code }}" {{ $package->services_id == $service->service_code ? 'selected' : '' }}>
                            {{ $service->service_code }}-{{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="package_name">Package Name *</label>
                <input type="text" name="package_name" class="form-control" value="{{ old('package_name', $package->package_name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $package->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Selling Price *</label>
                <input type="text" name="price" class="form-control" value="{{ old('price', $package->price) }}" required>
            </div>
            <div class="form-group">
                <label for="sub_categories">Sub Categories</label>
                <select name="sub_categories[]" class="form-control" multiple>
                    @foreach($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}" 
                            {{ in_array($subCategory->id, old('sub_categories', $package->subCategories->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $subCategory->subcategory_name }}
                        </option>
                    @endforeach
                </select>
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
