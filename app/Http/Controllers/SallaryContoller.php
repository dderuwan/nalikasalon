<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Carbon;


class SallaryContoller extends Controller
{
    public function index()
    {
        $salary = Salary::all();
        return view('salaryManagment.index', compact('salary'));
    }

    public function create()
    {
        $commission = Commission::all();
        $employees = Employee::all();
        return view('salaryManagment.create', compact('commission','employees'));
    }

    public function getAttendanceCount(Request $request)
    {
        $employeeId = $request->query('employee_id');

        // Validate that employeeId is provided
        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

        // Count the total number of attendance records for the given employee ID
        //$totalRecords = Attendance::where('emp_id', $employeeId)->count();

        $totalRecords = Attendance::where('emp_id', $employeeId)
                                  ->whereBetween('date', [$startOfPreviousMonth, $endOfPreviousMonth])
                                  ->count();

        // Return the count in a JSON response
        return response()->json(['days_worked' => $totalRecords]);
    }

    public function getTotalAllowance(Request $request)
    {
        $employeeId = $request->query('employee_id');

        // Validate that employeeId is provided
        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

        // Calculate the total allowance for the given employee ID
        //$totalAllowance = Commission::where('employee_id', $employeeId)->sum('commission_amount');

        $totalAllowance = Commission::where('employee_id', $employeeId)
                                  ->whereBetween('date', [$startOfPreviousMonth, $endOfPreviousMonth])
                                  ->sum('commission_amount');

        // Return the total allowance in a JSON response
        return response()->json(['total_allowance' => $totalAllowance]);
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'salary.*.employee_id' => 'required', // Ensure employee_id exists
            'salary.*.days_of_work' => 'required|numeric',
            'salary.*.no_pay_days' => 'nullable|numeric',
            'salary.*.no_pay_amount' => 'nullable|numeric',
            'salary.*.salary' => 'required|numeric',
            'salary.*.allowance' => 'nullable|numeric',
            'salary.*.epf_deduction' => 'nullable|numeric',
            'salary.*.salary_advance_deduction' => 'nullable|numeric',
            'salary.*.gross_salary' => 'required|numeric',
        ]);
    
        // Get current year and previous month
        $currentYear = date('Y');
        $previousMonth = date('m', strtotime('-1 month'));
    
        // Loop through each salary entry and save it to the database
        foreach ($validatedData['salary'] as $salaryData) {
            // Create or update a salary record in the database
            \App\Models\Salary::updateOrCreate(
                [
                    'employee_id' => $salaryData['employee_id'],
                    'year' => $currentYear,
                    'month' => $previousMonth,
                ],
                [
                    'days_of_work' => $salaryData['days_of_work'],
                    'no_pay_days' => $salaryData['no_pay_days'] ?? 0, // Default to 0 if null
                    'no_pay_amount' => $salaryData['no_pay_amount'] ?? 0, // Default to 0 if null
                    'salary' => $salaryData['salary'],
                    'allowance' => $salaryData['allowance'] ?? 0, // Default to 0 if null
                    'epf_deduction' => $salaryData['epf_deduction'] ?? 0, // Default to 0 if null
                    'salary_advance_deduction' => $salaryData['salary_advance_deduction'] ?? 0, // Default to 0 if null
                    'gross_salary' => $salaryData['gross_salary'],
                ]
            );
        }
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Salary data has been saved successfully.');
    }
    
    

    public function edit($id)
    {
        $salary = Salary::findOrFail($id); 
        $commission = Commission::all();
        $employees = Employee::all(); 
        return view('salaryManagment.edit', compact('salary','commission','employees')); 
    }

    public function updatess(Request $request, $id)
{
    try {
        // Validate incoming data
        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required',
            'gross_salary' => 'required',
        ]);

        // Find the Salary record by primary key (id)
        $voucher = Salary::findOrFail($id);

        // Update the salary record fields
        $voucher->employee_id = $request->employee_id;
        $voucher->year = date('Y');
        $voucher->month = date('m', strtotime('-1 month'));
        $voucher->days_of_work = $request->days_of_work;
        $voucher->no_pay_days = $request->no_pay_days;
        $voucher->no_pay_amount = $request->no_pay_amount;
        $voucher->salary = $request->salary;
        $voucher->allowance = $request->allowance;
        $voucher->epf_deduction = $request->epf_deduction;
        $voucher->salary_advance_deduction = $request->salary_advance_deduction;
        $voucher->gross_salary = $request->gross_salary;

        // Save the updated record
        $voucher->save();

        // Return success message and redirect
        notify()->success('Salary updated successfully. ⚡️', 'Success');
        return redirect()->route('salary')->with('success', 'Salary updated successfully.');

    } catch (Exception $e) {
        return back()->withError($e->getMessage())->withInput();
    }
}


    public function destroy($id)
    {
        $voucher = Salary::find($id);
        if ($voucher) {
            $voucher->delete();

            return redirect('salary')->with('success', 'Salary deleted successfully');
        } else {
            return redirect()->route('salary')->with('error', 'Salary not found.');
        }
    }
}
