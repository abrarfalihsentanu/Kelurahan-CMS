@extends('layouts.app')

@section('title', __('ui.pengaduan_title'))

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.pengaduan_title') }}</span>
            </div>
            <h1><i class="fa fa-bullhorn"></i> {{ __('ui.pengaduan_title') }}</h1>
            <p>{{ __('ui.pengaduan_desc') }}</p>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div style="max-width:1320px;margin:0 auto;padding:44px 24px;">

        <!-- ALUR PENGADUAN -->
        <section class="section-block">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.pengaduan_flow_badge') }}</span>
                    <h2 class="section-title">{{ __('ui.pengaduan_flow_title') }}</h2>
                </div>
            </div>
            <div class="pengaduan-alur">
                <div class="alur-step">
                    <div class="alur-icon"><i class="fa fa-edit"></i></div>
                    <div class="alur-num">1</div>
                    <h4>{{ __('ui.pengaduan_step1') }}</h4>
                    <p>{{ __('ui.pengaduan_step1_desc') }}</p>
                </div>
                <div class="alur-arrow"><i class="fa fa-chevron-right"></i></div>
                <div class="alur-step">
                    <div class="alur-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="alur-num">2</div>
                    <h4>{{ __('ui.pengaduan_step2') }}</h4>
                    <p>{{ __('ui.pengaduan_step2_desc') }}</p>
                </div>
                <div class="alur-arrow"><i class="fa fa-chevron-right"></i></div>
                <div class="alur-step">
                    <div class="alur-icon"><i class="fa fa-cogs"></i></div>
                    <div class="alur-num">3</div>
                    <h4>{{ __('ui.pengaduan_step3') }}</h4>
                    <p>{{ __('ui.pengaduan_step3_desc') }}</p>
                </div>
                <div class="alur-arrow"><i class="fa fa-chevron-right"></i></div>
                <div class="alur-step">
                    <div class="alur-icon"><i class="fa fa-reply"></i></div>
                    <div class="alur-num">4</div>
                    <h4>{{ __('ui.pengaduan_step4') }}</h4>
                    <p>{{ __('ui.pengaduan_step4_desc') }}</p>
                </div>
            </div>
        </section>

        <div class="kontak-form-grid" style="display:grid;grid-template-columns:3fr 2fr;gap:24px;">

            <!-- FORM PENGADUAN -->
            <section class="section-block" id="form-pengaduan">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.pengaduan_form_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.pengaduan_form_title') }}</h2>
                    </div>
                </div>
                <div class="form-card">
                    <div class="form-card-header">
                        <h3><i class="fa fa-bullhorn"></i> Sampaikan Pengaduan Anda</h3>
                        <p>Isi formulir di bawah ini dengan lengkap dan jelas. Pengaduan Anda akan diproses dalam waktu
                            maksimal 5 (lima) hari kerja.</p>
                    </div>
                    <div class="form-body">
                        @if (session('success'))
                            <div
                                style="background:#E8F5E9;border:1px solid #4CAF50;color:#2E7D32;padding:16px;border-radius:8px;margin-bottom:20px;">
                                <strong>Berhasil!</strong> {{ session('success') }}
                                @if (session('ticket_number'))
                                    <br>Nomor Tiket Anda: <strong>{{ session('ticket_number') }}</strong>
                                @endif
                            </div>
                        @endif

                        @if ($errors->any())
                            <div
                                style="background:#FFEBEE;border:1px solid #E53935;color:#B71C1C;padding:16px;border-radius:8px;margin-bottom:20px;">
                                <strong><i class="fa fa-exclamation-triangle"></i> Terjadi Kesalahan:</strong>
                                <ul style="margin:8px 0 0;padding-left:20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="ppid-form" id="formPengaduan" method="POST" action="{{ route('pengaduan.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label>{{ __('ui.pengaduan_name') }} <span style="color:var(--red)">*</span></label>
                                    <input type="text" name="name"
                                        placeholder="{{ __('ui.pengaduan_name_placeholder') }}" required
                                        value="{{ old('name') }}" />
                                </div>
                                <div class="form-group">
                                    <label>NIK (Nomor Induk Kependudukan) <span style="color:var(--red)">*</span></label>
                                    <input type="text" name="nik" placeholder="16 digit NIK" maxlength="16" required
                                        value="{{ old('nik') }}" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>{{ __('ui.pengaduan_phone') }} <span style="color:var(--red)">*</span></label>
                                    <input type="tel" name="phone"
                                        placeholder="{{ __('ui.pengaduan_phone_placeholder') }}" required
                                        value="{{ old('phone') }}" />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('ui.pengaduan_email') }}</label>
                                    <input type="email" name="email"
                                        placeholder="{{ __('ui.pengaduan_email_placeholder') }}"
                                        value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>{{ __('ui.pengaduan_address') }} <span style="color:var(--red)">*</span></label>
                                    <input type="text" name="address"
                                        placeholder="{{ __('ui.pengaduan_address_placeholder') }}" required
                                        value="{{ old('address') }}" />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('ui.pengaduan_category') }} <span
                                            style="color:var(--red)">*</span></label>
                                    <select name="complaint_category_id" required>
                                        <option value="">{{ __('ui.pengaduan_category_select') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('complaint_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Lokasi Kejadian <span style="color:var(--red)">*</span></label>
                                    <input type="text" name="location"
                                        placeholder="Contoh: Jl. KS Tubun, depan Gang Masjid RT 05/03" required
                                        value="{{ old('location') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kejadian</label>
                                    <input type="date" name="incident_date" value="{{ old('incident_date') }}" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>RT/RW</label>
                                    <input type="text" name="rt_rw" placeholder="Contoh: 005/003"
                                        value="{{ old('rt_rw') }}" />
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:18px;">
                                <label>{{ __('ui.pengaduan_subject') }} <span style="color:var(--red)">*</span></label>
                                <input type="text" name="subject"
                                    placeholder="{{ __('ui.pengaduan_subject_placeholder') }}" required
                                    value="{{ old('subject') }}" />
                            </div>
                            <div class="form-group" style="margin-bottom:18px;">
                                <label>{{ __('ui.pengaduan_message') }} <span style="color:var(--red)">*</span></label>
                                <textarea name="description" placeholder="{{ __('ui.pengaduan_message_placeholder') }}" required
                                    style="min-height:150px;">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group" style="margin-bottom:24px;">
                                <label>{{ __('ui.pengaduan_attachment') }}</label>
                                <input type="file" name="attachments[]" multiple accept="image/*,.pdf,.doc,.docx"
                                    style="padding:10px;background:var(--gray-100);border:1.5px dashed var(--gray-300);border-radius:8px;" />
                                <small
                                    style="font-size:12px;color:var(--gray-500);margin-top:4px;">{{ __('ui.pengaduan_attachment_help') }}</small>
                            </div>
                            <div style="display:flex;align-items:flex-start;gap:8px;margin-bottom:20px;">
                                <input type="checkbox" name="agreement" required
                                    style="width:18px;height:18px;accent-color:var(--red);margin-top:2px;flex-shrink:0;" />
                                <label style="font-size:13.5px;color:var(--gray-700);line-height:1.5;">Saya menyatakan
                                    bahwa pengaduan yang disampaikan adalah benar berdasarkan fakta. Saya bersedia
                                    bertanggung jawab atas isi pengaduan ini dan data saya digunakan untuk keperluan
                                    tindak
                                    lanjut oleh Kelurahan Petamburan.</label>
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fa fa-paper-plane"></i> {{ __('ui.pengaduan_submit') }}
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- CEK STATUS PENGADUAN -->
            <section class="section-block" id="cek-status">
                <div class="section-header">
                    <div class="section-title-group">
                        <span class="section-badge">{{ __('ui.pengaduan_check_badge') }}</span>
                        <h2 class="section-title">{{ __('ui.pengaduan_check_title') }}</h2>
                    </div>
                </div>
                <div class="form-card">
                    <div class="form-card-header" style="background:linear-gradient(90deg,var(--blue),var(--blue-mid));">
                        <h3><i class="fa fa-search"></i> {{ __('ui.pengaduan_check_title') }}</h3>
                        <p>{{ __('ui.pengaduan_check_desc') }}</p>
                    </div>
                    <div class="form-body">
                        <form class="ppid-form" id="formCekStatus" method="GET"
                            action="{{ route('pengaduan.tracking') }}">
                            <div class="form-group" style="margin-bottom:18px;">
                                <label>Nomor Tiket Pengaduan <span style="color:var(--red)">*</span></label>
                                <input type="text" name="ticket" id="inputTiket"
                                    placeholder="{{ __('ui.pengaduan_ticket_placeholder') }}" required />
                            </div>
                            <button type="submit" class="btn-submit"
                                style="background:linear-gradient(90deg,var(--blue),var(--blue-mid));">
                                <i class="fa fa-search"></i> {{ __('ui.pengaduan_check_btn') }}
                            </button>
                        </form>
                    </div>
                </div>
            </section>

        </div><!-- /.kontak-form-grid -->

        <!-- DAFTAR PENGADUAN / TRACKING TABLE -->
        <section class="section-block" id="daftar-pengaduan">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.pengaduan_list_badge') }}</span>
                    <h2 class="section-title">{{ __('ui.pengaduan_list_title') }}</h2>
                </div>
            </div>
            <div class="form-card">
                <div class="form-card-header" style="background:linear-gradient(90deg,var(--blue),var(--blue-mid));">
                    <h3><i class="fa fa-list-alt"></i> Riwayat Pengaduan Masyarakat</h3>
                    <p>Transparansi tindak lanjut pengaduan warga Kelurahan Petamburan</p>
                </div>
                <div class="form-body" style="padding:0;">
                    @if (isset($complaints) && $complaints->count() > 0)
                        <div style="overflow-x:auto;">
                            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                                <thead>
                                    <tr style="background:#f0f4f8;border-bottom:2px solid #dee2e6;">
                                        <th
                                            style="padding:12px 16px;text-align:left;font-weight:600;color:var(--gray-700);white-space:nowrap;">
                                            {{ __('ui.pengaduan_list_ticket') }}</th>
                                        <th
                                            style="padding:12px 16px;text-align:left;font-weight:600;color:var(--gray-700);">
                                            Nama</th>
                                        <th
                                            style="padding:12px 16px;text-align:left;font-weight:600;color:var(--gray-700);">
                                            {{ __('ui.pengaduan_list_category') }}</th>
                                        <th
                                            style="padding:12px 16px;text-align:left;font-weight:600;color:var(--gray-700);">
                                            {{ __('ui.pengaduan_list_subject') }}</th>
                                        <th
                                            style="padding:12px 16px;text-align:center;font-weight:600;color:var(--gray-700);white-space:nowrap;">
                                            {{ __('ui.pengaduan_list_date') }}</th>
                                        <th
                                            style="padding:12px 16px;text-align:center;font-weight:600;color:var(--gray-700);">
                                            {{ __('ui.pengaduan_list_status') }}</th>
                                        <th
                                            style="padding:12px 16px;text-align:center;font-weight:600;color:var(--gray-700);">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaints as $c)
                                        @php
                                            $statusColors = [
                                                'pending' => [
                                                    'bg' => '#fff3cd',
                                                    'text' => '#856404',
                                                    'label' => 'Menunggu',
                                                ],
                                                'process' => [
                                                    'bg' => '#cce5ff',
                                                    'text' => '#004085',
                                                    'label' => 'Diproses',
                                                ],
                                                'resolved' => [
                                                    'bg' => '#d4edda',
                                                    'text' => '#155724',
                                                    'label' => 'Selesai',
                                                ],
                                                'rejected' => [
                                                    'bg' => '#f8d7da',
                                                    'text' => '#721c24',
                                                    'label' => 'Ditolak',
                                                ],
                                            ];
                                            $st = $statusColors[$c->status] ?? $statusColors['pending'];
                                        @endphp
                                        <tr style="border-bottom:1px solid #eee;transition:background .15s;"
                                            onmouseover="this.style.background='#f8f9fa'"
                                            onmouseout="this.style.background='transparent'">
                                            <td
                                                style="padding:10px 16px;font-family:monospace;font-weight:600;color:var(--primary);white-space:nowrap;">
                                                {{ $c->ticket_number }}</td>
                                            <td style="padding:10px 16px;">{{ $c->name }}</td>
                                            <td style="padding:10px 16px;">{{ $c->category->name ?? '-' }}</td>
                                            <td
                                                style="padding:10px 16px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                {{ $c->subject }}</td>
                                            <td style="padding:10px 16px;text-align:center;white-space:nowrap;">
                                                {{ $c->created_at->format('d/m/Y') }}</td>
                                            <td style="padding:10px 16px;text-align:center;">
                                                <span
                                                    style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:{{ $st['bg'] }};color:{{ $st['text'] }};">
                                                    {{ $st['label'] }}
                                                </span>
                                            </td>
                                            <td style="padding:10px 16px;text-align:center;">
                                                <a href="{{ route('pengaduan.tracking', ['ticket' => $c->ticket_number]) }}"
                                                    style="display:inline-flex;align-items:center;gap:4px;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:500;color:#fff;background:linear-gradient(90deg,var(--blue),var(--blue-mid));text-decoration:none;transition:opacity .2s;"
                                                    onmouseover="this.style.opacity='0.85'"
                                                    onmouseout="this.style.opacity='1'">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($complaints->hasPages())
                            <div style="padding:16px 20px;border-top:1px solid #eee;display:flex;justify-content:center;">
                                {{ $complaints->links() }}
                            </div>
                        @endif
                    @else
                        <div style="padding:40px 20px;text-align:center;color:var(--gray-500);">
                            <i class="fa fa-inbox"
                                style="font-size:40px;margin-bottom:12px;display:block;opacity:.4;"></i>
                            <p style="margin:0;font-size:15px;">{{ __('ui.pengaduan_no_data') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- FAQ PENGADUAN -->
        <section class="section-block">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.pengaduan_faq_badge') }}</span>
                    <h2 class="section-title">{{ __('ui.pengaduan_faq_title') }}</h2>
                </div>
            </div>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                        <span>{{ __('ui.pengaduan_faq1_q') }}</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>{{ __('ui.pengaduan_faq1_a') }}</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                        <span>{{ __('ui.pengaduan_faq2_q') }}</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>{{ __('ui.pengaduan_faq2_a') }}</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                        <span>{{ __('ui.pengaduan_faq3_q') }}</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>{{ __('ui.pengaduan_faq3_a') }}</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
