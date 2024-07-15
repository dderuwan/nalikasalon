@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create Order Request</h1>
        <form action="{{ route('orderrequests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="supplier_code">Supplier *</label>
                <select name="supplier_code" class="form-control" id="supplier_code" required>
                    <option value="">Select Supplier</option>
                    @foreach($items->unique('supplier_code') as $item)
                        <option value="{{ $item->supplier_code }}">{{ $item->supplier_code }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-bordered" id="items-table">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>In Stock</th>
                        <th>Quantity *</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="items[0][item_code]" class="form-control item-code-dropdown" required>
                                <option value="">Select Item Code</option>
                            </select>
                        </td>
                        <td><input type="text" name="items[0][instock]" class="form-control" readonly></td>
                        <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
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
                <td>
                    <select name="items[${rowIndex}][item_code]" class="form-control item-code-dropdown" required>
                        <option value="">Select Item Code</option>
                    </select>
                </td>
                <td><input type="text" name="items[${rowIndex}][instock]" class="form-control" readonly></td>
                <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>
        `;

        // Fetch items for the new row
        const supplierCode = document.getElementById('supplier_code').value;
        if (supplierCode) {
            fetch(`/api/get-items/${supplierCode}`)
                .then(response => response.json())
                .then(data => {
                    const itemCodeDropdown = newRow.querySelector('.item-code-dropdown');
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.item_code;
                        option.textContent = item.item_code;
                        itemCodeDropdown.appendChild(option);
                    });
                });
        }

        rowIndex++;
    });

    document.getElementById('items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });

    document.getElementById('supplier_code').addEventListener('change', function() {
        const supplierCode = this.value;
        fetch(`/api/get-items/${supplierCode}`)
            .then(response => response.json())
            .then(data => {
                const itemCodeDropdowns = document.querySelectorAll('.item-code-dropdown');
                itemCodeDropdowns.forEach(dropdown => {
                    const currentSelection = dropdown.value; // Save the current selection
                    dropdown.innerHTML = '<option value="">Select Item Code</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.item_code;
                        option.textContent = item.item_code;
                        dropdown.appendChild(option);
                    });
                    dropdown.value = currentSelection; // Restore the selection
                });
            });
    });

    document.getElementById('items-table').addEventListener('change', function(e) {
        if (e.target.classList.contains('item-code-dropdown')) {
            const itemCode = e.target.value;
            const row = e.target.closest('tr');
            fetch(`/api/get-item-stock/${itemCode}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    row.querySelector('input[name^="items"][name$="[instock]"]').value = data.instock;
            });
        }
    });
</script>
@endsection
