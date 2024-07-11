<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class MasterStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $items = Item::all();
            return view('masterstock.index', compact('items'));
    }
}
