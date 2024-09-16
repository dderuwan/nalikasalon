<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\bridelpreorder;
use App\Models\SalonThretment;
use App\Models\Order;
use App\Models\Customer;


class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        // Count bookings for BridalPreorder where 'today' column matches current date
        $bridalBookingsCount = bridelpreorder::whereDate('today', $today)->count();
        // Count bookings for SalonThretment where 'today' column matches current date
        $salonBookingsCount = SalonThretment::whereDate('today', $today)->count();
        // Total bookings
        $totalBookings = $bridalBookingsCount + $salonBookingsCount;


        $todayorders=Order::whereDate('date', $today)->count();


        $totalofOrders = Order::whereDate('date', $today)->sum('total_cost_payment');
        $totalofBookings = SalonThretment::whereDate('today', $today)->sum('total_price');
        $totalAdvancePriceToday = BridelPreorder::whereDate('today', $today)
        ->where('status', 'NotCompleted')
        ->sum('advanced_payment');
        $totalbalancedPriceToday = BridelPreorder::whereDate('today', $today)
        ->where('status', 'completed')
        ->sum('Balance_Payment');
        $totalrevenue=$totalofOrders+$totalofBookings+$totalAdvancePriceToday+$totalbalancedPriceToday;



        $totalCustomers = Customer::count();

        $dailyRevenue = $this->getMonthlyRevenueData();
        

        return view('dashboard.index', compact('totalBookings','todayorders','totalrevenue','totalCustomers','dailyRevenue'));
    }



    private function getMonthlyRevenueData()
{
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $dailyRevenue = [];

    for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
        $currentDay = $date->format('Y-m-d');

        $totalofOrders = Order::whereDate('date', $currentDay)->sum('total_cost_payment');
        $totalofBookings = SalonThretment::whereDate('today', $currentDay)->sum('total_price');
        $totalAdvancePriceToday = BridelPreorder::whereDate('today', $currentDay)
            ->where('status', 'NotCompleted')
            ->sum('advanced_payment');
        $totalbalancedPriceToday = BridelPreorder::whereDate('today', $currentDay)
            ->where('status', 'completed')
            ->sum('Balance_Payment');

        $totalRevenue = $totalofOrders + $totalofBookings + $totalAdvancePriceToday + $totalbalancedPriceToday;

        $dailyRevenue[] = [
            'date' => $currentDay,
            'revenue' => $totalRevenue
        ];
    }

    return $dailyRevenue;
}



}

