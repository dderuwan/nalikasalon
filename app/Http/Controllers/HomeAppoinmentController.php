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
use App\Models\SalonThretment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HomeAppoinmentController extends Controller
{
    public function showApp()
    {

        $services = Service::whereIn('service_code', ['SERVICE-7143', 'SERVICE-4463'])->get();
        $packages = Package::all();
        return view('appoinments', compact('services','packages'));
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
    // Validate the request
    $request->validate([
        'service_id' => 'required|string',
        'name' => 'required|string',
        'contact_number_1' => 'required|string',
        'start_date' => 'required|date',
        'appointment_time' => 'required|string',
        'total_price' => 'required|numeric',
    ]);

    $preorder = null; // Initialize preorder variable
    
    // Use a transaction for database operations
    \DB::transaction(function () use ($request, &$preorder) {
        try {
            // Check if customer exists with the provided contact number
            $customer = Customer::where('contact_number_1', $request->contact_number_1)->first();
            
            if (!$customer) {
                // If customer does not exist, create a new one
                $customer = Customer::create([
                    'name' => $request->name, // Use the correct name field
                    'contact_number_1' => $request->contact_number_1,
                    'contact_number_2' => $request->contact_number_2 ?? null, // Optional field
                    'address' => $request->address ?? null, // Optional field
                    'date_of_birth' => $request->date_of_birth ?? null, // Optional field
                    'customer_code' => $this->generateCustomerCode(), // Generate customer code
                ]);
            }
            
            // Create the preorder (SalonThretment) with the retrieved or newly created customer ID
            $preorder = SalonThretment::create([
                'Booking_number' => $this->generateBookingId(),
                'customer_id' => $customer->id, // Use the customer ID, not customer_code
                'customer_name' => $request->name,
                'contact_number_1' => $request->contact_number_1,
                'service_id' => $request->service_id,
                'package_id' => $request->package ?? null, // Ensure package is optional
                'Appoinment_date' => $request->start_date,
                'today' => Carbon::today(),
                'Appointment_time' => $request->appointment_time,
                'note' => $request->note ?? null, // Optional field
                'Main_Dresser' => $request->Main_Dresser ?? null, // Optional field
                'Assistent_Dresser_1' => $request->Assistent_Dresser_1 ?? null, // Optional field
                'Assistent_Dresser_2' => $request->Assistent_Dresser_2 ?? null, // Optional field
                'Assistent_Dresser_3' => $request->Assistent_Dresser_3 ?? null, // Optional field
                'Discount' => $request->Discount ?? null, // Optional field
                'payment_method' => $request->payment_method ?? "cash", // Default to cash if not provided
                'total_price' => $request->total_price,
                'status' => "preOrder",
            ]);

            // Format contact number for SMS
            $formattedContact = $this->formatContactNumber($preorder->contact_number_1);

            // Prepare SMS message
            $msg = "Hello {$preorder->customer_name},\n\nYour order is confirmed!\n"
               . "Booking Number: {$preorder->Booking_number}\n"
               . "Appointment Date: {$preorder->Appoinment_date}\n"
               . "Appointment Time: {$preorder->Appointment_time}\n\n"
               . "Thank you for choosing our salon! We look forward to seeing you soon.";

            // Send the SMS
            $this->sendMessage($formattedContact, $msg);

        } catch (\Exception $e) {
            \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
            throw $e; // Rethrow exception to trigger transaction rollback
        }
    });

    // Redirect based on the outcome of preorder creation
    if ($preorder) {
        notify()->success('Package created successfully. You will receive a message shortly. ⚡️', 'Success');
        return redirect()->route('showApp')->with('success', 'Appointment created successfully. You will receive a message shortly.');
    } else {
        notify()->error('There was an error. ⚡️', 'Error');
        return redirect()->route('showApp')->withErrors('Failed to create appointment.');
    }
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

    // Helper method to generate customer code (if needed)
    private function generateCustomerCode()
    {
        // Logic to generate a unique customer code
        return 'CUS-' . time();
    }


    private function generateBookingId()
    {
        return 'PreBooking-' . rand(1000, 9999);
    }

    


}
