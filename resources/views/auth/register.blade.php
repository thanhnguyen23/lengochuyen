@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">Đăng ký tài khoản</h3>
                </div>
                <div class="card-body p-4">
                    <div id="alert-container"></div>

                    <form id="registerForm" onsubmit="return handleRegister(event)">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
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

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="mb-0">Đã có tài khoản? <a href="{{ route('login') }}" class="text-primary">Đăng nhập</a></p>
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

function showErrors(errors) {
    Object.keys(errors).forEach(field => {
        const input = document.getElementById(field);
        const errorDiv = document.getElementById(`${field}-error`);
        if (input && errorDiv) {
            input.classList.add('is-invalid');
            errorDiv.innerHTML = errors[field][0];
        }
    });
}

function handleRegister(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');

    window.axios.post('/api/register', {
        name: formData.get('name'),
        email: formData.get('email'),
        password: formData.get('password'),
        password_confirmation: formData.get('password_confirmation')
    })
    .then(response => {
        const { data } = response;
        if (data.token) {
            // Store user info and token in localStorage
            localStorage.setItem('user', JSON.stringify(data.user));
            localStorage.setItem('token', data.token);

            showAlert('Đăng ký thành công!');

            // Redirect to home page
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.response && error.response.data) {
            if (error.response.data.errors) {
                showErrors(error.response.data.errors);
            } else {
                showAlert(error.response.data.message || 'Có lỗi xảy ra khi đăng ký', 'danger');
            }
        } else {
            showAlert('Có lỗi xảy ra khi đăng ký', 'danger');
        }
    });

    return false;
}
</script>
@endsection
