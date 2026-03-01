@extends('admin.layouts.app')
@section('title', 'Tambah Jam Layanan')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i>Tambah Jam Layanan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.service-hours.store') }}" method="POST">
                @csrf
                @include('admin.service-hours._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.service-hours.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
