<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\TimeSlot;
use App\Models\TimeSlotBridel;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;



class AppointmentController extends Controller
{
    public function showCustomers()
    {
        $customers = Customer::all();
        $services = Service::all();
        $packages = Package::all();
        $timeSlots = TimeSlot::all();
        $timeSlotsBridels = TimeSlotBridel::all();

        //dd($timeSlots);
        $roleId = 4;
        $employees = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        $roleId2 = 5;
        $assemployees = Employee::whereHas('roles', function ($query) use ($roleId2) {
            $query->where('role_id', $roleId2);
        })->get();

        
        return view('appointment.new_appointment', compact('customers', 'services', 'packages','timeSlots','employees','assemployees','timeSlotsBridels'));
    }



    public function getAvailableTimeSlots(Request $request)
{
    $date = $request->input('date');
    $serviceId = $request->input('service_id'); // Added service_id parameter
    $roleId = 4; // Main dresser role ID
    
    // Get all main dresser IDs
    $employees = Employee::whereHas('roles', function ($query) use ($roleId) {
        $query->where('role_id', $roleId);
    })->pluck('id');
    
    // Initialize array to hold available time slots
    $availableTimeSlots = [];

    if ($serviceId == 'SERVICE-5284') {
        // Fetch all time slots for bridal service
        $timeSlotsBridals = TimeSlotBridel::all();

        foreach ($timeSlotsBridals as $bridalSlot) {
            // Check if the time slot is fully booked
            $isFullyBooked = Schedule::whereIn('employee_id', $employees)
                ->where('date', $date)
                ->where('time_slot', $bridalSlot->time_range)
                ->where('is_booked', true)
                ->count() == $employees->count();

            // If the time slot is not fully booked, add it to the available time slots
            if (!$isFullyBooked) {
                $availableTimeSlots[] = $bridalSlot->time_range;
            }
        }
    } else {
        // Fetch all regular time slots
        $timeSlots = TimeSlot::all();

        foreach ($timeSlots as $timeSlot) {
            // Check if the time slot is fully booked
            $isFullyBooked = Schedule::whereIn('employee_id', $employees)
                ->where('date', $date)
                ->where('time_slot', $timeSlot->time_range)
                ->where('is_booked', true)
                ->count() == $employees->count();

            // If the time slot is not fully booked, add it to the available time slots
            if (!$isFullyBooked) {
                $availableTimeSlots[] = $timeSlot->time_range;
            }
        }
    }

    // If no bookings exist, all time slots should be available
    if (Schedule::where('date', $date)->count() == 0) {
        if ($serviceId == 'SERVICE-5284') {
            $availableTimeSlots = TimeSlotBridel::pluck('time_range')->toArray();
        } else {
            $availableTimeSlots = TimeSlot::pluck('time_range')->toArray();
        }
    }
    
    // Log the available time slots
    Log::debug('Available Time Slots:', $availableTimeSlots);

    // Return available time slots as JSON response
    return response()->json(['available_time_slots' => $availableTimeSlots]);
}

    
    public function getAvailableMainDressers(Request $request)
    {
        $date = $request->input('date');
        $timeSlot = $request->input('time_slot');
        $roleId = 4;

        $availableDressers = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->whereDoesntHave('schedules', function ($query) use ($date, $timeSlot) {
            $query->where('date', $date)
                  ->where('time_slot', $timeSlot)
                  ->where('is_booked', true);
        })->get();

        return response()->json(['available_dressers' => $availableDressers]);
    }

    public function getAvailableAssistants(Request $request)
    {
        $date = $request->input('date');
        $timeSlot = $request->input('time_slot');
        $roleId = 5;

        $availableAssistants = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->whereDoesntHave('schedules', function ($query) use ($date, $timeSlot) {
            $query->where('date', $date)
                ->where('time_slot', $timeSlot)
                ->where('is_booked', true);
        })->get();

        return response()->json(['available_assistants' => $availableAssistants]);
    }



    public function showAppoinmentsss()
    {
        $appointments = Preorder::all(); 
        return view('appointment.index', compact('appointments'));
    }

    public function showPreOrders()
    {
        $appointments = Preorder::all(); 
        return view('appointment.preorderList', compact('appointments'));
    }
    

    public function showPreOrderDetails($id)
    {
        $preorder = Preorder::findOrFail($id);
        return view('appointment.showPreOrderDetails', compact('preorder'));
    }



    public function getCustomerDetails($customer_code)
    {
        $customer = Customer::where('customer_code', $customer_code)->first();

        if ($customer) {
            return response()->json([
                'name' => $customer->name,
                'contact_number_1' => $customer->contact_number_1,
                'contact_number_2' => $customer->contact_number_2,
                'address' => $customer->address,
                'date_of_birth' => $customer->date_of_birth,
            ]);
        }

        return response()->json([], 404);
    }

    public function storeAppointments(Request $request)
    {
        $request->validate([
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'start_date' => 'required|date',
            'appointment_time' => 'required|string',
            'main_dresser' => 'required|string',
            'payment_method' => 'required|string',
            'advanced_payment' => 'required|numeric',
        ]);
    
        $preorder = null; // Initialize preorder variable
    
        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = Preorder::create([
                    'Auto_serial_number' => $this->generateAutoSerial(),
                    'booking_reference_number' => $this->generateBookingRef(),
                    'customer_code' => $request->customer_id,
                    'customer_name' => $request->customer_name,
                    'customer_contact_1' => $request->contact_number_1,
                    'customer_address' => $request->customer_address,
                    'customer_dob' => $request->customer_dob,
                    'Service_type' => $request->service_id,
                    'Package_name_1' => $request->package_id_1,
                    'Package_name_2' => $request->package_id_2,
                    'Package_name_3' => $request->package_id_3,
                    'appointment_date' => $request->start_date,
                    'today' => Carbon::today(),
                    'appointment_time' => $request->appointment_time,
                    'main_job_holder' => $request->main_dresser,
                    'Assistant_1' => $request->assistant_1_name,
                    'Assistant_2' => $request->assistant_2_name,
                    'Assistant_3' => $request->assistant_3_name,
                    'note' => $request->note,
                    'payment_type' => $request->payment_method,
                    'Advanced_price' => $request->advanced_payment,
                    'Total_price' => $request->total_price,
                    'status' => 'pending',
                ]);
    
                \Log::info('Preorder created:', ['preorder' => $preorder]);
    
                // Save the schedule for the main dresser and assistants
                $employees = [$request->main_dresser];
                if (!empty($request->assistant_1_name)) {
                    $employees[] = $request->assistant_1_name;
                }
                if (!empty($request->assistant_2_name)) {
                    $employees[] = $request->assistant_2_name;
                }
                if (!empty($request->assistant_3_name)) {
                    $employees[] = $request->assistant_3_name;
                }
    
                foreach ($employees as $employee) {
                    Schedule::create([
                        'employee_id' => $employee,
                        'date' => $request->start_date,
                        'time_slot' => $request->appointment_time,
                        'is_booked' => true,
                    ]);
                }
    
                \Log::info('Schedules updated for employees');
            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    
        if ($preorder) {
            return redirect()->route('printAndRedirect', ['id' => $preorder->id]);
        } else {
            return redirect()->route('Appoinments')->withErrors('Failed to create appointment.');
        }
    }
    

private function generateAutoSerial()
{
    return 'ASN-' . rand(1000, 9999);
}

private function generateBookingRef()
{
    return 'BREF-' . rand(1000, 9999);
}


    public function getPackagesByService(Request $request)
    {
        $serviceCode = $request->input('service_code');
        $packages = Package::where('services_id', $serviceCode)->get();
        return response()->json(['packages' => $packages]);
    }

    public function printAndRedirect($id)
    {
        $preorder = Preorder::findOrFail($id);
        return view('appointment.print', compact('preorder'));
    }

    public function getPreorders()
    {
        $preorders = Preorder::all(['appointment_date as start', 'customer_name as title']);
        return response()->json($preorders);
    }

    public function customerstore(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number_1' => 'required|string|max:20',
            'contact_number_2' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);
        
        try {
            $customer = new Customer();
            $customer->name = $validatedData['name'];
            $customer->contact_number_1 = $validatedData['contact_number_1'];
            $customer->contact_number_2 = $validatedData['contact_number_2'];
            $customer->address = $validatedData['address'];
            $customer->date_of_birth = $validatedData['date_of_birth'];
            $customer->supplier_code = 'CUS' . strtoupper(uniqid()); // Generate supplier code
            $customer->save();
            
            notify()->success('Customer Registerd successfully. ⚡️', 'Success');
            return redirect()->route('new_appointment')->with('success', 'Customer Registerd successfully.');

        } catch (ModelNotFoundException $e) {

            notify()->success('Customer not Found. ⚡️', 'Fail');
            return redirect()->route('new_appointment')->withErrors(['error' => 'Customer not found.']);
        } catch (Exception $e) {
            
            notify()->success('Failed to update Customer. ⚡️', 'Fail');
            return redirect()->route('new_appointment')->withErrors(['error' => 'Failed to update Customer.']);
        }
    }
    
}
