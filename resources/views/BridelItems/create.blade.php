@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create Bridel Item</h1>
        <form action="{{ route('storebridelItems') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="service_code">Bridel Sub Category *</label>
                <select name="service_code" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($BridelSubCategorys as $service)
                        <option value="{{ $service->id }}">{{ $service->subcategory_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Item_name">Item Name *</label>
                <input type="text" name="Item_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price"> Price </label>
                <input type="text" name="price" class="form-control" >
            </div>
            <div class="form-group">
                <label for="quentity"> Quentity </label>
                <input type="text" name="quentity" class="form-control" >
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
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
