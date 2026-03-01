@extends('admin.layouts.app')
@section('title', 'Edit Statistik')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Statistik
        </div>
        <div class="card-body">
            <form action="{{ route('admin.statistics.update', $statistic) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.statistics._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
