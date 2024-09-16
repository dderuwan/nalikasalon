@extends('layouts.main.master')

@section('content')
<main role="main" class="main-content">
    <div class="container">
        <h2>Edit Salary</h2>

        <form action="{{ route('updatesalary', [$salary->id]) }}" method="POST" id="salary-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="employee_id">Employee Name</label>
                <select name="employee_id" id="employee_id" class="form-control employee-select" required >
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $employee->id == $salary->employee_id ? 'selected' : '' }}>
                            {{ $employee->getFullNameAttribute() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="days_of_work">Days of Work</label>
                <input type="number" name="days_of_work" id="days_of_work" class="form-control" value="{{ $salary->days_of_work }}" required>
            </div>

            <div class="form-group">
                <label for="no_pay_days">No Pay Days</label>
                <input type="number" name="no_pay_days" id="no_pay_days" class="form-control" value="{{ $salary->no_pay_days ?? '' }}">
            </div>

            <div class="form-group">
                <label for="no_pay_amount">No Pay Amount</label>
                <input type="number" name="no_pay_amount" id="no_pay_amount" class="form-control" value="{{ $salary->no_pay_amount ?? '' }}">
            </div>

            <div class="form-group">
                <label for="salaryid">Salary</label>
                <input type="number" name="salary" id="salaryid" class="form-control" value="{{ $salary->salary }}" required>
            </div>

            <div class="form-group">
                <label for="allowance">Allowance</label>
                <input type="number" name="allowance" id="allowance" class="form-control" value="{{ $salary->allowance ?? '' }}">
            </div>

            <div class="form-group">
                <label for="epf_deduction">EPF Deduction</label>
                <input type="number" name="epf_deduction" id="epf_deduction" class="form-control" value="{{ $salary->epf_deduction ?? '' }}">
            </div>

            <div class="form-group">
                <label for="salary_advance_deduction">Salary Advance Deduction</label>
                <input type="number" name="salary_advance_deduction" id="salary_advance_deduction" class="form-control" value="{{ $salary->salary_advance_deduction ?? '' }}">
            </div>

            <div class="form-group">
                <label for="gross_salary">Gross Salary</label>
                <input type="number" name="gross_salary" id="gross_salary" class="form-control" value="{{ $salary->gross_salary }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update Salary</button>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Handle employee selection change event
    document.getElementById('employee_id').addEventListener('change', function() {
        const employeeId = this.value;

        if (employeeId) {
            // Fetch attendance count for the selected employee
            fetch(`/get-employee-attendance-count?employee_id=${employeeId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the days of work input field with the count of days worked
                    document.getElementById('days_of_work').value = data.days_worked;
                })
                .catch(error => {
                    console.error('Error fetching attendance count:', error);
                });

            // Fetch total allowance for the selected employee
            fetch(`/get-employee-total-allowance?employee_id=${employeeId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the allowance input field with the total allowance
                    document.getElementById('allowance').value = data.total_allowance;
                })
                .catch(error => {
                    console.error('Error fetching total allowance:', error);
                });
        }
    });

    // Handle dynamic gross salary calculation
    document.addEventListener('DOMContentLoaded', function() {
        const salaryInput = document.getElementById('salaryid');
        const allowanceInput = document.getElementById('allowance');
        const noPayAmountInput = document.getElementById('no_pay_amount');
        const salaryAdvanceDeductionInput = document.getElementById('salary_advance_deduction');
        const epfDeductionInput = document.getElementById('epf_deduction');
        const grossSalaryInput = document.getElementById('gross_salary');

        // Function to calculate and update the gross salary
        function updateGrossSalary() {
            const salary = parseFloat(salaryInput.value) || 0;
            const allowance = parseFloat(allowanceInput.value) || 0;
            const noPayAmount = parseFloat(noPayAmountInput.value) || 0;
            const salaryAdvanceDeduction = parseFloat(salaryAdvanceDeductionInput.value) || 0;
            const epfDeduction = parseFloat(epfDeductionInput.value) || 0;

            // Calculate gross salary
            const grossSalary = (salary + allowance) - (noPayAmount + salaryAdvanceDeduction + epfDeduction);

            // Update the gross salary field
            grossSalaryInput.value = grossSalary.toFixed(2);
        }

        // Add event listeners to all input fields that affect the gross salary calculation
        salaryInput.addEventListener('input', updateGrossSalary);
        allowanceInput.addEventListener('input', updateGrossSalary);
        noPayAmountInput.addEventListener('input', updateGrossSalary);
        salaryAdvanceDeductionInput.addEventListener('input', updateGrossSalary);
        epfDeductionInput.addEventListener('input', updateGrossSalary);
    });


</script>
@endsection
