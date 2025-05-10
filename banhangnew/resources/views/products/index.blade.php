@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar filters -->
        <div class="col-md-3">
            <form action="{{ route('products.index') }}" method="GET" class="filter-sidebar">
                <h3 class="filter-title">Bộ lọc</h3>

                <!-- Brand filter -->
                <div class="filter-group">
                    <label class="filter-label">Thương hiệu</label>
                    <select name="brand" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price filter -->
                <div class="filter-group">
                    <label class="filter-label">Giá</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" name="price_min" placeholder="Từ" value="{{ request('price_min') }}"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="number" name="price_max" placeholder="Đến" value="{{ request('price_max') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Color filter -->
                <div class="filter-group">
                    <label class="filter-label">Màu sắc</label>
                    <select name="color" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($colors as $color)
                            <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                {{ $color }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type filter -->
                <div class="filter-group">
                    <label class="filter-label">Loại</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div class="filter-group">
                    <label class="filter-label">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Lọc
                </button>
            </form>
        </div>

        <!-- Product grid -->
        <div class="col-md-9">
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-4">
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
        </div>
    </div>
</div>

<style>
/* Filter Sidebar */
.filter-sidebar {
    background: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #1f2937;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #4b5563;
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

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
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
    .filter-sidebar {
        margin-bottom: 2rem;
    }
}
</style>
@endsection
