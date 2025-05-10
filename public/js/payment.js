// PayPal payment handling
class PayPalPayment {
    constructor() {
        this.form = document.getElementById('checkout-form');
        this.paypalButton = document.getElementById('paypal-button');
        this.setupEventListeners();
    }

    setupEventListeners() {
        if (this.form) {
            this.form.addEventListener('submit', this.handleSubmit.bind(this));
        }
    }

    async handleSubmit(e) {
        e.preventDefault();

        if (document.getElementById('paypal').checked) {
            await this.createPayPalOrder();
        } else if (document.getElementById('cash').checked) {
            await this.createCashOrder();
        } else {
            // Handle other payment methods
            alert('Phương thức thanh toán này đang được phát triển');
        }
    }

    async createPayPalOrder() {
        try {
            const formData = new FormData(this.form);
            const response = await axios.post('/api/payment/paypal/create', {
                shipping_address: formData.get('shipping_address'),
                shipping_phone: formData.get('shipping_phone'),
                shipping_name: formData.get('shipping_name'),
                shipping_email: formData.get('shipping_email'),
                note: formData.get('note')
            });

            if (response.data.success) {
                // Store order ID in localStorage for later use
                localStorage.setItem('paypalOrderId', response.data.orderId);
                // Redirect to PayPal
                window.location.href = response.data.approvalUrl;
            } else {
                throw new Error(response.data.message);
            }
        } catch (error) {
            alert('Lỗi khi tạo đơn hàng PayPal: ' + error.message);
        }
    }

    async createCashOrder() {
        try {
            const formData = new FormData(this.form);
            const response = await axios.post('/api/orders', {
                shipping_address: formData.get('shipping_address'),
                shipping_phone: formData.get('shipping_phone'),
                shipping_name: formData.get('shipping_name'),
                shipping_email: formData.get('shipping_email'),
                note: formData.get('note'),
                payment_method: 'cash'
            });

            if (response.data.success) {
                window.location.href = `/orders/success/${response.data.order.id}`;
            } else {
                throw new Error(response.data.message);
            }
        } catch (error) {
            alert('Lỗi khi tạo đơn hàng: ' + error.message);
        }
    }

    async capturePayment(token) {
        try {
            const orderId = localStorage.getItem('paypalOrderId');
            if (!orderId) {
                throw new Error('Không tìm thấy mã đơn hàng');
            }

            const response = await axios.post('/api/payment/paypal/capture', {
                orderId: orderId,
                token: token
            });

            if (response.data.success) {
                // Clear stored order ID
                localStorage.removeItem('paypalOrderId');
                // Redirect to success page
                window.location.href = `/orders/success/${response.data.order.id}`;
            } else {
                throw new Error(response.data.message);
            }
        } catch (error) {
            alert('Lỗi khi xác nhận thanh toán: ' + error.message);
            window.location.href = '/cart';
        }
    }

    async cancelPayment() {
        try {
            const orderId = localStorage.getItem('paypalOrderId');
            if (!orderId) {
                throw new Error('Không tìm thấy mã đơn hàng');
            }

            const response = await axios.post('/api/payment/paypal/cancel', {
                orderId: orderId
            });

            if (response.data.success) {
                localStorage.removeItem('paypalOrderId');
                window.location.href = '/cart';
            } else {
                throw new Error(response.data.message);
            }
        } catch (error) {
            alert('Lỗi khi hủy thanh toán: ' + error.message);
            window.location.href = '/cart';
        }
    }
}

// Initialize PayPal payment handling
document.addEventListener('DOMContentLoaded', () => {
    new PayPalPayment();
});
