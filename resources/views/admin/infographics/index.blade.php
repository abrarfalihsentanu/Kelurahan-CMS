@extends('admin.layouts.app')
@section('title', 'Kelola Infografis')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-chart-pie me-2"></i>Daftar Infografis</span>
            <a href="{{ route('admin.infographics.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Infografis
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th width="80">Urutan</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($infographics as $infographic)
                        <tr>
                            <td>
                                @if ($infographic->image)
                                    <img src="{{ asset('storage/' . $infographic->image) }}" alt="" class="rounded"
                                        style="width:60px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $infographic->title }}</td>
                            <td>{{ $infographic->informationCategory->name ?? '-' }}</td>
                            <td>{{ $infographic->order }}</td>
                            <td>
                                @if ($infographic->is_published)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.infographics.edit', $infographic) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.infographics.destroy', $infographic) }}" method="POST"
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
