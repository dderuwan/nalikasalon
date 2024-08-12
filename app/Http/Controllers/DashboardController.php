<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $todayOrdersCount = DB::table('pos')
            ->whereDate('date', $today)
            ->count();

        $todayRevenue = DB::table('pos')
            ->whereDate('date', $today)
            ->sum('total_cost_payment');

        $totalCustomers = DB::table('customers')->count();

        return view('dashboard.index', compact('todayOrdersCount', 'todayRevenue', 'totalCustomers'));
    }



}

