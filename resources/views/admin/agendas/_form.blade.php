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
                value="{{ old('title', $agenda->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $agenda->description ?? '') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                    value="{{ old('event_date', isset($agenda) && $agenda->event_date ? $agenda->event_date->format('Y-m-d') : '') }}"
                    required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                    value="{{ old('start_time', $agenda->start_time ?? '') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                    value="{{ old('end_time', $agenda->end_time ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                value="{{ old('location', $agenda->location ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Penyelenggara</label>
            <input type="text" name="organizer" class="form-control @error('organizer') is-invalid @enderror"
                value="{{ old('organizer', $agenda->organizer ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Status Agenda</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="upcoming"
                    {{ old('status', $agenda->status ?? 'upcoming') === 'upcoming' ? 'selected' : '' }}>Akan Datang
                </option>
                <option value="ongoing"
                    {{ old('status', $agenda->status ?? 'upcoming') === 'ongoing' ? 'selected' : '' }}>Sedang
                    Berlangsung</option>
                <option value="completed"
                    {{ old('status', $agenda->status ?? 'upcoming') === 'completed' ? 'selected' : '' }}>Selesai
                </option>
            </select>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" id="is_published"
                    {{ old('is_published', $agenda->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publikasi</label>
            </div>
        </div>
    </div>
</div>
