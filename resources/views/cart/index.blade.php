@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Giỏ hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cart && $cart->cartItems->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Giá</th>
                                <th class="text-end">Tổng</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0">{{ $item->product->name }}</h5>
                                                <p class="text-muted mb-0">{{ $item->product->brand }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="input-group input-group-sm" style="width: 120px; margin: 0 auto;">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">-</button>
                                            <input type="number" class="form-control text-center" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" onchange="updateQuantity({{ $item->id }}, this.value)">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                        </div>
                                    </td>
                                    <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                    <td class="text-end">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-danger" onclick="removeItem({{ $item->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td class="text-end"><strong>{{ number_format($cart->total_amount, 0, ',', '.') }} đ</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
            </a>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                Thanh toán<i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @else
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    function updateQuantity(cartItemId, newQuantity) {
        if (newQuantity < 1) return;

        window.axios.patch(`/api/cart/items/${cartItemId}`, {
            quantity: newQuantity
        })
        .then(response => {
            if (response.data.success) {
                window.location.reload();
            } else {
                alert(response.data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật số lượng');
        });
    }

    function removeItem(cartItemId) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            return;
        }

        window.axios.delete(`/api/cart/items/${cartItemId}`)
        .then(response => {
            if (response.data.success) {
                window.location.reload();
            } else {
                alert(response.data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa sản phẩm');
        });
    }
</script>
@endsection
