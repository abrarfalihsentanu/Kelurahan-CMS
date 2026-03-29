@extends('layouts.app')

@section('title', __('ui.informasi_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.informasi_title') }}</span>
            </div>
            <h1><i class="fa fa-newspaper"></i> {{ __('ui.informasi_title') }}</h1>
            <p>{{ __('ui.informasi_desc') }}</p>
        </div>
    </section>

    <!-- MAIN -->
    <div class="page-wrapper">
        <div class="main-content">

            <!-- ==================== AGENDA KELURAHAN ==================== -->
            <section class="section-block" id="agenda">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_agenda_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_agenda_title') }}</h2>
                    </div>
                    <a href="{{ route('agenda') }}" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>

                <div class="agenda-list">
                    @forelse($agendas as $agenda)
                        <div class="agenda-item" @if ($agenda->status == 'completed') style="opacity:.75;" @endif>
                            <div class="agenda-date"
                                @if ($agenda->status == 'completed') style="background:var(--gray-400);" @endif>
                                <span class="agenda-day">{{ $agenda->event_date->format('d') }}</span>
                                <span class="agenda-month">{{ $agenda->event_date->translatedFormat('M') }}</span>
                                <span class="agenda-year">{{ $agenda->event_date->format('Y') }}</span>
                            </div>
                            <div class="agenda-info">
                                <h4>{{ $agenda->title }}</h4>
                                <p>
                                    <i class="fa fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($agenda->start_time)->format('H.i') }} –
                                    {{ \Carbon\Carbon::parse($agenda->end_time)->format('H.i') }} WIB
                                    &nbsp;|&nbsp;
                                    <i class="fa fa-map-marker-alt"></i> {{ $agenda->location }}
                                </p>
                                @if ($agenda->description)
                                    <p style="font-size:12.5px;color:var(--gray-500);margin-top:6px;">
                                        {{ $agenda->description }}</p>
                                @endif
                            </div>
                            @if ($agenda->status == 'completed')
                                <span class="agenda-badge selesai">Selesai</span>
                            @elseif($agenda->status == 'ongoing')
                                <span class="agenda-badge berlangsung">Berlangsung</span>
                            @else
                                <span class="agenda-badge akan-datang">Akan Datang</span>
                            @endif
                        </div>
                    @empty
                        <p>{{ __('ui.informasi_no_agenda') }}</p>
                    @endforelse
                </div>
            </section>

            <!-- ==================== PRESTASI ==================== -->
            <section class="section-block" id="prestasi">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_achievement_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_achievement_title') }}</h2>
                    </div>
                </div>

                <div class="prestasi-grid">
                    @forelse($achievements as $achievement)
                        <div class="prestasi-card">
                            <div class="prestasi-card-img"
                                style="background-image:url('{{ $achievement->image ? asset('storage/' . $achievement->image) : asset('assets/img/prestasi-placeholder.svg') }}')">
                            </div>
                            <div class="prestasi-card-body">
                                <span class="prestasi-year"><i class="fa fa-trophy"></i> {{ $achievement->year }}</span>
                                <h3>{{ $achievement->title }}</h3>
                                <p>{{ $achievement->description }}</p>
                                @if ($achievement->awarded_by)
                                    <div class="prestasi-meta">
                                        <span><i class="fa fa-award"></i> {{ $achievement->awarded_by }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <!-- Default prestasi when none in database -->
                        <div class="prestasi-card">
                            <div class="prestasi-card-img"
                                style="background-image:url('{{ asset('assets/img/prestasi1.svg') }}')"></div>
                            <div class="prestasi-card-body">
                                <span class="prestasi-year"><i class="fa fa-trophy"></i> 2025</span>
                                <h3>Kelurahan Terbaik Se-Jakarta Pusat</h3>
                                <p>Meraih peringkat 1 dalam penilaian kinerja kelurahan se-wilayah Jakarta Pusat oleh
                                    Walikota Jakarta Pusat.</p>
                                <div class="prestasi-meta">
                                    <span><i class="fa fa-award"></i> Pemerintah Kota Jakarta Pusat</span>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- ==================== INFOGRAFIS ==================== -->
            <section class="section-block" id="infografis">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_infographic_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_infographic_title') }}</h2>
                    </div>
                    <a href="{{ route('infografis') }}" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>

                @if ($infographics->count() > 0)
                    <div class="berita-grid">
                        @foreach ($infographics->take(6) as $infographic)
                            <article class="berita-card">
                                <div class="berita-card-img"
                                    style="background-image:url('{{ $infographic->image ? asset('storage/' . $infographic->image) : asset('assets/img/news-placeholder.svg') }}')">
                                    @if ($infographic->informationCategory)
                                        <span class="berita-cat">{{ $infographic->informationCategory->name }}</span>
                                    @endif
                                </div>
                                <div class="berita-card-body">
                                    @if ($infographic->source || $infographic->year)
                                        <div class="berita-card-date">
                                            @if ($infographic->source)
                                                <i class="fa fa-database"></i> {{ $infographic->source }}
                                            @endif
                                            @if ($infographic->year)
                                                &nbsp;<i class="fa fa-calendar"></i> {{ $infographic->year }}
                                            @endif
                                        </div>
                                    @endif
                                    <h3 class="berita-card-title">
                                        <a
                                            href="{{ route('infografis.show', $infographic->id) }}">{{ $infographic->title }}</a>
                                    </h3>
                                    @if ($infographic->description)
                                        <p class="berita-card-excerpt">{{ Str::limit($infographic->description, 120) }}</p>
                                    @endif
                                    <a href="{{ route('infografis.show', $infographic->id) }}" class="berita-read-more">
                                        {{ __('ui.infographic_detail') }} <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div
                        style="text-align:center;padding:40px;background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);">
                        <i class="fa fa-chart-pie" style="font-size:48px;color:var(--gray-300);margin-bottom:16px;"></i>
                        <p style="color:var(--gray-500);">{{ __('ui.informasi_no_infographic') }}</p>
                    </div>
                @endif
            </section>

            <!-- ==================== POTENSI KELURAHAN ==================== -->
            <section class="section-block" id="potensi">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_potential_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_potential_title') }}</h2>
                    </div>
                    <a href="{{ route('potensi') }}" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>

                @if ($potentials->count() > 0)
                    <div class="berita-grid">
                        @foreach ($potentials->take(6) as $potential)
                            <article class="berita-card">
                                <div class="berita-card-img"
                                    style="background-image:url('{{ $potential->image ? asset('storage/' . $potential->image) : asset('assets/img/news-placeholder.svg') }}')">
                                    @if ($potential->informationCategory)
                                        <span class="berita-cat">{{ $potential->informationCategory->name }}</span>
                                    @endif
                                </div>
                                <div class="berita-card-body">
                                    <h3 class="berita-card-title">
                                        <a href="{{ route('potensi.show', $potential->id) }}">{{ $potential->title }}</a>
                                    </h3>
                                    @if ($potential->description)
                                        <p class="berita-card-excerpt">
                                            {{ Str::limit(strip_tags($potential->description), 120) }}</p>
                                    @endif
                                    <a href="{{ route('potensi.show', $potential->id) }}" class="berita-read-more">
                                        {{ __('ui.potential_detail') }} <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div
                        style="text-align:center;padding:40px;background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);">
                        <i class="fa fa-gem" style="font-size:48px;color:var(--gray-300);margin-bottom:16px;"></i>
                        <p style="color:var(--gray-500);">{{ __('ui.informasi_no_potential') }}</p>
                    </div>
                @endif
            </section>

            <!-- ==================== DOKUMEN INFORMASI PUBLIK ==================== -->
            <section class="section-block" id="dokumen-publik">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_pubdoc_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_pubdoc_title') }}</h2>
                    </div>
                </div>

                @if ($ppidDocuments->count() > 0)
                    <div
                        style="background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);overflow:hidden;">
                        <div style="overflow-x:auto;">
                            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                                <thead>
                                    <tr style="background:linear-gradient(135deg, #1B3A6B, #0F2A5C);color:#fff;">
                                        <th style="padding:14px 16px;text-align:left;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_no') }}</th>
                                        <th style="padding:14px 16px;text-align:left;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_name') }}</th>
                                        <th style="padding:14px 16px;text-align:left;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_category') }}</th>
                                        <th style="padding:14px 16px;text-align:center;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_year') }}</th>
                                        <th style="padding:14px 16px;text-align:center;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_type') }}</th>
                                        <th style="padding:14px 16px;text-align:center;font-weight:600;">
                                            {{ __('ui.informasi_pubdoc_download') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ppidDocuments as $i => $doc)
                                        <tr
                                            style="border-bottom:1px solid #eee;{{ $loop->even ? 'background:#f8fafc;' : '' }}">
                                            <td style="padding:12px 16px;color:var(--gray-600);">{{ $i + 1 }}</td>
                                            <td style="padding:12px 16px;">
                                                <div style="font-weight:600;color:var(--gray-900);">{{ $doc->title }}
                                                </div>
                                                @if ($doc->description)
                                                    <div style="font-size:12px;color:var(--gray-500);margin-top:4px;">
                                                        {{ Str::limit($doc->description, 80) }}</div>
                                                @endif
                                            </td>
                                            <td style="padding:12px 16px;">
                                                <span
                                                    style="display:inline-block;background:#e8f0fe;color:#1B3A6B;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                                                    {{ $doc->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td style="padding:12px 16px;text-align:center;color:var(--gray-600);">
                                                {{ $doc->year ?? '-' }}</td>
                                            <td style="padding:12px 16px;text-align:center;">
                                                @if ($doc->file_type)
                                                    <span
                                                        style="display:inline-block;background:#fff3cd;color:#856404;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:700;text-transform:uppercase;">{{ $doc->file_type }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="padding:12px 16px;text-align:center;">
                                                @if ($doc->file)
                                                    <a href="{{ route('ppid.download', $doc) }}"
                                                        style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg, #1B3A6B, #2851a3);color:#fff;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.2s;">
                                                        <i class="fa fa-download"></i> {{ __('ui.download') }}
                                                    </a>
                                                @else
                                                    <span style="color:var(--gray-400);">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div
                        style="text-align:center;padding:40px;background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);">
                        <i class="fa fa-folder-open" style="font-size:48px;color:var(--gray-300);margin-bottom:16px;"></i>
                        <p style="color:var(--gray-500);">{{ __('ui.informasi_pubdoc_empty') }}</p>
                    </div>
                @endif
            </section>

            <!-- ==================== INFORMASI BERKALA ==================== -->
            <section class="section-block" id="informasi-berkala">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_periodic_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.informasi_periodic_title') }}</h2>
                    </div>
                </div>

                <p style="color:var(--gray-600);margin-bottom:24px;font-size:14px;">{{ __('ui.informasi_periodic_desc') }}
                </p>

                @if ($periodicInformations->count() > 0)
                    @php
                        $groupedPeriodic = $periodicInformations->groupBy('category');
                    @endphp
                    @foreach ($groupedPeriodic as $category => $items)
                        <div style="margin-bottom:28px;">
                            <h3
                                style="font-size:16px;font-weight:700;color:var(--gray-800);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                                <i class="fa fa-folder" style="color:#D4A017;"></i>
                                {{ $category ?: 'Informasi Berkala' }}
                            </h3>
                            <div
                                style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:16px;">
                                @foreach ($items as $item)
                                    <div
                                        style="background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);padding:20px;transition:transform 0.2s, box-shadow 0.2s;border-left:4px solid #1B3A6B;">
                                        <div style="display:flex;align-items:flex-start;gap:14px;">
                                            <div
                                                style="flex-shrink:0;width:44px;height:44px;background:linear-gradient(135deg, #1B3A6B, #2851a3);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                                @php
                                                    $iconMap = [
                                                        'pdf' => 'fa-file-pdf',
                                                        'doc' => 'fa-file-word',
                                                        'docx' => 'fa-file-word',
                                                        'xls' => 'fa-file-excel',
                                                        'xlsx' => 'fa-file-excel',
                                                        'ppt' => 'fa-file-powerpoint',
                                                        'pptx' => 'fa-file-powerpoint',
                                                        'jpg' => 'fa-file-image',
                                                        'jpeg' => 'fa-file-image',
                                                        'png' => 'fa-file-image',
                                                    ];
                                                    $icon =
                                                        $iconMap[strtolower($item->file_type ?? '')] ?? 'fa-file-alt';
                                                @endphp
                                                <i class="fa {{ $icon }}" style="color:#fff;font-size:18px;"></i>
                                            </div>
                                            <div style="flex:1;min-width:0;">
                                                <h4
                                                    style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">
                                                    {{ $item->title }}</h4>
                                                @if ($item->description)
                                                    <p
                                                        style="font-size:12.5px;color:var(--gray-500);line-height:1.5;margin-bottom:8px;">
                                                        {{ Str::limit($item->description, 100) }}</p>
                                                @endif
                                                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                                                    @if ($item->year)
                                                        <span style="font-size:11px;color:var(--gray-500);"><i
                                                                class="fa fa-calendar"></i> {{ $item->year }}</span>
                                                    @endif
                                                    @if ($item->file_type)
                                                        <span
                                                            style="display:inline-block;background:#fff3cd;color:#856404;padding:2px 7px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;">{{ $item->file_type }}</span>
                                                    @endif
                                                    @if ($item->file_size)
                                                        <span
                                                            style="font-size:11px;color:var(--gray-400);">{{ number_format($item->file_size / 1024, 0) }}
                                                            KB</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if ($item->file)
                                            <div style="margin-top:14px;padding-top:12px;border-top:1px solid #f0f0f0;">
                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                    style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg, #1B3A6B, #2851a3);color:#fff;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.2s;">
                                                    <i class="fa fa-download"></i> {{ __('ui.download') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div
                        style="text-align:center;padding:40px;background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);">
                        <i class="fa fa-calendar-check"
                            style="font-size:48px;color:var(--gray-300);margin-bottom:16px;"></i>
                        <p style="color:var(--gray-500);">{{ __('ui.informasi_periodic_empty') }}</p>
                    </div>
                @endif
            </section>

        </div><!-- /.main-content -->

        <!-- SIDEBAR -->
        <aside class="sidebar">
            @if ($lurah ?? null)
                <div class="sidebar-card lurah-card">
                    <div class="lurah-photo-wrap">
                        <div class="lurah-photo-bg">
                            @if ($lurah->photo)
                                <img src="{{ asset('storage/' . $lurah->photo) }}" alt="{{ $lurah->name }}" />
                            @else
                                <img src="{{ asset('assets/img/lurah.svg') }}" alt="Lurah" />
                            @endif
                        </div>
                    </div>
                    <div class="lurah-info">
                        <span class="lurah-label">{{ __('ui.sidebar_lurah_label') }}</span>
                        <h3>{{ $lurah->name ?? 'Rian Hermanu' }}</h3>
                        <div class="lurah-links">
                            <a href="{{ route('perangkat') }}"><i class="fa fa-user"></i>
                                {{ __('ui.sidebar_profile') }}</a>
                            <a href="{{ route('perangkat') }}"><i class="fa fa-history"></i>
                                {{ __('ui.sidebar_history') }}</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-clock"></i> {{ __('ui.sidebar_service_hours') }}</div>
                <div class="jam-table">
                    <div class="jam-row"><span>Senin – Kamis</span><span class="jam-time">08.00 – 16.00</span></div>
                    <div class="jam-row"><span>Jumat</span><span class="jam-time">08.00 – 16.30</span></div>
                    <div class="jam-row weekend"><span>Sabtu – Minggu</span><span
                            class="jam-time closed">{{ __('ui.sidebar_closed') }}</span>
                    </div>
                    <div class="jam-note"><i class="fa fa-info-circle"></i> {{ __('ui.sidebar_break_note') }}</div>
                </div>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-phone-alt"></i> {{ __('ui.sidebar_contact_us') }}</div>
                <div class="kontak-list">
                    <a href="tel:{{ $settings['phone'] ?? '02153035403' }}" class="kontak-item"><i
                            class="fa fa-phone"></i><span>{{ $settings['phone'] ?? '(021) 5303540' }}</span></a>
                    <a href="mailto:{{ $settings['email'] ?? '' }}" class="kontak-item"><i
                            class="fa fa-envelope"></i><span>{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</span></a>
                    <a href="#" class="kontak-item"><i
                            class="fab fa-whatsapp"></i><span>{{ $settings['whatsapp'] ?? '0812-1234-5678' }}
                            (WA)</span></a>
                </div>
            </div>
        </aside>
    </div>

    <!-- PPID BANNER -->
    <section class="ppid-banner">
        <div class="ppid-banner-inner">
            <div class="ppid-banner-text">
                <i class="fa fa-shield-alt"></i>
                <div>
                    <h3>Keterbukaan Informasi Publik (PPID)</h3>
                    <p>Ajukan permohonan informasi atau keberatan secara online</p>
                </div>
            </div>
            <div class="ppid-banner-actions">
                <a href="{{ route('ppid') }}" class="btn-ppid primary">Form Permohonan</a>
                <a href="{{ route('ppid') }}" class="btn-ppid secondary">Form Keberatan</a>
            </div>
        </div>
    </section>
@endsection
