@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Master Stock</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Description</th>
                    <th>Pack Size</th>
                    <th>Unit Price</th>
                    <th>Supplier Code</th>
                    <th>Image</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->item_description }}</td>
                    <td>{{ $item->pack_size }}</td>
                    <td>{{ $item->unit_price }}</td>
                    <td>{{ $item->supplier_code }}</td>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}" style="width: 50px; height: 50px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $item->total_amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
