@extends('admin.layouts.app')
@section('title', 'Tambah Potensi Desa')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i>Tambah Potensi Desa
        </div>
        <div class="card-body">
            <form action="{{ route('admin.potentials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.potentials._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.potentials.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
