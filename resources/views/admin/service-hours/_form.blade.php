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
            <label class="form-label">Hari <span class="text-danger">*</span></label>
            <select name="day" class="form-select @error('day') is-invalid @enderror" required>
                <option value="">Pilih Hari</option>
                <option value="Senin" {{ old('day', $serviceHour->day ?? '') == 'Senin' ? 'selected' : '' }}>Senin
                </option>
                <option value="Selasa" {{ old('day', $serviceHour->day ?? '') == 'Selasa' ? 'selected' : '' }}>Selasa
                </option>
                <option value="Rabu" {{ old('day', $serviceHour->day ?? '') == 'Rabu' ? 'selected' : '' }}>Rabu
                </option>
                <option value="Kamis" {{ old('day', $serviceHour->day ?? '') == 'Kamis' ? 'selected' : '' }}>Kamis
                </option>
                <option value="Jumat" {{ old('day', $serviceHour->day ?? '') == 'Jumat' ? 'selected' : '' }}>Jumat
                </option>
                <option value="Sabtu" {{ old('day', $serviceHour->day ?? '') == 'Sabtu' ? 'selected' : '' }}>Sabtu
                </option>
                <option value="Minggu" {{ old('day', $serviceHour->day ?? '') == 'Minggu' ? 'selected' : '' }}>Minggu
                </option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Buka</label>
                <input type="time" name="open_time" class="form-control @error('open_time') is-invalid @enderror"
                    value="{{ old('open_time', $serviceHour->open_time ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Tutup</label>
                <input type="time" name="close_time" class="form-control @error('close_time') is-invalid @enderror"
                    value="{{ old('close_time', $serviceHour->close_time ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="note" class="form-control @error('note') is-invalid @enderror"
                value="{{ old('note', $serviceHour->note ?? '') }}" placeholder="Contoh: Istirahat 12:00 - 13:00">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $serviceHour->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_closed" class="form-check-input" value="1" id="is_closed"
                    {{ old('is_closed', $serviceHour->is_closed ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_closed">Tutup (libur)</label>
            </div>
        </div>
    </div>
</div>
