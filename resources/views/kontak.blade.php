@extends('layouts.app')

@section('title', __('ui.kontak_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.kontak_title') }}</span>
            </div>
            <h1><i class="fa fa-phone-alt"></i> {{ __('ui.kontak_title') }}</h1>
            <p>{{ __('ui.kontak_desc') }}</p>
        </div>
    </section>

    <div style="max-width:1320px;margin:0 auto;padding:44px 24px;">

        <!-- KONTAK INFO + PETA -->
        <div class="kontak-grid" style="margin-bottom:32px;">
            <div class="kontak-info-card">
                <div class="kontak-info-header">{{ __('ui.kontak_info_title') }}</div>
                <div class="kontak-info-body">
                    <div class="kontak-info-item">
                        <i class="fa fa-map-marker-alt"></i>
                        <div>
                            <strong>{{ __('ui.kontak_address') }}</strong>
                            <span>{{ $settings['address'] ?? 'Jl. KS Tubun No.1, Petamburan, Kec. Tanah Abang, Jakarta Pusat 10260' }}</span>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <i class="fa fa-phone"></i>
                        <div>
                            <strong>{{ __('ui.kontak_phone') }}</strong>
                            <span>{{ $settings['phone'] ?? '(021) 5303540' }}</span>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <i class="fa fa-envelope"></i>
                        <div>
                            <strong>{{ __('ui.kontak_email') }}</strong>
                            <span>{{ $settings['email'] ?? 'kel.petamburan@jakarta.go.id' }}</span>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <strong>WhatsApp</strong>
                            <span>{{ $settings['whatsapp'] ?? '0812-1234-5678' }} (Hari kerja, 08.00–16.00 WIB)</span>
                        </div>
                    </div>
                    <div class="kontak-info-item">
                        <i class="fa fa-clock"></i>
                        <div>
                            <strong>{{ __('ui.kontak_hours') }}</strong>
                            <span>Senin–Kamis: 08.00–16.00 WIB<br>Jumat: 08.00–16.30 WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-embed">
                <!-- Embed Google Maps wilayah Petamburan -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3999!2d106.8050!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6d26ffe43f9%3A0x5bb2bc7ffbe55ab6!2sPetamburan%2C%20Tanah%20Abang%2C%20Jakarta%20Pusat!5e0!3m2!1sid!2sid!4v1708600000000!5m2!1sid!2sid"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- FORM + TRACKING -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px;" class="kontak-form-grid">
            <!-- FORM HUBUNGI KAMI -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3><i class="fa fa-envelope-open-text"></i> {{ __('ui.kontak_form_title') }}</h3>
                    <p>Sampaikan pertanyaan, saran, atau pengaduan Anda. Tim kami akan merespons dalam 1×24 jam kerja.</p>
                </div>
                <div class="form-body">
                    @if (session('success'))
                        <div
                            style="background:#E8F5E9;border:1px solid #4CAF50;color:#2E7D32;padding:16px;border-radius:8px;margin-bottom:20px;">
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            style="background:#FFEBEE;border:1px solid #EF5350;color:#C62828;padding:16px;border-radius:8px;margin-bottom:20px;">
                            <strong><i class="fa fa-exclamation-triangle"></i> Terjadi kesalahan:</strong>
                            <ul style="margin:8px 0 0 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="ppid-form" id="formKontak" method="POST" action="{{ route('kontak.store') }}">
                        @csrf
                        <div class="form-group" style="margin-bottom:14px;">
                            <label>{{ __('ui.kontak_form_name') }} <span style="color:var(--red)">*</span></label>
                            <input type="text" name="name" placeholder="{{ __('ui.kontak_form_name_placeholder') }}"
                                required value="{{ old('name') }}" />
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>{{ __('ui.kontak_form_phone') }} <span style="color:var(--red)">*</span></label>
                                <input type="tel" name="phone"
                                    placeholder="{{ __('ui.kontak_form_phone_placeholder') }}" required
                                    value="{{ old('phone') }}" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('ui.kontak_form_email') }}</label>
                                <input type="email" name="email"
                                    placeholder="{{ __('ui.kontak_form_email_placeholder') }}"
                                    value="{{ old('email') }}" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Jenis Pesan <span style="color:var(--red)">*</span></label>
                                <select name="type" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Pertanyaan Layanan"
                                        {{ old('type') == 'Pertanyaan Layanan' ? 'selected' : '' }}>Pertanyaan Layanan
                                    </option>
                                    <option value="Pengaduan" {{ old('type') == 'Pengaduan' ? 'selected' : '' }}>Pengaduan
                                    </option>
                                    <option value="Saran / Masukan"
                                        {{ old('type') == 'Saran / Masukan' ? 'selected' : '' }}>Saran / Masukan</option>
                                    <option value="Informasi Umum" {{ old('type') == 'Informasi Umum' ? 'selected' : '' }}>
                                        Informasi Umum</option>
                                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('ui.kontak_form_subject') }} <span style="color:var(--red)">*</span></label>
                                <input type="text" name="subject"
                                    placeholder="{{ __('ui.kontak_form_subject_placeholder') }}" required
                                    value="{{ old('subject') }}" />
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:18px;">
                            <label>{{ __('ui.kontak_form_message') }} <span style="color:var(--red)">*</span></label>
                            <textarea name="message" placeholder="{{ __('ui.kontak_form_message_placeholder') }}" required
                                style="min-height:120px;">{{ old('message') }}</textarea>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                            <input type="checkbox" name="agreement" required
                                style="width:18px;height:18px;accent-color:var(--red);" />
                            <label style="font-size:13px;color:var(--gray-700);">Saya setuju data saya digunakan untuk
                                keperluan tindak lanjut oleh pihak kelurahan.</label>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-paper-plane"></i> {{ __('ui.kontak_form_submit') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- TRACKING PESAN -->
            <div>
                <div class="form-card" style="margin-bottom:24px;">
                    <div class="form-card-header" style="background:linear-gradient(135deg,var(--blue),var(--blue-mid));">
                        <h3><i class="fa fa-search"></i> {{ __('ui.kontak_tracking_title') }}</h3>
                        <p>{{ __('ui.kontak_tracking_desc') }}</p>
                    </div>
                    <div class="form-body">
                        <form class="ppid-form" id="formCekKontak" method="GET" action="{{ route('kontak.tracking') }}">
                            <div class="form-group" style="margin-bottom:16px;">
                                <label>Nomor Tiket Pesan <span style="color:var(--red)">*</span></label>
                                <input type="text" name="ticket"
                                    placeholder="{{ __('ui.kontak_tracking_placeholder') }}" required />
                            </div>
                            <button type="submit" class="btn-submit" style="background:var(--blue);width:100%;">
                                <i class="fa fa-search"></i> {{ __('ui.kontak_tracking_btn') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="form-card" style="background:var(--gray-50);">
                    <div style="padding:24px;">
                        <h4 style="font-size:15px;font-weight:700;color:var(--gray-700);margin-bottom:12px;">
                            <i class="fa fa-info-circle" style="color:var(--blue);"></i> Cara Melacak Pesan
                        </h4>
                        <ol style="padding-left:20px;margin:0;font-size:13.5px;color:var(--gray-600);line-height:2;">
                            <li>Kirim pesan melalui form di samping kiri</li>
                            <li>Anda akan mendapatkan <strong>Nomor Tiket</strong> (format: KTK-YYYYMM-XXXXX)</li>
                            <li>Masukkan nomor tiket pada form di atas</li>
                            <li>Lihat status dan tanggapan dari kelurahan</li>
                        </ol>
                        <div
                            style="margin-top:16px;padding:12px 16px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));border-radius:8px;color:#fff;font-size:13px;">
                            <i class="fa fa-headset"></i>
                            <strong>Butuh bantuan cepat?</strong><br>
                            Hubungi WhatsApp kami:
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '6281212345678') }}"
                                style="color:#fff;text-decoration:underline;">{{ $settings['whatsapp'] ?? '0812-1234-5678' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SOSMED STRIP -->
        <div style="text-align:center;margin-top:40px;">
            <p style="font-size:15px;font-weight:600;color:var(--gray-700);margin-bottom:16px;">
                {{ __('ui.kontak_social_title') }}
            </p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                @if ($settings['instagram'] ?? null)
                    <a href="{{ $settings['instagram'] }}" target="_blank"
                        style="display:flex;align-items:center;gap:10px;background:#E4405F;color:#fff;padding:12px 24px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;">
                        <i class="fab fa-instagram fa-lg"></i> @kel.petamburan
                    </a>
                @endif
                @if ($settings['facebook'] ?? null)
                    <a href="{{ $settings['facebook'] }}" target="_blank"
                        style="display:flex;align-items:center;gap:10px;background:#1877F2;color:#fff;padding:12px 24px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;">
                        <i class="fab fa-facebook fa-lg"></i> Kelurahan Petamburan
                    </a>
                @endif
                @if ($settings['youtube'] ?? null)
                    <a href="{{ $settings['youtube'] }}" target="_blank"
                        style="display:flex;align-items:center;gap:10px;background:#FF0000;color:#fff;padding:12px 24px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;">
                        <i class="fab fa-youtube fa-lg"></i> Petamburan Official
                    </a>
                @endif
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '6281212345678') }}"
                    target="_blank"
                    style="display:flex;align-items:center;gap:10px;background:#25D366;color:#fff;padding:12px 24px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;">
                    <i class="fab fa-whatsapp fa-lg"></i> WhatsApp Kami
                </a>
            </div>
        </div>

    </div>
@endsection
