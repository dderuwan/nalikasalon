<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $employees = Employee::paginate(10);
    return view('employee.index', [
        'employees' => $employees
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'DOB' => 'required|date',
            'NIC' => 'required|string|max:20',
            'contactno' => 'required|string|max:20',
            'Email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipecode' => 'required|string|max:10',
            'status' => 'nullable|boolean',
        ]);

        Employee::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'DOB' => $request->DOB,
            'NIC' => $request->NIC,
            'contactno' => $request->contactno,
            'Email' => $request->Email,
            'address' => $request->address,
            'city' => $request->city,
            'zipecode' => $request->zipecode,
            'status' => $request->status == true ? 1 : 0,
        ]);

        return redirect('/employee');
    }
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255',
        'lastname' => 'required|string|max:255',
        'DOB' => 'required|date',
        'NIC' => 'required|string|max:20',
        'contactno' => 'required|string|max:20',
        'Email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'zipecode' => 'required|string|max:10',
        'status' => 'required|boolean',
    ]);

    $employee = Employee::findOrFail($id);
    $employee->update([
        'firstname' => $request->firstname,
        'middlename' => $request->middlename,
        'lastname' => $request->lastname,
        'DOB' => $request->DOB,
        'NIC' => $request->NIC,
        'contactno' => $request->contactno,
        'Email' => $request->Email,
        'address' => $request->address,
        'city' => $request->city,
        'zipecode' => $request->zipecode,
        'status' => $request->status,
    ]);

    return redirect()->route('employee.index')->with('status', 'Employee updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();

            return redirect('/employee')->with('success', 'Employee deleted successfully');
        } else {
            return redirect()->route('employee')->with('error', 'Employee not found.');
        }
}
}
