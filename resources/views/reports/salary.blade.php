@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2>Employee Salary Reports</h2>
                        </div>
                    </div>
                    <p class="card-text"></p>
                    <div class="row my-4">
                        <!-- Filter Section -->
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row" id="filter-section">
                                        <div class="col-md-6">
                                            <h5>Filter Section</h5>
                                        </div>
                                        <div class="col-md-12" id="fil">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="filter-year">Year:</label>
                                                    <input type="number" id="filter-year" class="form-control" min="2000" max="{{ date('Y') }}">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="filter-month">Month:</label>
                                                    <select id="filter-month" class="form-control">
                                                        <option value="">Select Month</option>
                                                        @foreach (range(1, 12) as $month)
                                                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                                                {{ date("F", mktime(0, 0, 0, $month, 1)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                        <!-- Salary Table -->
                        <div class="col-md-13">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table id="salaryTable" class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Days of Work</th>
                                                <th>No Pay Days</th>
                                                <th>No Pay Amount</th>
                                                <th>Salary</th>
                                                <th>Allowance</th>
                                                <th>EPF Deduction</th>
                                                <th>Salary Advance Deduction</th>
                                                <th>Gross Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salaries as $salary)
                                            <tr>
                                                <td>{{ $salary->employee_id }}</td>
                                                <td>{{ $salary->employee->fullname }}</td>
                                                <td>{{ $salary->year }}</td>
                                                <td>{{ date("F", mktime(0, 0, 0, $salary->month, 1)) }}</td>
                                                <td>{{ $salary->days_of_work }}</td>
                                                <td>{{ $salary->no_pay_days }}</td>
                                                <td>{{ $salary->no_pay_amount }}</td>
                                                <td>{{ $salary->salary }}</td>
                                                <td>{{ $salary->allowance }}</td>
                                                <td>{{ $salary->epf_deduction }}</td>
                                                <td>{{ $salary->salary_advance_deduction }}</td>
                                                <td>{{ $salary->gross_salary }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="11" style="text-align:right">Total Gross Salary:</th>
                                                <th id="totalGrossSalary"></th>
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
    var table = $('#salaryTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'csv', 'pdf', 'print'
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Calculate total gross salary
            var total = api.column(11, { page: 'current' }).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

            // Update the total gross salary in the footer
            $(api.column(11).footer()).html('LKR ' + total.toFixed(2));
        }
    });

    // Filter salaries by year and month
    $('#filter-date-range').on('click', function() {
        var year = $('#filter-year').val();
        var month = $('#filter-month').val();

        // Filter the table data based on year and month
        var filteredData = @json($salaries).filter(function(salary) {
            return salary.year == year && salary.month == month;
        });

        // Clear existing table data and populate with filtered data
        table.clear();
        filteredData.forEach(function(salary) {
            table.row.add([
                
                salary.employee.name,
                salary.year,
                salary.month_name,
                salary.days_of_work,
                salary.no_pay_days,
                salary.no_pay_amount,
                salary.salary,
                salary.allowance,
                salary.epf_deduction,
                salary.salary_advance_deduction,
                salary.gross_salary
            ]);
        });
        table.draw();
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
