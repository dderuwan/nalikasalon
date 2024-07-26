@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h1>Create Service</h1>
        <form action="{{ route('storeservices') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" id="services-table">
                <thead>
                    <tr>
                        <th>Service Name *</th>
                        <th>Description *</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="services[0][service_name]" class="form-control" required></td>
                        <td><input type="text" name="services[0][description]" class="form-control" required></td>
                        <td><input type="file" name="services[0][image]" class="form-control"></td>
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
        const table = document.getElementById('services-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <tr>
                <td><input type="text" name="services[${rowIndex}][service_name]" class="form-control" required></td>
                <td><input type="text" name="services[${rowIndex}][description]" class="form-control" required></td>
                <td><input type="file" name="services[${rowIndex}][image]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>
        `;
        rowIndex++;
    });

    document.getElementById('services-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection
