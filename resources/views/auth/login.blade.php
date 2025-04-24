@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">Đăng nhập</h3>
                </div>
                <div class="card-body p-4">
                    <div id="alert-container"></div>

                    <form id="loginForm" onsubmit="return handleLogin(event)">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                            </div>
                            <div class="invalid-feedback" id="password-error"></div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="mb-0">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
}

function handleLogin(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    if (typeof window.axios === 'undefined') {
        console.error('Axios is not loaded');
        showAlert('Có lỗi xảy ra khi đăng nhập', 'danger');
        return false;
    }

    window.axios.post('/api/login', {
        email: formData.get('email'),
        password: formData.get('password'),
        remember: formData.get('remember') === 'on'
    })
    .then(response => {
        const { data } = response;
        if (data.token) {
            // Store user info and token in localStorage
            localStorage.setItem('user', JSON.stringify(data.user));
            localStorage.setItem('token', data.token);

            showAlert('Đăng nhập thành công!');

            // Redirect to home page
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.response && error.response.data) {
            showAlert(error.response.data.message || 'Email hoặc mật khẩu không đúng', 'danger');
        } else {
            showAlert('Có lỗi xảy ra khi đăng nhập', 'danger');
        }
    });

    return false;
}
</script>
@endsection
