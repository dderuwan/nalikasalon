<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $suppliers = Supplier::all();
            return view('suppliers.index', compact('suppliers'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve suppliers.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'account_details' => 'required|string|max:255',
        ]);

        try {
            $supplier = new Supplier();
            $supplier->name = $validatedData['name'];
            $supplier->address = $validatedData['address'];
            $supplier->contact_number = $validatedData['contact_number'];
            $supplier->account_details = $validatedData['account_details'];
            $supplier->supplier_code = 'SUP' . strtoupper(uniqid()); // Generate supplier code
            $supplier->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->route('suppliers.index')->with('success', 'Supplier Registerd successfully.');
            
        } catch (ModelNotFoundException $e) {
            toastr()->error('Supplier not found.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Supplier not found.']);
        } catch (Exception $e) {
            toastr()->error('Failed to update supplier.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Failed to update supplier.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):View
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return view('suppliers.show', compact('supplier'));
        } catch (ModelNotFoundException $e) {
            toastr()->error('Supplier not found.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Supplier not found.']);
        } catch (Exception $e) {
            toastr()->error('Failed to retrieve supplier details.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Failed to retrieve supplier details.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id):View
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return view('suppliers.edit', compact('supplier'));
        } catch (ModelNotFoundException $e) {
            toastr()->error('Supplier not found.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Supplier not found.']);
        } catch (Exception $e) {
            toastr()->error('Failed to retrieve supplier details.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Failed to retrieve supplier for editing.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'account_details' => 'required|string|max:255',
        ]);

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($validatedData);

            toastr()->success('Supplier updated successfully.');
            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
        } catch (ModelNotFoundException $e) {
            toastr()->error('Supplier not found.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Supplier not found.']);
        } catch (Exception $e) {
            toastr()->error('Failed to retrieve supplier details.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Failed to update supplier.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            toastr()->success('Supplier deleted successfully.');
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
        } catch (ModelNotFoundException $e) {
            toastr()->error('Supplier not found.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Supplier not found.']);
        } catch (Exception $e) {
            toastr()->error('Failed to retrieve delete supplier.');
            return redirect()->route('suppliers.index')->withErrors(['error' => 'Failed to delete supplier.']);
        }
    }
}
