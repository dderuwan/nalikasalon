<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use App\Models\Preorder;
use App\Models\promotions;
use App\Models\GiftVouchers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\TimeSlot;
use App\Models\TimeSlotBridel;
use App\Models\Schedule;
use App\Models\BridelSubCategory;
use App\Models\AdditionalPackage;
use App\Models\SubcategoryItem;
use App\Models\bridelpreorder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class AppointmentController extends Controller
{
    public function showCustomers()
    {
        $customers = Customer::all();
        $services = Service::whereIn('service_code', ['SERVICE-5284'])->get();
        $packages = Package::all();
        $timeSlots = TimeSlot::all();
        $timeSlotsBridels = TimeSlotBridel::all();
        $promotions = promotions::all();
        $giftvouchers = GiftVouchers::all();

        $packagesonly = Package::where('services_id', 'SERVICE-6465')->get();

        
        return view('appointment.new_appointment', compact('customers', 'services', 'packages','timeSlots','timeSlotsBridels','packagesonly','promotions','giftvouchers'));
    }

    public function getSubcategoriesByPackage(Request $request)
    {
        $packageId = $request->input('package_id');
        
        // Find the package by ID
        $package = Package::find($packageId);

        if ($package) {
            // Get related subcategories
            $subcategories = $package->subCategories;

            return response()->json(['subcategories' => $subcategories]);
        }

        return response()->json(['error' => 'Package not found'], 404);
    }
    

    public function getItemsBySubcategory(Request $request)
    {
        $subcategoryId = $request->input('subcategory_id');

        // Ensure that the subcategory exists and fetch related items
        $subcategory = BridelSubCategory::find($subcategoryId);

        if ($subcategory) {
            // Fetch items related to the subcategory
            $items = $subcategory->bridelItems; // Ensure the relationship is correctly defined

            return response()->json(['items' => $items]);
        }

        return response()->json(['error' => 'Subcategory not found'], 404);
    }


    public function getAvailableTimeSlots(Request $request)
    {
        $date = $request->input('date');
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

    
    public function getAvailableMainDressers(Request $request)
    {
        $date = $request->input('date');
        $timeSlot = $request->input('time_slot');
        $roleId = 2;

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
        $roleId = 3;

        $availableAssistants = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->whereDoesntHave('schedules', function ($query) use ($date, $timeSlot) {
            $query->where('date', $date)
                ->where('time_slot', $timeSlot)
                ->where('is_booked', true);
        })->get();

        return response()->json(['available_assistants' => $availableAssistants]);
    }

    public function showPackages()
    {
        $serviceCode = 'SERVICE-6465';  // Example service code
        $packages = Package::where('services_id', $serviceCode)->get();

        return view('your-view', compact('packages'));
    }

    public function showAppoinmentsss()
    {
        $appointments = bridelpreorder::all(); 
        return view('appointment.index', compact('appointments'));
    }

    public function showPreOrders()
    {
        $appointments = bridelpreorder::with('Package')->get(); 
        return view('appointment.preorderList', compact('appointments'));
    }
    

    public function showPreOrderDetails($id)
    {
        $preorder = bridelpreorder::with(['additionalPackages', 'subcategoryItems'])->findOrFail($id);
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

    public function storeAppointment(Request $request)
    {
        //dd($request);
        $request->validate([
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'start_date' => 'required|date',
            'appointment_time' => 'required|string',
            'payment_method' => 'required|string',
            'advanced_payment' => 'required|numeric',
            'total_price'=>'required|numeric',
        ]);
        //dd($request);
        $preorder = null; // Initialize preorder variable
    
        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = bridelpreorder::create([
                    'Auto_serial_number' => $this->generateAutoSerial(),
                    'customer_id' => $request->customer_id,
                    'customer_name' => $request->customer_name,
                    'contact_number_1' => $request->contact_number_1,
                    'service_id' => $request->service_id,
                    'package_id' => $request->package_id_1,
                    'Appoinment_date' => $request->start_date,
                    'today'=> Carbon::today(),
                    'Appointment_time' => $request->appointment_time,
                    'photographer_name' => $request->photographer_name,
                    'photographer_contact' => $request->photographer_contact,
                    'note' => $request->note,
                    'Main_Dresser'=> $request->Main_Dresser,
                    'Assistent_Dresser_1'=> $request->Assistent_Dresser_1,
                    'Assistent_Dresser_2'=> $request->Assistent_Dresser_2,
                    'Assistent_Dresser_3'=> $request->Assistent_Dresser_3,
                    'hotel_dress'=> $request->hotel_dress,
                    'Transport'=> $request->Transport,
                    'Discount'=> $request->Discount,
                    'payment_method'=> $request->payment_method,
                    'Gift_vouchwe_id'=> $request->gift_voucher_Id,
                    'Gift_voucher_value'=> $request->gift_voucher_price,
                    'promotion_id'=> $request->promotions_Id,
                    'Promotiona_value'=> $request->promotional_price,
                    'advanced_payment'=> $request->advanced_payment,
                    'Balance_Payment'=> $request->Balance_Payment,
                    'total_price'=> $request->total_price,
                    'status'=> "NotCompleted",
                ]);
    
                \Log::info('Preorder created:', ['preorder' => $preorder]);


                // Attach Additional Packages
                if ($request->has('otherpackages')) { // Use the correct key from the form data
                    foreach ($request->otherpackages as $packageId) {
                        AdditionalPackage::create([
                            'bridelpreorder_id' => $preorder->id,
                            'package_id' => $packageId,
                        ]);
                    }
                }

                // Attach Subcategory Items
                if ($request->has('subcategory_items') && is_array($request->subcategory_items)) {
                    foreach ($request->subcategory_items as $subcategoryId => $itemId) {
                        if ($itemId !== null) { // Ensure itemId is not null
                            SubcategoryItem::create([
                                'bridelpreorder_id' => $preorder->id, // Use 'id' for foreign key reference
                                'subcategory_id' => $subcategoryId,
                                'item_id' => $itemId,
                            ]);
                        }
                    }
                }

                // Send SMS after order confirmation
                $formattedContact = $this->formatContactNumber($preorder->contact_number_1);

                $msg = "Hello {$preorder->customer_name},\n\nYour order is confirmed!\n"
                    . "Booking Number: {$preorder->Auto_serial_number}\n"
                    . "Appointment Date: {$preorder->Appoinment_date}\n\n"
                    . "Thank you for choosing our salon! We look forward to seeing you soon.";

                // Call sendMessage function to send the SMS
                $this->sendMessage($formattedContact, $msg);

                

                \Log::info('Additional packages and subcategory items saved successfully.');


            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    
        if ($preorder) {
            return redirect()->route('printAndRedirectBridel', ['id' => $preorder->id]);
        } else {
            return redirect()->route('Appoinments')->withErrors('Failed to create appointment.');
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
    

    private function generateAutoSerial()
    {
        return 'ASN-' . rand(1000, 9999);
    }


    public function getPackagesByService(Request $request)
    {
        $serviceCode = $request->input('service_code');
        $packages = Package::where('services_id', $serviceCode)->get();
        return response()->json(['packages' => $packages]);
    }

    

    public function printAndRedirect($id)
    {
        // Eager load related additional packages and subcategory items
        $preorder = bridelpreorder::with(['additionalPackages', 'subcategoryItems'])->findOrFail($id);
        return view('appointment.print', compact('preorder'));
    }

    public function printAndRedirectmain($id)
    {
        // Eager load related additional packages and subcategory items
        $preorder = bridelpreorder::with(['additionalPackages', 'subcategoryItems'])->findOrFail($id);
        return view('appointment.printmain', compact('preorder'));
    }

    public function getPreorders()
    {
        $preorders = bridelpreorder::all(['Appoinment_date as start', 'customer_name as title', 'hotel_dress','Appointment_time as time']);

        $events = $preorders->map(function ($preorder) {
            return [
                'title' => $preorder->title,  // Customer name as the event title
                'start' => $preorder->start,  // Appointment date as the event start
                'hotel_dress' => $preorder->hotel_dress,  // Include hotel_dress as an attribute
                'time'=>$preorder->time,
            ];
        });

        return response()->json($events);
    }




    public function customerstore(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number_1' => 'required|string|max:20',
            'contact_number_2' => 'nullable|string|max:20',
            'address' => 'required|strinshowPreOrders|max:255',
            'date_of_birth' => 'required|date',
        ]);
        
        try {
            $customer = new Customer();
            $customer->name = $validatedData['name'];
            $customer->contact_number_1 = $validatedData['contact_number_1'];
            $customer->contact_number_2 = $validatedData['contact_number_2'];
            $customer->address = $validatedData['address'];
            $customer->date_of_birth = $validatedData['date_of_birth'];
            $customer->customer_code = 'CUS' . strtoupper(uniqid()); // Generate supplier code
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

    public function destroy($id)
    {
        // Find the preorder by ID and delete it
        $preorder = bridelpreorder::findOrFail($id);
        $preorder->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Preorder deleted successfully.');
    }
    
}
