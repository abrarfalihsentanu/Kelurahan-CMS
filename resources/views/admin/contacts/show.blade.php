@extends('admin.layouts.app')
@section('title', 'Detail Pesan')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            {{-- Detail Pesan --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-envelope me-2"></i>Detail Pesan Kontak
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">No. Tiket</th>
                            <td><span class="badge bg-dark font-monospace">{{ $contact->ticket_number ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $contact->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($contact->status === 'resolved')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($contact->status === 'process')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $contact->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Subjek</th>
                            <td>{{ $contact->subject }}</td>
                        </tr>
                    </table>
                    <hr>
                    <h6>Pesan:</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
            </div>

            {{-- Tanggapan yang sudah ada --}}
            @if ($contact->response)
                <div class="card mb-3 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-check-circle me-2"></i>Tanggapan Admin
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">
                                Ditanggapi pada
                                {{ $contact->responded_at ? \Carbon\Carbon::parse($contact->responded_at)->format('d F Y H:i') : '-' }}
                                @if ($contact->responder)
                                    oleh <strong>{{ $contact->responder->name }}</strong>
                                @endif
                            </small>
                        </div>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($contact->response)) !!}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Tanggapi Pesan --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-reply me-2"></i>Tanggapi Pesan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.respond', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending"
                                    {{ old('status', $contact->status) === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="process"
                                    {{ old('status', $contact->status) === 'process' ? 'selected' : '' }}>Diproses</option>
                                <option value="resolved"
                                    {{ old('status', $contact->status) === 'resolved' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="response" class="form-label">Tanggapan <span class="text-danger">*</span></label>
                            <textarea name="response" id="response" rows="5" class="form-control @error('response') is-invalid @enderror"
                                placeholder="Tulis tanggapan untuk pesan ini...">{{ old('response', $contact->response) }}</textarea>
                            @error('response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i
                                class="fas fa-paper-plane me-1"></i>{{ $contact->response ? 'Perbarui Tanggapan' : 'Kirim Tanggapan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">Aksi</div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                        onsubmit="return confirmDelete(this)">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary w-100">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
@endsection
