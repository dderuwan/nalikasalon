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
        $serviceCode = $request->query('service_code'); // For GET, use query() to get query parameters
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


    public function storeAppointments(Request $request)
    {
        $request->validate([
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package' => 'required|string',
            'start_date' => 'required|date',
            'appointment_time' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $preorder = null;

        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Check if the contact number already exists in the customers table
                $customer = Customer::where('contact_number_1', $request->contact_number_1)->first();

                if ($customer) {
                    // If the customer exists, get their customer code
                    $customerCode = $customer->customer_code;
                } else {
                    // If the customer doesn't exist, create a new customer
                    $customerDob = $request->has('date_of_birth') ? $request->input('date_of_birth') : null;

                    $newCustomer = Customer::create([
                        'name' => $request->name,
                        'contact_number_1' => $request->contact_number_1,
                        'contact_number_2' => $request->contact_number_2 ?? null,
                        'address' => $request->address,
                        'date_of_birth' => $customerDob,
                        'customer_code' => $this->generateCustomerCode()
                    ]);

                    $customerCode = $newCustomer->customer_code;
                }

                // Find available main dresser
                $roleIdMainDresser = 4;
                $availableMainDresser = Employee::whereHas('roles', function ($query) use ($roleIdMainDresser) {
                    $query->where('role_id', $roleIdMainDresser);
                })
                ->whereDoesntHave('schedules', function ($query) use ($request) {
                    $query->where('date', $request->start_date)
                        ->where('time_slot', $request->appointment_time);
                })
                ->first();

                // Find available assistant
                $roleIdAssistant = 5;
                $availableAssistant = Employee::whereHas('roles', function ($query) use ($roleIdAssistant) {
                    $query->where('role_id', $roleIdAssistant);
                })
                ->whereDoesntHave('schedules', function ($query) use ($request) {
                    $query->where('date', $request->start_date)
                        ->where('time_slot', $request->appointment_time);
                })
                ->first();

                // If no main dresser is available, you might want to handle it (e.g., show an error)
                if (!$availableMainDresser) {
                    throw new \Exception('No available main dresser for the selected time slot.');
                }

                // Create the preorder
                $preorder = Preorder::create([
                    'Auto_serial_number' => $this->generateAutoSerial(),
                    'booking_reference_number' => $this->generateBookingRef(),
                    'customer_code' => $customerCode,
                    'customer_name' => $request->name,
                    'customer_contact_1' => $request->contact_number_1,
                    'customer_address' => $request->address,
                    'customer_dob' => $customerDob ?? Carbon::today(),
                    'Service_type' => $request->service_id,
                    'Package_name_1' => $request->package,
                    'appointment_date' => $request->start_date,
                    'today' => Carbon::today(),
                    'appointment_time' => $request->appointment_time,
                    'main_job_holder' => $availableMainDresser->id,
                    'Assistant_1' => $availableAssistant ? $availableAssistant->id : null,
                    'note' => $request->note,
                    'payment_type' => $request->payment_method,
                    'Advanced_price' => $request->advance_price,
                    'Total_price' => $request->total_price,
                    'status' => 'pending',
                ]);

                // Log the preorder creation
                \Log::info('Preorder created:', ['preorder' => $preorder]);

                // Save the schedule for the main dresser and assistant
                Schedule::create([
                    'employee_id' => $availableMainDresser->id,
                    'date' => $request->start_date,
                    'time_slot' => $request->appointment_time,
                    'is_booked' => true,
                ]);

                if ($availableAssistant) {
                    Schedule::create([
                        'employee_id' => $availableAssistant->id,
                        'date' => $request->start_date,
                        'time_slot' => $request->appointment_time,
                        'is_booked' => true,
                    ]);
                }

                \Log::info('Schedules updated for main dresser and assistant');
            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        if ($preorder) {
            return redirect()->route('printAndRedirect', ['id' => $preorder->id]);
        } else {
            return redirect()->route('Appointments')->withErrors('Failed to create appointment.');
        }
    }

    public function printAndRedirect($id)
    {
        $preorder = Preorder::findOrFail($id);
        return view('appointment.print3', compact('preorder'));
    }


    // Example method to generate a unique customer code (implement as needed)
    private function generateCustomerCode()
    {
        return 'CUS' . strtoupper(uniqid());
    }

    private function generateAutoSerial()
    {
        return 'ASN-' . rand(1000, 9999);
    }

    private function generateBookingRef()
    {
        return 'BREF-' . rand(1000, 9999);
    }


}
