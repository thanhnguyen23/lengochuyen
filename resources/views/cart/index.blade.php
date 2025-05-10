@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">

            <div id="cart-content">
                <!-- Nội dung giỏ hàng sẽ được load bằng JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
.cart-empty {
    background: #fff;
    border-radius: 1rem;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.cart-empty svg {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    color: #9CA3AF;
}

.cart-table {
    background: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.cart-table table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    background: #F9FAFB;
    padding: 1.25rem 1rem;
    font-weight: 600;
    color: #374151;
    text-align: left;
    border-bottom: 1px solid #E5E7EB;
}

.cart-table td {
    padding: 1.5rem 1rem;
    border-bottom: 1px solid #E5E7EB;
    vertical-align: middle;
}

.cart-item {
    transition: all 0.2s ease;
}

.cart-item:hover {
    background: #F9FAFB;
}

.cart-item:last-child td {
    border-bottom: none;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.5rem;
    border: 1px solid #E5E7EB;
}

.product-details {
    flex: 1;
}

.product-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.product-stock {
    color: #6B7280;
    font-size: 0.875rem;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    max-width: 120px;
}

.quantity-btn {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E5E7EB;
    border-radius: 0.375rem;
    background: #fff;
    color: #4B5563;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background: #F3F4F6;
    border-color: #D1D5DB;
}

.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-input {
    width: 3.5rem;
    height: 2.5rem;
    text-align: center;
    border: 1px solid #E5E7EB;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #111827;
    background: #fff;
}

.quantity-input:focus {
    outline: none;
    border-color: #3B82F6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

.remove-btn {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #EF4444;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    background: transparent;
}

.remove-btn:hover {
    background: #FEE2E2;
    color: #DC2626;
}

.cart-summary {
    background: #fff;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.cart-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #E5E7EB;
}

.total-label {
    font-size: 1.125rem;
    font-weight: 600;
    color: #374151;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
}

.checkout-btn {
    background: #3B82F6;
    color: #fff;
    padding: 1rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
    text-align: center;
    display: block;
    width: 100%;
}

.checkout-btn:hover {
    background: #2563EB;
}

.continue-shopping {
    background: #F3F4F6;
    color: #374151;
    padding: 1rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-block;
    margin-top: 1rem;
}

.continue-shopping:hover {
    background: #E5E7EB;
}

@media (max-width: 768px) {
    .cart-table {
        display: block;
        overflow-x: auto;
    }

    .product-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
    }

    .cart-total {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});

function loadCart() {
    window.axios.get('/cart')
        .then(response => {
            const cart = response.data.cart;
            renderCart(cart);
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            alert('Có lỗi xảy ra khi tải giỏ hàng');
        });
}

function renderCart(cart) {
    const cartContent = document.getElementById('cart-content');

    if (!cart || cart.cart_items.length === 0) {
        cartContent.innerHTML = `
            <div class="cart-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Giỏ hàng của bạn đang trống</h2>
                <p class="text-gray-500 mb-6">Hãy thêm một số sản phẩm vào giỏ hàng của bạn</p>
                <a href="{{ route('products.index') }}" class="continue-shopping">
                    Tiếp tục mua sắm
                </a>
            </div>
        `;
        return;
    }

    let total = 0;
    let html = `
        <div class="cart-table">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
    `;

    cart.cart_items.forEach(item => {
        const itemPrice = parseFloat(item.product.price) || 0;
        const itemQuantity = parseInt(item.quantity) || 0;
        const itemTotal = itemPrice * itemQuantity;
        total += itemTotal;

        const isMinQuantity = itemQuantity <= 1;
        const isMaxQuantity = itemQuantity >= item.product.stock;

        html += `
            <tr class="cart-item">
                <td>
                    <div class="product-info">
                        <img class="product-image" src="${item.product.image_url}" alt="${item.product.name}">
                        <div class="product-details">
                            <div class="product-name">${item.product.name}</div>
                            <div class="product-stock">Còn lại: ${item.product.stock} sản phẩm</div>
                        </div>
                    </div>
                </td>
                <td class="product-price">${formatPrice(itemPrice)}</td>
                <td>
                    <div class="quantity-control">
                        <button onclick="updateQuantity(${item.id}, ${itemQuantity - 1})"
                                class="quantity-btn"
                                ${isMinQuantity ? 'disabled' : ''}>-</button>
                        <input type="number"
                               value="${itemQuantity}"
                               min="1"
                               max="${item.product.stock}"
                               class="quantity-input"
                               onchange="updateQuantity(${item.id}, this.value)">
                        <button onclick="updateQuantity(${item.id}, ${itemQuantity + 1})"
                                class="quantity-btn"
                                ${isMaxQuantity ? 'disabled' : ''}>+</button>
                    </div>
                </td>
                <td class="product-price">${formatPrice(itemTotal)}</td>
                <td>
                    <button onclick="removeItem(${item.id})" class="remove-btn" title="Xóa sản phẩm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            </tr>
        `;
    });

    html += `
                </tbody>
            </table>
        </div>
        <div class="cart-summary">
            <div class="cart-total">
                <span class="total-label">Tổng cộng:</span>
                <span class="total-amount">${formatPrice(total)}</span>
            </div>
            <a href="{{ route('orders.checkout') }}" class="checkout-btn">
                Tiến hành thanh toán
            </a>
        </div>
    `;

    cartContent.innerHTML = html;
}

function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) return;

    window.axios.patch(`/cart/items/${itemId}`, {
        quantity: newQuantity
    })
    .then(response => {
        loadCart(); // Reload toàn bộ giỏ hàng
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
        alert('Có lỗi xảy ra khi cập nhật số lượng');
    });
}

function removeItem(itemId) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        return;
    }

    window.axios.delete(`/cart/items/${itemId}`)
        .then(response => {
            loadCart(); // Reload toàn bộ giỏ hàng
        })
        .catch(error => {
            console.error('Error removing item:', error);
            alert('Có lỗi xảy ra khi xóa sản phẩm');
        });
}

function formatPrice(price) {
    // Đảm bảo price là số
    const numericPrice = parseFloat(price) || 0;

    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(numericPrice);
}
</script>
@endsection
