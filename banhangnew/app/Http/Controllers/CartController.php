<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        $cartItem = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id
            ],
            [
                'quantity' => $request->quantity,
                'price' => $product->price
            ]
        );

        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cart = $cartItem->cart;
        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return redirect()->back()->with('success', 'Cart updated successfully');
    }
}
