@extends('admin.layouts.app')
@section('title', 'Kelola Perangkat Desa')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-2"></i>Daftar Perangkat Desa</span>
            <a href="{{ route('admin.officials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Perangkat
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="60">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Bidang</th>
                        <th width="100">Level</th>
                        <th width="80">Urutan</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($officials as $official)
                        <tr>
                            <td>
                                @if ($official->photo)
                                    <img src="{{ Storage::url($official->photo) }}" alt="" class="rounded-circle"
                                        style="width:40px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $official->name }}</td>
                            <td>{{ $official->position }}</td>
                            <td>{{ $official->division->name ?? '-' }}</td>
                            <td>
                                @switch($official->level)
                                    @case('lurah')
                                        <span class="badge bg-primary">Lurah</span>
                                    @break

                                    @case('sekretaris')
                                        <span class="badge bg-info">Sekretaris</span>
                                    @break

                                    @case('kasi')
                                        <span class="badge bg-warning">Kasi</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">Staff</span>
                                @endswitch
                            </td>
                            <td>{{ $official->order }}</td>
                            <td>
                                @if ($official->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.officials.edit', $official) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.officials.destroy', $official) }}" method="POST"
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
