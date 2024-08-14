<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Package;
use Illuminate\Support\Facades\Validator; 

class PackageController extends Controller
{
    public function index()
    {
            $packages = Package::all();
            return view('packages.index', compact('packages'));
    }

    public function create()
    {
            $services = Service::all();
            $packages = Package::all();
            return view('packages.create', compact('packages','services'));
    }


    public function storepackages(Request $request)
    {
        try {
            $request->validate([
                'service_code' => 'required',
                'package_name' => 'required',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric',
            ]);

            $package = new Package();
            $package->services_id = $request->service_code;
            $package->package_name = $request->package_name;
            $package->description = $request->description; // This will store the HTML content
            $package->price = $request->price;
            $package->duration=0;
            $package->save();

            notify()->success('Package Created successfully. ⚡️', 'Success');
            return redirect()->route('packages')->with('success', 'Package created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $services = Service::all();
        $package = Package::findOrFail($id);

        return view('packages.edit', compact('package', 'services'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'service_code' => 'required',
                'package_name' => 'required',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric',
            ]);

            $package = Package::findOrFail($id);
            $package->services_id = $request->service_code;
            $package->package_name = $request->package_name;
            $package->description = $request->description; // This will store the HTML content
            $package->price = $request->price;
            $package->save();

            notify()->success('Package updated successfully. ⚡️', 'Success');
            return redirect()->route('packages')->with('success', 'Package updated successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }




    
    public function destroy($id)
    {
        try {
            $item = Package::findOrFail($id);
            $item->delete();
            notify()->success('Package deleted successfully. ⚡️', 'Success');
            return redirect()->route('packages')->with('success', 'Package deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withError('Package not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

}
