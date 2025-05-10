@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Search form -->
    <div class="search-form mb-5">
        <form action="{{ route('products.search') }}" method="GET">
            <div class="input-group">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Tìm kiếm sản phẩm..."
                    class="form-control form-control-lg">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Tìm kiếm
                </button>
            </div>
        </form>
    </div>

    <!-- Search results -->
    @if(request()->has('keyword'))
        <div class="search-results">
            <h2 class="search-title">
                Kết quả tìm kiếm cho "{{ request('keyword') }}"
                <span class="result-count">({{ $products->total() }} sản phẩm)</span>
            </h2>

            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-3">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    <div class="hover-overlay"></div>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title">{{ $product->name }}</h3>
                                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="product-footer">
                                        <span class="price">${{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                            Chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper mt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="no-results">
                    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary mt-3">
                        Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        @else
            <div class="search-prompt">
                <p>Vui lòng nhập từ khóa để tìm kiếm sản phẩm.</p>
            </div>
        @endif
</div>

<style>
/* Search Form */
.search-form {
    max-width: 800px;
    margin: 0 auto;
}

.search-form .input-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 0.5rem;
    overflow: hidden;
}

.search-form .form-control {
    border: none;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
}

.search-form .btn {
    padding: 0 2rem;
    font-size: 1.1rem;
}

/* Search Results */
.search-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: #1f2937;
}

.result-count {
    color: #6b7280;
    font-size: 1.1rem;
    font-weight: normal;
}

/* Product Cards */
.product-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.product-image img {
    width: 100%;
    height: 100%;
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

.product-info {
    padding: 1.25rem;
}

.product-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1f2937;
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

/* No Results & Search Prompt */
.no-results,
.search-prompt {
    text-align: center;
    padding: 3rem 0;
    color: #6b7280;
    font-size: 1.1rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.page-link {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    color: #4b5563;
    background: white;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: #f3f4f6;
    color: #2563eb;
}

.page-item.active .page-link {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
}

/* Responsive */
@media (max-width: 768px) {
    .search-form .form-control {
        padding: 0.75rem 1rem;
    }

    .search-form .btn {
        padding: 0 1rem;
    }

    .search-title {
        font-size: 1.25rem;
    }
}
</style>
@endsection
