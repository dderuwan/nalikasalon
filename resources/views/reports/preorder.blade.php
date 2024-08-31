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
                                                <th style="color: black;">Order ID</th>
                                                <th style="color: black;">Customer Code</th>
                                                <th style="color: black;">Service</th>
                                                <th style="color: black;">Package</th>
                                                <th style="color: black;">Appointment Date</th>
                                                <th style="color: black;">Appointment Time</th>
                                                <th style="color: black;">Advanced Price</th>
                                                <th style="color: black;">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($preorders as $gin)
                                            <tr>
                                                <td>{{ $gin->Auto_serial_number }}</td>
                                                <td>{{ $gin->customer_code }}</td>
                                                <td>{{ $gin->Service_type }}</td>
                                                <td>{{ $gin->Package_name_1 }}</td>
                                                <td>{{ $gin->appointment_date }}</td>
                                                <td>{{ $gin->appointment_time }}</td>
                                                <td>{{ $gin->Advanced_price }}</td>
                                                <td>{{ $gin->Total_price }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right">Total:</th>
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

            // Calculate total price
            var total = api.column(7, { page: 'current' }).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

            // Update the total cost in the footer
            $(api.column(7).footer()).html('LKR' + total.toFixed(2));
        }
    });

    $('#filter-date-range').on('click', function() {
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
 
        // Filter the table data based on date range
        var filteredData = @json($preorders).filter(function(order) {
            var orderDate = order.appointment_date;
            return orderDate >= startDate && orderDate <= endDate;
        });

        // Clear existing table data and populate with filtered data
        table.clear();
        filteredData.forEach(function(order) {
            table.row.add([
                order.Auto_serial_number,
                order.customer_code,
                order.Service_type,
                order.Package_name_1,
                order.appointment_date,
                order.appointment_time,
                order.Advanced_price,
                order.Total_price
            ]);
        });
        table.draw();
    });
});

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
