@extends('layouts.app')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="product-detail">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainImage">
                        @if($product->is_featured)
                            <span class="badge-featured">Nổi bật</span>
                        @endif
                        @if($product->is_new)
                            <span class="badge-new">Mới</span>
                        @endif
                    </div>
                    @if($product->gallery)
                        <div class="thumbnail-list mt-3">
                            @foreach(json_decode($product->gallery) as $image)
                                <div class="thumbnail" onclick="changeMainImage('{{ $image }}')">
                                    <img src="{{ $image }}" alt="Gallery image">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="product-meta">
                        <span class="brand"><i class="fas fa-building me-2"></i>Thương hiệu: {{ $product->brand }}</span>
                        <span class="type"><i class="fas fa-tag me-2"></i>Loại: {{ $product->type }}</span>
                        <span class="stock"><i class="fas fa-box me-2"></i>Kho: {{ $product->stock }} sản phẩm</span>
                    </div>

                    <div class="product-price">
                        <span class="current-price">{{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="compare-price">{{ number_format($product->compare_price, 2) }}</span>
                            <span class="discount-badge">
                                -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                            </span>
                        @endif
                    </div>

                    <div class="product-description">
                        {{ $product->description }}
                    </div>

                    <div class="product-actions">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-3">
                            @csrf
                            <div class="quantity-input">
                                <button type="button" class="btn-quantity" onclick="decrementQuantity()">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" id="quantity">
                                <button type="button" class="btn-quantity" onclick="incrementQuantity()">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary flex-grow-1" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart me-2"></i>
                                {{ $product->stock < 1 ? 'Hết hàng' : 'Thêm vào giỏ hàng' }}
                            </button>
                        </form>
                    </div>

                    <div class="product-features">
                        <div class="feature-item">
                            <i class="fas fa-truck"></i>
                            <span>Miễn phí vận chuyển</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-undo"></i>
                            <span>Đổi trả trong 30 ngày</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Bảo hành 12 tháng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs mt-5">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab">
                        Mô tả chi tiết
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="specs-tab" data-bs-toggle="tab" href="#specs" role="tab">
                        Thông số kỹ thuật
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab">
                        Đánh giá
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    {!! $product->long_description !!}
                </div>
                <div class="tab-pane fade" id="specs" role="tabpanel">
                    <table class="table table-striped">
                        <tbody>
                            @foreach(json_decode($product->specifications ?? '[]') as $spec)
                                <tr>
                                    <th>{{ $spec->name }}</th>
                                    <td>{{ $spec->value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="text-center py-4">
                        <p class="mb-3">Chưa có đánh giá nào cho sản phẩm này.</p>
                        <button class="btn btn-primary" onclick="alert('Tính năng đang được phát triển')">
                            <i class="fas fa-star me-2"></i>Viết đánh giá
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="related-products mt-5">
                <h2 class="section-title">Sản phẩm liên quan</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($relatedProducts as $related)
                        <div class="col">
                            <div class="product-card h-100">
                                <div class="product-image">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                                    @if($related->is_featured)
                                        <span class="badge-featured">Nổi bật</span>
                                    @endif
                                    @if($related->is_new)
                                        <span class="badge-new">Mới</span>
                                    @endif
                                    <div class="hover-overlay">
                                        <a href="{{ route('products.show', $related) }}" class="btn btn-light btn-sm">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info p-3">
                                    <h3 class="related-product-title">
                                        <a href="{{ route('products.show', $related) }}">{{ $related->name }}</a>
                                    </h3>
                                    <div class="product-meta mb-2">
                                        <span class="brand">{{ $related->brand }}</span>
                                        <span class="type">{{ $related->type }}</span>
                                    </div>
                                    <div class="product-footer d-flex justify-content-between align-items-center">
                                        <div class="price-wrapper">
                                            <span class="current-price">{{ number_format($related->price, 2) }}</span>
                                            @if($related->compare_price)
                                                <span class="compare-price small">{{ number_format($related->compare_price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="stock-status {{ $related->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                            {{ $related->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Product Gallery */
.product-gallery {
    position: relative;
}

.main-image {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.main-image img {
    width: 100%;
    height: auto;
    display: block;
}

.badge-featured,
.badge-new {
    position: absolute;
    top: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 600;
    z-index: 1;
}

.badge-featured {
    left: 1rem;
    background: #2563eb;
    color: white;
}

.badge-new {
    right: 1rem;
    background: #10b981;
    color: white;
}

.thumbnail-list {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding: 0.5rem 0;
}

.thumbnail {
    flex: 0 0 80px;
    height: 80px;
    border-radius: 0.25rem;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.thumbnail:hover,
.thumbnail.active {
    opacity: 1;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.product-title {
    font-size: 2rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
}

.product-meta {
    display: flex;
    gap: 2rem;
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.product-price {
    margin-bottom: 1.5rem;
}

.current-price {
    font-size: 2rem;
    font-weight: bold;
    color: #2563eb;
}

.compare-price {
    text-decoration: line-through;
    color: #6b7280;
    margin-left: 1rem;
}

.discount-badge {
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.product-description {
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Product Actions */
.quantity-input {
    display: flex;
    align-items: center;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    overflow: hidden;
}

.btn-quantity {
    background: #f3f4f6;
    border: none;
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-quantity:hover {
    background: #e5e7eb;
}

.quantity-input input {
    width: 60px;
    text-align: center;
    border: none;
    padding: 0.5rem;
    -moz-appearance: textfield;
}

.quantity-input input::-webkit-outer-spin-button,
.quantity-input input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Product Features */
.product-features {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4b5563;
}

.feature-item i {
    font-size: 1.25rem;
    color: #2563eb;
}

/* Product Tabs */
.nav-tabs {
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 1.5rem;
}

.nav-tabs .nav-link {
    color: #6b7280;
    font-weight: 500;
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
}

.nav-tabs .nav-link:hover {
    color: #2563eb;
}

.nav-tabs .nav-link.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
}

.tab-content {
    padding: 1.5rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Reviews */
.review-item {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.review-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.review-author img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.review-rating i {
    color: #d1d5db;
}

.review-rating i.active {
    color: #fbbf24;
}

.review-content {
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 0.5rem;
}

.review-date {
    color: #6b7280;
    font-size: 0.875rem;
}

/* Related Products Styling */
.related-products {
    padding: 2rem 0;
    background: #f8fafc;
    border-radius: 1rem;
    margin-top: 3rem !important;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
}

.section-title:after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: #2563eb;
    margin: 0.5rem auto;
}

.product-card {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.product-image {
    position: relative;
    padding-top: 75%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.hover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .hover-overlay {
    opacity: 1;
}

.related-product-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.related-product-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-product-title a:hover {
    color: #2563eb;
}

.product-meta {
    font-size: 0.875rem;
    color: #6b7280;
}

.product-meta span:not(:last-child):after {
    content: '•';
    margin: 0 0.5rem;
}

.price-wrapper .current-price {
    font-size: 1.125rem;
    font-weight: 600;
    color: #2563eb;
}

.price-wrapper .compare-price {
    text-decoration: line-through;
    color: #9ca3af;
    margin-left: 0.5rem;
}

.stock-status {
    font-size: 0.875rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
}

.stock-status.in-stock {
    background: #dcfce7;
    color: #166534;
}

.stock-status.out-of-stock {
    background: #fee2e2;
    color: #991b1b;
}

@media (max-width: 768px) {
    .related-products {
        padding: 1.5rem 0;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .product-card {
        margin-bottom: 1rem;
    }
}
</style>

<script>
function changeMainImage(imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
        if(thumb.querySelector('img').src === imageUrl) {
            thumb.classList.add('active');
        }
    });
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    if(parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>
@endsection
