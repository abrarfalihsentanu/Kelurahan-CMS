@extends('admin.layouts.app')
@section('title', 'Detail Permohonan')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            {{-- Detail Permohonan --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope-open-text me-2"></i>Detail Permohonan</span>
                    <div>
                        @if ($ppidRequest->type === 'keberatan')
                            <span class="badge bg-warning text-dark me-1">Keberatan</span>
                        @else
                            <span class="badge bg-info me-1">Permohonan</span>
                        @endif
                        @if ($ppidRequest->status == 'pending')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($ppidRequest->status == 'processing')
                            <span class="badge bg-info">Diproses</span>
                        @elseif($ppidRequest->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">No. Tiket</th>
                            <td><span class="badge bg-dark font-monospace">{{ $ppidRequest->ticket_number }}</span></td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $ppidRequest->type === 'keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Permohonan</th>
                            <td>{{ $ppidRequest->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $ppidRequest->name }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $ppidRequest->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $ppidRequest->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $ppidRequest->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $ppidRequest->address ?? '-' }}</td>
                        </tr>
                        @if ($ppidRequest->reference_number)
                            <tr>
                                <th>No. Registrasi Rujukan</th>
                                <td><span
                                        class="badge bg-secondary font-monospace">{{ $ppidRequest->reference_number }}</span>
                                </td>
                            </tr>
                        @endif
                    </table>
                    <hr>
                    <h6>{{ $ppidRequest->type === 'keberatan' ? 'Alasan Keberatan:' : 'Tujuan Permohonan:' }}</h6>
                    <p>{{ $ppidRequest->information_type ?? '-' }}</p>
                    <h6>{{ $ppidRequest->type === 'keberatan' ? 'Uraian Keberatan:' : 'Informasi yang Diminta:' }}</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($ppidRequest->information_detail)) !!}
                    </div>
                    @if ($ppidRequest->purpose && $ppidRequest->type === 'permohonan')
                        <h6 class="mt-3">Tujuan Penggunaan:</h6>
                        <p>{{ $ppidRequest->purpose }}</p>
                    @endif
                </div>
            </div>

            {{-- Tanggapan yang sudah ada --}}
            @if ($ppidRequest->response)
                <div class="card mb-3 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-check-circle me-2"></i>Tanggapan
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">
                                Ditanggapi pada
                                {{ $ppidRequest->responded_at ? \Carbon\Carbon::parse($ppidRequest->responded_at)->format('d F Y H:i') : '-' }}
                                @if ($ppidRequest->responder)
                                    oleh <strong>{{ $ppidRequest->responder->name }}</strong>
                                @endif
                            </small>
                        </div>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($ppidRequest->response)) !!}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Tanggapi --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-reply me-2"></i>Tanggapi Permohonan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ppid-requests.update', $ppidRequest) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending"
                                    {{ old('status', $ppidRequest->status) == 'pending' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="processing"
                                    {{ old('status', $ppidRequest->status) == 'processing' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="approved"
                                    {{ old('status', $ppidRequest->status) == 'approved' ? 'selected' : '' }}>Disetujui
                                </option>
                                <option value="rejected"
                                    {{ old('status', $ppidRequest->status) == 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="response" class="form-label">Tanggapan <span class="text-danger">*</span></label>
                            <textarea name="response" id="response" rows="5" class="form-control @error('response') is-invalid @enderror"
                                placeholder="Tulis tanggapan untuk permohonan ini...">{{ old('response', $ppidRequest->response) }}</textarea>
                            @error('response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i
                                class="fas fa-paper-plane me-1"></i>{{ $ppidRequest->response ? 'Perbarui Tanggapan' : 'Kirim Tanggapan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">Aksi</div>
                <div class="card-body">
                    <form action="{{ route('admin.ppid-requests.destroy', $ppidRequest) }}" method="POST"
                        onsubmit="return confirmDelete(this)">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>Hapus Permohonan
                        </button>
                    </form>
                </div>
            </div>
            <a href="{{ route('admin.ppid-requests.index') }}" class="btn btn-secondary w-100">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
@endsection
