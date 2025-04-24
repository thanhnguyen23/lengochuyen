<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('cartItems.product')
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'total_amount' => 0
            ]);
        }

        return response()->json($cart);
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Số lượng sản phẩm trong kho không đủ'
            ], 422);
        }

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

        // Update product stock
        $product->stock -= $request->quantity;
        $product->save();

        // Update cart total
        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json([
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart' => $cart->load('cartItems.product')
        ]);
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Số lượng sản phẩm trong kho không đủ'
            ], 422);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cart = $cartItem->cart;
        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json([
            'message' => 'Đã cập nhật số lượng',
            'cart' => $cart->load('cartItems.product')
        ]);
    }

    public function removeItem(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        $cart->total_amount = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json([
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'cart' => $cart->load('cartItems.product')
        ]);
    }
}
