@extends('admin.layouts.app')
@section('title', 'Edit Agenda')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Edit Agenda
        </div>
        <div class="card-body">
            <form action="{{ route('admin.agendas.update', $agenda) }}" method="POST">
                @csrf @method('PUT')
                @include('admin.agendas._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.agendas.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
