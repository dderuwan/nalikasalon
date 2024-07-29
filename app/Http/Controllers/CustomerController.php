<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = customer::all();
        return view('customers.index',compact('customers'));
    }

    public function create():View
    {
        return view('customers.create');
    }

    public function store(Request $request)
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
            return redirect()->route('allcustomer')->with('success', 'Customer Registerd successfully.');

        } catch (ModelNotFoundException $e) {

            notify()->success('Customer not Found. ⚡️', 'Fail');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Customer not found.']);
        } catch (Exception $e) {
            
            notify()->success('Failed to update Customer. ⚡️', 'Fail');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Failed to update Customer.']);
        }
    }

    public function edit(string $id):View
    {
        try {
            $customer = Customer::findOrFail($id);
            return view('customers.edit', compact('customer'));
        } catch (ModelNotFoundException $e) {

            notify()->error('Supplier not found.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Supplier not found.']);

        } catch (Exception $e) {

            notify()->error('Failed to retrieve supplier for editing.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Failed to retrieve supplier for editing.']);
        }
    }

    public function show(string $id):View
    {
        try {
            $customer = Customer::findOrFail($id);
            return view('customers.show', compact('customer'));
        } catch (ModelNotFoundException $e) {
            
            notify()->error('customer not found.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'customer not found.']);
        } catch (Exception $e) {
            
            notify()->error('Failed to retrieve customer details.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Failed to retrieve customer details.']);
        }
    }


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number_1' => 'required|string|max:20',
            'contact_number_2' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $customer = Customer::findOrFail($request->id);
            $customer->update($validatedData);

            notify()->success('Customer Updated successfully. ⚡️', 'Success');
            return redirect()->route('allcustomer')->with('success', 'customer updated successfully.');
        } catch (ModelNotFoundException $e) {

            notify()->error('customer not found.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'customer not found.']);
        } catch (Exception $e) {

            notify()->error('Failed to update customer.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Failed to update customer.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            notify()->success('Customer Deleted successfully. ⚡️', 'Success');
            return redirect()->route('allcustomer')->with('success', 'customer deleted successfully.');
        } catch (ModelNotFoundException $e) {

            notify()->error('customer not found.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'customer not found.']);
        } catch (Exception $e) {

            notify()->error('Failed to delete customer.', 'Error');
            return redirect()->route('allcustomer')->withErrors(['error' => 'Failed to delete customer.']);
        }
    }


}
