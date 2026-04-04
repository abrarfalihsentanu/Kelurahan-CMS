@extends('admin.layouts.app')
@section('title', 'Kelola Slider')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-images me-2"></i>Daftar Slider</span>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Slider
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th>Subtitle</th>
                        <th width="80">Urutan</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>
                                @if ($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="" class="rounded"
                                        style="width:60px;height:40px;object-fit:cover">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ Str::limit($slider->subtitle, 50) }}</td>
                            <td>{{ $slider->order }}</td>
                            <td>
                                @if ($slider->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline"
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
