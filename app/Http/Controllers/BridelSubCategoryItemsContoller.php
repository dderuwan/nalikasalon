<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BridelSubCategory;
use App\Models\BridelItems;

class BridelSubCategoryItemsContoller extends Controller
{
    public function index()
    {
        $bridelitems = BridelItems::with('bridelSubCategory')->get();
        return view('BridelItems.index', compact('bridelitems'));
    }

    public function create()
    {
        $BridelSubCategorys = BridelSubCategory::all();
        return view('BridelItems.create',compact('BridelSubCategorys'));
    }


    public function store(Request $request)
    {
        try {

            //dd($request);
            $request->validate([
                'service_code'=>'required',
                'Item_name' => 'required',
                'description' => 'nullable|string',
                'quentity' => 'nullable|string',
                'price' => 'nullable',
            ]);
            
            //dd($request);

            $package = new BridelItems();
            $package->Bridel_sub_category = $request->service_code;
            $package->Item_name = $request->Item_name;
            $package->quentity = $request->quentity;
            $package->price = $request->price;
            $package->description = $request->description;
            $package->save();

            notify()->success('Item Created successfully. ⚡️', 'Success');
            return redirect()->route('bridelItems')->with('success', ' Item created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $BridelSubCategorys = BridelSubCategory::all();
        $bridelitems = BridelItems::findOrFail($id);
        return view('BridelItems.edit', compact('bridelitems','BridelSubCategorys'));

    }

    public function update(Request $request, $id)
    {
        try {
            //dd($request);
            $request->validate([
                'package_name' => 'required',
                'description' => 'nullable|string',
                'quentity' => 'nullable|string',
                'price' => 'nullable',
            ]);
            
            //dd($request);

            $package = BridelItems::findOrFail($id);
            $package->Bridel_sub_category = $request->service_code;
            $package->Item_name = $request->package_name;
            $package->quentity = $request->quentity;
            $package->price = $request->price;
            $package->description = $request->description;
            $package->save();

            notify()->success('Item Update successfully. ⚡️', 'Success');
            return redirect()->route('bridelItems')->with('success', ' Item Update successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $item = BridelItems::findOrFail($id);
            $item->delete();
            notify()->success('Item deleted successfully. ⚡️', 'Success');
            return redirect()->route('bridelItems')->with('success', 'Item deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withError('Package not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
