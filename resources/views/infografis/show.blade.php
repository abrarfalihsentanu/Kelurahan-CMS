@extends('layouts.app')

@section('title', $infographic->title)

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('infografis') }}">{{ __('ui.infographic_page_title') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ Str::limit($infographic->title, 30) }}</span>
            </div>
            <h1><i class="fa fa-chart-pie"></i> {{ $infographic->title }}</h1>
            <p>
                @if ($infographic->informationCategory)
                    <span class="berita-cat" style="margin-right:12px;">{{ $infographic->informationCategory->name }}</span>
                @endif
                @if ($infographic->source)
                    <i class="fa fa-database"></i> {{ $infographic->source }}
                @endif
                @if ($infographic->year)
                    &nbsp;|&nbsp; <i class="fa fa-calendar"></i> {{ $infographic->year }}
                @endif
            </p>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content">

            <article class="news-article">
                @if ($infographic->image)
                    <div class="news-featured-image" style="margin-bottom:24px;">
                        <img src="{{ asset('storage/' . $infographic->image) }}" alt="{{ $infographic->title }}"
                            style="width:100%;border-radius:var(--radius-lg);" />
                    </div>
                @endif

                @if ($infographic->description)
                    <div class="news-content"
                        style="background:#fff;padding:32px;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);font-size:15px;line-height:1.8;color:var(--gray-700);">
                        {{ $infographic->description }}
                    </div>
                @endif

                <!-- Share Buttons -->
                <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                    <span style="font-weight:600;color:var(--gray-700);">{{ __('ui.berita_share') }}</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#1877F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($infographic->title) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#1DA1F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($infographic->title . ' ' . url()->current()) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#25D366;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>

                <!-- Back -->
                <div style="margin-top:32px;">
                    <a href="{{ route('infografis') }}"
                        style="display:flex;align-items:center;gap:8px;color:var(--gray-700);text-decoration:none;font-size:14px;">
                        <i class="fa fa-arrow-left"></i> {{ __('ui.infographic_back') }}
                    </a>
                </div>
            </article>

            <!-- Related Infographics -->
            @if ($relatedInfographics->count() > 0)
                <section class="section-block" style="margin-top:40px;">
                    <div class="section-header">
                        <div class="section-title-group">
                            <h2 class="section-title">{{ __('ui.infographic_related') }}</h2>
                        </div>
                    </div>
                    <div class="berita-grid">
                        @foreach ($relatedInfographics as $related)
                            <article class="berita-card">
                                <div class="berita-card-img"
                                    style="background-image:url('{{ $related->image ? asset('storage/' . $related->image) : asset('assets/img/news-placeholder.svg') }}')">
                                    @if ($related->informationCategory)
                                        <span class="berita-cat">{{ $related->informationCategory->name }}</span>
                                    @endif
                                </div>
                                <div class="berita-card-body">
                                    @if ($related->source || $related->year)
                                        <div class="berita-card-date">
                                            @if ($related->source)
                                                <i class="fa fa-database"></i> {{ $related->source }}
                                            @endif
                                            @if ($related->year)
                                                &nbsp;<i class="fa fa-calendar"></i> {{ $related->year }}
                                            @endif
                                        </div>
                                    @endif
                                    <h3 class="berita-card-title">
                                        <a href="{{ route('infografis.show', $related->id) }}">{{ $related->title }}</a>
                                    </h3>
                                    @if ($related->description)
                                        <p class="berita-card-excerpt">{{ Str::limit($related->description, 120) }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

        </div><!-- /.main-content -->

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-chart-bar"></i> {{ __('ui.infographic_categories') }}
                </div>
                <div style="padding:14px 18px;">
                    @php
                        $categories = \App\Models\Infographic::where('is_published', true)
                            ->whereNotNull('category')
                            ->distinct()
                            ->pluck('category');
                    @endphp
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
