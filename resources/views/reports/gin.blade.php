@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2>Sales Report</h2>
                        </div>
                    </div>
                    <p class="card-text"></p>
                    <div class="row my-4">
                        <!-- Filter Section -->
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row" id='filter-section'>
                                        <div class="col-md-6">
                                            <h5>Filter Section</h5>
                                        </div>
                                        <div class="col-md-12" id='fil'>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="start-date">From:</label>
                                                    <input type="date" id="start-date" class="form-control">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="end-date">To:</label>
                                                    <input type="date" id="end-date" class="form-control">
                                                </div>
                                                <div class="col-md-2 align-self-end">
                                                    <button class="btn btn-primary" id="filter-date-range">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table id="mydata" class="table">
                                        <thead>
                                            <tr>
                                            <th style="color: black;">Date</th>
                                            <th style="color: black;">GIN Code</th>
                                            <th style="color: black;">Order Request Code</th>
                                            <th style="color: black;">Supplier Code</th>
                                            <th style="color: black;">Total Cost</th>
                                            <th style="color: black;" width="200px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($gins as $gin)
                                            <tr>
                                                <td>{{ $gin->date }}</td>
                                                <td>{{ $gin->gin_code }}</td>
                                                <td>{{ $gin->order_request_code }}</td>
                                                <td>{{ $gin->supplier_code }}</td>
                                                <td>{{ $gin->total_cost_payment }}</td>
                                                <td>
                                                    <!-- Show Button -->
                                                    <a href="{{ route('ginshow', $gin->id) }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-danger" onclick="confirmDelete({{ $gin->id }})"><i class="fe fe-trash fe-16"></i></button>
                                                    <form id="delete-form-{{ $gin->id }}" action="{{ route('gindestroy', $gin->id) }}" method="POST" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align:right">Total:</th>
                                                <th id="totalCost"></th>
                                            </tr>
                                        </tfoot>
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
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Calculate total cost
            var total = api.column(4).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

            // Update the total cost in the footer
            $(api.column(3).footer()).html('LKR ' + total.toFixed(2));
        }
    });

    $('#filter-date-range').on('click', function() {
        var startDate = new Date($('#start-date').val());
        var endDate = new Date($('#end-date').val());
        endDate.setDate(endDate.getDate() + 1); // Include the end date

        var filteredData = @json($gins).filter(function(order) {
            var orderDate = new Date(order.date);
            return orderDate >= startDate && orderDate < endDate;
        }).map(function(order) {
            return [order.date, order.gin_code, order.order_request_code, order.supplier_code, order.total_cost_payment, 
                '<a href="{{ route('showogins', 'ORDER_ID') }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a> \
                 <button class="btn btn-danger" onclick="confirmDelete(ORDER_ID)"><i class="fe fe-trash fe-16"></i></button> \
                 <form id="delete-form-ORDER_ID" action="{{ route('deletegins', 'ORDER_ID') }}" method="POST" style="display:none;"> \
                    @csrf \
                    @method('DELETE') \
                 </form>'
            ].map(cell => cell.replace(/ORDER_ID/g, order.id)); // Replace ORDER_ID placeholder with actual ID
        });

        table.clear().rows.add(filteredData).draw();
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(orderRequestId) {
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
                document.getElementById('delete-form-' + orderRequestId).submit();
            }
        })
    }
</script>

@endsection
