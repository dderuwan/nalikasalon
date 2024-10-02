<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\bridelpreorder;
use App\Models\Customer;
use App\Models\SalonThretment;
use Carbon\Carbon;
use App\Models\AdditionalPackage;
use App\Models\SubcategoryItem;
use App\Models\Service;
use App\Models\Package;
use App\Models\promotions;
use App\Models\GiftVouchers;



use Illuminate\Support\Facades\Http;

class Stoercontroller extends Controller
{

    public function preordercreate()
    {
        try {

            $customers = Customer::all();
            $services = Service::whereIn('service_code', ['SERVICE-5284'])->get();
            $packages= Package::where('services_id', 'SERVICE-5284')->get();
            $otherpackages= Package::where('services_id', 'SERVICE-6465')->get();
            $promotions = promotions::all();
            $giftvouchers = GiftVouchers::all();


            return view('store.preorder.create', compact('customers','services','packages','promotions','giftvouchers','otherpackages'));

        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
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


    public function preorderstore(Request $request)
    {
        // Dump the request data for debugging (You can remove this after verifying)
        //dd($request);
    
        // Validate the request data
        $request->validate([
            'contact_number_1' => 'required|string',
            'customer_name' => 'required|string',
            'customer_contact' => 'required|string',
            'customer_address' => 'nullable|string',
            'customer_dob' => 'nullable|date',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'subcategory_items.*' => 'nullable|string', // Validating each subcategory item
            'start_date' => 'required|date',
            'appointment_time' => 'required|string',
            'note' => 'nullable|string',
            'photographer_name' => 'nullable|string',
            'photographer_contact' => 'nullable|string',
            'gift_voucher_Id' => 'nullable|string',
            'gift_voucher_price' => 'nullable|numeric',
            'promotions_Id' => 'nullable|string',
            'promotional_price' => 'nullable|numeric',
            'Transport' => 'nullable|numeric',
            'Discount' => 'nullable|numeric',
            'payment_method' => 'required|string',
            'advanced_payment' => 'required|numeric',
            'Balance_Payment' => 'required|numeric',
            'total_price' => 'required|numeric',
            'otherpackages.*' => 'nullable|string', // Validating additional packages
        ]);
        //dd($request);
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
                'today' => Carbon::today(),
                'Appointment_time' => $request->appointment_time,
                'photographer_name' => $request->photographer_name,
                'photographer_contact' => $request->photographer_contact,
                'note' => $request->note,
                'Main_Dresser' => $request->Main_Dresser,
                'Assistent_Dresser_1' => $request->Assistent_Dresser_1,
                'Assistent_Dresser_2' => $request->Assistent_Dresser_2,
                'Assistent_Dresser_3' => $request->Assistent_Dresser_3,
                'hotel_dress' => $request->hotel_dress,
                'Transport' => $request->Transport,
                'Discount' => $request->Discount,
                'payment_method' => $request->payment_method,
                'Gift_vouchwe_id' => $request->gift_voucher_Id,
                'Gift_voucher_value' => $request->gift_voucher_price,
                'promotion_id' => $request->promotions_Id,
                'Promotiona_value' => $request->promotional_price,
                'advanced_payment' => $request->advanced_payment,
                'Balance_Payment' => $request->Balance_Payment,
                'total_price' => $request->total_price,
                'status' => "NotCompleted",
            ]);
    
            
    
            // Attach Additional Packages (otherpackages)
            if ($request->has('otherpackages')) {
                foreach ($request->otherpackages as $packageId) {
                    AdditionalPackage::create([
                        'bridelpreorder_id' => $preorder->id,
                        'package_id' => $packageId,
                    ]);
                }
            }
    
            // Attach Subcategory Items (subcategory_items)
            if ($request->has('subcategory_items') && is_array($request->subcategory_items)) {
                foreach ($request->subcategory_items as $subcategoryId => $itemId) {
                    if (!is_null($itemId)) {
                        SubcategoryItem::create([
                            'bridelpreorder_id' => $preorder->id,
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

            $this->sendMessage($formattedContact, $msg);

    
            // Redirect to print bill page if preorder is successfully created
            if ($preorder) {
                return redirect()->route('printAndRedirectBridel', ['id' => $preorder->id])
                    ->with('success', 'Preorder created successfully and message sent.');
            } else {
                return redirect()->route('appointments')->withErrors('Failed to create appointment.');
            }
    
    
        } catch (\Exception $e) {
           
            return back()->withError('There was an error creating the preorder.')->withInput();
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
            

            if ($responseData['message'] === 'success') {
                // SMS sent successfully
            } else {
                
            }
        } else {
            $error = $response->json();
            
        }
    }

    

    private function generateAutoSerial()
    {
        return 'ASN-' . rand(1000, 9999);
    }

    public function printAndRedirect($id)
    {
        // Eager load related additional packages and subcategory items
        $preorder = bridelpreorder::with(['additionalPackages', 'subcategoryItems'])->findOrFail($id);
        return view('appointment.print', compact('preorder'));
    }


    //------------------------------------------------------------------------------------------------
public function homeorderstore(Request $request)
{
    //dd($request);
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
        return back()->withErrors('There was an error creating the appointment. Please try again.');
    }

    // Redirect based on the outcome of preorder creation
    if ($preorder) {
        notify()->success('Package created successfully. You will receive a message shortly. ⚡️', 'Success');
        return redirect()->route('showApp')->with('success', 'Appointment created successfully. You will receive a message shortly.');
    } else {
        notify()->error('There was an error. ⚡️', 'Error');
        return redirect()->route('showApp')->withErrors('Failed to create appointment.');
    }
}



    

// Helper to generate booking ID
private function generateBookingId()
{
    return 'PreBooking-' . rand(1000, 9999);
}

// Helper to generate customer code
private function generateCustomerCode()
{
    return 'CUS-' . time();
}

// Helper to send SMS
private function sendConfirmationSMS($preorder)
{
    $formattedContact = $this->formatContactNumber($preorder->contact_number_1);
    $msg = "Hello {$preorder->customer_name},\n\nYour order is confirmed!\n"
        . "Booking Number: {$preorder->Booking_number}\n"
        . "Appointment Date: {$preorder->Appoinment_date}\n"
        . "Appointment Time: {$preorder->Appointment_time}\n\n"
        . "Thank you for choosing our salon!";

    $this->sendMessage($formattedContact, $msg);
}



    //-------------------------------------------------------------------------------------------------------


    public function saloonorderstore(Request $request){
        //dd($request);
        $request->validate([
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'payment_method' => 'required|string',
            'total_price'=>'required|numeric',
        ]);
        //dd($request);
        $preorder = null; // Initialize preorder variable
    
        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = SalonThretment::create([
                    'Booking_number' => $this->generateBookingId1(),
                    'customer_id' => $request->customer_id,
                    'customer_name' => $request->customer_name,
                    'contact_number_1' => $request->contact_number_1,
                    'service_id' => $request->service_name,
                    'package_id' => $request->package_name_1,
                    'Appoinment_date' => $request->start_date,
                    'today'=> Carbon::today(),
                    'Appointment_time' => $request->appointment_time,
                    'note' => $request->note,
                    'Main_Dresser'=> $request->Main_Dresser,
                    'Assistent_Dresser_1'=> $request->Assistent_Dresser_1,
                    'Assistent_Dresser_2'=> $request->Assistent_Dresser_2,
                    'Assistent_Dresser_3'=> $request->Assistent_Dresser_3,
                    'Discount'=> $request->Discount,
                    'payment_method'=> $request->payment_method,
                    'total_price'=> $request->total_price,
                    'status'=> "RealTimeOrder",
                ]);


                $formattedContact = $this->formatContactNumber($request->contact_number_1);
                $msg = "Your appointment is confirmed.\nBooking Number: {$preorder->Booking_number}\nDate: " . Carbon::today()->toFormattedDateString() . "\nThank you for choosing our salon!";
                $this->sendMessage($formattedContact, $msg);

                

            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    
        if ($preorder) {
            return redirect()->route('saloonpreorderprint1', ['id' => $preorder->id]);
        } else {
            return redirect()->route('RealSalonThretment')->withErrors('Failed to create appointment.');
        }
    }

    private function generateBookingId1()
    {
        return 'BOOKING-' . rand(1000, 9999);
    }

    public function saloonpreorderprint1($id)
    {
        // Retrieve the SalonThretment record by ID
        $preorder = SalonThretment::findOrFail($id);

        // Pass the retrieved record to the view
        return view('Salon&Thretment.realtimeorder.print', compact('preorder'));
    }

    public function saloonpreorderprintmain($id)
    {
        // Retrieve the SalonThretment record by ID
        $preorder = SalonThretment::findOrFail($id);

        // Pass the retrieved record to the view
        return view('Salon&Thretment.realtimeorder.print1', compact('preorder'));
    }

    
}
