@extends('layouts.app')

@section('title', __('ui.layanan_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.layanan_title') }}</span>
            </div>
            <h1><i class="fa fa-concierge-bell"></i> {{ __('ui.layanan_title') }}</h1>
            <p>{{ __('ui.layanan_desc') }}</p>
        </div>
    </section>

    <!-- MAKLUMAT -->
    <div class="page-wrapper">
        <div class="main-content">

            <!-- MAKLUMAT CARD -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.layanan_commitment') }}</span>
                        <h2 class="section-title">{{ __('ui.layanan_pledge') }}</h2>
                    </div>
                </div>
                <div
                    style="background:linear-gradient(135deg,#fff 0%,var(--accent-pale) 100%); border:2px solid var(--accent); border-radius:var(--radius-lg); padding:28px 32px; box-shadow:var(--shadow-sm);">
                    <div class="maklumat-flex">
                        <div style="font-size:40px;color:var(--red);flex-shrink:0;">📜</div>
                        <div>
                            <h3 style="font-size:18px;font-weight:800;color:var(--gray-900);margin-bottom:10px;">
                                {{ __('ui.layanan_pledge_title') }}</h3>
                            <p
                                style="font-size:14.5px;color:var(--gray-700);line-height:1.8;font-style:italic;font-family:'Lora',serif;">
                                {!! __('ui.layanan_pledge_text') !!}
                            </p>
                            <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;">
                                <span
                                    style="background:var(--red);color:#fff;padding:5px 14px;border-radius:30px;font-size:12.5px;font-weight:700;"><i
                                        class="fa fa-check"></i> {{ __('ui.layanan_fast') }}</span>
                                <span
                                    style="background:var(--orange);color:#fff;padding:5px 14px;border-radius:30px;font-size:12.5px;font-weight:700;"><i
                                        class="fa fa-check"></i> {{ __('ui.layanan_transparent') }}</span>
                                <span
                                    style="background:#27AE60;color:#fff;padding:5px 14px;border-radius:30px;font-size:12.5px;font-weight:700;"><i
                                        class="fa fa-check"></i> {{ __('ui.layanan_accountable') }}</span>
                                <span
                                    style="background:#2980B9;color:#fff;padding:5px 14px;border-radius:30px;font-size:12.5px;font-weight:700;"><i
                                        class="fa fa-check"></i> {{ __('ui.layanan_free') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- JENIS LAYANAN -->
            <section class="section-block" id="jenis">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.layanan_service_type') }}</span>
                        <h2 class="section-title">{{ __('ui.layanan_service_types') }}</h2>
                    </div>
                </div>

                <div class="layanan-grid">
                    @foreach ($services as $service)
                        <div class="layanan-detail-card" id="{{ $service->slug }}">
                            <div class="layanan-card-top">
                                <span class="icon"><i class="{{ $service->icon }}"></i></span>
                                <div>
                                    <h3>{{ $service->name }}</h3>
                                    <small>{{ $service->category->name ?? '' }}</small>
                                </div>
                            </div>
                            <div class="layanan-card-body">
                                <p class="layanan-req-title">{{ __('ui.layanan_doc_requirements') }}</p>
                                <ul class="layanan-req-list">
                                    @foreach ($service->requirements ?? [] as $req)
                                        <li>{{ $req }}</li>
                                    @endforeach
                                </ul>
                                <div class="layanan-meta">
                                    <span class="layanan-meta-item"><i class="fa fa-clock"></i>
                                        {{ $service->duration }}</span>
                                    <span class="layanan-meta-item"><i class="fa fa-money-bill"></i>
                                        {{ $service->cost }}</span>
                                    <span class="layanan-meta-item"><i class="fa fa-calendar"></i>
                                        {{ $service->schedule }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- JAM LAYANAN -->
            <section class="section-block" id="jam">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.layanan_schedule') }}</span>
                        <h2 class="section-title">{{ __('ui.layanan_hours') }}</h2>
                    </div>
                </div>
                <div class="jam-table-wrap"
                    style="background:#fff;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);overflow:hidden;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:linear-gradient(90deg,var(--blue),var(--blue-light));color:#fff;">
                                <th style="padding:14px 20px;text-align:left;font-size:14px;">{{ __('ui.layanan_day') }}
                                </th>
                                <th style="padding:14px 20px;text-align:left;font-size:14px;">
                                    {{ __('ui.layanan_open_time') }}</th>
                                <th style="padding:14px 20px;text-align:left;font-size:14px;">{{ __('ui.layanan_break') }}
                                </th>
                                <th style="padding:14px 20px;text-align:left;font-size:14px;">
                                    {{ __('ui.layanan_close_time') }}</th>
                                <th style="padding:14px 20px;text-align:left;font-size:14px;">{{ __('ui.layanan_status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($serviceHours as $hour)
                                <tr
                                    style="border-bottom:1px solid var(--gray-100);{{ $hour->is_closed ? 'background:var(--gray-100);' : '' }}">
                                    <td
                                        style="padding:14px 20px;font-weight:600;{{ $hour->is_closed ? 'color:var(--gray-400);' : '' }}">
                                        {{ $hour->day }}</td>
                                    @if ($hour->is_closed)
                                        <td style="padding:14px 20px;color:var(--gray-400);">–</td>
                                        <td style="padding:14px 20px;color:var(--gray-400);">–</td>
                                        <td style="padding:14px 20px;color:var(--gray-400);">–</td>
                                        <td style="padding:14px 20px;"><span
                                                style="background:var(--gray-200);color:var(--gray-400);padding:4px 12px;border-radius:30px;font-size:12px;font-weight:700;">{{ __('ui.layanan_closed') }}</span>
                                        </td>
                                    @else
                                        <td style="padding:14px 20px;">
                                            {{ \Carbon\Carbon::parse($hour->open_time)->format('H.i') }} WIB</td>
                                        <td style="padding:14px 20px;">
                                            {{ \Carbon\Carbon::parse($hour->break_start)->format('H.i') }} –
                                            {{ \Carbon\Carbon::parse($hour->break_end)->format('H.i') }} WIB</td>
                                        <td style="padding:14px 20px;">
                                            {{ \Carbon\Carbon::parse($hour->close_time)->format('H.i') }} WIB</td>
                                        <td style="padding:14px 20px;"><span
                                                style="background:#E8F5E9;color:#2E7D32;padding:4px 12px;border-radius:30px;font-size:12px;font-weight:700;">{{ __('ui.layanan_open') }}</span>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- NILAI IKM -->
            <section class="section-block" id="ikm">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.layanan_survey') }}</span>
                        <h2 class="section-title">{{ __('ui.layanan_ikm_title') }}</h2>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 2fr;gap:24px;" class="ikm-grid">
                    <div
                        style="background:linear-gradient(135deg,var(--blue),var(--blue-light));border-radius:var(--radius-lg);padding:32px;text-align:center;color:#fff;">
                        <div style="font-size:72px;font-weight:800;line-height:1;">{{ $settings['ikm_score'] ?? '96,4' }}
                        </div>
                        <div style="font-size:16px;font-weight:700;margin-top:8px;">{{ __('ui.layanan_ikm_score') }}</div>
                        <div style="font-size:14px;opacity:.88;margin-top:4px;">
                            {{ $settings['ikm_period'] ?? 'Semester I – 2026' }}</div>
                        <div
                            style="margin-top:16px;background:rgba(255,255,255,.2);border-radius:8px;padding:10px 14px;font-size:13px;font-weight:700;">
                            ⭐ {{ __('ui.layanan_ikm_category') }}
                        </div>
                    </div>
                    <div style="background:#fff;border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow-sm);">
                        <h4 style="font-size:15px;font-weight:700;margin-bottom:16px;color:var(--gray-900);">
                            {{ __('ui.layanan_ikm_detail') }}</h4>
                        <div style="display:flex;flex-direction:column;gap:14px;">
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:13.5px;margin-bottom:6px;">
                                    <span>{{ __('ui.layanan_ikm_procedure') }}</span><strong
                                        style="color:var(--red);">98,2</strong>
                                </div>
                                <div style="background:var(--gray-200);height:8px;border-radius:30px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:98.2%;background:linear-gradient(90deg,var(--blue),var(--blue-light));border-radius:30px;">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:13.5px;margin-bottom:6px;">
                                    <span>{{ __('ui.layanan_ikm_speed') }}</span><strong
                                        style="color:var(--red);">95,8</strong>
                                </div>
                                <div style="background:var(--gray-200);height:8px;border-radius:30px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:95.8%;background:linear-gradient(90deg,var(--blue),var(--blue-light));border-radius:30px;">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div
                                    style="display:flex;justify-content:space-between;font-size:13.5px;margin-bottom:6px;">
                                    <span>{{ __('ui.layanan_ikm_friendly') }}</span><strong
                                        style="color:var(--red);">97,1</strong>
                                </div>
                                <div style="background:var(--gray-200);height:8px;border-radius:30px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:97.1%;background:linear-gradient(90deg,var(--blue),var(--blue-light));border-radius:30px;">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div
                                    style="display:flex;justify-content:space-between;font-size:13.5px;margin-bottom:6px;">
                                    <span>{{ __('ui.layanan_ikm_comfort') }}</span><strong
                                        style="color:var(--red);">94,6</strong>
                                </div>
                                <div style="background:var(--gray-200);height:8px;border-radius:30px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:94.6%;background:linear-gradient(90deg,var(--blue),var(--blue-light));border-radius:30px;">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div
                                    style="display:flex;justify-content:space-between;font-size:13.5px;margin-bottom:6px;">
                                    <span>{{ __('ui.layanan_ikm_cost') }}</span><strong
                                        style="color:var(--red);">96,5</strong>
                                </div>
                                <div style="background:var(--gray-200);height:8px;border-radius:30px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:96.5%;background:linear-gradient(90deg,var(--blue),var(--blue-light));border-radius:30px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div><!-- /.main-content -->

        <!-- SIDEBAR -->
        <aside class="sidebar">
            @if ($lurah)
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
                        <h3>{{ $lurah->name }}</h3>
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
                    <div class="jam-row weekend"><span>Sabtu – Minggu</span><span class="jam-time closed">Libur</span>
                    </div>
                    <div class="jam-note"><i class="fa fa-info-circle"></i> Istirahat: 12.00 – 13.00 WIB</div>
                </div>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-phone-alt"></i> {{ __('ui.sidebar_contact_us') }}</div>
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
