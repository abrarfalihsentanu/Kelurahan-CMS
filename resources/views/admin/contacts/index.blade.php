@extends('admin.layouts.app')
@section('title', 'Pesan Kontak')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-envelope me-2"></i>Daftar Pesan Kontak
        </div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Subjek</th>
                        <th width="80">Baca</th>
                        <th width="100">Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr class="{{ $contact->is_read ? '' : 'table-warning' }}">
                            <td><span class="badge bg-dark font-monospace">{{ $contact->ticket_number ?? '-' }}</span></td>
                            <td>{{ $contact->created_at->format('d/m/Y') }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ Str::limit($contact->subject, 40) }}</td>
                            <td>
                                @if ($contact->is_read)
                                    <span class="badge bg-secondary">Dibaca</span>
                                @else
                                    <span class="badge bg-primary">Baru</span>
                                @endif
                            </td>
                            <td>
                                @if ($contact->status === 'resolved')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($contact->status === 'process')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
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
