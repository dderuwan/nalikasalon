@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create Item</h1>
        <form action="{{ route('insertitem') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="supplier_code">Supplier *</label>
                <select name="supplier_code" class="form-control" required>
                    <option value="">Select Supplier </option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_code }}">{{ $supplier->supplier_code }}-{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-bordered" id="items-table">
                <thead>
                    <tr>
                        <th style="color: black;">Item Name *</th>
                        <th style="color: black;">Description</th>
                        <th style="color: black;">Selling Price</th>
                        <th style="color: black;">Image</th>
                        <th style="color: black;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][item_name]" class="form-control" required></td>
                        <td><input type="text" name="items[0][item_description]" class="form-control" required></td>
                        <td><input type="text" name="items[0][unit_price]" class="form-control" required></td>
                        <td><input type="file" name="items[0][image]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="add-row">Add New Item</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</main>

<script>
    let rowIndex = 1;

    document.getElementById('add-row').addEventListener('click', function() {
        const table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <tr>
                <td><input type="text" name="items[${rowIndex}][item_name]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][item_description]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][unit_price]" class="form-control" required></td>
                <td><input type="file" name="items[${rowIndex}][image]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>
        `;
        rowIndex++;
    });

    document.getElementById('items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection
