<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSController extends Controller
{
    public function showHomepage()
    {
        return view('POS.homepage');
    }
}
