@extends('admin.layouts.app')

@section('title', 'Profil Saya')

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
                        <a class="nav-link active" href="{{ route('admin.profile.index') }}">
                            <i class="fas fa-user"></i> Informasi Profil
                        </a>
                        <a class="nav-link" href="{{ route('admin.profile.password') }}">
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
                    <i class="fas fa-user-edit me-2"></i>Informasi Profil
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
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

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Akun Dibuat</label>
                                <p class="form-control-plaintext">
                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                    {{ $user->created_at->translatedFormat('d F Y, H:i') }} WIB
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Terakhir Diperbarui</label>
                                <p class="form-control-plaintext">
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    {{ $user->updated_at->translatedFormat('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
