<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
        public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        $cartItem = [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'image' => $request->input('image'),
        ];

        if(isset($cart[$cartItem['title']])) {
            $cart[$cartItem['title']]['quantity']++;
        } else {
            $cart[$cartItem['title']] = $cartItem;
            $cart[$cartItem['title']]['quantity'] = 1;
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }


    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('shopping_cart', ['cart' => $cart]);
    }


    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);
        \Log::info('Cart count fetched: ' . $cartCount);
        return response()->json(['cart_count' => $cartCount]);
    }
    

    public function removeFromCart($title)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$title])) {
            unset($cart[$title]);
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }


}
