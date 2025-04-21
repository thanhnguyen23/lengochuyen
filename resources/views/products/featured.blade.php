@extends('layouts.app')

@section('content')
<div class="main-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title fade-in-up">
                            Khám phá công nghệ <br>
                            <span class="highlight mt-3">mới nhất</span>
                        </h1>
                        <p class="hero-description fade-in-up delay-200">
                            Sản phẩm chính hãng - Giá tốt nhất - Giao hàng siêu tốc
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-hero">
                            Mua sắm ngay
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-bg"></div>
                        <img src="https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-14-pro-model-unselect-gallery-1-202209?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1660753619946"
                             class="hero-image" alt="Featured Product">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-content pt-5 pb-5">
        <!-- Featured Products -->
        <section class="featured-section">
            <div class="section-header">
                <h2>SẢN PHẨM NỔI BẬT</h2>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            <span class="hot-badge">Hot</span>
                            <div class="hover-overlay"></div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-description">{{ $product->description }}</p>
                            <div class="product-footer">
                                <span class="price">{{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Categories -->
        <section class="categories-section pt-5">
            <div class="section-header text-center">
                <h2>DANH MỤC SẢN PHẨM</h2>
            </div>
            <div class="row pt-3">
                @php
                    $categories = [
                        ['name' => 'Điện thoại', 'type' => 'Smartphone', 'icon' => '📱'],
                        ['name' => 'Laptop', 'type' => 'Laptop', 'icon' => '💻'],
                        ['name' => 'Máy tính bảng', 'type' => 'Tablet', 'icon' => '📟'],
                        ['name' => 'Tai nghe', 'type' => 'Headphone', 'icon' => '🎧'],
                        ['name' => 'Đồng hồ', 'type' => 'Smartwatch', 'icon' => '⌚'],
                    ];
                @endphp
                @foreach($categories as $category)
                <div class="col">
                    <a href="{{ route('products.index', ['type' => $category['type']]) }}" class="category-card">
                        <span class="category-icon">{{ $category['icon'] }}</span>
                        <h3 class="category-title">{{ $category['name'] }}</h3>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Floating Cart -->
    <div class="floating-cart">
        <button class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i>
            Giỏ hàng
        </button>
    </div>
</div>

<style>
/* General Styles */
.main-container {
    background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
    min-height: 100vh;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(to right, #1a56db, #1e40af);
    color: white;
    padding: 6rem 0;
    position: relative;
    overflow: hidden;
}

.hero-pattern {
    position: absolute;
    inset: 0;
    background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
    opacity: 0.1;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-title .highlight {
    background: rgba(252, 211, 77, 0.2);
    color: #fcd34d;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    display: block;
    width: fit-content;
}

.hero-description {
    font-size: 1.25rem;
    color: #bfdbfe;
    margin-bottom: 2rem;
}

.btn-hero {
    padding: 1rem 2rem;
    font-size: 1.125rem;
    border-radius: 9999px;
    background-color: #fcd34d;
    color: #1e3a8a;
    border: none;
    transition: all 0.3s ease;
}

.btn-hero:hover {
    transform: scale(1.05);
    background-color: #fbbf24;
}

.hero-image-wrapper {
    position: relative;
}

.hero-image-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(30, 58, 138, 0.2), transparent);
    border-radius: 1.5rem;
    transform: rotate(6deg);
}

.hero-image {
    width: 100%;
    max-width: 28rem;
    margin: 0 auto;
    position: relative;
    z-index: 1;
    transition: transform 0.5s ease;
}

.hero-image:hover {
    transform: scale(1.05);
}

/* Product Slider */
.product-slider {
    position: relative;
    margin: 2rem 0;
}

.slider-container {
    overflow: hidden;
    padding: 1rem 0;
}

.slider-track {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.3s ease;
}

.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 2;
    transition: all 0.3s ease;
}

.prev-btn { left: -20px; }
.next-btn { right: -20px; }

.slider-nav:hover {
    background: #f3f4f6;
    transform: translateY(-50%) scale(1.1);
}

/* Product Cards */
.product-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
}

.product-image {
    position: relative;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.hover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .hover-overlay {
    opacity: 1;
}

.top-badge {
    position: absolute;
    top: 1rem;
    left: -1.5rem;
    background: linear-gradient(45deg, #ef4444, #f87171);
    color: white;
    padding: 0.25rem 1.5rem;
    font-size: 0.875rem;
    font-weight: bold;
    transform: rotate(-45deg);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.hot-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    animation: bounce 1s infinite;
}

.product-info {
    padding: 1.25rem;
}

.product-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.product-card:hover .product-title {
    color: #2563eb;
}

.product-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2563eb;
}

/* Categories */
.category-card {
    display: block;
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}

.category-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
}

.category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

/* Floating Cart */
.floating-cart {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 50;
}

.floating-cart .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 9999px;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.floating-cart .btn:hover {
    transform: scale(1.05);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

.delay-200 {
    animation-delay: 0.2s;
}

/* Shine Effect */
.shine-effect {
    position: relative;
    overflow: hidden;
}

.shine-effect::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        to right,
        transparent 0%,
        rgba(255,255,255,0.3) 50%,
        transparent 100%
    );
    transform: skewX(-25deg);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { left: -100%; }
    20% { left: 100%; }
    100% { left: 100%; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-description {
        font-size: 1rem;
    }

    .slider-nav {
        width: 32px;
        height: 32px;
    }

    .top-badge {
        font-size: 0.75rem;
        padding: 0.2rem 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.slider-track');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (prevBtn && nextBtn && slider) {
        prevBtn.addEventListener('click', () => {
            slider.scrollBy({
                left: -280,
                behavior: 'smooth'
            });
        });

        nextBtn.addEventListener('click', () => {
            slider.scrollBy({
                left: 280,
                behavior: 'smooth'
            });
        });

        // Show/hide navigation buttons based on scroll position
        slider.addEventListener('scroll', () => {
            prevBtn.style.opacity = slider.scrollLeft > 0 ? '1' : '0';
            nextBtn.style.opacity =
                slider.scrollLeft < (slider.scrollWidth - slider.clientWidth) ? '1' : '0';
        });
    }
});
</script>
@endsection