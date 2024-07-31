<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use PDF;



class POSController extends Controller
{
    public function showHomepage()
    {
        $items = Item::all();
        $customers = Customer::all();
        $orders = Order::all();
        $today = Carbon::today()->toDateString();
        return view('POS.homepage', compact('items','customers','orders','today'));

    }

    public function customerstore(Request $request)
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
            $customer->supplier_code = 'CUS' . strtoupper(uniqid()); // Generate supplier code
            $customer->save();

            notify()->success('Customer Registerd successfully. ⚡️', 'Success');
            return redirect()->route('pospage')->with('success', 'Customer Registerd successfully.');

        } catch (ModelNotFoundException $e) {

            notify()->success('Customer not Found. ⚡️', 'Fail');
            return redirect()->route('pospage')->withErrors(['error' => 'Customer not found.']);
        } catch (Exception $e) {

            notify()->success('Failed to update Customer. ⚡️', 'Fail');
            return redirect()->route('pospage')->withErrors(['error' => 'Failed to update Customer.']);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_code' => 'required',
            'items' => 'required|array',
            'item_code.*' => 'required',
            'item_name.*' => 'required',
            'quantity.*' => 'required|numeric',
            'total.*' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'payment_type' => 'required|string',
            'paid_amount' => 'required|numeric',
            'change' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pos = Order::create([
                'order_code' => $this->generateOrderCode(),
                'customer_code' => $request->customer_code,
                'date' => Carbon::today(),
                'total_cost_payment' => $request->grand_total,
                'discount' => $request->discount,
                'vat' => $request->vat,
                'paid_amount' => $request->paid_amount,
                'change' => $request->change,
                'payment_type' => $request->payment_type,
            ]);

            foreach ($request->items as $item) {
                $orderItem = OrderItems::create([
                    'pos_id' => $pos->id,
                    'item_code' => $item['item_code'],
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'total_cost' => $item['total'],
                ]);
                dd($orderItem);
                // Decrease item quantity in Item table
                $itemModel = Item::where('item_code', $item['item_code'])->first();
                if ($itemModel) {
                    if ($itemModel->item_quentity >= $item['quantity']) {
                        $itemModel->item_quentity -= $item['quantity'];
                        $itemModel->save();
                    } else {
                        throw new Exception("Not enough stock for item: " . $item['item_code']);
                    }
                } else {
                    throw new Exception("Item not found: " . $item['item_code']);
                }
            }

            DB::commit();

            $this->generateAndDownloadBill($pos->id);

            notify()->success('Order created successfully. ⚡️', 'Success');
            return redirect()->route('pospage')->with('success', 'Order created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to create order: ' . $e->getMessage());
            return redirect()->route('pospage')->withErrors(['error' => 'Failed to create order.']);
        }
    }


    protected function generateAndDownloadBill($orderId)
    {
        $order = Order::with('items')->find($orderId);

        // Generate the PDF
        $pdf = PDF::loadView('bill', compact('order'));

        // Download the PDF
        $pdf->download('order_bill.pdf');

        // Optionally, you can also display the PDF in the browser
        // $pdf->stream('order_bill.pdf');
    }

    private function generateOrderCode()
    {
        return 'ORD-'  . rand(1000, 9999);
    }

     // Display the specified order request
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('POS.show', compact('order'));
    }

    // Remove the specified order request from storage
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        notify()->success('Requested Order deleted successfully. ⚡️', 'Success');
        return redirect()->route('pospage')->with('success', 'Requested Order deleted successfully.');
    }


}
