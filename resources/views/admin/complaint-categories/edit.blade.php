@extends('admin.layouts.app')
@section('title', 'Edit Kategori Pengaduan')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Kategori Pengaduan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.complaint-categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.complaint-categories._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.complaint-categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
