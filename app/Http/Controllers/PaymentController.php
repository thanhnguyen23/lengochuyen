<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function paypal(Order $order)
    {
        try {
            $approvalUrl = $this->paymentService->createOrder($order);
            return redirect()->away($approvalUrl);
        } catch (\Exception $e) {
            return redirect()->route('orders.checkout')->with('error', $e->getMessage());
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
