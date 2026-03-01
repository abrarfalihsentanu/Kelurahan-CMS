@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('berita') }}">{{ __('ui.berita_title') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ Str::limit($news->title, 30) }}</span>
            </div>
            <h1><i class="fa fa-newspaper"></i> {{ $news->title }}</h1>
            <p>
                @if ($news->category)
                    <span class="berita-cat" style="margin-right:12px;">{{ $news->category->name }}</span>
                @endif
                <i class="fa fa-calendar-alt"></i> {{ $news->published_at->translatedFormat('d F Y') }}
                @if ($news->author)
                    &nbsp;|&nbsp; <i class="fa fa-user"></i> {{ $news->author->name }}
                @endif
            </p>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content">

            <article class="news-article">
                @if ($news->image)
                    <div class="news-featured-image" style="margin-bottom:24px;">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                            style="width:100%;border-radius:var(--radius-lg);" />
                    </div>
                @endif

                <div class="news-content"
                    style="background:#fff;padding:32px;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);font-size:15px;line-height:1.8;color:var(--gray-700);">
                    {!! $news->content !!}
                </div>

                <!-- Share Buttons -->
                <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                    <span style="font-weight:600;color:var(--gray-700);">{{ __('ui.berita_share') }}</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank"
                        style="background:#1877F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}"
                        target="_blank"
                        style="background:#1DA1F2;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank"
                        style="background:#25D366;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;text-decoration:none;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>

                <!-- Navigation -->
                <div style="margin-top:32px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                    @if ($previousNews)
                        <a href="{{ route('berita.show', $previousNews->slug) }}"
                            style="display:flex;align-items:center;gap:8px;color:var(--gray-700);text-decoration:none;font-size:14px;">
                            <i class="fa fa-arrow-left"></i> {{ Str::limit($previousNews->title, 40) }}
                        </a>
                    @else
                        <span></span>
                    @endif
                    @if ($nextNews)
                        <a href="{{ route('berita.show', $nextNews->slug) }}"
                            style="display:flex;align-items:center;gap:8px;color:var(--gray-700);text-decoration:none;font-size:14px;">
                            {{ Str::limit($nextNews->title, 40) }} <i class="fa fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </article>

        </div><!-- /.main-content -->

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-newspaper"></i> {{ __('ui.berita_latest') }}</div>
                <div style="padding:14px 18px;">
                    @foreach ($latestNews as $latest)
                        <a href="{{ route('berita.show', $latest->slug) }}"
                            style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--gray-100);text-decoration:none;">
                            <div
                                style="width:60px;height:60px;background:var(--gray-200);border-radius:8px;flex-shrink:0;background-image:url('{{ $latest->image ? asset('storage/' . $latest->image) : '' }}');background-size:cover;background-position:center;">
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:600;color:var(--gray-900);line-height:1.4;">
                                    {{ Str::limit($latest->title, 50) }}</div>
                                <div style="font-size:11px;color:var(--gray-500);margin-top:4px;">
                                    {{ $latest->published_at->translatedFormat('d M Y') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-card-header"><i class="fa fa-tags"></i> {{ __('ui.berita_categories') }}</div>
                <div style="padding:14px 18px;">
                    @foreach ($categories as $category)
                        <a href="{{ route('berita', ['kategori' => $category->slug]) }}"
                            style="display:block;padding:8px 0;border-bottom:1px solid var(--gray-100);font-size:13.5px;color:var(--gray-700);text-decoration:none;">
                            {{ $category->name }}
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
