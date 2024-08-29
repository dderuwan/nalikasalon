<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pluck the roles with the ID as the key and name as the value
        $roles = Role::pluck('name', 'name')->all();
        return view('employee.create', compact('roles'));
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'zipecode' => 'required|string|max:10',
            'status' => 'nullable|boolean',
            'roles' => 'nullable|array',
        ]);


        //dd($request);
        $employee = Employee::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'DOB' => $request->DOB,
            'NIC' => $request->NIC,
            'contactno' => $request->contactno,
            'email' => $request->Email,
            'address' => $request->address,
            'city' => $request->city,
            'password' =>Hash::make($request->password),
            'zipecode' => $request->zipecode,
            'status' => $request->status == true ? 1 : 0,
        ]);

        $employee->syncRoles($request->roles);


        return redirect('employee');
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
    public function edit($id)
    {
        $employee = Employee::findOrFail($id); 
        $roles = Role::all()->pluck('name'); 
        return view('employee.edit', compact('employee', 'roles')); 
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateemp(Request $request, $id)
    {
        
        // Validate the request data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'DOB' => 'required|date',
            'NIC' => 'required|string|max:20',
            'contactno' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipecode' => 'required|string|max:10',
            'status' => 'required|boolean', 
        ]);
        
        // Find the employee by ID or fail
        $employee = Employee::findOrFail($id);

        // Update the employee details
        $data=[
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'DOB' => $request->DOB,
            'NIC' => $request->NIC,
            'contactno' => $request->contactno,
            'Email' => $request->email, 
            'address' => $request->address,
            'city' => $request->city,
            'zipecode' => $request->zipecode,
            'status' => $request->status,
        ];

        if(!empty($request->password)){
            $data += [
                'password'=>Hash::make($request->password),
            ];;
        }

        $employee->update($data);
        $employee->syncRoles($request->roles);

        // Redirect back to the employee index with a success message
        return redirect()->route('employee')->with('status', 'Employee updated successfully');
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
