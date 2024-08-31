@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2>Product Report</h2>
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
                                            <th>Image</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Description</th>
                                            <th>Item Quentity</th>
                                            <th>Unit Price</th>
                                            <th>Supplier Code</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                        <tr>
                                            <td id="items-table-img">
                                                @if($item->image)
                                                    <img src="{{ asset('images/items/' . $item->image) }}" alt="{{ $item->item_name }}" style="width: 50px; height: 50px;">
                                                @else
                                                    No image
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


@endsection
