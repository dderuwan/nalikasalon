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
        try {
            $items = Item::all();

            
            foreach ($items as $item) {
                $item->total_amount = $item->unit_price * $item->item_quentity;
            }

            return view('masterstock.index', compact('items'));
        } catch (Exception $e) {
            return redirect()->route('masterstock.index')->withErrors(['error' => 'Failed to retrieve stock data.']);
        }
    }
}
