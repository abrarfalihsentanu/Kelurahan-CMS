@extends('admin.layouts.app')
@section('title', 'Kelola Jam Layanan')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-clock me-2"></i>Daftar Jam Layanan</span>
            <a href="{{ route('admin.service-hours.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Jam Layanan
            </a>
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Buka</th>
                        <th>Jam Tutup</th>
                        <th width="80">Status</th>
                        <th>Keterangan</th>
                        <th width="80">Urutan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($serviceHours as $hour)
                        <tr>
                            <td>{{ $hour->day }}</td>
                            <td>{{ $hour->open_time ?? '-' }}</td>
                            <td>{{ $hour->close_time ?? '-' }}</td>
                            <td>
                                @if ($hour->is_closed)
                                    <span class="badge bg-danger">Tutup</span>
                                @else
                                    <span class="badge bg-success">Buka</span>
                                @endif
                            </td>
                            <td>{{ $hour->note ?? '-' }}</td>
                            <td>{{ $hour->order }}</td>
                            <td>
                                <a href="{{ route('admin.service-hours.edit', $hour) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.service-hours.destroy', $hour) }}" method="POST"
                                    class="d-inline" onsubmit="return confirmDelete(this)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
