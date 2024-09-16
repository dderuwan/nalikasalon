@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Bridel Item </h1>
        <form action="{{ route('updatebridelItems', $bridelitems->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="service_code">Service *</label>
                <select name="service_code" class="form-control" required>
                    @foreach($BridelSubCategorys as $service)
                        <option value="{{ $service->id }}" {{ $bridelitems->id == $service->id ? 'selected' : '' }}>
                            {{ $service->id }} - {{ $service->subcategory_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            
            <div class="form-group">
                <label for="package_name">Package Name</label>
                <input type="text" name="package_name" class="form-control" value="{{ old('package_name', $bridelitems->Item_name) }}">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" value="{{ old('price', $bridelitems->price) }}">
            </div>

            <div class="form-group">
                <label for="quentity">Quantity</label>
                <input type="text" name="quentity" class="form-control" value="{{ old('quentity', $bridelitems->quentity) }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $bridelitems->description) }}</textarea>
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
