<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
    
       
        
        public function sendBirthdayWishes()
        {
            // Get today's date in month-day format
            $today = Carbon::today()->format('m-d');
        
            // Get employees whose DOB matches today's date
            $employees = Employee::whereRaw("DATE_FORMAT(DOB, '%m-%d') = ?", [$today])->get();
        
            if ($employees->isEmpty()) {
                \Log::info("No employees have a birthday today.");
                return "No employees have a birthday today.";
            }
        
            foreach ($employees as $employee) {
                // Format the contact number
                $formattedContact = $this->formatContactNumber($employee->contactno);
        
                // Create a birthday message
                $msg = "Hello {$employee->firstname},\n\n"
                     . "🎉 Happy Birthday! 🎉\n"
                     . "We wish you a year filled with joy, success, and happiness.\n\n"
                     . "Thank you for being an amazing part of our team!\n"
                     . "Warm regards,\n"
                     . "The Bridalhouse Team";
        
                // Send the SMS
                $this->sendMessage($formattedContact, $msg);
                
                // Log the birthday SMS sending
                \Log::info("Birthday SMS sent to {$employee->firstname} ({$formattedContact})");
            }
        
            return "Birthday wishes sent to employees.";
        }
        
        // Function to format contact number
        protected function formatContactNumber($contact)
        {
            $contact = preg_replace('/\D/', '', $contact); // Remove any non-digit characters
        
            if (strpos($contact, '0') === 0) {
                $contact = substr($contact, 1); // Remove leading zero
            }
        
            return '94' . $contact; // Add country code (94 for Sri Lanka)
        }
        
        // Function to send the SMS
        protected function sendMessage($contact, $msg)
        {
            $apiToken = env('RICHMO_API_TOKEN');
            $senderName = 'Bridalhouse';
        
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiToken"
            ])->withoutVerifying()->get('https://portal.richmo.lk/api/sms/send/', [
                'dst' => $contact,
                'from' => $senderName,
                'msg' => $msg
            ]);
        
            if ($response->successful()) {
                $responseData = $response->json();
                \Log::info('SMS sent successfully:', $responseData);
        
                if ($responseData['message'] === 'success') {
                    // SMS sent successfully
                } else {
                    \Log::warning('Unexpected response:', $responseData);
                }
            } else {
                $error = $response->json();
                \Log::error('SMS sending failed:', $error);
            }
        }
}

