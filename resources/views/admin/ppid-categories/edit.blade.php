@extends('admin.layouts.app')
@section('title', 'Edit Kategori PPID')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Kategori PPID
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ppid-categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.ppid-categories._form', ['category' => $ppidCategory])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.ppid-categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
