@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Master Stock</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="color: black;">Image</th>
                    <th style="color: black;">Item Code</th>
                    <th style="color: black;">Item Name</th>
                    <th style="color: black;">Item Description</th>
                    <th style="color: black;">Quantity</th>
                    <th style="color: black;">Unit Price</th>
                    <th style="color: black;">Supplier Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}" style="width: 50px; height: 50px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->item_description }}</td>
                    <td>{{ $item->item_quantity }}</td> 
                    <td>{{ $item->unit_price }}</td>
                    <td>{{ $item->supplier_code }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
