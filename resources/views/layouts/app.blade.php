<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop Bán Hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
        }
        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .card {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .card-header {
            background-color: #4e73df;
            color: white;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #4e73df;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Shop Bán Hàng</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index', ['type' => 'Smartphone']) }}">Điện thoại</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['type' => 'Laptop']) }}">Laptop</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['type' => 'Tablet']) }}">Máy tính bảng</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['type' => 'Headphone']) }}">Tai nghe</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['type' => 'Smartwatch']) }}">Đồng hồ</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </a>
                    </li>
                    <li class="nav-item" id="cart-nav-item" style="display: none;">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item dropdown" id="user-nav-item" style="display: none;">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar" id="user-avatar"></div>
                            <span id="user-name"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="handleLogout(event)">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item" id="login-nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item" id="register-nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Về chúng tôi</h5>
                    <p>Shop Bán Hàng - Nơi mua sắm trực tuyến uy tín, chất lượng với đa dạng sản phẩm công nghệ.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> 0123 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@shopbanhang.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Shop Bán Hàng. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite(['resources/js/app.js'])

    <script>
        // Check authentication status
        function checkAuth() {
            const user = JSON.parse(localStorage.getItem('user'));
            const token = localStorage.getItem('token');

            if (user && token) {
                // User is logged in
                document.getElementById('cart-nav-item').style.display = 'block';
                document.getElementById('user-nav-item').style.display = 'block';
                document.getElementById('login-nav-item').style.display = 'none';
                document.getElementById('register-nav-item').style.display = 'none';

                // Update user info
                document.getElementById('user-name').textContent = user.name;
                document.getElementById('user-avatar').textContent = user.name.charAt(0).toUpperCase();
            } else {
                // User is not logged in
                document.getElementById('cart-nav-item').style.display = 'none';
                document.getElementById('user-nav-item').style.display = 'none';
                document.getElementById('login-nav-item').style.display = 'block';
                document.getElementById('register-nav-item').style.display = 'block';
            }
        }

        // Handle logout
        function handleLogout(event) {
            event.preventDefault();

            window.axios.post('/logout')
                .then(response => {
                    if (response.data.message) {
                        // Clear localStorage
                        localStorage.removeItem('user');
                        localStorage.removeItem('token');

                        // Redirect to home page
                        window.location.href = '{{ route("home") }}';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Add to cart functionality
        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            const token = localStorage.getItem('token');

            if (!token) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            window.axios.post(`/cart/add/${productId}`, {
                quantity: quantity
            },
                {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }
            )
            .then(response => {
                if (response.data.success) {
                    alert('Đã thêm sản phẩm vào giỏ hàng');
                } else {
                    alert(response.data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
            });
        }

        // Quantity increment/decrement
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Check auth status on page load
        document.addEventListener('DOMContentLoaded', checkAuth);
    </script>
</body>
</html>
