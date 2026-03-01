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
                value="{{ old('title', $gallery->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $gallery->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe <span class="text-danger">*</span></label>
            <select name="type" class="form-select @error('type') is-invalid @enderror" id="gallery_type" required>
                <option value="image" {{ old('type', $gallery->type ?? 'image') == 'image' ? 'selected' : '' }}>Gambar
                </option>
                <option value="video" {{ old('type', $gallery->type ?? '') == 'video' ? 'selected' : '' }}>Video
                </option>
            </select>
        </div>
        <div class="mb-3" id="video_url_field"
            style="{{ old('type', $gallery->type ?? 'image') == 'video' ? '' : 'display:none' }}">
            <label class="form-label">URL Video</label>
            <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                value="{{ old('video_url', $gallery->video_url ?? '') }}"
                placeholder="https://www.youtube.com/watch?v=...">
            <small class="text-muted">Masukkan URL video YouTube</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Gambar @if (!isset($gallery))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                accept="image/*">
            @if (isset($gallery) && $gallery->image)
                <img src="{{ Storage::url($gallery->image) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $gallery->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active"
                    {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('gallery_type').addEventListener('change', function() {
            document.getElementById('video_url_field').style.display = this.value === 'video' ? '' : 'none';
        });
    </script>
@endpush
