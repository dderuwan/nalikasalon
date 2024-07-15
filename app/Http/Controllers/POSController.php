<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Customer;
use Illuminate\View\View;


class POSController extends Controller
{
    public function showHomepage()
    {
        $items = Item::all();
        $customers = Customer::all();
        return view('POS.homepage', compact('items','customers'));

    }
}
