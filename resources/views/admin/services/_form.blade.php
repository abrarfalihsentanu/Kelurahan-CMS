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
            <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $service->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                value="{{ old('slug', $service->slug ?? '') }}" placeholder="otomatis-dari-nama">
            <small class="text-muted">Biarkan kosong untuk generate otomatis dari nama</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $service->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Persyaratan</label>
            <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="4"
                placeholder="Masukkan persyaratan layanan...">{{ old('requirements', is_array($service->requirements ?? '') ? implode("\n", $service->requirements ?? []) : $service->requirements ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Prosedur</label>
            <textarea name="procedure" class="form-control @error('procedure') is-invalid @enderror" rows="4"
                placeholder="Masukkan prosedur layanan...">{{ old('procedure', $service->procedure ?? '') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Durasi</label>
                <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror"
                    value="{{ old('duration', $service->duration ?? '') }}" placeholder="Contoh: 3 hari kerja">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Biaya</label>
                <input type="text" name="cost" class="form-control @error('cost') is-invalid @enderror"
                    value="{{ old('cost', $service->cost ?? '') }}" placeholder="Contoh: Gratis / Rp 50.000">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $service->service_category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $service->icon ?? '') }}" placeholder="fas fa-file-alt">
            <small class="text-muted">Gunakan class Font Awesome</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                accept="image/*">
            @if (isset($service) && $service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $service->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active"
                    {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>
