@extends('admin.layouts.app')
@section('title', 'Tanggapi Pengaduan')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-reply me-2"></i>Tanggapi Pengaduan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.complaints.update', $complaint) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.complaints._form', ['complaint' => $complaint])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
