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
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $potential->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $potential->description ?? '') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>
                <select name="information_category_id"
                    class="form-select @error('information_category_id') is-invalid @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('information_category_id', $potential->information_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                    value="{{ old('location', $potential->location ?? '') }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                accept="image/*">
            @if (isset($potential) && $potential->image)
                <img src="{{ asset('storage/' . $potential->image) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $potential->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" id="is_published"
                    {{ old('is_published', $potential->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Aktif</label>
            </div>
        </div>
    </div>
</div>
