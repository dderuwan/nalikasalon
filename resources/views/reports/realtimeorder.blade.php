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
                                                <th style="color: black;">Order ID</th>
                                                <th style="color: black;">Customer Code</th>
                                                <th style="color: black;">Service</th>
                                                <th style="color: black;">Package</th>
                                                <th style="color: black;">Appointment Time</th>
                                                <th style="color: black;">Pre Order Id</th>
                                                <th style="color: black;">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($realtime as $gin)
                                            <tr>
                                                <td>{{ $gin->today }}</td>
                                                <td>{{ $gin->real_time_app_no }}</td>
                                                <td>{{ $gin->customer_code }}</td>
                                                <td>{{ $gin->Service_type }}</td>
                                                <td>{{ $gin->Package_name_1 }}</td>
                                                <td>{{ $gin->appointment_time }}</td>
                                                <td>{{ $gin->preorder_id }}</td>
                                                <td>{{ $gin->Total_price }}</td>
                                                
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7" style="text-align:right">Total:</th>
                                                <th colspan="2" id="totalCost"></th>
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
                'copy', 'excel', 'csv', 'pdf', 'print'
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Calculate the total across all pages
                var total = api.column(7, { page: 'current' }).data().reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

                // Update the footer with the total
                $(api.column(7).footer()).html('LKR ' + total.toFixed(2));
            }
        });

        // Filter the table based on date range
        $('#filter-date-range').on('click', function() {
            var startDate = new Date($('#start-date').val());
            var endDate = new Date($('#end-date').val());
            endDate.setDate(endDate.getDate() + 1); // Include the end date

            var filteredData = @json($realtime).filter(function(order) {
                var orderDate = new Date(order.today);
                return orderDate >= startDate && orderDate < endDate;
            }).map(function(order) {
                return [
                    order.today, 
                    order.real_time_app_no, 
                    order.customer_code, 
                    order.Service_type, 
                    order.Package_name_1, 
                    order.appointment_time, 
                    order.preorder_id, 
                    order.Total_price,
                    '<a href="{{ route('ginshow', 'ORDER_ID') }}" class="btn btn-secondary"><i class="fe fe-eye fe-16"></i></a>' +
                    '<button class="btn btn-danger" onclick="confirmDelete(ORDER_ID)"><i class="fe fe-trash fe-16"></i></button>' +
                    '<form id="delete-form-ORDER_ID" action="{{ route('gindestroy', 'ORDER_ID') }}" method="POST" style="display:none;">' +
                        '@csrf @method('DELETE')' +
                    '</form>'
                ].map(cell => cell.replace(/ORDER_ID/g, order.id));
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
