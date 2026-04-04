@extends('admin.layouts.app')
@section('title', 'Kelola Prestasi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-trophy me-2"></i>Daftar Prestasi</span>
            <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Prestasi
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th>Tingkat</th>
                        <th>Tahun</th>
                        <th width="100">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achievements as $achievement)
                        <tr>
                            <td>
                                @if ($achievement->image)
                                    <img src="{{ asset('storage/' . $achievement->image) }}" alt="" class="rounded"
                                        style="width:60px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $achievement->title }}</td>
                            <td>{{ $achievement->level ?? '-' }}</td>
                            <td>{{ $achievement->year ?? '-' }}</td>
                            <td>
                                @if ($achievement->is_published)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.achievements.edit', $achievement) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST"
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
