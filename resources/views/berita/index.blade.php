@extends('layouts.app')

@section('title', __('ui.berita_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.berita_title') }}</span>
            </div>
            <h1><i class="fa fa-newspaper"></i> {{ __('ui.berita_title') }}</h1>
            <p>{{ __('ui.berita_desc') }}</p>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content">

            <!-- FILTER KATEGORI -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.berita_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.berita_title') }}</h2>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px;">
                    <a href="{{ route('berita') }}"
                        class="info-filter-btn {{ !request('kategori') ? 'active' : '' }}">{{ __('ui.berita_filter_all') }}</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('berita', ['kategori' => $category->slug]) }}"
                            class="info-filter-btn {{ request('kategori') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </section>

            <!-- DAFTAR BERITA -->
            <section class="section-block">
                <div class="berita-grid">
                    @forelse($news as $item)
                        <article class="berita-card">
                            <div class="berita-card-img"
                                style="background-image:url('{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/news-placeholder.svg') }}')">
                                @if ($item->category)
                                    <span
                                        class="berita-cat berita-cat-{{ $item->category->color ?? 'kegiatan' }}">{{ $item->category->name }}</span>
                                @endif
                            </div>
                            <div class="berita-card-body">
                                <div class="berita-card-date">
                                    <i class="fa fa-calendar-alt"></i> {{ $item->published_at->translatedFormat('d F Y') }}
                                </div>
                                <h3 class="berita-card-title">
                                    <a href="{{ route('berita.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>
                                <p class="berita-card-excerpt">{{ $item->excerpt }}</p>
                                <a href="{{ route('berita.show', $item->slug) }}" class="berita-read-more">
                                    {{ __('ui.read_more') }} <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <p>{{ __('ui.berita_no_news') }}</p>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                @if ($news->hasPages())
                    <div style="margin-top:32px;display:flex;justify-content:center;">
                        {{ $news->links() }}
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
                            <img src="{{ asset('assets/img/lurah.svg') }}" alt="Lurah" />
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
                            class="jam-time closed">{{ __('ui.sidebar_closed') }}</span></div>
                    <div class="jam-note"><i class="fa fa-info-circle"></i> {{ __('ui.sidebar_break_note') }}</div>
                </div>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-phone-alt"></i> {{ __('ui.sidebar_contact_us') }}</div>
                <div class="kontak-list">
                    <a href="tel:{{ $settings['phone'] ?? '' }}" class="kontak-item"><i
                            class="fa fa-phone"></i><span>{{ $settings['phone'] ?? '(021) 5303540' }}</span></a>
                    <a href="mailto:{{ $settings['email'] ?? '' }}" class="kontak-item"><i
                            class="fa fa-envelope"></i><span>{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</span></a>
                </div>
            </div>
        </aside>
    </div>
@endsection
