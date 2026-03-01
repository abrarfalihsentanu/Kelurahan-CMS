@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small mb-1">Total Berita</div>
                        <div class="stat-value">{{ $stats['news'] }}</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small mb-1">Pengaduan Masuk</div>
                        <div class="stat-value">{{ $stats['complaints'] }}</div>
                        <small class="text-warning">{{ $stats['complaints_pending'] }} menunggu</small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small mb-1">Pesan Kontak</div>
                        <div class="stat-value">{{ $stats['contacts'] }}</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small mb-1">Permohonan PPID</div>
                        <div class="stat-value">{{ $stats['ppid_requests'] }}</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Latest Complaints -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bullhorn me-2 text-warning"></i>Pengaduan Terbaru</span>
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if ($latestComplaints->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestComplaints as $complaint)
                                        <tr>
                                            <td><a
                                                    href="{{ route('admin.complaints.show', $complaint) }}">{{ $complaint->ticket_number }}</a>
                                            </td>
                                            <td>{{ $complaint->category->name ?? '-' }}</td>
                                            <td>
                                                @if ($complaint->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($complaint->status == 'processing')
                                                    <span class="badge bg-info">Diproses</span>
                                                @elseif($complaint->status == 'resolved')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $complaint->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada pengaduan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Contacts -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2 text-info"></i>Pesan Kontak Terbaru</span>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if ($latestContacts->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Subjek</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestContacts as $contact)
                                        <tr>
                                            <td>{{ $contact->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.contacts.show', $contact) }}">
                                                    {{ Str::limit($contact->subject, 30) }}
                                                </a>
                                            </td>
                                            <td>{{ $contact->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada pesan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest News -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-newspaper me-2 text-primary"></i>Berita Terbaru</span>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if ($latestNews->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestNews as $news)
                                        <tr>
                                            <td>{{ Str::limit($news->title, 50) }}</td>
                                            <td>{{ $news->category->name ?? '-' }}</td>
                                            <td>
                                                @if ($news->is_published)
                                                    <span class="badge bg-success">Dipublikasi</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $news->published_at ? $news->published_at->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.news.edit', $news) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada berita</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
