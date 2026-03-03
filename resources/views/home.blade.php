@extends('layouts.app')

@section('title', __('ui.home_title'))

@section('content')
    <!-- ===== HERO / SLIDER ===== -->
    <section class="hero">
        <div class="hero-slides">
            @forelse($sliders as $index => $slider)
                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                    style="background-image:url('{{ $slider->image ? asset('storage/' . $slider->image) : asset('assets/img/hero' . ($index + 1) . '.svg') }}')">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        @if ($slider->tag)
                            <span class="hero-tag"><i class="{{ $slider->tag_icon ?? 'fa fa-star' }}"></i>
                                {{ $slider->tag }}</span>
                        @endif
                        <h1>{{ $slider->title }}</h1>
                        <p>{{ $slider->description }}</p>
                        @if ($slider->button_link)
                            <a href="{{ $slider->button_link }}"
                                class="btn-hero">{{ $slider->button_text ?? 'Baca Selengkapnya' }} <i
                                    class="fa fa-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="hero-slide active" style="background-image:url('{{ asset('assets/img/hero1.svg') }}')">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <span class="hero-tag"><i class="fa fa-star"></i> {{ __('ui.home_welcome') }}</span>
                        <h1>{{ __('ui.home_official_website') }}</h1>
                        <p>{{ __('ui.home_tagline') }}</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="hero-controls">
            <button class="hero-btn prev" id="heroPrev"><i class="fa fa-chevron-left"></i></button>
            <div class="hero-dots">
                @foreach ($sliders as $index => $slider)
                    <span class="dot {{ $index === 0 ? 'active' : '' }}" data-idx="{{ $index }}"></span>
                @endforeach
            </div>
            <button class="hero-btn next" id="heroNext"><i class="fa fa-chevron-right"></i></button>
        </div>
    </section>

    <!-- ===== STATS BAR ===== -->
    <section class="stats-bar">
        <div class="stats-inner">
            @forelse($statistics as $index => $stat)
                @if ($index > 0)
                    <div class="stat-divider"></div>
                @endif
                <div class="stat-item">
                    <i class="{{ $stat->icon }}"></i>
                    <div>
                        <span class="stat-num">{{ $stat->value }}</span>
                        <span class="stat-label">{{ $stat->label }}</span>
                    </div>
                </div>
            @empty
                <div class="stat-item">
                    <i class="fa fa-map-marked-alt"></i>
                    <div>
                        <span class="stat-num">90,10</span>
                        <span class="stat-label">Hektar Luas Wilayah</span>
                    </div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <i class="fa fa-layer-group"></i>
                    <div>
                        <span class="stat-num">11</span>
                        <span class="stat-label">Rukun Warga (RW)</span>
                    </div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <i class="fa fa-home"></i>
                    <div>
                        <span class="stat-num">116</span>
                        <span class="stat-label">Rukun Tetangga (RT)</span>
                    </div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <i class="fa fa-users"></i>
                    <div>
                        <span class="stat-num">42.500+</span>
                        <span class="stat-label">Jiwa Penduduk</span>
                    </div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <i class="fa fa-star"></i>
                    <div>
                        <span class="stat-num">96,4</span>
                        <span class="stat-label">Nilai IKM</span>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-wrapper">
        <div class="main-content">
            <!-- BERITA TERBARU -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.home_latest') }}</span>
                        <h2 class="section-title">{{ __('ui.home_news_title') }}</h2>
                    </div>
                    <a href="{{ route('berita') }}" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>

                <div class="news-grid">
                    @forelse($news as $index => $item)
                        <article class="news-card {{ $index === 0 ? 'featured' : '' }}">
                            <div class="news-img"
                                style="background-image:url('{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/news' . ($index + 1) . '.svg') }}')">
                                @if ($item->category)
                                    <span
                                        class="news-cat {{ strtolower($item->category->slug) }}">{{ $item->category->name }}</span>
                                @endif
                            </div>
                            <div class="news-body">
                                <span class="news-date"><i class="fa fa-calendar"></i>
                                    {{ $item->published_at->isoFormat('D MMMM Y') }}</span>
                                <h3><a href="{{ route('berita.show', $item->slug) }}">{{ $item->title }}</a></h3>
                                <p>{{ Str::limit($item->excerpt ?? strip_tags($item->content), 150) }}</p>
                                <a href="{{ route('berita.show', $item->slug) }}"
                                    class="btn-read">{{ __('ui.read_more') }} <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </article>
                    @empty
                        <p>{{ __('ui.home_no_news') }}</p>
                    @endforelse
                </div>
            </section>

            <!-- LAYANAN PUBLIK QUICK ACCESS -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.home_public') }}</span>
                        <h2 class="section-title">{{ __('ui.home_village_services') }}</h2>
                    </div>
                    <a href="{{ route('layanan') }}" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>

                <div class="service-grid">
                    @forelse($services as $service)
                        <a href="{{ route('layanan') }}#{{ $service->slug }}" class="service-card">
                            <div class="service-icon"><i class="{{ $service->icon ?? 'fa fa-file-alt' }}"></i></div>
                            <h4>{{ $service->name }}</h4>
                            <p>{{ Str::limit($service->description, 60) }}</p>
                            <span class="service-arrow"><i class="fa fa-arrow-right"></i></span>
                        </a>
                    @empty
                        <a href="{{ route('layanan') }}#ktp" class="service-card">
                            <div class="service-icon"><i class="fa fa-id-card"></i></div>
                            <h4>Surat Pengantar KTP</h4>
                            <p>Pengantar untuk pembuatan & perubahan data KTP elektronik</p>
                            <span class="service-arrow"><i class="fa fa-arrow-right"></i></span>
                        </a>
                    @endforelse
                </div>
            </section>

            <!-- AGENDA -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.home_schedule') }}</span>
                        <h2 class="section-title">{{ __('ui.nav_village_agenda') }}</h2>
                    </div>
                    <a href="{{ route('informasi') }}#agenda" class="btn-all">{{ __('ui.view_all') }} <i
                            class="fa fa-arrow-right"></i></a>
                </div>
                <div class="agenda-list">
                    @forelse($agendas as $agenda)
                        <div class="agenda-item">
                            <div class="agenda-date">
                                <span class="agenda-day">{{ $agenda->event_date->format('d') }}</span>
                                <span class="agenda-month">{{ $agenda->event_date->isoFormat('MMM') }}</span>
                                <span class="agenda-year">{{ $agenda->event_date->format('Y') }}</span>
                            </div>
                            <div class="agenda-info">
                                <h4>{{ $agenda->title }}</h4>
                                <p>
                                    @if ($agenda->start_time)
                                        <i class="fa fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($agenda->start_time)->format('H.i') }}
                                        @if ($agenda->end_time)
                                            – {{ \Carbon\Carbon::parse($agenda->end_time)->format('H.i') }} WIB
                                        @endif
                                    @endif
                                    @if ($agenda->location)
                                        &nbsp;|&nbsp; <i class="fa fa-map-marker-alt"></i> {{ $agenda->location }}
                                    @endif
                                </p>
                            </div>
                            <span class="agenda-badge {{ $agenda->status }}">{{ $agenda->status_label }}</span>
                        </div>
                    @empty
                        <p>{{ __('ui.home_no_agenda') }}</p>
                    @endforelse
                </div>
            </section>
        </div><!-- /.main-content -->

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <!-- Profil Lurah -->
            @if ($lurah)
                <div class="sidebar-card lurah-card">
                    <div class="lurah-photo-wrap">
                        <div class="lurah-photo-bg">
                            <img src="{{ $lurah->photo ? asset('storage/' . $lurah->photo) : asset('assets/img/lurah.svg') }}"
                                alt="Lurah" />
                        </div>
                    </div>
                    <div class="lurah-info">
                        <span class="lurah-label">{{ __('ui.sidebar_lurah_label') }}</span>
                        <h3>{{ $lurah->name }}</h3>
                        <div class="lurah-links">
                            <a href="{{ route('perangkat') }}#lurah"><i class="fa fa-user"></i>
                                {{ __('ui.sidebar_profile') }}</a>
                            <a href="{{ route('perangkat') }}#lurah"><i class="fa fa-history"></i>
                                {{ __('ui.sidebar_history') }}</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Jam Layanan -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fa fa-clock"></i> {{ __('ui.sidebar_service_hours') }}
                </div>
                <div class="jam-table">
                    @forelse($serviceHours as $hour)
                        <div class="jam-row {{ $hour->is_closed ? 'weekend' : '' }}">
                            <span>{{ $hour->day }}</span>
                            <span class="jam-time {{ $hour->is_closed ? 'closed' : '' }}">
                                {{ $hour->is_closed ? __('ui.sidebar_closed') : \Carbon\Carbon::parse($hour->open_time)->format('H.i') . ' – ' . \Carbon\Carbon::parse($hour->close_time)->format('H.i') }}
                            </span>
                        </div>
                    @empty
                        <div class="jam-row">
                            <span>Senin – Kamis</span>
                            <span class="jam-time">08.00 – 16.00</span>
                        </div>
                        <div class="jam-row">
                            <span>Jumat</span>
                            <span class="jam-time">08.00 – 16.30</span>
                        </div>
                        <div class="jam-row weekend">
                            <span>Sabtu – Minggu</span>
                            <span class="jam-time closed">Libur</span>
                        </div>
                    @endforelse
                    <div class="jam-note">
                        <i class="fa fa-info-circle"></i> {{ __('ui.sidebar_break_note') }}
                    </div>
                </div>
            </div>

            <!-- Kontak Cepat -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fa fa-phone-alt"></i> {{ __('ui.sidebar_contact_us') }}
                </div>
                <div class="kontak-list">
                    <a href="tel:{{ $settings['phone'] ?? '02153035403' }}" class="kontak-item">
                        <i class="fa fa-phone"></i>
                        <span>{{ $settings['phone'] ?? '(021) 5303540' }}</span>
                    </a>
                    <a href="mailto:{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}" class="kontak-item">
                        <i class="fa fa-envelope"></i>
                        <span>{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</span>
                    </a>
                    @if ($settings['whatsapp'] ?? false)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp']) }}"
                            class="kontak-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>{{ $settings['whatsapp'] }} (WA)</span>
                        </a>
                    @endif
                    <a href="#" class="kontak-item">
                        <i class="fa fa-map-marker-alt"></i>
                        <span>{{ $settings['address_short'] ?? 'Jl. KS Tubun No.1, Jakarta Pusat' }}</span>
                    </a>
                </div>
            </div>

            <!-- Link Eksternal -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fa fa-link"></i> {{ __('ui.sidebar_related_links') }}
                </div>
                <div class="link-ext-list">
                    <a href="https://jakarta.go.id" target="_blank" class="link-ext-item">
                        <i class="fa fa-globe"></i> {{ __('ui.sidebar_portal_jakarta') }}
                    </a>
                    <a href="https://jakpus.jakarta.go.id" target="_blank" class="link-ext-item">
                        <i class="fa fa-city"></i> {{ __('ui.sidebar_jakarta_pusat') }}
                    </a>
                    <a href="#" class="link-ext-item">
                        <i class="fa fa-briefcase"></i> {{ __('ui.sidebar_kecamatan') }}
                    </a>
                    <a href="https://dukcapil.jakarta.go.id" target="_blank" class="link-ext-item">
                        <i class="fa fa-id-card"></i> {{ __('ui.sidebar_dukcapil') }}
                    </a>
                </div>
            </div>

            <!-- IKM Widget -->
            <div class="sidebar-card ikm-card">
                <div class="sidebar-card-header">
                    <i class="fa fa-chart-bar"></i> {{ __('ui.sidebar_ikm_title') }}
                </div>
                <div class="ikm-body">
                    <div class="ikm-score">{{ $settings['ikm_score'] ?? '96,4' }}</div>
                    <div class="ikm-bar-wrap">
                        <div class="ikm-bar" style="width: {{ $settings['ikm_score'] ?? 96.4 }}%"></div>
                    </div>
                    <div class="ikm-label">{{ __('ui.sidebar_very_good') }}</div>
                    <div class="ikm-period">{{ __('ui.sidebar_period') }}
                        {{ $settings['ikm_period'] ?? 'Semester I 2026' }}</div>
                </div>
            </div>
        </aside>
    </div>

    <!-- ===== GALERI KEGIATAN ===== -->
    <section class="section-block" style="max-width:1320px; margin:0 auto 32px; padding:0 24px;">
        <div class="section-header">
            <div class="section-title-group">
                <span class="section-badge">{{ __('ui.home_gallery_badge') }}</span>
                <h2 class="section-title">{{ __('ui.home_gallery_title') }}</h2>
            </div>
        </div>
        <div class="gallery-grid">
            @forelse($galleries as $gallery)
                <div class="gallery-item"
                    @if ($gallery->type === 'video' && $gallery->video_url) onclick="openGalleryVideo('{{ addslashes($gallery->video_url) }}', '{{ addslashes($gallery->title) }}')"
                    @else
                        onclick="openGalleryLightbox('{{ asset('storage/' . $gallery->image) }}', '{{ addslashes($gallery->title) }}')" @endif>
                    @if ($gallery->image)
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}"
                            loading="lazy">
                    @else
                        <div class="gallery-item-placeholder">
                            <i class="fa {{ $gallery->type === 'video' ? 'fa-play-circle' : 'fa-image' }}"></i>
                        </div>
                    @endif
                    <div class="gallery-item-overlay">
                        <span>{{ $gallery->title }}</span>
                    </div>
                    @if ($gallery->type === 'video')
                        <span class="gallery-item-badge"><i class="fa fa-play"></i>
                            {{ __('ui.home_gallery_video') }}</span>
                    @endif
                </div>
            @empty
                <p>{{ __('ui.home_gallery_empty') }}</p>
            @endforelse
        </div>
    </section>

    <!-- Gallery Lightbox -->
    <div class="gallery-lightbox" id="galleryLightbox" onclick="closeGalleryLightbox(event)">
        <button class="gallery-lightbox-close" onclick="closeGalleryLightbox(event)"><i class="fa fa-times"></i></button>
        <img id="galleryLightboxImg" src="" alt="" style="display:none">
        <iframe id="galleryLightboxVideo" src="" frameborder="0" allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="no-referrer-when-downgrade"
            style="display:none; width:90vw; max-width:900px; height:50.625vw; max-height:506px; border-radius:12px;"></iframe>
        <div class="gallery-lightbox-caption" id="galleryLightboxCaption"></div>
        <a id="galleryLightboxYtLink" href="#" target="_blank" rel="noopener noreferrer"
            style="display:none; margin-top:10px; color:#fff; background:#c00; padding:8px 18px; border-radius:6px; text-decoration:none; font-size:15px; font-weight:600;">
            <i class="fab fa-youtube"></i> Buka di YouTube
        </a>
    </div>

    <!-- ===== BANNER PPID ===== -->
    <section class="ppid-banner">
        <div class="ppid-banner-inner">
            <div class="ppid-banner-text">
                <i class="fa fa-shield-alt"></i>
                <div>
                    <h3>{{ __('ui.home_ppid_title') }}</h3>
                    <p>{{ __('ui.home_ppid_desc') }}
                    </p>
                </div>
            </div>
            <div class="ppid-banner-actions">
                <a href="{{ route('ppid') }}#form-permohonan"
                    class="btn-ppid primary">{{ __('ui.home_form_request') }}</a>
                <a href="{{ route('ppid') }}#form-keberatan"
                    class="btn-ppid secondary">{{ __('ui.home_form_objection') }}</a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function getYouTubeEmbedUrl(url) {
            var match = url.match(
                /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
            return match ? 'https://www.youtube-nocookie.com/embed/' + match[1] + '?autoplay=1&rel=0' : null;
        }

        function getYouTubeWatchUrl(url) {
            var match = url.match(
                /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
            return match ? 'https://www.youtube.com/watch?v=' + match[1] : url;
        }

        function openGalleryLightbox(src, title) {
            document.getElementById('galleryLightboxVideo').style.display = 'none';
            document.getElementById('galleryLightboxVideo').src = '';
            document.getElementById('galleryLightboxYtLink').style.display = 'none';
            var img = document.getElementById('galleryLightboxImg');
            img.src = src;
            img.style.display = '';
            document.getElementById('galleryLightboxCaption').textContent = title;
            document.getElementById('galleryLightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function openGalleryVideo(url, title) {
            document.getElementById('galleryLightboxImg').style.display = 'none';
            document.getElementById('galleryLightboxImg').src = '';
            var iframe = document.getElementById('galleryLightboxVideo');
            var ytLink = document.getElementById('galleryLightboxYtLink');
            var embedUrl = getYouTubeEmbedUrl(url);
            if (embedUrl) {
                iframe.src = embedUrl;
                iframe.style.display = '';
                ytLink.href = getYouTubeWatchUrl(url);
                ytLink.style.display = '';
            } else {
                window.open(url, '_blank');
                return;
            }
            document.getElementById('galleryLightboxCaption').textContent = title;
            document.getElementById('galleryLightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeGalleryLightbox(e) {
            if (e.target === document.getElementById('galleryLightbox') ||
                e.currentTarget.classList.contains('gallery-lightbox-close')) {
                document.getElementById('galleryLightbox').classList.remove('active');
                document.getElementById('galleryLightboxVideo').src = '';
                document.getElementById('galleryLightboxYtLink').style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('galleryLightbox').classList.remove('active');
                document.getElementById('galleryLightboxVideo').src = '';
                document.getElementById('galleryLightboxYtLink').style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    </script>
@endpush
