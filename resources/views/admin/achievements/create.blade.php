@extends('admin.layouts.app')
@section('title', 'Tambah Prestasi')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i>Tambah Prestasi
        </div>
        <div class="card-body">
            <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.achievements._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
