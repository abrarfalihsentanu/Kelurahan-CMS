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
            <label class="form-label">Label <span class="text-danger">*</span></label>
            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                value="{{ old('label', $statistic->label ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nilai <span class="text-danger">*</span></label>
            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror"
                value="{{ old('value', $statistic->value ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $statistic->icon ?? '') }}" placeholder="fas fa-users">
            <small class="text-muted">Gunakan class Font Awesome, contoh: fas fa-users</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $statistic->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active"
                    {{ old('is_active', $statistic->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>
