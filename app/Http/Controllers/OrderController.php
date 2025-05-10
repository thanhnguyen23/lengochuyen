<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('orders.checkout');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'shipping_address' => 'required|string',
                'shipping_phone' => 'required|string',
                'shipping_name' => 'required|string',
                'shipping_email' => 'required|email',
                'payment_method' => 'required|in:paypal,visa,cash',
                'note' => 'nullable|string'
            ]);

            $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống'
                ], 400);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $cart->total_amount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'note' => $request->note
            ]);

            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);
            }

            // Clear the cart
            $cart->cartItems()->delete();
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được tạo thành công',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}
