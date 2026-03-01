@extends('admin.layouts.app')
@section('title', 'Kelola Informasi Berkala')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-calendar-check me-2"></i>Daftar Informasi Berkala</span>
            <a href="{{ route('admin.periodic-informations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Informasi Berkala
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Tipe File</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->category ?? '-' }}</td>
                            <td>{{ $document->year ?? '-' }}</td>
                            <td>
                                @if ($document->file_type)
                                    <span class="badge bg-info">{{ strtoupper($document->file_type) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($document->is_published)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.periodic-informations.edit', $document) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.periodic-informations.destroy', $document) }}" method="POST"
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
