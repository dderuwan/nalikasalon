<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime; 


class RevenueController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    

    public function getMonthlyRevenue()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        // Get revenue for each day of the current month
        $dailyRevenue = DB::table('bridelpreorder')
            ->selectRaw('DATE(today) as date, 
                (SELECT SUM(total_cost_payment) FROM orders WHERE DATE(date) = DATE(bridelpreorder.today)) as total_orders,
                (SELECT SUM(total_price) FROM salon_thretments WHERE DATE(today) = DATE(bridelpreorder.today)) as total_bookings,
                SUM(CASE WHEN status = "NotCompleted" THEN advanced_payment ELSE 0 END) as total_advance,
                SUM(CASE WHEN status = "completed" THEN Balance_Payment ELSE 0 END) as total_balance')
            ->whereBetween('today', [$startOfMonth, $endOfMonth])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    
        $revenueData = $dailyRevenue->map(function($day) {
            return [
                'date' => $day->date,
                'daily_revenue' => $day->total_orders + $day->total_bookings + $day->total_advance + $day->total_balance
            ];
        });
    
        // Return as JSON response
        return response()->json($revenueData);
    }
    


    



    public function getDailyRevenueForColumnChart()
    {
  
        $currentDate = new \DateTime();
        
        $currentMonthStart = (clone $currentDate)->modify('first day of this month')->format('Y-m-d');
        $currentMonthEnd = (clone $currentDate)->modify('last day of this month')->format('Y-m-d');
        
        $lastMonthStart = (clone $currentDate)->modify('first day of last month')->format('Y-m-d');
        $lastMonthEnd = (clone $currentDate)->modify('last day of last month')->format('Y-m-d');
    
    
        // Retrieve revenue data for the current month
        $currentMonthRevenue = DB::table('pos')
            ->select(DB::raw('DATE(date) as date'), DB::raw('SUM(total_cost_payment) as total_revenue'))
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date');
    
        // Retrieve revenue data for the last month
        $lastMonthRevenue = DB::table('pos')
            ->select(DB::raw('DATE(date) as date'), DB::raw('SUM(total_cost_payment) as total_revenue'))
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date');
    

        $currentMonthDays = [];
        $lastMonthDays = [];
        $categories = [];
    

        $currentMonthDaysInMonth = (new \DateTime($currentMonthEnd))->format('j');
        $lastMonthDaysInMonth = (new \DateTime($lastMonthEnd))->format('j');
    
        for ($day = 0; $day < $currentMonthDaysInMonth; $day++) {
            $currentDateStr = (new \DateTime($currentMonthStart))->modify("+$day days")->format('Y-m-d');
            $lastDateStr = (new \DateTime($lastMonthStart))->modify("+$day days")->format('Y-m-d');
    
            $categories[] = $day + 1;
    

            $currentMonthDays[] = isset($currentMonthRevenue[$currentDateStr]) ? $currentMonthRevenue[$currentDateStr]->total_revenue : 0;
    

            $lastMonthDays[] = isset($lastMonthRevenue[$lastDateStr]) ? $lastMonthRevenue[$lastDateStr]->total_revenue : 0;
        }
    

        $currentMonthDays = array_pad($currentMonthDays, $currentMonthDaysInMonth, 0);
        $lastMonthDays = array_pad($lastMonthDays, $currentMonthDaysInMonth, 0);
    
        $totalCurrentMonthRevenue = array_sum($currentMonthDays);
        $totalLastMonthRevenue = array_sum($lastMonthDays);
    
     
        \Log::info('Current Month Revenue Data:', ['currentMonthRevenue' => $currentMonthRevenue]);
        \Log::info('Last Month Revenue Data:', ['lastMonthRevenue' => $lastMonthRevenue]);
        \Log::info('Categories:', ['categories' => $categories]);
   
        return response()->json([
            'categories' => $categories,
            'currentMonth' => $currentMonthDays,
            'lastMonth' => $lastMonthDays,
            'totalCurrentMonthRevenue' => $totalCurrentMonthRevenue,
            'totalLastMonthRevenue' => $totalLastMonthRevenue
        ]);
    }
    
    


}




