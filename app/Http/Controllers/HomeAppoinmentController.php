<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use App\Models\Preorder;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\TimeSlot;
use App\Models\TimeSlotBridel;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class HomeAppoinmentController extends Controller
{
    public function showApp()
    {
        
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

        
        return view('appoinments', compact( 'services', 'packages','timeSlots','employees','assemployees','timeSlotsBridels'));
    }

    public function getPackagesByService(Request $request)
    {
        $serviceCode = $request->input('service_code');
        $packages = Package::where('services_id', $serviceCode)->get();
        return response()->json(['packages' => $packages]);
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

    public function getPackagePrice(Request $request)
    {
        $packageId = $request->input('package_id');
        $package = Package::find($packageId);
        
        return response()->json(['price' => $package->price]);
    }

    public function storeAppointments(Request $request){
        dd($request);
    }

}
