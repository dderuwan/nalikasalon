@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Service</h1>
        <form action="{{ route('updateservices', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="service_name">Service Name *</label>
                <input type="text" name="service_name" class="form-control" value="{{ old('service_name', $service->service_name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $service->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
                @if($service->image)
                    <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->service_name }}" style="height: 100px; margin-top: 10px;">
                @endif
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</main>
@endsection
