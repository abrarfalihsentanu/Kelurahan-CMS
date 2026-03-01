@extends('admin.layouts.app')
@section('title', 'Permohonan Informasi')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-envelope-open-text me-2"></i>Daftar Permohonan Informasi
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th width="100">Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr class="{{ !$request->is_read ? 'table-warning' : '' }}">
                            <td><span class="badge bg-dark font-monospace">{{ $request->ticket_number }}</span></td>
                            <td>
                                {{ $request->created_at->format('d/m/Y') }}
                                @if (!$request->is_read)
                                    <span class="badge bg-danger ms-1" style="font-size:10px;">Baru</span>
                                @endif
                            </td>
                            <td>{{ $request->name }}</td>
                            <td>
                                @if ($request->type === 'keberatan')
                                    <span class="badge bg-warning text-dark">Keberatan</span>
                                @else
                                    <span class="badge bg-info">Permohonan</span>
                                @endif
                            </td>
                            <td>
                                @if ($request->status == 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($request->status == 'processing')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif($request->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.ppid-requests.show', $request) }}"
                                    class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.ppid-requests.destroy', $request) }}" method="POST"
                                    class="d-inline" onsubmit="return confirmDelete(this)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
