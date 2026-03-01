<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-col brand">
            <div class="footer-brand">
                <div class="footer-brand-text">
                    <strong>{{ $settings['site_name'] ?? 'Kelurahan Petamburan' }}</strong>
                    <span>{{ $settings['site_tagline'] ?? 'Kecamatan Tanah Abang, Jakarta Pusat' }}</span>
                    <span>{{ $settings['province'] ?? 'Provinsi DKI Jakarta' }}</span>
                </div>
            </div>
            <p class="footer-desc">
                {{ $settings['footer_description'] ?? 'Melayani masyarakat dengan sepenuh hati, transparan, akuntabel, dan berintegritas untuk Jakarta yang lebih baik.' }}
            </p>
            <div class="footer-sosmed">
                @if ($settings['instagram'] ?? false)
                    <a href="{{ $settings['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                @if ($settings['facebook'] ?? false)
                    <a href="{{ $settings['facebook'] }}" target="_blank"><i class="fab fa-facebook"></i></a>
                @endif
                @if ($settings['youtube'] ?? false)
                    <a href="{{ $settings['youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                @endif
                @if ($settings['twitter'] ?? false)
                    <a href="{{ $settings['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif
            </div>
        </div>
        <div class="footer-col">
            <h4>{{ __('ui.footer_services') }}</h4>
            <ul>
                <li><a href="{{ route('layanan') }}#ktp">{{ __('ui.footer_ktp_intro') }}</a></li>
                <li><a href="{{ route('layanan') }}#kk">{{ __('ui.footer_family_card') }}</a></li>
                <li><a href="{{ route('layanan') }}#skd">{{ __('ui.footer_domicile_letter') }}</a></li>
                <li><a href="{{ route('layanan') }}#sktm">{{ __('ui.footer_sktm') }}</a></li>
                <li><a href="{{ route('layanan') }}#usaha">{{ __('ui.footer_micro_business') }}</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>{{ __('ui.footer_information') }}</h4>
            <ul>
                <li><a href="{{ route('perangkat') }}">{{ __('ui.footer_village_profile') }}</a></li>
                <li><a href="{{ route('perangkat') }}#pejabat">{{ __('ui.footer_village_apparatus') }}</a></li>
                <li><a href="{{ route('informasi') }}">{{ __('ui.footer_activity_agenda') }}</a></li>
                <li><a href="{{ route('informasi') }}#prestasi">{{ __('ui.footer_achievements') }}</a></li>
                <li><a href="{{ route('informasi') }}#potensi">{{ __('ui.footer_regional_potential') }}</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>{{ __('ui.footer_ppid') }}</h4>
            <ul>
                <li><a href="{{ route('ppid') }}">{{ __('ui.footer_public_info') }}</a></li>
                <li><a href="{{ route('ppid') }}#form-permohonan">{{ __('ui.footer_info_request') }}</a></li>
                <li><a href="{{ route('ppid') }}#form-keberatan">{{ __('ui.footer_objection') }}</a></li>
                <li><a href="{{ route('ppid') }}">{{ __('ui.footer_service_procedure') }}</a></li>
                <li><a href="{{ route('ppid') }}">{{ __('ui.footer_sop_ppid') }}</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>{{ __('ui.footer_contact') }}</h4>
            <div class="footer-kontak">
                <p><i class="fa fa-map-marker-alt"></i>
                    {{ $settings['address'] ?? 'Jl. KS Tubun No.1, Petamburan, Tanah Abang, Jakarta Pusat 10260' }}</p>
                <p><i class="fa fa-phone"></i> {{ $settings['phone'] ?? '(021) 5303540' }}</p>
                <p><i class="fa fa-envelope"></i> {{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</p>
                <p><i class="fa fa-clock"></i> {{ $settings['service_hours'] ?? 'Senin–Jumat, 08.00–16.00 WIB' }}</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} {{ $settings['site_name'] ?? 'Kelurahan Petamburan' }} –
            {{ $settings['parent_org'] ?? 'Pemerintah Provinsi DKI Jakarta' }}. {{ __('ui.footer_rights') }}</span>
        <span>
            {{ $settings['footer_credit'] ?? 'Dibangun oleh Tim IT Pemprov DKI Jakarta' }}
            &nbsp;|&nbsp;
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,.6);text-decoration:none;">
                <i class="fas fa-lock" style="font-size:.75rem"></i> {{ __('ui.footer_admin_login') }}
            </a>
        </span>
    </div>
</footer>
