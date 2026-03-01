@extends('layouts.app')

@section('title', __('ui.kontak_tracking_page_title'))

@push('styles')
    <style>
        .tracking-card {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .tracking-card-header {
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            color: #fff;
            padding: 24px 28px;
        }

        .tracking-card-header.success {
            background: linear-gradient(135deg, #2E7D32, #43A047);
        }

        .tracking-card-header h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .tracking-card-header p {
            font-size: 13.5px;
            opacity: .85;
            margin: 0;
        }

        .tracking-body {
            padding: 28px;
        }

        .ticket-number {
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            border-radius: 10px;
            padding: 20px 24px;
            text-align: center;
            margin-bottom: 24px;
        }

        .ticket-number label {
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 8px;
        }

        .ticket-number code {
            font-size: 24px;
            font-weight: 800;
            color: var(--blue);
            letter-spacing: 2px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .detail-item {
            padding: 14px 16px;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .detail-item label {
            font-size: 11px;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: .5px;
            display: block;
            margin-bottom: 4px;
        }

        .detail-item span {
            font-size: 14px;
            color: var(--gray-800);
            font-weight: 600;
        }

        .detail-full {
            grid-column: 1 / -1;
        }

        .status-badge-lg {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .status-badge-lg.pending {
            background: #FFF3E0;
            color: var(--orange);
        }

        .status-badge-lg.process {
            background: #E3F2FD;
            color: var(--blue);
        }

        .status-badge-lg.resolved {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .timeline {
            position: relative;
            padding: 0;
            margin: 24px 0 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 18px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--gray-200);
            border-radius: 3px;
        }

        .timeline-item {
            position: relative;
            padding-left: 50px;
            padding-bottom: 24px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: 9px;
            top: 2px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
        }

        .timeline-dot.active {
            background: var(--blue);
        }

        .timeline-dot.done {
            background: #43A047;
        }

        .timeline-content h5 {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-800);
            margin: 0 0 4px;
        }

        .timeline-content p {
            font-size: 12.5px;
            color: var(--gray-500);
            margin: 0;
        }

        .response-box {
            background: #F1F8E9;
            border: 1px solid #AED581;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .response-box h4 {
            font-size: 14px;
            font-weight: 700;
            color: #33691E;
            margin: 0 0 8px;
        }

        .response-box p {
            font-size: 13.5px;
            color: #558B2F;
            line-height: 1.7;
            margin: 0;
        }

        .not-found-box {
            text-align: center;
            padding: 40px 20px;
        }

        .not-found-box i {
            font-size: 48px;
            color: var(--gray-300);
            margin-bottom: 16px;
        }

        .not-found-box h4 {
            font-size: 16px;
            color: var(--gray-700);
            margin-bottom: 8px;
        }

        .not-found-box p {
            font-size: 13.5px;
            color: var(--gray-500);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--gray-100);
            color: var(--gray-700);
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-back:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('kontak') }}">{{ __('ui.nav_contact') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.kontak_tracking_page_title') }}</span>
            </div>
            <h1><i class="fa fa-search"></i> {{ __('ui.kontak_tracking_page_title') }}</h1>
            <p>{{ __('ui.kontak_tracking_page_desc') }}</p>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="page-wrapper">
        <div class="main-content">

            @if (session('success'))
                <div
                    style="background:#E8F5E9;border:1px solid #4CAF50;color:#2E7D32;padding:16px;border-radius:8px;margin-bottom:24px;">
                    <i class="fa fa-check-circle"></i> <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            @if ($ticket && $contact)
                <!-- RESULT: FOUND -->
                <div class="tracking-card">
                    <div class="tracking-card-header {{ $contact->status == 'resolved' ? 'success' : '' }}">
                        <h3><i class="fa fa-clipboard-check"></i> {{ __('ui.kontak_tracking_detail_title') }}</h3>
                        <p>Berikut adalah status terkini pesan Anda</p>
                    </div>
                    <div class="tracking-body">
                        <div class="ticket-number">
                            <label>{{ __('ui.kontak_tracking_ticket') }}</label>
                            <code>{{ $contact->ticket_number }}</code>
                        </div>

                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>{{ __('ui.kontak_tracking_name') }}</label>
                                <span>{{ $contact->name }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Jenis Pesan</label>
                                <span>{{ $contact->type }}</span>
                            </div>
                            <div class="detail-item">
                                <label>{{ __('ui.kontak_tracking_date') }}</label>
                                <span>{{ $contact->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                            </div>
                            <div class="detail-item">
                                <label>{{ __('ui.kontak_tracking_status') }}</label>
                                <span class="status-badge-lg {{ $contact->status }}">
                                    @switch($contact->status)
                                        @case('pending')
                                            <i class="fa fa-clock"></i> Menunggu Tanggapan
                                        @break

                                        @case('process')
                                            <i class="fa fa-cogs"></i> Sedang Diproses
                                        @break

                                        @case('resolved')
                                            <i class="fa fa-check-circle"></i> Sudah Ditanggapi
                                        @break

                                        @default
                                            <i class="fa fa-clock"></i> {{ $contact->status }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="detail-item detail-full">
                                <label>{{ __('ui.kontak_tracking_subject') }}</label>
                                <span>{{ $contact->subject }}</span>
                            </div>
                            <div class="detail-item detail-full">
                                <label>{{ __('ui.kontak_tracking_content') }}</label>
                                <span style="font-weight:400;line-height:1.7;">{{ $contact->message }}</span>
                            </div>
                            @if ($contact->email)
                                <div class="detail-item">
                                    <label>Email</label>
                                    <span>{{ $contact->email }}</span>
                                </div>
                            @endif
                            @if ($contact->phone)
                                <div class="detail-item">
                                    <label>Telepon</label>
                                    <span>{{ $contact->phone }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Timeline -->
                        <h4 style="font-size:14px;font-weight:700;color:var(--gray-700);margin-bottom:4px;">
                            <i class="fa fa-stream"></i> {{ __('ui.kontak_tracking_timeline') }}
                        </h4>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot done"><i class="fa fa-check"></i></div>
                                <div class="timeline-content">
                                    <h5>Pesan Diterima</h5>
                                    <p>{{ $contact->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div
                                    class="timeline-dot {{ in_array($contact->status, ['process', 'resolved']) ? 'done' : 'active' }}">
                                    <i
                                        class="fa {{ in_array($contact->status, ['process', 'resolved']) ? 'fa-check' : 'fa-hourglass-half' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Dibaca & Diproses</h5>
                                    <p>
                                        @if (in_array($contact->status, ['process', 'resolved']))
                                            Pesan telah dibaca dan sedang/telah ditindaklanjuti
                                        @else
                                            Menunggu petugas membaca pesan
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $contact->status == 'resolved' ? 'done' : '' }}">
                                    <i
                                        class="fa {{ $contact->status == 'resolved' ? 'fa-check' : 'fa-flag-checkered' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Tanggapan Resmi</h5>
                                    <p>
                                        @if ($contact->status == 'resolved')
                                            Pesan telah ditanggapi
                                        @else
                                            Menunggu tanggapan resmi
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($contact->response)
                            <div class="response-box">
                                <h4><i class="fa fa-reply"></i> {{ __('ui.kontak_tracking_response') }}</h4>
                                <p>{!! nl2br(e($contact->response)) !!}</p>
                                @if ($contact->responded_at)
                                    <small style="color:#689F38;margin-top:8px;display:block;">
                                        Ditanggapi: {{ $contact->responded_at->translatedFormat('d F Y, H:i') }} WIB
                                    </small>
                                @endif
                            </div>
                        @endif

                        <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
                            <a href="{{ route('kontak') }}" class="btn-back">
                                <i class="fa fa-arrow-left"></i> Kembali ke Kontak
                            </a>
                            <a href="{{ route('kontak') }}" class="btn-back" style="background:var(--blue);color:#fff;">
                                <i class="fa fa-plus"></i> Kirim Pesan Baru
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($ticket && !$contact)
                <!-- RESULT: NOT FOUND -->
                <div class="tracking-card">
                    <div class="tracking-card-header" style="background:linear-gradient(135deg,var(--orange),#FB8C00);">
                        <h3><i class="fa fa-exclamation-triangle"></i> {{ __('ui.kontak_tracking_not_found') }}</h3>
                        <p>{{ __('ui.kontak_tracking_not_found_desc') }}</p>
                    </div>
                    <div class="tracking-body">
                        <div class="not-found-box">
                            <i class="fa fa-search"></i>
                            <h4>Tiket "{{ $ticket }}" tidak ditemukan</h4>
                            <p>Pastikan nomor tiket yang Anda masukkan sudah benar. Nomor tiket diberikan saat Anda
                                mengirim pesan.<br>Format: <code>KTK-YYYYMM-XXXXX</code></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- FORM SEARCH (always visible) -->
            <div class="tracking-card">
                <div class="tracking-card-header">
                    <h3><i class="fa fa-search"></i> {{ __('ui.kontak_tracking_search_title') }}</h3>
                    <p>Masukkan nomor tiket untuk melihat status dan tanggapan</p>
                </div>
                <div class="tracking-body">
                    <form style="max-width:500px;" method="GET" action="{{ route('kontak.tracking') }}">
                        <div style="display:flex;gap:12px;align-items:flex-end;">
                            <div style="flex:1;">
                                <label
                                    style="display:block;font-size:13px;font-weight:600;color:var(--gray-700);margin-bottom:6px;">Nomor
                                    Tiket</label>
                                <input type="text" name="ticket"
                                    placeholder="{{ __('ui.kontak_tracking_search_placeholder') }}" required
                                    value="{{ $ticket ?? '' }}"
                                    style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-300);border-radius:8px;font-size:14px;" />
                            </div>
                            <button type="submit"
                                style="padding:10px 20px;background:var(--blue);color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;white-space:nowrap;">
                                <i class="fa fa-search"></i> {{ __('ui.kontak_tracking_search_btn') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-clock"></i> Jam Pelayanan</div>
                <div class="jam-table">
                    <div class="jam-row"><span>Senin – Kamis</span><span class="jam-time">08.00 – 16.00</span></div>
                    <div class="jam-row"><span>Jumat</span><span class="jam-time">08.00 – 16.30</span></div>
                    <div class="jam-row weekend"><span>Sabtu – Minggu</span><span class="jam-time closed">Libur</span>
                    </div>
                    <div class="jam-note"><i class="fa fa-info-circle"></i> Istirahat: 12.00 – 13.00 WIB</div>
                </div>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-phone-alt"></i> Kontak Kami</div>
                <div class="kontak-list">
                    <a href="tel:{{ $settings['phone'] ?? '' }}" class="kontak-item"><i
                            class="fa fa-phone"></i><span>{{ $settings['phone'] ?? '(021) 5303540' }}</span></a>
                    <a href="mailto:{{ $settings['email'] ?? '' }}" class="kontak-item"><i
                            class="fa fa-envelope"></i><span>{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</span></a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '') }}"
                        class="kontak-item"><i
                            class="fab fa-whatsapp"></i><span>{{ $settings['whatsapp'] ?? '0812-1234-5678' }}
                            (WA)</span></a>
                </div>
            </div>
        </aside>
    </div>
@endsection
