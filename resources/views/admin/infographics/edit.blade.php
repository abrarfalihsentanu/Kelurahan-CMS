@extends('admin.layouts.app')
@section('title', 'Edit Infografis')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Infografis
        </div>
        <div class="card-body">
            <form action="{{ route('admin.infographics.update', $infographic) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.infographics._form', ['infographic' => $infographic])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.infographics.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
