@extends('admin.layouts.app')
@section('title', 'Detail Pengaduan')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-eye me-2"></i>Detail Pengaduan</span>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">No. Tiket</th>
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
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $complaint->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @switch($complaint->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @break

                                    @case('process')
                                        <span class="badge bg-info">Diproses</span>
                                    @break

                                    @case('resolved')
                                        <span class="badge bg-success">Selesai</span>
                                    @break

                                    @case('rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">{{ $complaint->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Subjek</h6>
                    <p>{{ $complaint->subject }}</p>

                    <h6 class="fw-bold">Uraian Pengaduan</h6>
                    <p class="text-muted">{!! nl2br(e($complaint->description)) !!}</p>

                    @if ($complaint->incident_date)
                        <h6 class="fw-bold">Tanggal Kejadian</h6>
                        <p class="text-muted">{{ $complaint->incident_date->translatedFormat('d F Y') }}</p>
                    @endif

                    @if ($complaint->location)
                        <h6 class="fw-bold">Lokasi Kejadian</h6>
                        <p class="text-muted">{{ $complaint->location }}</p>
                    @endif

                    @if ($complaint->attachments && count($complaint->attachments) > 0)
                        <h6 class="fw-bold">Lampiran</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($complaint->attachments as $i => $attachment)
                                <a href="{{ Storage::url($attachment) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download me-1"></i>Lampiran {{ $i + 1 }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if ($complaint->response)
                <hr>
                <h6 class="fw-bold">Tanggapan</h6>
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($complaint->response)) !!}
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-primary">
                    <i class="fas fa-reply me-1"></i>Tanggapi
                </a>
            </div>
        </div>
    </div>
@endsection
