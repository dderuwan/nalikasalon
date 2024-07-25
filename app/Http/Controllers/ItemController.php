<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ItemController extends Controller
{
    // Display a listing of the items
    public function index()
    {
            $items = Item::all();
            return view('items.index', compact('items'));
    }

    public function showMasterStock()
    {
        $items = Item::all();
        return view('items.master', compact('items'));
    }


    // Show the form for creating a new item
    public function create()
    {
        try {
            $suppliers = Supplier::all();
            return view('items.create', compact('suppliers'));
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'supplier_code' => 'required',
                'items.*.item_name' => 'required',
                'items.*.item_description' => 'required',
                'items.*.unit_price' => 'nullable|numeric',
                'items.*.image' => 'nullable|image',
            ]);

            foreach ($request->items as $itemData) {
                $item = new Item();
                $item->item_code = $this->generateItemCode();
                $item->item_name = $itemData['item_name'];
                $item->item_description = $itemData['item_description'];
                $item->unit_price = $itemData['unit_price'];
                $item->item_quentity = 0;
                $item->supplier_code = $request->supplier_code;

                if (isset($itemData['image'])) {
                    $file = $itemData['image'];
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/items'), $filename);
                    $item->image = $filename;
                }

                $item->save();
            }
            notify()->success('Items Created successfully. ⚡️', 'Success');
            return redirect()->route('allitems')->with('success', 'Items created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


    private function generateItemCode()
    {
        return 'ITEM-' . time() . '-' . rand(1000, 9999);
    }

    // Display the specified item
    public function show($id)
    {
        try {
            $item = Item::findOrFail($id);
            return view('items.show', compact('item'));
        } catch (ModelNotFoundException $e) {
            return back()->withError('Item not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    // Show the form for editing the specified item
    public function edit($id)
    {
        try {
            $item = Item::findOrFail($id);
            $suppliers = Supplier::all(); // Get all suppliers
            return view('items.edit', compact('item', 'suppliers'));
        } catch (ModelNotFoundException $e) {
            return back()->withError('Item not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    // Update the specified item in storage
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'item_code' => 'required|unique:items,item_code,'.$id,
                'item_name' => 'required',
                'item_description' => 'required',
                'unit_price' => 'nullable|numeric',
                'supplier_code' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $item = Item::findOrFail($id);
            $item->item_code = $request->item_code;
            $item->item_name = $request->item_name;
            $item->item_description = $request->item_description;
            $item->unit_price = $request->unit_price;
            $item->supplier_code = $request->supplier_code;

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/items'), $imageName);
                $item->image = $imageName;
            }

            $item->save();
            notify()->success('Item Updated successfully. ⚡️', 'Success');
            return redirect()->route('allitems')->with('success', 'Item updated successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withError('Item not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    // Remove the specified item from storage
    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            notify()->success('Item deleted successfully. ⚡️', 'Success');
            return redirect()->route('allitems')->with('success', 'Item deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withError('Item not found')->withInput();
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
