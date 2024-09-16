@extends('layouts.main.master')

@section('content')

<main role="main" class="main-content">
    <div class="container">
        
        <h2>Salary Management</h2>


        <form action="{{ route('storesalary') }}" method="POST">
            @csrf
            <table class="table table-bordered" id="salary-table">
                <thead>
                    <tr>
                        <th style="color: black;">Employee Name</th>
                        <th style="color: black;">Days of Work</th>
                        <th style="color: black;">No Pay Days</th>
                        <th style="color: black;">No Pay Amount</th>
                        <th style="color: black;">Salary</th>
                        <th style="color: black;">Allowance</th>
                        <th style="color: black;">EPF Deduction</th>
                        <th style="color: black;">Salary Advance Deduction</th>
                        <th style="color: black;">Gross Salary</th>
                        <th style="color: black;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="salary[0][employee_id]" class="form-control employee-select" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->getFullNameAttribute() }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="salary[0][days_of_work]" class="form-control"  readonly></td>
                        <td><input type="number" name="salary[0][no_pay_days]" class="form-control" ></td>
                        <td><input type="number" name="salary[0][no_pay_amount]" class="form-control" ></td>
                        <td><input type="number" name="salary[0][salary]" class="form-control" required></td>
                        <td><input type="number" name="salary[0][allowance]" class="form-control" readonly></td>
                        <td><input type="number" name="salary[0][epf_deduction]" class="form-control"></td>
                        <td><input type="number" name="salary[0][salary_advance_deduction]" class="form-control"></td>
                        <td><input type="number" name="salary[0][gross_salary]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="add-row">Add New Employee</button>
            <button type="submit" class="btn btn-success">Save Salary Data</button>
        </form>
        
    </div>
</main>

<style>
  #card02pre {
    margin-top: 20px;
    padding: 20px 20px 20px 30px;
  }
</style>

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = 1; // Start at 1 for the new rows

    // Add new row
    document.querySelector('#add-row').addEventListener('click', function() {
        const newRow = `
            <tr>
                <td>
                    <select name="salary[${rowIndex}][employee_id]" class="form-control employee-select" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->getFullNameAttribute() }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="salary[${rowIndex}][days_of_work]" class="form-control" required readonly></td>
                <td><input type="number" name="salary[${rowIndex}][no_pay_days]" class="form-control" ></td>
                <td><input type="number" name="salary[${rowIndex}][no_pay_amount]" class="form-control" ></td>
                <td><input type="number" name="salary[${rowIndex}][salary]" class="form-control" required></td>
                <td><input type="number" name="salary[${rowIndex}][allowance]" class="form-control"></td>
                <td><input type="number" name="salary[${rowIndex}][epf_deduction]" class="form-control"></td>
                <td><input type="number" name="salary[${rowIndex}][salary_advance_deduction]" class="form-control"></td>
                <td><input type="number" name="salary[${rowIndex}][gross_salary]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>
        `;

        // Append new row to the table
        document.querySelector('#salary-table tbody').insertAdjacentHTML('beforeend', newRow);
        rowIndex++; // Increment row index
    });

    // Handle dynamic deletion of rows
    document.querySelector('#salary-table').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-row')) {
            const row = event.target.closest('tr');
            row.remove();
        }
    });

    // Handle change event for employee selection
    document.querySelector('#salary-table').addEventListener('change', function(event) {
        if (event.target.classList.contains('employee-select')) {
            const employeeId = event.target.value;
            console.log('Selected Employee ID:', employeeId); // Log the selected employee ID

            if (employeeId) {
                // Fetch attendance count for the previous month
                fetch(`/get-employee-attendance-count?employee_id=${employeeId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Attendance Count:', data.days_worked); // Log the count

                        // Find the row of the changed dropdown
                        const row = event.target.closest('tr');
                        // Get the days worked input field in the same row
                        const daysWorkedInput = row.querySelector('input[name$="[days_of_work]"]');
                        // Update the input field with the count of days worked
                        daysWorkedInput.value = data.days_worked;
                    })
                    .catch(error => {
                        console.error('Error fetching attendance count:', error);
                    });

                // Fetch total allowance
                fetch(`/get-employee-total-allowance?employee_id=${employeeId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Total Allowance:', data.total_allowance); // Log the total allowance

                        // Find the row of the changed dropdown
                        const row = event.target.closest('tr');
                        // Get the allowance input field in the same row
                        const allowanceInput = row.querySelector('input[name$="[allowance]"]');
                        // Update the input field with the total allowance
                        allowanceInput.value = data.total_allowance;
                    })
                    .catch(error => {
                        console.error('Error fetching total allowance:', error);
                    });
            }
        }
    });
});

// Handle dynamic gross salary calculation for each row
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#salary-table').addEventListener('input', function(event) {
        const row = event.target.closest('tr');
        
        const salary = parseFloat(row.querySelector('input[name$="[salary]"]').value) || 0;
        const allowance = parseFloat(row.querySelector('input[name$="[allowance]"]').value) || 0;
        const noPayAmount = parseFloat(row.querySelector('input[name$="[no_pay_amount]"]').value) || 0;
        const salaryAdvanceDeduction = parseFloat(row.querySelector('input[name$="[salary_advance_deduction]"]').value) || 0;
        const epfDeduction = parseFloat(row.querySelector('input[name$="[epf_deduction]"]').value) || 0;

        // Calculate gross salary
        const grossSalary = (salary + allowance) - (noPayAmount + salaryAdvanceDeduction + epfDeduction);

        // Update the gross salary input field in the same row
        row.querySelector('input[name$="[gross_salary]"]').value = grossSalary.toFixed(2);
    });
});
</script>




@endsection
