@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2>Monthly Financial Report</h2>

                            <!-- Date Range Picker Form -->
                            <form action="{{ route('report.generate') }}" method="GET">
                                <div class="row mb-5">
                                    <div class="col-md-4">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                    
                                </div>
                            </form>

                            @if(isset($reportData))
                            <form action="{{ route('report.saveManualEntries') }}" method="POST">
                                @csrf
                                <table id="financialReportTable" class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Amount (LKR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Item Sales Income</td>
                                            <td>{{ $reportData['itemSales'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bridal Pre Bookings Income</td>
                                            <td>{{ $reportData['totalAdvancePriceToday'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bridal Closed Appointment Income</td>
                                            <td>{{ $reportData['totalbalancedPriceToday'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Salon Appointment Income</td>
                                            <td>{{ $reportData['salonIncome'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Other Incomes
                                                <input type="number" step="0.01" name="other_incomes" class="form-control" value="{{ old('other_incomes', $reportData['otherIncomes']) }}">
                                            </td>
                                            <td>{{ $reportData['otherIncomes'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Operating Expenses
                                                <input type="number" step="0.01" name="operational_cost" class="form-control" value="{{ old('operational_cost', $reportData['operationalCost']) }}">
                                            </td>
                                            <td>{{ $reportData['operationalCost'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Other Expenses
                                                <input type="number" step="0.01" name="other_expenses" class="form-control" value="{{ old('other_expenses', $reportData['otherExpenses']) }}">
                                            </td>
                                            <td>{{ $reportData['otherExpenses'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Income</strong></td>
                                            <td>{{ $reportData['totalIncome'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Expenses</strong></td>
                                            <td>{{ $reportData['totalExpenses'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Net Profit/Loss</strong></td>
                                            <td>{{ $reportData['netProfitOrLoss'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary mt-3">Save Manual Entries</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- DataTables and Buttons JS/CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    $('#financialReportTable').DataTable({
        dom: 'Bfrtip', // Define where buttons will appear
        buttons: [
            'copy',      // For copy to clipboard
            'excel',     // For Excel export
            'csv',       // For CSV export
            'pdf',       // For PDF export
            'print'      // For printing
        ]
    });
});
</script>
@endsection
