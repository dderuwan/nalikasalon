@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Item Details</h2>
        <div class="mb-3">
            <a href="{{ route('allitems') }}" class="btn btn-secondary"><i class="fe fe-arrow-left fe-16"></i></a>
            <a href="{{ route('edititem', $item->id) }}" class="btn btn-primary"><i class="fe fe-edit fe-16"></i></a>
            <form action="{{ route('deleteitem', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger"><i class="fe fe-trash fe-16"></i></button>
            </form>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Item Code</th>
                <td>{{ $item->item_code }}</td>
            </tr>
            <tr>
                <th>Item Name</th>
                <td>{{ $item->item_name }}</td>
            </tr>
            <tr>
                <th>Item Description</th>
                <td>{{ $item->item_description }}</td>
            </tr>
            <tr>
                <th>Unit Price</th>
                <td>{{ $item->unit_price }}</td>
            </tr>
            <tr>
                <th>Supplier Code</th>
                <td>{{ $item->supplier_code }}</td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    @if($item->image)
                        <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}" style="max-width: 200px;">
                    @else
                        No image available
                    @endif
                </td>
            </tr>
        </table>
    </div>
</main>
@endsection
