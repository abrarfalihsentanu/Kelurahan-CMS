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
                value="{{ old('name', $official->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                value="{{ old('position', $official->position ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip', $official->nip ?? '') }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Bidang/Seksi</label>
                <select name="division_id" class="form-select @error('division_id') is-invalid @enderror">
                    <option value="">Pilih Bidang</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}"
                            {{ old('division_id', $official->division_id ?? '') == $division->id ? 'selected' : '' }}>
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Level <span class="text-danger">*</span></label>
                <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                    <option value="lurah" {{ old('level', $official->level ?? '') == 'lurah' ? 'selected' : '' }}>Lurah
                    </option>
                    <option value="sekretaris"
                        {{ old('level', $official->level ?? '') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                    <option value="kasi" {{ old('level', $official->level ?? '') == 'kasi' ? 'selected' : '' }}>Kasi
                    </option>
                    <option value="staff"
                        {{ old('level', $official->level ?? 'staff') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                accept="image/*">
            @if (isset($official) && $official->photo)
                <img src="{{ Storage::url($official->photo) }}" alt="" class="mt-2 rounded"
                    style="max-width:100%;max-height:150px">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control"
                value="{{ old('order', $official->order ?? 0) }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active"
                    {{ old('is_active', $official->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
    </div>
</div>
