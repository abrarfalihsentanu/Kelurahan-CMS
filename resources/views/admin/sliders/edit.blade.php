@extends('admin.layouts.app')
@section('title', 'Edit Slider')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Slider
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.sliders._form', ['slider' => $slider])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
