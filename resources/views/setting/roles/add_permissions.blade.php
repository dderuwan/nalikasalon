@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        <h1>Add Permission</h1>
        <form action="{{ route('storePermission') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <div class="form-group row">
                  <label for="inputCategory" class="col-sm-2 col-form-label" style="color:black;">Section Name <i class="text-danger">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="category" name="category" placeholder="category name" required>
                  </div>
                </div>
            </div>
            <table class="table table-bordered" id="items-table">
                <thead>
                    <tr>
                        <th>Permission Name *</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][name]" class="form-control" required></td>
                        <td><input type="text" name="items[0][description]" class="form-control" ></td>
                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="add-row">Add New Permission</button>
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
                <td><input type="text" name="items[${rowIndex}][name]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][description]" class="form-control" ></td>
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
