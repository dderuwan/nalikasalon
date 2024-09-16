@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Edit Item</h2>
        <form action="{{ route('updateitem', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $item->id }}">
            
            <div class="form-group">
                <label for="item_code">Item Code</label>
                <input type="text" name="item_code" id="item_code" class="form-control" value="{{ old('item_code', $item->item_code) }}" readonly>
            </div>

            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="form-control" value="{{ old('item_name', $item->item_name) }}" required>
            </div>

            <div class="form-group">
                <label for="item_description">Item Description</label>
                <input type="text" name="item_description" id="item_description" class="form-control" value="{{ old('item_description', $item->item_description) }}" required>
            </div>

            <div class="form-group">
                <label for="unit_price">Unit Price</label>
                <input type="text" name="unit_price" id="unit_price" class="form-control" value="{{ old('unit_price', $item->unit_price) }}" required>
            </div>

            <div class="form-group">
                <label for="shots">Shots</label>
                <input type="text" name="shots" id="shots" class="form-control" value="{{ old('shots', $item->shots) }}" required>
            </div>

            <div class="form-group">
                <label for="supplier_code">Supplier Code</label>
                <select name="supplier_code" id="supplier_code" class="form-control" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_code }}" {{ $supplier->supplier_code == $item->supplier_code ? 'selected' : '' }}>
                        {{ $supplier->supplier_code }}- {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Item Image</label>
                <input type="file" name="image" class="form-control">
                @if($item->image)
                    <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}" style="max-width: 200px; margin-top: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Item</button>
        </form>
    </div>
</main>
@endsection
