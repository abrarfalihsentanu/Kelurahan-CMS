@extends('admin.layouts.app')
@section('title', 'Kelola Pengaduan')

@section('content')
    <div class="card">
        <div class="card-header">
            <span><i class="fas fa-comments me-2"></i>Daftar Pengaduan</span>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th width="100">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr class="{{ !$complaint->is_read ? 'table-warning' : '' }}">
                            <td>
                                <code>{{ $complaint->ticket_number }}</code>
                                @if (!$complaint->is_read)
                                    <span class="badge bg-danger ms-1"
                                        style="font-size:10px;animation:pulse 2s infinite;">Baru</span>
                                @endif
                            </td>
                            <td>{{ $complaint->name }}</td>
                            <td>{{ $complaint->category->name ?? '-' }}</td>
                            <td>{{ Str::limit($complaint->subject, 30) }}</td>
                            <td>{{ $complaint->created_at->format('d M Y') }}</td>
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
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                    class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.complaints.edit', $complaint) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-reply"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
