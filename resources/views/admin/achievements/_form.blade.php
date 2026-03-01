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
                value="{{ old('title', $achievement->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $achievement->description ?? '') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tahun</label>
                <input type="text" name="year" class="form-control @error('year') is-invalid @enderror"
                    value="{{ old('year', $achievement->year ?? '') }}" placeholder="Contoh: 2024">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tingkat</label>
                <input type="text" name="level" class="form-control @error('level') is-invalid @enderror"
                    value="{{ old('level', $achievement->level ?? '') }}"
                    placeholder="Contoh: Kota, Provinsi, Nasional">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Penyelenggara</label>
                <input type="text" name="organizer" class="form-control @error('organizer') is-invalid @enderror"
                    value="{{ old('organizer', $achievement->organizer ?? '') }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                accept="image/*">
            @if (isset($achievement) && $achievement->image)
                <img src="{{ Storage::url($achievement->image) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $achievement->icon ?? '') }}" placeholder="fas fa-trophy">
            <small class="text-muted">Gunakan class Font Awesome</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $achievement->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" id="is_published"
                    {{ old('is_published', $achievement->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publikasi</label>
            </div>
        </div>
    </div>
</div>
