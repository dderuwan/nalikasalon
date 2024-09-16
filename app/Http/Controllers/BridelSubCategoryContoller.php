<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BridelSubCategory;


class BridelSubCategoryContoller extends Controller
{
    public function index()
    {
        $bridelsubcategories = BridelSubCategory::all();
        return view('BridelSubPackages.index', compact('bridelsubcategories'));
    }

    public function create()
    {
        return view('BridelSubPackages.create');
    }


    public function store(Request $request)
    {
        try {
            
            $request->validate([
                'package_name' => 'required',
                'description' => 'nullable|string',
            ]);
            
            //dd($request);

            $package = new BridelSubCategory();
            $package->subcategory_name = $request->package_name;
            $package->description = $request->description;
            $package->save();

            notify()->success('Sub Package Created successfully. ⚡️', 'Success');
            return redirect()->route('bridelsubcategory')->with('success', ' Sub Package created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $bridelsubcategories = BridelSubCategory::findOrFail($id);
        return view('BridelSubPackages.edit', compact('bridelsubcategories'));
    }

    public function update(Request $request, $id)
    {
        try {
            
            $request->validate([
                'package_name' => 'required',
                'description' => 'nullable|string',
            ]);
            
            //dd($request);

            $package = BridelSubCategory::findOrFail($id);
            $package->subcategory_name = $request->package_name;
            $package->description = $request->description;
            $package->save();

            notify()->success('Sub Package Update successfully. ⚡️', 'Success');
            return redirect()->route('bridelsubcategory')->with('success', ' Sub Package Update successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $item = BridelSubCategory::findOrFail($id);
            $item->delete();
            notify()->success('Package deleted successfully. ⚡️', 'Success');
            return redirect()->route('bridelsubcategory')->with('success', 'Package deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withError('Package not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
