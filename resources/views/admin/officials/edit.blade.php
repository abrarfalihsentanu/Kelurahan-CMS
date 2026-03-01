@extends('admin.layouts.app')
@section('title', 'Edit Perangkat Desa')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Perangkat Desa
        </div>
        <div class="card-body">
            <form action="{{ route('admin.officials.update', $official) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.officials._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
