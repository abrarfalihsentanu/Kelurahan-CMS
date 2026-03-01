<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-left">
            <span><i class="fa fa-clock"></i> {{ __('ui.service_hours_label') }}
                {{ $settings['service_hours'] ?? 'Senin–Jumat, 08.00–16.00 WIB' }}</span>
            <span><i class="fa fa-phone"></i> {{ $settings['phone'] ?? '(021) 5303540' }}</span>
        </div>
        <div class="topbar-right">
            <button class="a11y-header-btn" id="a11yHeaderBtn" title="{{ __('ui.a11y_title') }}"
                aria-label="{{ __('ui.a11y_open') }}">
                <i class="fa fa-universal-access"></i>
            </button>
            <span id="clock-date"></span>
            <a href="{{ route('lang.switch', 'id') }}"
                class="lang {{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
            <a href="{{ route('lang.switch', 'en') }}"
                class="lang {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>
    </div>
</div>
