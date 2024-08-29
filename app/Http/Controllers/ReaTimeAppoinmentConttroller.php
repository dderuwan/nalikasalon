<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preorder;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\TimeSlot;
use App\Models\TimeSlotBridel;
use App\Models\Schedule;
use App\Models\RealTimeBooking;
use Illuminate\Support\Facades\Log;

class ReaTimeAppoinmentConttroller extends Controller
{
    public function RealTimepage1(){
        $preorders = Preorder::all(); 
        return view('appointment.realtime1', compact('preorders'));
    }

    public function getAppointmentsByCustomer(Request $request)
    {
        $contactNumber = $request->input('contact_number_1');

        if ($contactNumber) {
            // Filter preorders by status 'pending' and the provided contact number
            $preorders = Preorder::where('customer_contact_1', $contactNumber)
                ->where('status', 'pending') // Only select preorders with status 'pending'
                ->get();

            return response()->json($preorders);
        }

        return response()->json([]);
    }


    public function realtime2page()
    {
        $customers = Customer::all();
        $services = Service::all();
        $packages = Package::all();
        $timeSlots = TimeSlot::all();
        $timeSlotsBridels = TimeSlotBridel::all();

        //dd($timeSlots);
        $roleId = 2;
        $employees = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        $roleId2 = 3;
        $assemployees = Employee::whereHas('roles', function ($query) use ($roleId2) {
            $query->where('role_id', $roleId2);
        })->get();

        
        return view('appointment.realtime2', compact('customers', 'services', 'packages','timeSlots','employees','assemployees','timeSlotsBridels'));
    }

    public function getAvailableTime(Request $request)
    {
        $date = now()->toDateString(); // Automatically set to today's date
        $serviceId = $request->input('service_id'); // Added service_id parameter
        $roleId = 2; // Main dresser role ID

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


    public function storerealtime2(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|string',
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'appointment_time' => 'required|string',
            'main_dresser' => 'required|string',
            'assistant_1_name' => 'required|string',
            'payment_method' => 'required|string',
            'total_price' => 'required|numeric',
        ]);
        
        $preorder = null; // Initialize preorder variable

        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = RealTimeBooking::create([
                    'real_time_app_no' => $this->generateRealTime(), 
                    'customer_code' => $request->customer_id,
                    'customer_name' => $request->customer_name,
                    'customer_contact_1' => $request->contact_number_1,
                    'customer_address' => $request->customer_address,
                    'customer_dob' => $request->customer_dob,
                    'Service_type' => $request->service_id,
                    'Package_name_1' => $request->package_id_1,
                    'Package_name_2' => $request->package_id_2,
                    'Package_name_3' => $request->package_id_3,
                    'today' => Carbon::today(),
                    'appointment_time' => $request->appointment_time,
                    'main_job_holder' => $request->main_dresser,
                    'Assistant_1' => $request->assistant_1_name,
                    'Assistant_2' => $request->assistant_2_name,
                    'Assistant_3' => $request->assistant_3_name,
                    'note' => $request->note,
                    'preorder_id'=> NULL,
                    'gift_voucher_No'=> $request->gift_voucher_No,
                    'gift_voucher_price'=> $request->gift_voucher_price,
                    'promotional_code_No'=> $request->promotional_code_No,
                    'promotional_price'=> $request->promotional_price,
                    'payment_type' => $request->payment_method,
                    'Advanced_price' => 0,
                    'Total_discount'=> $request->discount,
                    'vat'=> 0,
                    'Total_price' => $request->total_price,
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
                        'date' => Carbon::today(),
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
            return redirect()->route('printAndRedirectReal', ['id' => $preorder->id]);
        } else {
            return redirect()->route('RealTimepage1')->withErrors('Failed to create appointment.');
        }
    }


    private function generateRealTime()
    {
        return 'RTO-'  . rand(1000, 9999);
    }

    public function printAndRedirectReal($id)
    {
        $preorder = RealTimeBooking::findOrFail($id);
        return view('appointment.print2', compact('preorder'));
    }


    public function realtime3page(Request $request)
    {
        // dd($request); // Uncomment this for debugging to see the incoming request data

        // Retrieve the selected appointment number from the request
        $autoSerialNumber = $request->input('selected_appointment_number');

        // Fetch the preorder details using the Auto_serial_number field
        $preorderDetails = Preorder::where('Auto_serial_number', $autoSerialNumber)->first();

        // Check if preorder details were found
        if (!$preorderDetails) {
            return redirect()->back()->withErrors(['error' => 'Preorder not found.']);
        }

        // Pass the details to the view
        return view('appointment.realtime3', compact('preorderDetails'));
    }


    public function storerealtime34(Request $request)
    {
        //dd($request); 
        $request->validate([
            'customer_code' => 'required|string', 
        ]);
        //dd($request); 
        $preorder = null; // Initialize preorder variable

        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = RealTimeBooking::create([
                    'real_time_app_no' => $this->generateRealTime(), 
                    'customer_code' => $request->customer_code,
                    'customer_name' => $request->customer_name,
                    'customer_contact_1' => $request->customer_contact_1,
                    'customer_address' => $request->customer_address,
                    'customer_dob' => $request->customer_dob,
                    'Service_type' => $request->Service_type,
                    'Package_name_1' => $request->Package_name_1,
                    'Package_name_2' => $request->Package_name_2,
                    'Package_name_3' => $request->Package_name_3,
                    'today' => Carbon::today(),
                    'appointment_time' => $request->selected_time,
                    'main_job_holder' => $request->main_job_holder,
                    'Assistant_1' => $request->Assistant_1,
                    'Assistant_2' => $request->Assistant_2,
                    'Assistant_3' => $request->Assistant_3,
                    'note' => $request->note,
                    'preorder_id'=>  $request->Auto_serial_number,
                    'gift_voucher_No'=> $request->gift_voucher_No,
                    'gift_voucher_price'=> $request->gift_voucher_price,
                    'promotional_code_No'=> $request->promotional_code_No,
                    'promotional_price'=> $request->promotional_price,
                    'payment_type' => $request->payment_method,
                    'Advanced_price' => $request->Advanced_price,
                    'Total_discount'=> $request->discount,
                    'vat'=> 0,
                    'Total_price' => $request->Total_price,
                ]);

                Preorder::where('Auto_serial_number', $request->Auto_serial_number)
                ->update(['status' => 'completed']);

            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        if ($preorder) {
            return redirect()->route('printAndRedirectReal', ['id' => $preorder->id]);
        } else {
            return redirect()->route('RealTimepage1')->withErrors('Failed to create appointment.');
        }
    }


    public function RealTimeOrderList(){
        $realtimeOrders = RealTimeBooking::all(); 
        return view('appointment.realtimeOrderList', compact('realtimeOrders'));
    }



}


