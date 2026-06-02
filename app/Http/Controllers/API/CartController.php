<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = CartItem::where('user_email', $request->user()->email)->get();
        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_name' => 'required|string',
            'product_price' => 'required|integer',
        ]);

        $cartItem = CartItem::create([
            'user_email' => $request->user()->email,
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'quantity' => 1,
        ]);

        return response()->json($cartItem, 201);
    }

    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Товар удалён из корзины']);
    }
}
