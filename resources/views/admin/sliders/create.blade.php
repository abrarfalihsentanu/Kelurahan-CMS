@extends('admin.layouts.app')
@section('title', 'Tambah Slider')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i>Tambah Slider
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.sliders._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
