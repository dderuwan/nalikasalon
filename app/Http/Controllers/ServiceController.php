<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Package;

class ServiceController extends Controller
{
    public function index()
    {
            $services = Service::all();
            return view('services.index', compact('services'));
    }

    public function create()
    {
            $services = Service::all();
            return view('services.create', compact('services'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'services.*.service_name' => 'required',
                'services.*.description' => 'required',
                'services.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            foreach ($request->services as $itemData) {
                $service = new Service();
                $service->service_code = $this->generateServiceCode();
                $service->service_name = $itemData['service_name'];
                $service->description = $itemData['description'];

                if (isset($itemData['image'])) {
                    $file = $itemData['image'];
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/services'), $filename);
                    $service->image = $filename;
                }

                $service->save();
            }

            notify()->success('Service Created successfully. ⚡️', 'Success');
            return redirect()->route('services')->with('success', 'Service created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    private function generateServiceCode()
    {
        return 'SERVICE-' . rand(1000, 9999);
    }

    public function show($id)
    {
        $service = Service::with('packages')->findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function edit($id)
    {
        // Find the service by ID or throw a 404 error if not found
        $service = Service::findOrFail($id);
        
        // Pass the service instance to the view
        return view('services.edit', compact('service'));
    }
    

    public function update(Request $request, $id)
    {
        try {
            // Find the service by id
            $service = Service::findOrFail($id);

            // Validate the request data
            $request->validate([
                'service_name' => 'required',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Update the service attributes
            $service->service_name = $request->service_name;
            $service->description = $request->description;

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($service->image) {
                    unlink(public_path('images/services/' . $service->image));
                }

                // Save the new image
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/services'), $filename);
                $service->image = $filename;
            }

            // Save the updated service
            $service->save();

            notify()->success('Service Updated successfully. ⚡️', 'Success');
            return redirect()->route('services')->with('success', 'Service updated successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }



    public function destroy($id)
    {
        try {
            // Find the service by ID
            $service = Service::findOrFail($id);

            // Delete related packages
            $service->packages()->delete();

            // Delete the service
            $service->delete();

            notify()->success('Service and related packages deleted successfully. ⚡️', 'Success');
            return redirect()->route('services')->with('success', 'Service and related packages deleted successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

}
