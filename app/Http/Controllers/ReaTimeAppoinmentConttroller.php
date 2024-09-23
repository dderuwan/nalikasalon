<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preorder;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\promotions;
use App\Models\GiftVouchers;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\TimeSlot;
use App\Models\TimeSlotBridel;
use App\Models\Schedule;
use App\Models\Item;
use App\Models\Commission;
use App\Models\bridelpreorder;
use App\Models\RealTimeBooking;
use Illuminate\Support\Facades\Log;

class ReaTimeAppoinmentConttroller extends Controller
{
    public function RealTimepage1(){
    
        $preorders = bridelpreorder::all(); 
        return view('appointment.realtime1', compact('preorders'));
    }

    public function getAppointmentsByCustomer(Request $request)
    {
        $contactNumber = $request->input('contact_number_1');

        // Fetch orders related to the selected contact number and where the status is 'NotCompleted'
        $appointments = bridelpreorder::where('contact_number_1', $contactNumber)
                                    ->where('status', 'NotCompleted')
                                    ->get();

        // Return the filtered data as JSON
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




    public function realtime3page(Request $request)
    {
        $autoSerialNumber = $request->input('selected_appointment_number');
        $preorderDetails = bridelpreorder::where('Auto_serial_number', $autoSerialNumber)->first();
        
        // Check if preorder details were found
        if (!$preorderDetails) {
            return redirect()->back()->withErrors(['error' => 'Preorder not found.']);
        }

        // Fetch the service details using the service_code from preorder details
        $service = Package::where('id', $preorderDetails->package_id)->first();

        $promotions = promotions::all();
        $giftvouchers = GiftVouchers::all();

        // Pass the details and the service to the view
        return view('appointment.realtime3', compact('preorderDetails', 'service','promotions','giftvouchers'));
    }

    public function getGiftVoucherPrice($giftVoucherId)
    {
        // Fetch the gift voucher by its ID
        $giftVoucher = GiftVouchers::where('gift_voucher_Id', $giftVoucherId)->first();

        // Check if the gift voucher exists
        if ($giftVoucher) {
            return response()->json([
                'success' => true,
                'price' => $giftVoucher->price,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gift voucher not found',
            ]);
        }
    }

    public function getPromotionPrice($id)
    {
        $promotion = promotions::where('promotions_Id', $id)->first();

        if ($promotion) {
            return response()->json([
                'success' => true,
                'price' => $promotion->price
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Promotion not found.'
            ]);
        }
    }

    public function storerealtime34(Request $request)
    {
        // Validate the request
        $request->validate([
            'Auto_serial_number' => 'required|string',
        ]);

        // Find the preorder by Auto_serial_number
        $preorder = bridelpreorder::where('Auto_serial_number', $request->Auto_serial_number)->first();

        if ($preorder) {
            // Update the preorder status to "completed"
            $preorder->status = 'completed';
            $preorder->save();

            // Redirect to the printAndRedirect route if the preorder was successfully updated
            return redirect()->route('printlast', ['id' => $preorder->id]);
        } else {
            // Return back with error if preorder was not found
            return redirect()->route('Appoinments')->withErrors('Failed to update preorder.');
        }
    }

    public function printlast($id)
    {
        // Eager load related additional packages and subcategory items
        $preorder = bridelpreorder::with(['additionalPackages', 'subcategoryItems'])->findOrFail($id);

        // Redirect to the print view with the preorder details
        return view('appointment.print2', compact('preorder'));
    }




    public function RealTimeOrderList(){
        $realtimeOrders = bridelpreorder::all(); 
        return view('appointment.realtimeOrderList', compact('realtimeOrders'));
    }

    public function destroy($id)
    {
        // Find the preorder by ID and delete it
        $preorder = bridelpreorder::findOrFail($id);
        $preorder->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Preorder deleted successfully.');
    }

    public function showRealOrderDetails($id)
    {
        $preorder = bridelpreorder::findOrFail($id);
        return view('appointment.showRealtimeDetails', compact('preorder'));
    }

    public function updateRealOrderDetails($id)
    {
        $preorder = bridelpreorder::findOrFail($id);
 
        $items = Item::where('shots', '>', 0)->get();
        
        $roleId = 2;
        $employees = Employee::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })->get();

        $roleId2 = 3;
        $assemployees = Employee::whereHas('roles', function ($query) use ($roleId2) {
            $query->where('role_id', $roleId2);
        })->get();

        return view('appointment.updateorders', compact('preorder','employees','assemployees','items')); 
    }

    public function storeupdate(Request $request)
    {
        //dd($request);
        // Getting current date
        $currentDate = Carbon::now()->toDateString();
        
        // Retrieve the assistants, commission type, and price from the request
        $assistants = array_filter($request->assistants);
        $bookingNumber = $request->input('Booking_number'); // order_id
        $commissionPrices = $request->input('price');
        $mainDresser = $request->input('main_dresser');

        // Loop through assistants and insert commission details into the table
        foreach ($assistants as $index => $assistantId) {
            // Create a new commission record for each assistant
            Commission::create([
                'employee_id' => $assistantId,           // The assistant's ID
                'order_id' => $bookingNumber,            // Use the booking number as the order ID
                'date' => $currentDate,                  // Set the date as today's date
                'commission_amount' => $commissionPrices[$index], // Get the corresponding price from the "price" array
            ]);
        }

        $salonThretment = bridelpreorder::where('Auto_serial_number', $bookingNumber)->firstOrFail();

        $salonThretment->update([
            'Main_Dresser' => $mainDresser,                   // Update Main Dresser
            'Assistent_Dresser_1' => $assistants[0] ?? null,  // Update Assistant Dresser 1
            'Assistent_Dresser_2' => $assistants[1] ?? null,  // Update Assistant Dresser 2
            'Assistent_Dresser_3' => $assistants[2] ?? null,  // Update Assistant Dresser 3
        ]);

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

        return redirect('RealTimeOrderList')->with('success', 'Update Details successfully');
    }





}


