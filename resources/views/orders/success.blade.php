@extends('layouts.app')

@section('content')
    <div class="text-center">
        <div class="mb-8">
            <i class="fas fa-check-circle text-6xl text-green-500"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Thank You for Your Order!</h1>
        <p class="text-gray-600 mb-8">Your order has been placed successfully.</p>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Details</h2>
            <div class="grid grid-cols-2 gap-4 text-left">
                <div>
                    <p class="text-gray-600">Order Number:</p>
                    <p class="font-semibold">{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Order Date:</p>
                    <p class="font-semibold">{{ $order->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method:</p>
                    <p class="font-semibold">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Total Amount:</p>
                    <p class="font-semibold text-pink-500">${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="space-x-4">
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-pink-500 text-white rounded hover:bg-pink-400 transition duration-300">
                Continue Shopping
            </a>
        </div>
    </div>
@endsection
