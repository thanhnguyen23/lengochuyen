@extends('layouts.app')

@section('content')
<style>
.checkout-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

.checkout-title {
    font-size: 2rem;
    color: #2d3748;
    margin-bottom: 2rem;
    text-align: center;
    font-weight: 700;
}

.checkout-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.checkout-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.checkout-card-title {
    font-size: 1.25rem;
    color: #2d3748;
    margin-bottom: 1.5rem;
    font-weight: 600;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0.75rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    color: #4a5568;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.payment-method {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-method:hover {
    border-color: #4299e1;
    background: #f7fafc;
}

.payment-method input[type="radio"] {
    margin-right: 1rem;
}

.payment-method img {
    height: 24px;
    margin-right: 1rem;
}

.payment-method-label {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: #4a5568;
}

.submit-button {
    width: 100%;
    padding: 1rem;
    background: #4299e1;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-button:hover {
    background: #3182ce;
    transform: translateY(-1px);
}

.order-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 1rem;
}

.order-item-details {
    flex: 1;
}

.order-item-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.order-item-quantity {
    color: #718096;
}

.order-item-price {
    font-weight: 600;
    color: #2d3748;
}

.order-summary {
    position: sticky;
    top: 2rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    color: #4a5568;
}

.summary-row.total {
    border-top: 2px solid #e2e8f0;
    margin-top: 1rem;
    padding-top: 1rem;
    font-weight: 600;
    color: #2d3748;
    font-size: 1.25rem;
}

@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }

    .checkout-container {
        padding: 1rem;
    }
}
</style>

<div class="checkout-container">
    <h1 class="checkout-title">Thanh toán</h1>

    <div class="checkout-grid">
        <div>
            <div class="checkout-card">
                <h2 class="checkout-card-title">Đơn hàng của bạn</h2>
                <div id="order-summary">
                    <!-- Order items will be loaded here -->
                </div>
            </div>

            <form id="checkout-form" class="checkout-card">
                @csrf
                <h2 class="checkout-card-title">Thông tin giao hàng</h2>
                <div class="form-group">
                    <label for="shipping_name" class="form-label">Họ và tên</label>
                    <input type="text" name="shipping_name" id="shipping_name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="shipping_email" class="form-label">Email</label>
                    <input type="email" name="shipping_email" id="shipping_email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="shipping_phone" class="form-label">Số điện thoại</label>
                    <input type="tel" name="shipping_phone" id="shipping_phone" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="shipping_address" class="form-label">Địa chỉ</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" class="form-input" required></textarea>
                </div>

                <h2 class="checkout-card-title">Phương thức thanh toán</h2>
                <div class="payment-method">
                    <input type="radio" name="payment_method" id="paypal" value="paypal" required>
                    <label for="paypal" class="payment-method-label">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal">
                        <span>PayPal</span>
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" name="payment_method" id="visa" value="visa">
                    <label for="visa" class="payment-method-label">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa">
                        <span>Visa</span>
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" name="payment_method" id="cash" value="cash">
                    <label for="cash" class="payment-method-label">
                        <i class="fas fa-money-bill-wave" style="color: #48bb78; font-size: 1.5rem; margin-right: 0.5rem;"></i>
                        <span>Thanh toán khi nhận hàng</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Ghi chú (Không bắt buộc)</label>
                    <textarea name="note" id="note" rows="3" class="form-input"></textarea>
                </div>

                <button type="submit" class="submit-button">
                    Đặt hàng
                </button>
            </form>
        </div>

        <div class="order-summary">
            <div class="checkout-card">
                <h2 class="checkout-card-title">Chi tiết đơn hàng</h2>
                <div id="order-details">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});

function loadCart() {
    axios.get('/cart')
        .then(response => {
            const cart = response.data.cart;
            console.log(cart)
            renderOrderSummary(cart);
            renderOrderDetails(cart);
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            alert('Có lỗi xảy ra khi tải giỏ hàng');
        });
}

function renderOrderSummary(cart) {
    const orderSummary = document.getElementById('order-summary');
    let html = '';

    cart.cart_items.forEach(item => {
        html += `
            <div class="order-item">
                <img src="${item.product.image_url}" alt="${item.product.name}" class="order-item-image">
                <div class="order-item-details">
                    <h3 class="order-item-name">${item.product.name}</h3>
                    <p class="order-item-quantity">Số lượng: ${item.quantity}</p>
                </div>
                <span class="order-item-price">${formatPrice(item.price * item.quantity)}</span>
            </div>
        `;
    });

    orderSummary.innerHTML = html;
}

function renderOrderDetails(cart) {
    const orderDetails = document.getElementById('order-details');
    // Tính tổng tiền từ cart_items
    const total = cart.cart_items.reduce((sum, item) => {
        return sum + (item.price * item.quantity);
    }, 0);

    orderDetails.innerHTML = `
        <div>
            <div class="summary-row">
                <span>Tạm tính</span>
                <span>${formatPrice(total)}</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                <span>Miễn phí</span>
            </div>
            <div class="summary-row total">
                <span>Tổng cộng</span>
                <span>${formatPrice(total)}</span>
            </div>
        </div>
    `;
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

// Initialize PayPal payment handling
new PayPalPayment();
</script>
<script src="{{ asset('js/payment.js') }}"></script>
@endsection
