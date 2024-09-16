@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create New Promotion</h1>
        <form action="{{ route('storePromotion') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="gift_voucher_name">Promotion Name </label>
                <input type="text" id='gift_voucher_name' name="gift_voucher_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Promotion Price </label>
                <input type="text" name="price" class="form-control" >
            </div>
            <label for="or">or</label>

            <div class="form-group">
                <label for="price">Promotion Percentage *</label>
                <input type="text" name="price" class="form-control" >
            </div>
            <div class="form-group">
                <label for="start_date">Start Date *</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date *</label>
                <input type="date" name="end_date" class="form-control" required>
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
