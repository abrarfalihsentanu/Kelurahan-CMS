@extends('layouts.app')

@section('title', __('ui.ppid_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.nav_ppid') }}</span>
            </div>
            <h1><i class="fa fa-shield-alt"></i> {{ __('ui.ppid_title') }}</h1>
            <p>{{ __('ui.ppid_desc') }}</p>
        </div>
    </section>

    <div style="max-width:1320px;margin:0 auto;padding:44px 24px;">
        <div>

            <!-- PPID OVERVIEW -->
            <section class="section-block">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.ppid_overview_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.ppid_overview_title') }}</h2>
                    </div>
                </div>
                <div class="ppid-grid">
                    @forelse($categories as $category)
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="{{ $category->icon ?? 'fa fa-folder' }}"></i></div>
                            <div>
                                <h4>{{ $category->name }}</h4>
                                <p>{{ $category->description }}</p>
                            </div>
                        </a>
                    @empty
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-sitemap"></i></div>
                            <div>
                                <h4>Struktur PPID</h4>
                                <p>Susunan organisasi Pejabat Pengelola Informasi dan Dokumentasi Kelurahan Petamburan</p>
                            </div>
                        </a>
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-tasks"></i></div>
                            <div>
                                <h4>Tugas dan Fungsi PPID</h4>
                                <p>Uraian tugas pokok dan fungsi PPID dalam pengelolaan informasi publik</p>
                            </div>
                        </a>
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-folder-open"></i></div>
                            <div>
                                <h4>Dokumen Informasi Publik</h4>
                                <p>Daftar dokumen informasi publik yang tersedia untuk diakses masyarakat</p>
                            </div>
                        </a>
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-clock"></i></div>
                            <div>
                                <h4>Waktu & Biaya Layanan</h4>
                                <p>Informasi mengenai standar waktu dan biaya dalam pelayanan informasi publik</p>
                            </div>
                        </a>
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-calendar-alt"></i></div>
                            <div>
                                <h4>Informasi Berkala</h4>
                                <p>Informasi yang wajib disediakan dan diumumkan secara berkala kepada publik</p>
                            </div>
                        </a>
                        <a href="#" class="ppid-card" style="text-decoration:none;">
                            <div class="ppid-card-icon"><i class="fa fa-project-diagram"></i></div>
                            <div>
                                <h4>SOP PPID</h4>
                                <p>Standar Operasional Prosedur pelayanan informasi dan penanganan sengketa</p>
                            </div>
                        </a>
                    @endforelse
                </div>
            </section>

            <!-- FORM PERMOHONAN + TRACKING -->
            <section class="section-block" id="form-permohonan">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.ppid_request_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.ppid_request_title') }}</h2>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" class="kontak-form-grid">
                    <!-- FORM -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h3><i class="fa fa-file-alt"></i> Formulir Permohonan</h3>
                            <p>Ajukan permohonan informasi publik kepada PPID Kelurahan Petamburan</p>
                        </div>
                        <div class="form-body">
                            @if ($errors->any() && old('_form') === 'permohonan')
                                <div
                                    style="background:#FFEBEE;border:1px solid #EF5350;color:#C62828;padding:14px;border-radius:8px;margin-bottom:16px;">
                                    <strong><i class="fa fa-exclamation-triangle"></i> Kesalahan:</strong>
                                    <ul style="margin:6px 0 0 18px;font-size:13px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="ppid-form" id="formPermohonan" method="POST"
                                action="{{ route('ppid.request') }}">
                                @csrf
                                <input type="hidden" name="_form" value="permohonan">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_request_name') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="text" name="name"
                                            placeholder="{{ __('ui.ppid_request_name_placeholder') }}" required
                                            value="{{ old('_form') === 'permohonan' ? old('name') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" name="nik" placeholder="Nomor Induk Kependudukan"
                                            value="{{ old('_form') === 'permohonan' ? old('nik') : '' }}" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_request_phone') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="tel" name="phone"
                                            placeholder="{{ __('ui.ppid_request_phone_placeholder') }}" required
                                            value="{{ old('_form') === 'permohonan' ? old('phone') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_request_email') }}</label>
                                        <input type="email" name="email"
                                            placeholder="{{ __('ui.ppid_request_email_placeholder') }}"
                                            value="{{ old('_form') === 'permohonan' ? old('email') : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:14px;">
                                    <label>{{ __('ui.ppid_request_address') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <input type="text" name="address"
                                        placeholder="{{ __('ui.ppid_request_address_placeholder') }}" required
                                        value="{{ old('_form') === 'permohonan' ? old('address') : '' }}" />
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tujuan Permohonan <span style="color:var(--red)">*</span></label>
                                        <select name="information_type" required>
                                            <option value="">-- Pilih Tujuan --</option>
                                            <option value="Keperluan Pribadi"
                                                {{ old('information_type') == 'Keperluan Pribadi' ? 'selected' : '' }}>
                                                Keperluan Pribadi</option>
                                            <option value="Penelitian / Akademik"
                                                {{ old('information_type') == 'Penelitian / Akademik' ? 'selected' : '' }}>
                                                Penelitian / Akademik</option>
                                            <option value="Jurnalistik / Media"
                                                {{ old('information_type') == 'Jurnalistik / Media' ? 'selected' : '' }}>
                                                Jurnalistik / Media</option>
                                            <option value="Hukum / Advokasi"
                                                {{ old('information_type') == 'Hukum / Advokasi' ? 'selected' : '' }}>Hukum
                                                / Advokasi</option>
                                            <option value="Lainnya"
                                                {{ old('information_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cara Mendapatkan <span style="color:var(--red)">*</span></label>
                                        <select name="method" required>
                                            <option value="">-- Pilih Cara --</option>
                                            <option value="Datang Langsung"
                                                {{ old('method') == 'Datang Langsung' ? 'selected' : '' }}>Datang Langsung
                                            </option>
                                            <option value="Email" {{ old('method') == 'Email' ? 'selected' : '' }}>Email
                                            </option>
                                            <option value="WhatsApp" {{ old('method') == 'WhatsApp' ? 'selected' : '' }}>
                                                WhatsApp</option>
                                            <option value="Pos / Kurir"
                                                {{ old('method') == 'Pos / Kurir' ? 'selected' : '' }}>Pos / Kurir</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:14px;">
                                    <label>{{ __('ui.ppid_request_purpose') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <select name="purpose" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Keperluan Pribadi"
                                            {{ old('purpose') == 'Keperluan Pribadi' ? 'selected' : '' }}>Keperluan Pribadi
                                        </option>
                                        <option value="Penelitian / Akademik"
                                            {{ old('purpose') == 'Penelitian / Akademik' ? 'selected' : '' }}>Penelitian /
                                            Akademik</option>
                                        <option value="Jurnalistik / Media"
                                            {{ old('purpose') == 'Jurnalistik / Media' ? 'selected' : '' }}>Jurnalistik /
                                            Media</option>
                                        <option value="Hukum / Advokasi"
                                            {{ old('purpose') == 'Hukum / Advokasi' ? 'selected' : '' }}>Hukum / Advokasi
                                        </option>
                                        <option value="Bisnis / Komersial"
                                            {{ old('purpose') == 'Bisnis / Komersial' ? 'selected' : '' }}>Bisnis /
                                            Komersial</option>
                                        <option value="Lainnya" {{ old('purpose') == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:14px;">
                                    <label>{{ __('ui.ppid_request_info') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <textarea name="information_detail" placeholder="{{ __('ui.ppid_request_info_placeholder') }}" required
                                        style="min-height:90px;">{{ old('_form') === 'permohonan' ? old('information_detail') : '' }}</textarea>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                                    <input type="checkbox" name="agreement" required
                                        style="width:18px;height:18px;accent-color:var(--red);" />
                                    <label style="font-size:12.5px;color:var(--gray-700);">Saya menyatakan data yang diisi
                                        benar dan dapat dipertanggungjawabkan.</label>
                                </div>
                                <button type="submit" class="btn-submit" style="width:100%;">
                                    <i class="fa fa-paper-plane"></i> {{ __('ui.ppid_request_submit') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- TRACKING -->
                    <div>
                        <div class="form-card" style="margin-bottom:20px;">
                            <div class="form-card-header"
                                style="background:linear-gradient(135deg,var(--blue),var(--blue-mid));">
                                <h3><i class="fa fa-search"></i> {{ __('ui.ppid_request_tracking_title') }}</h3>
                                <p>{{ __('ui.ppid_request_tracking_desc') }}</p>
                            </div>
                            <div class="form-body">
                                <form class="ppid-form" id="formCekPpid" method="GET"
                                    action="{{ route('ppid.tracking') }}">
                                    <div class="form-group" style="margin-bottom:14px;">
                                        <label>{{ __('ui.ppid_tracking_ticket') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="text" name="ticket"
                                            placeholder="{{ __('ui.ppid_request_tracking_placeholder') }}" required />
                                    </div>
                                    <button type="submit" class="btn-submit" style="background:var(--blue);width:100%;">
                                        <i class="fa fa-search"></i> {{ __('ui.ppid_request_tracking_btn') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="form-card" style="background:var(--gray-50);">
                            <div style="padding:20px;">
                                <h4 style="font-size:14px;font-weight:700;color:var(--gray-700);margin-bottom:10px;">
                                    <i class="fa fa-info-circle" style="color:var(--blue);"></i> Cara Melacak Permohonan
                                </h4>
                                <ol style="padding-left:18px;margin:0;font-size:13px;color:var(--gray-600);line-height:2;">
                                    <li>Kirim permohonan melalui form di samping</li>
                                    <li>Anda akan mendapatkan <strong>Nomor Tiket</strong> (format: PPID-XXXXXXXX-XXXXX)
                                    </li>
                                    <li>Masukkan nomor tiket pada form di atas</li>
                                    <li>Lihat status dan tanggapan dari PPID</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FORM KEBERATAN + TRACKING -->
            <section class="section-block" id="form-keberatan">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.ppid_objection_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.ppid_objection_title') }}</h2>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" class="kontak-form-grid">
                    <!-- FORM -->
                    <div class="form-card">
                        <div class="form-card-header"
                            style="background:linear-gradient(90deg,var(--red-dark),var(--red));">
                            <h3><i class="fa fa-exclamation-triangle"></i> Formulir Keberatan</h3>
                            <p>Gunakan jika permohonan Anda tidak ditindaklanjuti atau ditolak tanpa alasan sah</p>
                        </div>
                        <div class="form-body">
                            @if ($errors->any() && old('_form') === 'keberatan')
                                <div
                                    style="background:#FFEBEE;border:1px solid #EF5350;color:#C62828;padding:14px;border-radius:8px;margin-bottom:16px;">
                                    <strong><i class="fa fa-exclamation-triangle"></i> Kesalahan:</strong>
                                    <ul style="margin:6px 0 0 18px;font-size:13px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="ppid-form" id="formKeberatan" method="POST"
                                action="{{ route('ppid.keberatan') }}">
                                @csrf
                                <input type="hidden" name="_form" value="keberatan">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_objection_name') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="text" name="name"
                                            placeholder="{{ __('ui.ppid_objection_name_placeholder') }}" required
                                            value="{{ old('_form') === 'keberatan' ? old('name') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_objection_ticket') }}</label>
                                        <input type="text" name="reference_number"
                                            placeholder="{{ __('ui.ppid_objection_ticket_placeholder') }}"
                                            value="{{ old('_form') === 'keberatan' ? old('reference_number') : '' }}" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_request_phone') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="tel" name="phone"
                                            placeholder="{{ __('ui.ppid_request_phone_placeholder') }}" required
                                            value="{{ old('_form') === 'keberatan' ? old('phone') : '' }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('ui.ppid_objection_email') }}</label>
                                        <input type="email" name="email"
                                            placeholder="{{ __('ui.ppid_objection_email_placeholder') }}"
                                            value="{{ old('_form') === 'keberatan' ? old('email') : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:14px;">
                                    <label>{{ __('ui.ppid_objection_reason') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <select name="information_type" required>
                                        <option value="">-- Pilih Alasan --</option>
                                        <option value="Permohonan tidak ditanggapi"
                                            {{ old('information_type') == 'Permohonan tidak ditanggapi' ? 'selected' : '' }}>
                                            Permohonan tidak ditanggapi</option>
                                        <option value="Informasi yang diberikan tidak sesuai"
                                            {{ old('information_type') == 'Informasi yang diberikan tidak sesuai' ? 'selected' : '' }}>
                                            Informasi yang diberikan tidak sesuai</option>
                                        <option value="Permohonan ditolak tanpa alasan jelas"
                                            {{ old('information_type') == 'Permohonan ditolak tanpa alasan jelas' ? 'selected' : '' }}>
                                            Permohonan ditolak tanpa alasan jelas</option>
                                        <option value="Biaya tidak wajar"
                                            {{ old('information_type') == 'Biaya tidak wajar' ? 'selected' : '' }}>Biaya
                                            tidak wajar</option>
                                        <option value="Informasi melebihi batas waktu"
                                            {{ old('information_type') == 'Informasi melebihi batas waktu' ? 'selected' : '' }}>
                                            Informasi melebihi batas waktu</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom:14px;">
                                    <label>{{ __('ui.ppid_objection_reason') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <textarea name="information_detail" placeholder="{{ __('ui.ppid_objection_reason_placeholder') }}" required
                                        style="min-height:90px;">{{ old('_form') === 'keberatan' ? old('information_detail') : '' }}</textarea>
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                                    <input type="checkbox" name="agreement" required
                                        style="width:18px;height:18px;accent-color:var(--red);" />
                                    <label style="font-size:12.5px;color:var(--gray-700);">Saya menyatakan uraian keberatan
                                        yang disampaikan adalah benar.</label>
                                </div>
                                <button type="submit" class="btn-submit"
                                    style="background:linear-gradient(90deg,var(--red-dark),var(--red));width:100%;">
                                    <i class="fa fa-paper-plane"></i> {{ __('ui.ppid_objection_submit') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- INFO KEBERATAN -->
                    <div>
                        <div class="form-card" style="margin-bottom:20px;">
                            <div class="form-card-header"
                                style="background:linear-gradient(135deg,var(--blue),var(--blue-mid));">
                                <h3><i class="fa fa-search"></i> {{ __('ui.ppid_objection_tracking_title') }}</h3>
                                <p>{{ __('ui.ppid_objection_tracking_desc') }}</p>
                            </div>
                            <div class="form-body">
                                <form class="ppid-form" id="formCekPpidKeberatan" method="GET"
                                    action="{{ route('ppid.tracking') }}">
                                    <div class="form-group" style="margin-bottom:14px;">
                                        <label>{{ __('ui.ppid_tracking_ticket') }} <span
                                                style="color:var(--red)">*</span></label>
                                        <input type="text" name="ticket"
                                            placeholder="{{ __('ui.ppid_objection_tracking_placeholder') }}" required />
                                    </div>
                                    <button type="submit" class="btn-submit" style="background:var(--blue);width:100%;">
                                        <i class="fa fa-search"></i> {{ __('ui.ppid_objection_tracking_btn') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="form-card" style="background:var(--gray-50);">
                            <div style="padding:20px;">
                                <h4 style="font-size:14px;font-weight:700;color:var(--gray-700);margin-bottom:10px;">
                                    <i class="fa fa-gavel" style="color:var(--red);"></i> Ketentuan Keberatan
                                </h4>
                                <ul style="padding-left:18px;margin:0;font-size:13px;color:var(--gray-600);line-height:2;">
                                    <li>Pengajuan keberatan sesuai Pasal 35 UU No. 14/2008</li>
                                    <li>Keberatan diajukan paling lambat 30 hari kerja setelah ditemukannya alasan keberatan
                                    </li>
                                    <li>Atasan PPID wajib memberikan tanggapan dalam waktu paling lambat 30 hari kerja</li>
                                    <li>Jika tidak puas, dapat mengajukan sengketa ke Komisi Informasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
