<header class="site-header" id="siteHeader">
    <div class="header-inner">
        <div class="header-brand">
            <img src="{{ asset('assets/img/logoDKIJakarta.png') }}" alt="Logo DKI Jakarta" class="logo-dki" />
            <div class="brand-text">
                <span class="brand-sub">{{ $settings['parent_org'] ?? 'Pemerintah Provinsi DKI Jakarta' }}</span>
                <span class="brand-name">{{ $settings['site_name'] ?? 'Kelurahan Petamburan' }}</span>
                <span
                    class="brand-info">{{ $settings['site_tagline'] ?? 'Kecamatan Tanah Abang · Jakarta Pusat' }}</span>
            </div>
        </div>
        <nav class="main-nav" id="mainNav">
            <div class="nav-drawer-header">
                <div class="nav-drawer-brand">
                    <img src="{{ asset('assets/img/logoDKIJakarta.png') }}" alt="Logo" class="nav-drawer-logo" />
                    <div class="brand-text">
                        <span class="brand-name">{{ $settings['site_name'] ?? 'Kelurahan Petamburan' }}</span>
                        <span
                            class="brand-info">{{ $settings['site_tagline'] ?? 'Kecamatan Tanah Abang · Jakarta Pusat' }}</span>
                    </div>
                </div>
                <button class="nav-close" id="navClose"><i class="fa fa-times"></i></button>
            </div>
            <ul>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ __('ui.nav_home') }}</a>
                </li>
                <li class="has-dropdown {{ request()->routeIs('perangkat*') ? 'active' : '' }}">
                    <a href="#">{{ __('ui.nav_apparatus') }} <i class="fa fa-chevron-down fa-xs"></i></a>
                    <ul class="dropdown">
                        <li><a href="{{ route('perangkat') }}">{{ __('ui.nav_org_structure') }}</a></li>
                        <li><a href="{{ route('perangkat') }}#pejabat">{{ __('ui.nav_officials_list') }}</a></li>
                        <li><a href="{{ route('perangkat') }}#tugas">{{ __('ui.nav_duties') }}</a></li>
                    </ul>
                </li>
                <li class="has-dropdown {{ request()->routeIs('layanan*') ? 'active' : '' }}">
                    <a href="#">{{ __('ui.nav_services') }} <i class="fa fa-chevron-down fa-xs"></i></a>
                    <ul class="dropdown">
                        <li><a href="{{ route('layanan') }}">{{ __('ui.nav_service_pledge') }}</a></li>
                        <li><a href="{{ route('layanan') }}#jenis">{{ __('ui.nav_service_types') }}</a></li>
                        <li><a href="{{ route('layanan') }}#jam">{{ __('ui.nav_service_hours') }}</a></li>
                        <li><a href="{{ route('layanan') }}#ikm">{{ __('ui.nav_ikm_score') }}</a></li>
                    </ul>
                </li>
                <li class="has-dropdown {{ request()->routeIs('informasi*') ? 'active' : '' }}">
                    <a href="#">{{ __('ui.nav_information') }} <i class="fa fa-chevron-down fa-xs"></i></a>
                    <ul class="dropdown">
                        <li><a href="{{ route('informasi') }}">{{ __('ui.nav_village_agenda') }}</a></li>
                        <li><a href="{{ route('informasi') }}#prestasi">{{ __('ui.nav_achievements') }}</a></li>
                        <li><a href="{{ route('informasi') }}#infografis">{{ __('ui.nav_infographics') }}</a></li>
                        <li><a href="{{ route('informasi') }}#potensi">{{ __('ui.nav_village_potential') }}</a></li>
                        <li><a href="{{ route('informasi') }}#dokumen-publik">{{ __('ui.nav_public_documents') }}</a>
                        </li>
                        <li><a href="{{ route('informasi') }}#informasi-berkala">{{ __('ui.nav_periodic_info') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('pengaduan*') ? 'active' : '' }}">
                    <a href="{{ route('pengaduan') }}"><i class="fa fa-bullhorn"></i>
                        {{ __('ui.nav_complaints') }}</a>
                </li>
                <li class="{{ request()->routeIs('ppid*') ? 'active' : '' }}">
                    <a href="{{ route('ppid') }}">{{ __('ui.nav_ppid') }}</a>
                </li>
                <li class="{{ request()->routeIs('kontak*') ? 'active' : '' }}">
                    <a href="{{ route('kontak') }}">{{ __('ui.nav_contact') }}</a>
                </li>
            </ul>
        </nav>
        <button class="hamburger" id="hamburger"><i class="fa fa-bars"></i></button>
    </div>
    <div class="nav-overlay" id="navOverlay"></div>
</header>
