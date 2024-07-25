@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2>Supplier Report</h2>
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
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Account Details</th>
                                        <th>Supplier Code</th>
                                        <th width="280px">Action</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>{{ $supplier->contact_number }}</td>
                                            <td>{{ $supplier->account_details }}</td>
                                            <td>{{ $supplier->supplier_code }}</td>
                                            <td>

                                                <!-- Delete Button -->
                                                <button class="btn btn-danger" onclick="confirmDelete({{ $supplier->id }})"><i class="fe fe-trash fe-16"></i></button>
                                                <form id="delete-form-{{ $supplier->id }}" action="{{ route('supplierdestroy', $supplier->id) }}" method="POST" style="display:none;">
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
