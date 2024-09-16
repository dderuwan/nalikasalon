@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Edit Gift Voucher</h1>
        <form action="{{ route('updatePromotion', $giftVoucher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="gift_voucher_Id">promotions Code </label>
                <input type="text" id='gift_voucher_Id' name="gift_voucher_Id" class="form-control" value="{{ $giftVoucher->promotions_Id }}" readonly>
            </div>
            <div class="form-group">
                <label for="gift_voucher_name">Name </label>
                <input type="text" id='gift_voucher_name' name="gift_voucher_name" class="form-control" value="{{ $giftVoucher->promotions_name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $giftVoucher->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Selling Price *</label>
                <input type="text" name="price" class="form-control" value="{{ $giftVoucher->price }}" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date *</label>
                <input type="date" name="start_date" class="form-control" value="{{ $giftVoucher->start_date }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date *</label>
                <input type="date" name="end_date" class="form-control" value="{{ $giftVoucher->end_date }}" required>
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
