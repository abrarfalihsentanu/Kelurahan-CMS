@extends('admin.layouts.app')
@section('title', 'Edit Permohonan')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fas fa-edit me-2"></i>Update Status Permohonan</div>
        <div class="card-body">
            <form action="{{ route('admin.ppid-requests.update', $ppidRequest) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $ppidRequest->name }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $ppidRequest->email }}" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Informasi yang Diminta</label>
                        <textarea class="form-control" rows="3" readonly>{{ $ppidRequest->information_needed }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $ppidRequest->status == 'pending' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="processing" {{ $ppidRequest->status == 'processing' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="approved" {{ $ppidRequest->status == 'approved' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="rejected" {{ $ppidRequest->status == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Tanggapan</label>
                        <textarea name="response" class="form-control" rows="4">{{ $ppidRequest->response }}</textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.ppid-requests.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
