<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SalonThretment;
use App\Models\bridelpreorder;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Gin;
use App\Models\Salary;
use App\Models\OrderRequest;
use App\Models\OrderRequestItem;
use App\Models\Preorder;
use App\Models\RealTimeBooking;

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

    public function PreOrderReport()
    {
        $preorders = bridelpreorder::all();
        return view('reports.preorder', compact('preorders'));

    }

    
    public function RealOrderReport()
    {
        $preorders = SalonThretment::all();
        return view('reports.realtimeorder', compact('preorders'));

    }

    public function SalaryReport()
    {
        $salaries = Salary::with('employee')->get();
        return view('reports.salary', compact('salaries'));

    }

    public function MoyhlyFinalReport()
    {
        return view('reports.FinalReport');

    }

    public function generateReport(Request $request)
    {
        // Validate the date inputs
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        // Get the start and end dates
        $startDate = $request->start_date;
        $endDate = $request->end_date;
    
        // Fetch the required data from your models based on the date range
        $itemSales = Order::whereBetween('date', [$startDate, $endDate])->sum('total_cost_payment');
        $cogs = Gin::whereBetween('date', [$startDate, $endDate])->sum('total_cost_payment');
        $salonIncome = SalonThretment::whereBetween('today', [$startDate, $endDate])->sum('total_price');
        
        $totalAdvancePriceToday = BridelPreorder::whereBetween('today', [$startDate, $endDate])
        ->where('status', 'NotCompleted')
        ->sum('advanced_payment');
        $totalbalancedPriceToday = BridelPreorder::whereBetween('today', [$startDate, $endDate])
        ->where('status', 'completed')
        ->sum('total_price');
    
        $totalSalaries = Salary::whereBetween('created_at', [$startDate, $endDate])->sum('gross_salary');
    
        // Default values for manual entries
        $operationalCost = 0;
        $otherExpenses = 0; 
        $otherIncomes = 0;
    
        // Calculate totals
        $totalExpenses = $cogs + $totalSalaries + $operationalCost + $otherExpenses;
        $totalIncome = $itemSales + $totalAdvancePriceToday + $totalbalancedPriceToday + $salonIncome + $otherIncomes;
        $netProfitOrLoss = $totalIncome - $totalExpenses;
    
        // Store dates in the session
        $request->session()->put('start_date', $startDate);
        $request->session()->put('end_date', $endDate);
    
        // Pass data to the view
        return view('reports.FinalReport', [
            'reportData' => [
                'itemSales' => $itemSales,
                'cogs' => $cogs,
                'totalAdvancePriceToday' => $totalAdvancePriceToday,
                'totalbalancedPriceToday' => $totalbalancedPriceToday,
                'salonIncome' => $salonIncome,
                'totalSalaries' => $totalSalaries,
                'operationalCost' => $operationalCost,
                'otherExpenses' => $otherExpenses,
                'totalExpenses' => $totalExpenses,
                'otherIncomes' => $otherIncomes,
                'totalIncome' => $totalIncome,
                'netProfitOrLoss' => $netProfitOrLoss,
            ]
        ]);
    }
    
    public function saveManualEntries(Request $request)
    {
        // Validate manual entries
        $request->validate([
            'other_incomes' => 'nullable|numeric',
            'operational_cost' => 'nullable|numeric',
            'other_expenses' => 'nullable|numeric',
        ]);
    
        // Calculate the values from the request
        $otherIncomes = $request->input('other_incomes', 0);
        $operationalCost = $request->input('operational_cost', 0);
        $otherExpenses = $request->input('other_expenses', 0);
    
        // Fetch the previous report data
        $startDate = $request->session()->get('start_date');
        $endDate = $request->session()->get('end_date');
    
        $itemSales = Order::whereBetween('date', [$startDate, $endDate])->sum('total_cost_payment');
        $cogs = Gin::whereBetween('date', [$startDate, $endDate])->sum('total_cost_payment');
        $salonIncome = SalonThretment::whereBetween('today', [$startDate, $endDate])->sum('total_price');
        
        $totalAdvancePriceToday = BridelPreorder::whereBetween('today', [$startDate, $endDate])
        ->where('status', 'NotCompleted')
        ->sum('advanced_payment');
        $totalbalancedPriceToday = BridelPreorder::whereBetween('today', [$startDate, $endDate])
        ->where('status', 'completed')
        ->sum('total_price');
    
        $totalSalaries = Salary::whereBetween('created_at', [$startDate, $endDate])->sum('gross_salary');
    
        // Recalculate totals with manual entries
        $totalExpenses = $cogs + $totalSalaries + $operationalCost + $otherExpenses;
        $totalIncome = $itemSales + $totalAdvancePriceToday + $totalbalancedPriceToday + $salonIncome + $otherIncomes;
        $netProfitOrLoss = $totalIncome - $totalExpenses;
    
        // Pass data to the view with manual entries
        return view('reports.FinalReport', [
            'reportData' => [
                'itemSales' => $itemSales,
                'cogs' => $cogs,
                'totalAdvancePriceToday' => $totalAdvancePriceToday,
                'totalbalancedPriceToday' => $totalbalancedPriceToday,
                'salonIncome' => $salonIncome,
                'totalSalaries' => $totalSalaries,
                'operationalCost' => $operationalCost,
                'otherExpenses' => $otherExpenses,
                'totalExpenses' => $totalExpenses,
                'otherIncomes' => $otherIncomes,
                'totalIncome' => $totalIncome,
                'netProfitOrLoss' => $netProfitOrLoss,
            ]
        ]);
    }    

}
