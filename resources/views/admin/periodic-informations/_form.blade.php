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
                value="{{ old('title', $document->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-select @error('category') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @php
                    $categories = [
                        'Laporan Keuangan',
                        'Laporan Kinerja',
                        'Profil Kelurahan',
                        'Data Kependudukan',
                        'Rencana Kerja',
                        'Peraturan',
                        'Lainnya',
                    ];
                @endphp
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}"
                        {{ old('category', $document->category ?? '') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $document->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Konten Detail</label>
            <textarea name="content" class="form-control summernote">{{ old('content', $document->content ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">File Dokumen @if (!isset($document))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
            <small class="text-muted">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG (Max: 10MB)</small>
            @if (isset($document) && $document->file)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $document->file) }}" target="_blank"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download me-1"></i>{{ strtoupper($document->file_type) }}
                        ({{ number_format(($document->file_size ?? 0) / 1024, 0) }} KB)
                    </a>
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="year" class="form-control"
                value="{{ old('year', $document->year ?? date('Y')) }}" min="2000" max="2100">
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $document->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" id="is_published"
                    {{ old('is_published', $document->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publikasikan</label>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'table']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush
