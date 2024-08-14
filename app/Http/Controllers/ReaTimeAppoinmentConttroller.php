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
        $contactNumber = $request->contact_number_1;

        $appointments = Preorder::where('customer_contact_1', $contactNumber)
            ->select('booking_reference_number', 'appointment_date', 'appointment_time')
            ->get();

        return response()->json($appointments);
    }

    public function realtime2page()
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

        
        return view('appointment.realtime2', compact('customers', 'services', 'packages','timeSlots','employees','assemployees','timeSlotsBridels'));
    }

    public function getAvailableTime(Request $request)
    {
        $date = now()->toDateString(); // Automatically set to today's date
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


    public function storerealtime2(Request $request)
    {
        dd($request);
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
                $realTimeBooking = RealTimeBooking::create([
                    'real_time_app_no' => $this->generateAutoSerial(), 
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
                    'preorder_id'=> $request->preorder_id,
                    'Advanced_price'=> $request->advanced_payment,
                    'gift_voucher_No'=> $request->advanced_payment,
                    'gift_voucher_price'=> $request->advanced_payment,
                    'promotional_code_No'=> $request->advanced_payment,
                    'promotional_price'=> $request->advanced_payment,
                    'payment_type' => $request->payment_method,
                    'Advanced_price' => $request->advanced_payment,
                    'Total discount'=> $request->advanced_payment,
                    'vat'=> $request->advanced_payment,
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


}


