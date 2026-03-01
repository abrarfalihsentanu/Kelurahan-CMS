@extends('admin.layouts.app')
@section('title', 'Kelola Galeri')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-images me-2"></i>Daftar Galeri</span>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Galeri
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th width="100">Tipe</th>
                        <th width="80">Urutan</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $gallery)
                        <tr>
                            <td>
                                @if ($gallery->image)
                                    <img src="{{ Storage::url($gallery->image) }}" alt="" class="rounded"
                                        style="width:60px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $gallery->title }}</td>
                            <td>
                                @if ($gallery->type == 'image')
                                    <span class="badge bg-info">Gambar</span>
                                @else
                                    <span class="badge bg-danger">Video</span>
                                @endif
                            </td>
                            <td>{{ $gallery->order }}</td>
                            <td>
                                @if ($gallery->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST"
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
