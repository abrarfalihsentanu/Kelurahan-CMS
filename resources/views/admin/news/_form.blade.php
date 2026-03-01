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
                value="{{ old('title', $news->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                value="{{ old('slug', $news->slug ?? '') }}" placeholder="otomatis-dari-judul">
            <small class="text-muted">Biarkan kosong untuk generate otomatis dari judul</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Ringkasan</label>
            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Konten <span class="text-danger">*</span></label>
            <textarea name="content" class="form-control summernote @error('content') is-invalid @enderror" rows="10">{{ old('content', $news->content ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                accept="image/*">
            @if (isset($news) && $news->image)
                <img src="{{ Storage::url($news->image) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Publikasi</label>
            <input type="datetime-local" name="published_at"
                class="form-control @error('published_at') is-invalid @enderror"
                value="{{ old('published_at', isset($news) && $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" id="is_published"
                    {{ old('is_published', $news->is_published ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publikasikan</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_featured" class="form-check-input" value="1" id="is_featured"
                    {{ old('is_featured', $news->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Berita Unggulan</label>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
