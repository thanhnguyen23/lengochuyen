@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>

    @if ($cart && $cart->cartItems->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-4">Product</th>
                        <th class="text-center py-4">Quantity</th>
                        <th class="text-right py-4">Price</th>
                        <th class="text-right py-4">Total</th>
                        <th class="text-right py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->cartItems as $item)
                        <tr class="border-b">
                            <td class="py-4">
                                <div class="flex items-center">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                        <p class="text-gray-600">{{ $item->product->brand }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex justify-center items-center">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center border rounded">
                                        <button type="button" onclick="decrementQuantity('quantity-{{ $item->id }}')" class="px-3 py-1 text-gray-600 hover:text-pink-500">-</button>
                                        <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-x py-1">
                                        <button type="button" onclick="incrementQuantity('quantity-{{ $item->id }}')" class="px-3 py-1 text-gray-600 hover:text-pink-500">+</button>
                                    </div>
                                    <button type="submit" class="ml-2 text-sm text-blue-500 hover:text-blue-700">Update</button>
                                </form>
                            </td>
                            <td class="text-right py-4">${{ number_format($item->price, 2) }}</td>
                            <td class="text-right py-4">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            <td class="text-right py-4">
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-4 font-semibold">Total:</td>
                        <td class="text-right py-4 font-bold text-2xl text-pink-500">${{ number_format($cart->total_amount, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-8 text-right">
                <a href="{{ route('orders.checkout') }}" class="px-6 py-3 bg-pink-500 text-white rounded hover:bg-pink-400 transition duration-300">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-pink-500 text-white rounded hover:bg-pink-400 transition duration-300">
                Continue Shopping
            </a>
        </div>
    @endif

    <script>
        function incrementQuantity(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(id) {
            const input = document.getElementById(id);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection
