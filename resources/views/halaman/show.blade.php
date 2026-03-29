@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ $page->title }}</span>
            </div>
            <h1><i class="fa fa-file-alt"></i> {{ $page->title }}</h1>
            @if ($page->excerpt)
                <p>{{ $page->excerpt }}</p>
            @endif
        </div>
    </section>

    <div class="page-wrapper">
        <div class="main-content" style="max-width:900px;margin:0 auto;">

            @if ($page->image)
                <div style="margin-bottom:24px;">
                    <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}"
                        style="width:100%;border-radius:var(--radius-lg);" />
                </div>
            @endif

            <div
                style="background:#fff;padding:32px;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);font-size:15px;line-height:1.8;color:var(--gray-700);">
                {!! $page->content !!}
            </div>

        </div>
    </div>
@endsection
