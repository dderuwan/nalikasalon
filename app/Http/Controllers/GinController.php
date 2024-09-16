<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gin;
use App\Models\GinItems;
use App\Models\OrderRequest;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\OrderRequestItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon; 
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class GinController extends Controller
{
    public function index()
    {
        $gins = Gin::all();
        return view('gin.index', compact('gins'));
    }

    public function create()
    {
        // Fetch order requests with status 'Processing' and include their items
        $orderRequests = OrderRequest::with('items')
                                    ->where('status', 'Processing')
                                    ->get();

        return view('gin.create', compact('orderRequests'));
    }


    public function store(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'order_request_code' => 'required|string',
            'orderItems' => 'required|array',
            'orderItems.*.item_code' => 'required|string',
            'orderItems.*.pack_size' => 'nullable|numeric',
            'orderItems.*.unit_price' => 'required|numeric',
            'orderItems.*.in_quantity' => 'required|numeric',
            'orderItems.*.shots_count' => 'required|numeric',
            'orderItems.*.manufacture_date' => 'required|date',
            'orderItems.*.expire_date' => 'required|date',
            'orderItems.*.total_cost' => 'required|numeric',
            'orderItems.*.payment' => 'required|string'
        ]);
    
        DB::transaction(function () use ($request, $validatedData) {
            // Generate a unique gin_code
            $gin_code = 'GIN-' . strtoupper(Str::random(6));
            
            // Calculate the total_cost_payment
            $total_cost_payment = array_reduce($validatedData['orderItems'], function ($sum, $item) {
                return $sum + $item['total_cost'];
            }, 0);
    
            // Create the Gin entry
            $gin = Gin::create([
                'gin_code' => $gin_code,
                'order_request_code' => $validatedData['order_request_code'],
                'supplier_code' => $request->supplier_code,
                'date' => $request->date,
                'total_cost_payment' => $total_cost_payment
            ]);
    
            // Create the GinItems entries
            foreach ($validatedData['orderItems'] as $item) {
                GinItems::create([
                    'gin_id' => $gin->id,
                    'item_name' => $item['item_code'],
                    'packsize' => $item['pack_size'],
                    'unit_price' => $item['unit_price'],
                    'in_quantity' => $item['in_quantity'],
                    'shots_Count'=>$item['shots_count'],
                    'manufacture_date'=>$item['manufacture_date'],
                    'expire_date'=>$item['expire_date'],
                    'total_cost' => $item['total_cost'],
                    'payment' => $item['payment']
                ]);

                // Update the item quantity in the items table
                $itemRecord = Item::where('item_code', $item['item_code'])->first();
                if ($itemRecord) {
                    $itemRecord->item_quentity += $item['in_quantity'];
                    $itemRecord->save();
                }

                if ($itemRecord) {
                    $itemRecord->shots+= $item['shots_count'];
                    $itemRecord->save();
                }
            }

            $orderRequest = OrderRequest::where('order_request_code', $validatedData['order_request_code'])->first();
            if ($orderRequest) {
                $orderRequest->update(['status' => 'complete']);
            }
        });

        notify()->success('Goods In Note created successfully. ⚡️', 'Success');
        return redirect()->route('allgins')->with('success', 'Goods In Note created successfully.');
    }
    


    private function generateGINCode()
    {
        return 'GIN-' . time() . '-' . rand(1000, 9999);
    }

    public function getOrderItems($orderRequestCode)
    {
        $orderItems = OrderRequestItem::where('order_request_code', $orderRequestCode)->get();
        return response()->json($orderItems);
    }

    // Display the specified order request
    public function show($id)
    {
        $gin = Gin::with('items')->findOrFail($id);
        return view('gin.show', compact('gin'));
    }

    // Show the form for editing the specified order request
    public function edit($id)
    {
        $gin = Gin::findOrFail($id);
        return view('editgins', compact('gin'));
    }



    // Remove the specified order request from storage
    public function destroy($id)
    {
        $gin = Gin::findOrFail($id);
        $gin->delete();

        notify()->success('Requested Order deleted successfully. ⚡️', 'Success');
        return redirect()->route('allgins')->with('success', 'Requested Order deleted successfully.');
    }


}
