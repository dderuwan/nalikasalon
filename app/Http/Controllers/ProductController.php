<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {

        $item = Item::findOrFail($id);
        return view('products', compact('item'));
    
    }
}