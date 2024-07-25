@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2>Customer Report</h2>
                        </div>
                    </div>
                    <p class="card-text"></p>
                    <div class="row my-4">
                        
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                <table id="mydata" class="table">
                                    <thead>
                                        <tr>
                                        <th>Customer Code</th>
                                        <th>Name</th>
                                        <th>Contact Number 1</th>
                                        <th>Contact Number 2</th>
                                        <th>Address</th>
                                        <th>Date Of Birth</th>
                                        <th>Actions</th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->supplier_code }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->contact_number_1 }}</td>
                                            <td>{{ $customer->contact_number_2 }}</td>
                                            <td>{{ $customer->address }}</td>
                                            <td>{{ $customer->date_of_birth }}</td>
                                            <td>

                                                <!-- Delete Button -->
                                                <button class="btn btn-danger" onclick="confirmDelete({{ $customer->id }})"><i class="fe fe-trash fe-16"></i></button>
                                                <form id="delete-form-{{ $customer->id }}" action="{{ route('customerdestroy', $customer->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



<script>
$(document).ready(function() {
    var table = $('#mydata').DataTable({
        dom: 'Bfrtip', // Layout for DataTables with Buttons
        buttons: [
            {
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'csvHtml5',
                footer: true
            },
            {
                extend: 'pdfHtml5',
                footer: true,
                customize: function (doc) {
                    // Set a margin for the footer
                    doc.content[1].margin = [0, 0, 0, 20];
                }
            },
            {
                extend: 'print',
                footer: true
            }
        ],
        
    });

    
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(supplier_code) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + supplier_code).submit();
            }
        })
    }
</script>

@endsection
