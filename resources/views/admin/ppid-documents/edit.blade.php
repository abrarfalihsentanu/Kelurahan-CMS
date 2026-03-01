@extends('admin.layouts.app')
@section('title', 'Edit Dokumen PPID')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fas fa-edit me-2"></i>Edit Dokumen PPID</div>
        <div class="card-body">
            <form action="{{ route('admin.ppid-documents.update', $ppidDocument) }}" method="POST"
                enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.ppid-documents._form', ['document' => $ppidDocument])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.ppid-documents.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
