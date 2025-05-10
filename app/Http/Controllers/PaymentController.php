<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPaypalOrder(Request $request)
    {
        try {
            $request->validate([
                'shipping_address' => 'required|string',
                'shipping_phone' => 'required|string',
                'shipping_name' => 'required|string',
                'shipping_email' => 'required|email',
                'note' => 'nullable|string'
            ]);

            $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $cart->total_amount,
                'status' => 'pending',
                'payment_method' => 'paypal',
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

            // Create PayPal order
            $approvalUrl = $this->paymentService->createOrder($order);

            return response()->json([
                'success' => true,
                'approvalUrl' => $approvalUrl,
                'orderId' => $order->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function capturePaypalPayment(Request $request)
    {
        try {
            $request->validate([
                'orderId' => 'required|string',
                'token' => 'required|string'
            ]);

            $response = $this->paymentService->capturePayment($request->token);

            if ($response['status'] === 'COMPLETED') {
                $order = Order::where('id', $request->orderId)
                    ->where('payment_status', 'pending')
                    ->first();

                if (!$order) {
                    throw new \Exception('Order not found or already processed');
                }

                $order->payment_status = 'completed';
                $order->status = 'processing';
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Payment completed successfully',
                    'order' => $order
                ]);
            }

            throw new \Exception('Payment failed');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelPaypalPayment(Request $request)
    {
        try {
            $request->validate([
                'orderId' => 'required|integer'
            ]);

            $order = Order::where('id', $request->orderId)
                ->where('payment_status', 'pending')
                ->first();

            if (!$order) {
                throw new \Exception('Order not found or already processed');
            }

            $order->status = 'cancelled';
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment cancelled successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function visa(Order $order)
    {
        // Implement Visa payment integration here
        // This is just a placeholder - you'll need to integrate with your chosen payment gateway
        return view('payment.visa', compact('order'));
    }

    public function success(Request $request)
    {
        try {
            $response = $this->paymentService->capturePayment($request->token);

            if ($response['status'] === 'COMPLETED') {
                $order = Order::where('payment_status', 'pending')->latest()->first();
                $order->payment_status = 'completed';
                $order->status = 'processing';
                $order->save();

                return redirect()->route('orders.success', $order);
            }
        } catch (\Exception $e) {
            return redirect()->route('orders.checkout')->with('error', $e->getMessage());
        }

        return redirect()->route('orders.checkout')->with('error', 'Payment failed');
    }

    public function cancel()
    {
        return redirect()->route('orders.checkout')->with('error', 'Payment cancelled');
    }
}

