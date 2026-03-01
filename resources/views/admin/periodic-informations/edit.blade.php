@extends('admin.layouts.app')
@section('title', 'Edit Informasi Berkala')

@section('content')
    <div class="card">
        <div class="card-header"><i class="fas fa-edit me-2"></i>Edit Informasi Berkala</div>
        <div class="card-body">
            <form action="{{ route('admin.periodic-informations.update', $periodicInformation) }}" method="POST"
                enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.periodic-informations._form', ['document' => $periodicInformation])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('admin.periodic-informations.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
