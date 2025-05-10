@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Payment with Visa</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="text-2xl font-bold text-pink-500">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <form id="payment-form" class="space-y-6">
                <div>
                    <label for="card-number" class="block text-gray-700 mb-2">Card Number</label>
                    <input type="text" id="card-number" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" placeholder="1234 5678 9012 3456" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="expiry-date" class="block text-gray-700 mb-2">Expiry Date</label>
                        <input type="text" id="expiry-date" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" placeholder="MM/YY" required>
                    </div>
                    <div>
                        <label for="cvv" class="block text-gray-700 mb-2">CVV</label>
                        <input type="text" id="cvv" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" placeholder="123" required>
                    </div>
                </div>

                <div>
                    <label for="card-holder" class="block text-gray-700 mb-2">Card Holder Name</label>
                    <input type="text" id="card-holder" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-pink-500" placeholder="John Doe" required>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full px-6 py-3 bg-pink-500 text-white rounded hover:bg-pink-400 transition duration-300">
                        Pay Now
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('orders.checkout') }}" class="text-gray-500 hover:text-pink-500">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Checkout
            </a>
        </div>
    </div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically integrate with your payment gateway
            // For this example, we'll just redirect to the success page
            window.location.href = "{{ route('orders.success', $order) }}";
        });

        // Add input formatting
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = value;
        });

        document.getElementById('expiry-date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.slice(0,2) + '/' + value.slice(2,4);
            }
            e.target.value = value;
        });

        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0,3);
        });
    </script>
@endsection
