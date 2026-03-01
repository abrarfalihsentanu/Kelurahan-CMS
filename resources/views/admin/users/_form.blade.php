@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name ?? '') }}" required placeholder="Masukkan nama lengkap">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}"
                required placeholder="contoh@email.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password
                        @if (isset($user))
                            <small class="text-muted">(kosongkan jika tidak diubah)</small>
                        @else
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        {{ !isset($user) ? 'required' : '' }} placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        Konfirmasi Password
                        @if (!isset($user))
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        {{ !isset($user) ? 'required' : '' }} placeholder="Ulangi password">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-cog me-1"></i>Pengaturan</h6>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Akun Aktif</label>
                    </div>
                    <small class="text-muted">Admin nonaktif tidak bisa login ke panel admin.</small>
                </div>

                @if (isset($user))
                    <hr>
                    <div class="text-muted" style="font-size:13px;">
                        <p class="mb-1"><i class="fas fa-calendar me-1"></i>Dibuat:
                            {{ $user->created_at->format('d M Y, H:i') }}</p>
                        <p class="mb-0"><i class="fas fa-clock me-1"></i>Diperbarui:
                            {{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
