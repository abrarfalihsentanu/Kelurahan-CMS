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
            <label class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $category->icon ?? '') }}" placeholder="fas fa-file-alt">
            <small class="text-muted">Gunakan class Font Awesome, contoh: fas fa-file-alt</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active"
                    {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>
