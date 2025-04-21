@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                <div class="space-y-4">
                    @foreach ($cart->cartItems as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-semibold text-gray-800">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total:</span>
                        <span class="text-2xl font-bold text-pink-500">${{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                @csrf
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Shipping Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="shipping_name" class="block text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="shipping_name" id="shipping_name" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" required>
                    </div>
                    <div>
                        <label for="shipping_email" class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="shipping_email" id="shipping_email" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" required>
                    </div>
                    <div>
                        <label for="shipping_phone" class="block text-gray-700 mb-2">Phone</label>
                        <input type="tel" name="shipping_phone" id="shipping_phone" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="shipping_address" class="block text-gray-700 mb-2">Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" required></textarea>
                    </div>
                </div>

                <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Payment Method</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" id="paypal" value="paypal" class="mr-2" required>
                        <label for="paypal" class="flex items-center">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal" class="h-6">
                            <span class="ml-2">PayPal</span>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" id="visa" value="visa" class="mr-2">
                        <label for="visa" class="flex items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6">
                            <span class="ml-2">Visa</span>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" id="cash" value="cash" class="mr-2">
                        <label for="cash" class="flex items-center">
                            <i class="fas fa-money-bill-wave text-xl text-green-500"></i>
                            <span class="ml-2">Cash on Delivery</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8">
                    <label for="note" class="block text-gray-700 mb-2">Order Notes (Optional)</label>
                    <textarea name="note" id="note" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500"></textarea>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full px-6 py-3 bg-pink-500 text-white rounded hover:bg-pink-400 transition duration-300">
                        Place Order
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Details Sidebar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Details</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-800">${{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-gray-800">Free</span>
                    </div>
                    <div class="pt-4 border-t">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-800">Total</span>
                            <span class="text-2xl font-bold text-pink-500">${{ number_format($cart->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
