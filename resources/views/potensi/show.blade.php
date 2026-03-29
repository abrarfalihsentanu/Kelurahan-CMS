@extends('layouts.app')

@section('title', $potential->title)

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('potensi') }}">{{ __('ui.potential_page_title') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ Str::limit($potential->title, 30) }}</span>
            </div>
            <h1><i class="fa fa-gem"></i> {{ $potential->title }}</h1>
            <p>
                @if ($potential->informationCategory)
                    <span class="berita-cat" style="margin-right:12px;">{{ $potential->informationCategory->name }}</span>
                @endif
            </p>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content">

            <article class="news-article">
                @if ($potential->image)
                    <div class="news-featured-image" style="margin-bottom:24px;">
                        <img src="{{ asset('storage/' . $potential->image) }}" alt="{{ $potential->title }}"
                            style="width:100%;border-radius:var(--radius-lg);" />
                    </div>
                @endif

                <div class="news-content"
                    style="background:#fff;padding:32px;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);font-size:15px;line-height:1.8;color:var(--gray-700);">
                    @if ($potential->description)
                        <div style="margin-bottom:16px;">{{ $potential->description }}</div>
                    @endif
                    @if ($potential->content)
                        <div>{!! $potential->content !!}</div>
                    @endif
                </div>

                <!-- Share Buttons -->
                <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                    <span style="font-weight:600;color:var(--gray-700);">{{ __('ui.berita_share') }}</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#1877F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($potential->title) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#1DA1F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($potential->title . ' ' . url()->current()) }}"
                        target="_blank" rel="noopener noreferrer"
                        style="background:#25D366;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>

                <!-- Back -->
                <div style="margin-top:32px;">
                    <a href="{{ route('potensi') }}"
                        style="display:flex;align-items:center;gap:8px;color:var(--gray-700);text-decoration:none;font-size:14px;">
                        <i class="fa fa-arrow-left"></i> {{ __('ui.potential_back') }}
                    </a>
                </div>
            </article>

            <!-- Related Potentials -->
            @if ($relatedPotentials->count() > 0)
                <section class="section-block" style="margin-top:40px;">
                    <div class="section-header">
                        <div class="section-title-group">
                            <h2 class="section-title">{{ __('ui.potential_related') }}</h2>
                        </div>
                    </div>
                    <div class="berita-grid">
                        @foreach ($relatedPotentials as $related)
                            <article class="berita-card">
                                <div class="berita-card-img"
                                    style="background-image:url('{{ $related->image ? asset('storage/' . $related->image) : asset('assets/img/news-placeholder.svg') }}')">
                                    @if ($related->informationCategory)
                                        <span class="berita-cat">{{ $related->informationCategory->name }}</span>
                                    @endif
                                </div>
                                <div class="berita-card-body">
                                    <h3 class="berita-card-title">
                                        <a href="{{ route('potensi.show', $related->id) }}">{{ $related->title }}</a>
                                    </h3>
                                    @if ($related->description)
                                        <p class="berita-card-excerpt">
                                            {{ Str::limit(strip_tags($related->description), 120) }}</p>
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
                <div class="sidebar-card-header"><i class="fa fa-gem"></i> {{ __('ui.potential_categories') }}</div>
                <div style="padding:14px 18px;">
                    @php
                        $categories = \App\Models\Potential::where('is_published', true)
                            ->whereNotNull('category')
                            ->distinct()
                            ->pluck('category');
                    @endphp
                    @foreach ($categories as $category)
                        <a href="{{ route('potensi', ['kategori' => $category]) }}"
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
