@extends('admin.layouts.app')

@section('title', 'Ubah Password')

@push('styles')
    <style>
        .profile-header {
            background: linear-gradient(135deg, #1B3A6B, #0F2A5C);
            border-radius: 12px;
            color: #fff;
            padding: 30px;
            margin-bottom: 24px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            border: 3px solid rgba(255, 255, 255, .4);
        }

        .profile-nav .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all .2s;
        }

        .profile-nav .nav-link:hover {
            background: #f0f4f8;
        }

        .profile-nav .nav-link.active {
            background: #1B3A6B;
            color: #fff;
        }

        .profile-nav .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
    </style>
@endpush

@section('content')
    @php $user = Auth::user(); @endphp

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="d-flex align-items-center">
            <div class="profile-avatar me-3">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="mb-0 opacity-75"><i class="fas fa-envelope me-1"></i>{{ $user->email }}</p>
                <small class="opacity-50">Bergabung sejak {{ $user->created_at->translatedFormat('d F Y') }}</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-2">
                    <nav class="profile-nav nav flex-column">
                        <a class="nav-link" href="{{ route('admin.profile.index') }}">
                            <i class="fas fa-user"></i> Informasi Profil
                        </a>
                        <a class="nav-link active" href="{{ route('admin.profile.password') }}">
                            <i class="fas fa-lock"></i> Ubah Password
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Pastikan password baru minimal 8 karakter dan mudah Anda ingat.
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Lama <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control @error('current_password') is-invalid @enderror" required
                                placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-1"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
