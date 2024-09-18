<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalonThretment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Employee;
use App\Models\TimeSlot;
use App\Models\Item;
use App\Models\TimeSlotBridel;
use Carbon\Carbon;
use App\Models\Commission;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class SalonThretmentContoller extends Controller
{
    public function index(){
        $bookings = SalonThretment::whereIn('status', ['preOrder'])->get();
        return view('Salon&Thretment.preorder.index', compact('bookings'));
    }

    public function create(){
        $customers = Customer::all();
        $services = Service::whereIn('service_code', ['SERVICE-7143', 'SERVICE-4463'])->get();
        $packages = Package::all();
        $timeSlots = TimeSlot::all();
        $timeSlotsBridels = TimeSlotBridel::all();
        return view('Salon&Thretment.preorder.create', compact('customers','services','packages','timeSlots','timeSlotsBridels'));
    }

    public function store(Request $request){

        dd($request);
        $request->validate([
            'contact_number_1' => 'required|string',
            'service_id' => 'required|string',
            'package_id_1' => 'required|string',
            'start_date' => 'required|date',
            'appointment_time' => 'required|string',
            'payment_method' => 'required|string',
            'total_price'=>'required|numeric',
        ]);
        //dd($request);
        $preorder = null; // Initialize preorder variable
    
        \DB::transaction(function () use ($request, &$preorder) {
            try {
                // Create the preorder
                $preorder = SalonThretment::create([
                    'Booking_number' => $this->generateBookingId(),
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
                    'status'=> "preOrder",
                ]);
    


            } catch (\Exception $e) {
                \Log::error('Error creating preorder or updating schedules:', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    
        if ($preorder) {
            return redirect()->route('SalonThretment', ['id' => $preorder->id]);
        } else {
            return redirect()->route('SalonThretment')->withErrors('Failed to create appointment.');
        }
    }

    private function generateBookingId()
    {
        return 'BOOKING-' . rand(1000, 9999);
    }

    public function destroy($id)
    {
        $voucher = SalonThretment::find($id);
        if ($voucher) {
            $voucher->delete();

            return redirect('SalonThretment')->with('success', 'Order deleted successfully');
        } else {
            return redirect()->route('SalonThretment')->with('error', 'Order not found.');
        }
    }

    public function calender(){
        return view('Salon&Thretment.preorder.calender');
    }

    public function getPreorders()
    {
        // Fetch all bookings with 'preOrder' status
        $bookings = SalonThretment::where('status', 'preOrder')
                    ->get(['Appoinment_date as start', 'customer_name as title', 'Appointment_time']);

        // Map the bookings into events array
        $events = $bookings->map(function ($booking) {
            return [
                'title' => $booking->title,  // Customer name as the event title
                'start' => $booking->start,  // Appointment date as the event start
                'appointment_time' => $booking->Appointment_time,  // Appointment time as additional attribute
            ];
        });

        // Return the events as a JSON response
        return response()->json($events);
    }

    //real time section

    public function index1(){
        $bookings = SalonThretment::whereIn('status', ['RealTimeOrder'])->get();
        return view('Salon&Thretment.realtimeorder.index', compact('bookings'));
    }

    public function create1(){
        $customers = Customer::all();
        $services = Service::whereIn('service_code', ['SERVICE-7143', 'SERVICE-4463'])->get();
        $packages = Package::all();
        $timeSlots = TimeSlot::all();
        $timeSlotsBridels = TimeSlotBridel::all();
        return view('Salon&Thretment.realtimeorder.create', compact('customers','services','packages','timeSlots','timeSlotsBridels'));
    }

    public function store1(Request $request){

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
                $msg = "Your appointment is confirmed.\nBooking Number: {$preorder->Booking_number}\nDate: {$request->Carbon::today()}\nThank you for choosing our salon!";
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

    private function formatContactNumber($contact)
    {
        // Remove any non-digit characters
        $contact = preg_replace('/\D/', '', $contact);

        // Check if the number starts with '0' and remove it
        if (strpos($contact, '0') === 0) {
            $contact = substr($contact, 1);
        }

        // Add the country code (94 for Sri Lanka)
        return '94' . $contact;
    }

    private function sendMessage($contact, $msg)
    {
        $apiToken = env('RICHMO_API_TOKEN');
        $senderName = 'Bridalhouse'; 
        $message = $msg;

        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiToken"
        ])->withoutVerifying()->get('https://portal.richmo.lk/api/sms/send/', [
            'dst' => $contact,
            'from' => $senderName,
            'msg' => $message
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData['message'] === 'success') {
                \Log::info('SMS sent successfully:', ['response' => $responseData]);
            } else {
                \Log::warning('Unexpected response from SMS API:', ['response' => $responseData]);
            }
        } else {
            $error = $response->json();
            \Log::error('SMS sending failed:', ['error' => $error]);
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

    public function edit1($id)
    {
        $preorder = SalonThretment::findOrFail($id); 
        $items = Item::where('shots', '>', 0)->get();
        
        $roleId = 2;
        $employees = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        $roleId2 = 3;
        $assemployees = Employee::whereHas('roles', function ($query) use ($roleId2) {
            $query->where('role_id', $roleId2);
        })->get();

        return view('Salon&Thretment.realtimeorder.edit', compact('preorder','employees','assemployees','items')); 
    }




public function store2(Request $request)
{
    // Getting current date
    $currentDate = Carbon::now()->toDateString();
    
    // Retrieve the assistants, commission type, and price from the request
    $assistants = array_filter($request->input('assistants')); // Filter out null values
    $bookingNumber = $request->input('Booking_number'); // order_id
    $commissionPrices = $request->input('price');
    $mainDresser = $request->input('main_dresser');

    // Check if there are valid assistants and prices before proceeding
    foreach ($assistants as $index => $assistantId) {
        if (!empty($assistantId) && isset($commissionPrices[$index])) {
            // Ensure assistantId and price are valid
            Commission::create([
                'employee_id' => $assistantId,           // The assistant's ID
                'order_id' => $bookingNumber,            // Use the booking number as the order ID
                'date' => $currentDate,                  // Set the date as today's date
                'commission_amount' => $commissionPrices[$index], // Get the corresponding price from the "price" array
            ]);
        }
    }

    // Update the salon treatment with the main dresser and assistants
    $salonThretment = SalonThretment::where('Booking_number', $bookingNumber)->firstOrFail();

    $salonThretment->update([
        'Main_Dresser' => $mainDresser,                   // Update Main Dresser
        'Assistent_Dresser_1' => $assistants[0] ?? null,  // Update Assistant Dresser 1
        'Assistent_Dresser_2' => $assistants[1] ?? null,  // Update Assistant Dresser 2
        'Assistent_Dresser_3' => $assistants[2] ?? null,  // Update Assistant Dresser 3
    ]);

    // Handle items and update their vastage slots
    $items = $request->input('items');
    foreach ($items as $itemData) {
        $itemId = $itemData['item_name']; // Assuming item_name is the item ID
        $vastageSlots = $itemData['vastage_slots'];

        // Find the item in the database
        $item = Item::find($itemId);

        if ($item) {
            // Decrease the item quantity by the vastage slots
            $item->shots -= $vastageSlots;

            // Save the updated item quantity
            $item->save();
        }
    }

    return redirect()->route('RealSalonThretment')->with('success', 'Commission created successfully');
}


    public function destroy12($id)
    {
        $voucher = SalonThretment::find($id);
        if ($voucher) {
            $voucher->delete();

            return redirect()->route('RealSalonThretment')->with('success', 'Order deleted successfully'); // Ensure route name is correct
        } else {
            return redirect()->route('RealSalonThretment')->with('error', 'Order not found.');
        }
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
            $customer->customer_code = 'CUS' . strtoupper(uniqid()); // Generate supplier code
            $customer->save();
            
            notify()->success('Customer Registerd successfully. ⚡️', 'Success');
            return redirect()->route('RealcreateSalonThretment')->with('success', 'Customer Registerd successfully.');

        } catch (ModelNotFoundException $e) {

            notify()->success('Customer not Found. ⚡️', 'Fail');
            return redirect()->route('new_appointment')->withErrors(['error' => 'Customer not found.']);
        } catch (Exception $e) {
            
            notify()->success('Failed to update Customer. ⚡️', 'Fail');
            return redirect()->route('new_appointment')->withErrors(['error' => 'Failed to update Customer.']);
        }
    }

    

}
