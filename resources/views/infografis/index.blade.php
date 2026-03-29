@extends('layouts.app')

@section('title', __('ui.infographic_page_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('informasi') }}">{{ __('ui.informasi_title') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.infographic_page_title') }}</span>
            </div>
            <h1><i class="fa fa-chart-pie"></i> {{ __('ui.infographic_page_title') }}</h1>
            <p>{{ __('ui.infographic_page_desc') }}</p>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content">

            <!-- FILTER KATEGORI -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.informasi_infographic_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.infographic_page_title') }}</h2>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px;">
                    <a href="{{ route('infografis') }}"
                        class="info-filter-btn {{ !request('kategori') ? 'active' : '' }}">{{ __('ui.berita_filter_all') }}</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('infografis', ['kategori' => $category->slug]) }}"
                            class="info-filter-btn {{ request('kategori') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </section>

            <!-- DAFTAR INFOGRAFIS -->
            <section class="section-block">
                <div class="berita-grid">
                    @forelse($infographics as $infographic)
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
                    @empty
                        <p>{{ __('ui.informasi_no_infographic') }}</p>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                @if ($infographics->hasPages())
                    <div style="margin-top:32px;display:flex;justify-content:center;">
                        {{ $infographics->appends(request()->query())->links() }}
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
                <div class="sidebar-card-header"><i class="fa fa-chart-bar"></i> {{ __('ui.infographic_categories') }}
                </div>
                <div style="padding:14px 18px;">
                    @foreach ($categories as $category)
                        <a href="{{ route('infografis', ['kategori' => $category]) }}"
                            style="display:block;padding:8px 0;border-bottom:1px solid var(--gray-100);font-size:13.5px;color:var(--gray-700);text-decoration:none;">
                            {{ $category }}
                        </a>
                    @endforeach
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
