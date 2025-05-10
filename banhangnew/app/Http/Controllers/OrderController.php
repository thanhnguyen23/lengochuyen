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
        $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();
        return view('orders.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
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
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $cart->total_amount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
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

        if ($request->payment_method === 'paypal') {
            // Redirect to PayPal payment
            return redirect()->route('payment.paypal', $order);
        } elseif ($request->payment_method === 'visa') {
            // Redirect to Visa payment
            return redirect()->route('payment.visa', $order);
        }

        // For cash payment
        return redirect()->route('orders.success', $order)->with('success', 'Order placed successfully');
    }

    public function success(Order $order)
    {
        return view('orders.success', compact('order'));
    }
}
