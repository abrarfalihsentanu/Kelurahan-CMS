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
    <div class="col-md-6">
        <div class="card bg-light mb-3">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Pengaduan</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th width="120">No. Tiket</th>
                        <td><code>{{ $complaint->ticket_number }}</code></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $complaint->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $complaint->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $complaint->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $complaint->category->name ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card bg-light mb-3">
            <div class="card-body">
                <h6 class="fw-bold">Subjek</h6>
                <p class="mb-2">{{ $complaint->subject }}</p>

                <h6 class="fw-bold">Uraian Pengaduan</h6>
                <p class="mb-2 text-muted">{!! nl2br(e($complaint->description)) !!}</p>

                @if ($complaint->location)
                    <h6 class="fw-bold">Lokasi Kejadian</h6>
                    <p class="mb-0 text-muted">{{ $complaint->location }}</p>
                @endif
            </div>
        </div>

        @if ($complaint->attachments && count($complaint->attachments) > 0)
            <div class="mb-3">
                @foreach ($complaint->attachments as $i => $attachment)
                    <a href="{{ asset('storage/' . $attachment) }}" target="_blank"
                        class="btn btn-outline-primary btn-sm me-1 mb-1">
                        <i class="fas fa-download me-1"></i>Lampiran {{ $i + 1 }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status', $complaint->status) == 'pending' ? 'selected' : '' }}>Menunggu
                </option>
                <option value="process" {{ old('status', $complaint->status) == 'process' ? 'selected' : '' }}>Diproses
                </option>
                <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>
                    Selesai</option>
                <option value="rejected" {{ old('status', $complaint->status) == 'rejected' ? 'selected' : '' }}>
                    Ditolak</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggapan</label>
            <textarea name="response" class="form-control @error('response') is-invalid @enderror" rows="8"
                placeholder="Masukkan tanggapan untuk pengaduan ini...">{{ old('response', $complaint->response ?? '') }}</textarea>
        </div>
    </div>
</div>
