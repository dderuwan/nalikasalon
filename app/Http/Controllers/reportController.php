<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Gin;
use App\Models\OrderRequest;
use App\Models\OrderRequestItem;


class reportController extends Controller
{

    //this is order report section
    public function orderreport()
    {
        $orders = Order::all();
        return view('reports.orders', compact('orders'));

    }

    public function printOrderReport($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('reports.print_order', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete(); // Delete related order items
        $order->delete(); // Delete the order itself
        
        notify()->success('Order deleted successfully. ⚡️', 'Success');
        return redirect()->route('orderreport')->with('success', 'Order Request deleted successfully.');
    }


    //This is Product report section
    public function productreport()
    {
        $items = Item::all();
        return view('reports.products', compact('items'));

    }

    

    //This is customer report section
    public function customerreport()
    {
        $customers = Customer::all();
        return view('reports.customers', compact('customers'));

    }

    public function customerdestroy(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            notify()->success('Customer Deleted successfully. ⚡️', 'Success');
            return redirect()->route('customerreport')->with('success', 'customer deleted successfully.');
        } catch (ModelNotFoundException $e) {

            notify()->error('customer not found.', 'Error');
            return redirect()->route('customerreport')->withErrors(['error' => 'customer not found.']);
        } catch (Exception $e) {

            notify()->error('Failed to delete customer.', 'Error');
            return redirect()->route('customerreport')->withErrors(['error' => 'Failed to delete customer.']);
        }
    }

    //This is Supplier report section
    public function supplierreport()
    {
        $suppliers = Supplier::all();
        return view('reports.suppliers', compact('suppliers'));

    }

    public function supplierdestroy(string $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            notify()->success('Supplier Deleted successfully. ⚡️', 'Success');
            return redirect()->route('supplierreport')->with('success', 'customer deleted successfully.');
        } catch (ModelNotFoundException $e) {

            notify()->error('Supplier not found.', 'Error');
            return redirect()->route('supplierreport')->withErrors(['error' => 'customer not found.']);
        } catch (Exception $e) {

            notify()->error('Failed to delete Supplier.', 'Error');
            return redirect()->route('supplierreport')->withErrors(['error' => 'Failed to delete customer.']);
        }
    }

    //This is gin report section
    public function ginreport()
    {
        $gins = Gin::all();
        return view('reports.gin', compact('gins'));

    }

    public function ginshow($id)
    {
        $gin = Gin::with('items')->findOrFail($id);
        return view('reports.showgin', compact('gin'));
    }

    public function gindestroy($id)
    {
        $gin = Gin::findOrFail($id);
        $gin->delete();

        notify()->success('Requested Order deleted successfully. ⚡️', 'Success');
        return redirect()->route('ginreport')->with('success', 'Requested Order deleted successfully.');
    }

    //This is puurchase order report section
    public function purchaseorderreport()
    {
        $orderRequests = OrderRequest::all();
        return view('reports.purchaseorder', compact('orderRequests'));

    }

    public function purchaseordershow($id)
    {
        $orderRequest = OrderRequest::with('items')->findOrFail($id);
        return view('reports.purchaseordershow', compact('orderRequest'));
    }

    public function purchaseorderdestroy($id)
    {
        $orderRequest = OrderRequest::findOrFail($id);
        $orderRequest->delete();

        notify()->success('Order Request deleted successfully. ⚡️', 'Success');
        return redirect()->route('purchaseorderreport')->with('success', 'Order Request deleted successfully.');
    }




}
