@extends('admin.layouts.app')
@section('title', 'Kelola Agenda')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-calendar-alt me-2"></i>Daftar Agenda</span>
            <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Agenda
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendas as $agenda)
                        <tr>
                            <td>{{ $agenda->title }}</td>
                            <td>{{ $agenda->date ? \Carbon\Carbon::parse($agenda->date)->format('d M Y') : '-' }}</td>
                            <td>{{ $agenda->time ?? '-' }}</td>
                            <td>{{ Str::limit($agenda->location, 30) ?? '-' }}</td>
                            <td>
                                @if ($agenda->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.agendas.edit', $agenda) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.agendas.destroy', $agenda) }}" method="POST" class="d-inline"
                                    onsubmit="return confirmDelete(this)">
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
