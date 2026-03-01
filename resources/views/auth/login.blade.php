<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1B3A6B 0%, #2554A0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, #1B3A6B 0%, #2554A0 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-header img {
            width: 80px;
            margin-bottom: 15px;
        }

        .login-body {
            padding: 40px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: #1B3A6B;
            box-shadow: 0 0 0 0.2rem rgba(27, 58, 107, 0.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #1B3A6B 0%, #2554A0 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0F2A5C 0%, #1B3A6B 100%);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/img/logoDKIJakarta.png') }}" alt="Logo DKI Jakarta">
            <h4 class="mb-0">Admin Panel</h4>
            <p class="mb-0 opacity-75">Kelurahan Petamburan</p>
        </div>
        <div class="login-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com"
                            value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Website
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
