@extends('admin.layouts.app')
@section('title', 'Kelola Berita')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-newspaper me-2"></i>Daftar Berita</span>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Berita
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th width="120">Tanggal</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($news as $item)
                        <tr>
                            <td>
                                @if ($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="" class="rounded"
                                        style="width:60px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                {{ $item->title }}
                                @if ($item->is_featured)
                                    <span class="badge bg-warning">Unggulan</span>
                                @endif
                            </td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</td>
                            <td>
                                @if ($item->is_published)
                                    <span class="badge bg-success">Terbit</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
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
