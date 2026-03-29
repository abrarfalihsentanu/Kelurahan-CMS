@extends('admin.layouts.app')
@section('title', 'Edit Kategori Informasi')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Kategori Informasi
        </div>
        <div class="card-body">
            <form action="{{ route('admin.information-categories.update', $informationCategory) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.information-categories._form', ['category' => $informationCategory])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.information-categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
