<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Carbon\Carbon;



class AppointmentController extends Controller
{
    public function showCustomers()
    {
        $customers = Customer::all();
        $services = Service::all();
        $packages = Package::all();
        return view('appointment.new_appointment', compact('customers', 'services', 'packages'));
    }

    public function showAppoinmentsss()
    {
        $appointments = Preorder::all(); 
        return view('appointment.index', compact('appointments'));
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
            'main_job_holder_name' => 'required|string',
            'payment_method' => 'required|string',
            'advanced_payment' => 'required|numeric',
        ]);
        //dd($request);
        
    
        //dd($request);
        $preorder = Preorder::create([
            'Auto_serial_number' => $this->generateautoserial(),
            'booking_reference_number' => $this->generatebookingRef(),
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
            'today' =>Carbon::today(),
            'appointment_time' => $request->appointment_time,
            'main_job_holder' => $request->main_job_holder_name,
            'Assistant_1' => $request->assistant_1_name,
            'Assistant_2' => $request->assistant_2_name,
            'Assistant_3' => $request->assistant_3_name,
            'note' => $request->note,
            'payment_type' => $request->payment_method,
            'Advanced_price' => $request->advanced_payment,
            'Total_price' => $request->total_price,
            'status'=>'pending',
        ]);

        notify()->success('Order created successfully. ⚡️', 'Success');
        return redirect()->route('printAndRedirect', ['id' => $preorder->id]);
        return redirect()->route('Appoinments')->with('success', 'Appointment added successfully.');

    }

    private function generateautoserial()
    {
        return 'ASN-'  . rand(1000, 9999);
    }

    private function generatebookingRef()
    {
        return 'BREF-'  . rand(1000, 9999);
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
    
}
