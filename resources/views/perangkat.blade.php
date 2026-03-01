@extends('layouts.app')

@section('title', __('ui.perangkat_title'))

@section('content')
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.perangkat_title') }}</span>
            </div>
            <h1><i class="fa fa-users-cog"></i> {{ __('ui.perangkat_title') }}</h1>
            <p>{{ __('ui.perangkat_desc') }}</p>
        </div>
    </section>

    <div style="max-width:1320px;margin:0 auto;padding:44px 24px;">

        <!-- STRUKTUR ORGANISASI -->
        <section class="section-block">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.perangkat_org') }}</span>
                    <h2 class="section-title">{{ __('ui.perangkat_org_structure') }}</h2>
                </div>
            </div>

            <!-- Bagan Org -->
            <div
                style="background:#fff;border-radius:var(--radius-lg);padding:40px 20px;box-shadow:var(--shadow-sm);overflow-x:auto;">
                <div style="min-width:700px;">

                    <!-- Level 1: Lurah -->
                    @if ($lurah)
                        <div style="display:flex;justify-content:center;margin-bottom:0;">
                            <div
                                style="background:linear-gradient(135deg,var(--red),var(--red-mid));color:#fff;border-radius:16px;padding:20px 28px;text-align:center;min-width:220px;box-shadow:var(--shadow-md);">
                                @if ($lurah->photo)
                                    <div
                                        style="width:80px;height:80px;margin:0 auto 12px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,0.4);box-shadow:0 4px 12px rgba(0,0,0,0.2);">
                                        <img src="{{ asset('storage/' . $lurah->photo) }}" alt="{{ $lurah->name }}"
                                            style="width:100%;height:100%;object-fit:cover;">
                                    </div>
                                @else
                                    <div
                                        style="width:80px;height:80px;margin:0 auto 12px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;border:3px solid rgba(255,255,255,0.4);">
                                        <i class="fa fa-user" style="font-size:32px;opacity:0.8;"></i>
                                    </div>
                                @endif
                                <div style="font-weight:800;font-size:16px;">{{ $lurah->name }}</div>
                                <div style="font-size:13px;opacity:.9;margin-top:4px;">{{ $lurah->position }}</div>
                            </div>
                        </div>
                        <!-- Connector -->
                        <div style="display:flex;justify-content:center;">
                            <div
                                style="width:3px;height:35px;background:linear-gradient(to bottom, var(--red), var(--blue-mid));border-radius:2px;">
                            </div>
                        </div>
                    @endif

                    <!-- Level 2: Sekretaris -->
                    @if ($sekretaris)
                        <div style="display:flex;justify-content:center;margin-bottom:0;">
                            <div
                                style="background:linear-gradient(135deg,var(--blue-mid),var(--blue-light));color:#fff;border-radius:14px;padding:18px 24px;text-align:center;min-width:200px;box-shadow:var(--shadow-sm);">
                                @if ($sekretaris->photo)
                                    <div
                                        style="width:70px;height:70px;margin:0 auto 10px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,0.4);box-shadow:0 3px 10px rgba(0,0,0,0.15);">
                                        <img src="{{ asset('storage/' . $sekretaris->photo) }}"
                                            alt="{{ $sekretaris->name }}" style="width:100%;height:100%;object-fit:cover;">
                                    </div>
                                @else
                                    <div
                                        style="width:70px;height:70px;margin:0 auto 10px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;border:3px solid rgba(255,255,255,0.4);">
                                        <i class="fa fa-user" style="font-size:28px;opacity:0.8;"></i>
                                    </div>
                                @endif
                                <div style="font-weight:700;font-size:15px;">{{ $sekretaris->name }}</div>
                                <div style="font-size:12px;opacity:.9;margin-top:3px;">{{ $sekretaris->position }}</div>
                            </div>
                        </div>
                        <!-- Horizontal Connector -->
                        <div style="display:flex;justify-content:center;">
                            <div style="width:3px;height:30px;background:var(--gray-300);border-radius:2px;"></div>
                        </div>
                        <div style="display:flex;justify-content:center;margin-bottom:0;">
                            <div style="width:80%;max-width:800px;height:3px;background:var(--gray-300);border-radius:2px;">
                            </div>
                        </div>
                    @endif

                    <!-- Level 3: Kasi-kasi -->
                    @if ($kasiList->count() > 0)
                        <div style="display:flex;justify-content:center;gap:24px;flex-wrap:wrap;">
                            @foreach ($kasiList as $kasi)
                                <div style="flex:0 0 auto;">
                                    <div style="display:flex;justify-content:center;">
                                        <div style="width:3px;height:25px;background:var(--gray-300);border-radius:2px;">
                                        </div>
                                    </div>
                                    <div
                                        style="background:#fff;border:2px solid var(--orange);border-radius:12px;padding:16px 20px;text-align:center;min-width:170px;max-width:180px;box-shadow:var(--shadow-sm);">
                                        @if ($kasi->photo)
                                            <div
                                                style="width:60px;height:60px;margin:0 auto 10px;border-radius:50%;overflow:hidden;border:2px solid var(--orange);box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                                                <img src="{{ asset('storage/' . $kasi->photo) }}"
                                                    alt="{{ $kasi->name }}"
                                                    style="width:100%;height:100%;object-fit:cover;">
                                            </div>
                                        @else
                                            <div
                                                style="width:60px;height:60px;margin:0 auto 10px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;border:2px solid var(--orange);">
                                                <i class="fa fa-user" style="font-size:24px;color:var(--gray-400);"></i>
                                            </div>
                                        @endif
                                        <div style="font-weight:700;font-size:13px;color:var(--gray-900);">
                                            {{ $kasi->name }}</div>
                                        <div style="font-size:11.5px;color:var(--gray-500);margin-top:4px;">
                                            {{ $kasi->position }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </section>

        <!-- DAFTAR PEJABAT -->
        <section class="section-block" id="pejabat">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.perangkat_officials') }}</span>
                    <h2 class="section-title">{{ __('ui.perangkat_officials_list') }}</h2>
                </div>
            </div>
            <div class="pejabat-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ui.perangkat_no') }}</th>
                            <th>{{ __('ui.perangkat_photo') }}</th>
                            <th>{{ __('ui.perangkat_fullname') }}</th>
                            <th>{{ __('ui.perangkat_position') }}</th>
                            <th>{{ __('ui.perangkat_nip') }}</th>
                            <th>{{ __('ui.perangkat_contact') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($officials as $index => $official)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($official->photo)
                                        <div
                                            style="width:50px;height:50px;border-radius:50%;overflow:hidden;border:2px solid var(--blue-mid);box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                                            <img src="{{ asset('storage/' . $official->photo) }}"
                                                alt="{{ $official->name }}"
                                                style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div
                                            style="width:50px;height:50px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;border:2px solid var(--gray-300);">
                                            <i class="fa fa-user" style="font-size:20px;color:var(--gray-400);"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $official->name }}</strong></td>
                                <td>
                                    @php
                                        $badgeColors = [
                                            'lurah' => ['bg' => '#DBEAFE', 'color' => '#0F2A5C'],
                                            'sekretaris' => ['bg' => '#EFF6FF', 'color' => '#1B3A6B'],
                                            'kasi' => ['bg' => '#F0F4FF', 'color' => '#2554A0'],
                                            'staff' => ['bg' => '#F5F8FF', 'color' => '#2554A0'],
                                        ];
                                        $colors = $badgeColors[$official->level] ?? [
                                            'bg' => '#E3F2FD',
                                            'color' => 'var(--blue-mid)',
                                        ];
                                    @endphp
                                    <span
                                        style="background:{{ $colors['bg'] }};color:{{ $colors['color'] }};padding:3px 10px;border-radius:30px;font-size:12px;font-weight:700;">{{ $official->position }}</span>
                                </td>
                                <td>{{ $official->nip ?? '-' }}</td>
                                <td>
                                    @if ($official->phone)
                                        <a href="tel:{{ $official->phone }}"
                                            style="color:var(--blue-mid);">{{ $official->phone }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- TUGAS DAN FUNGSI -->
        <section class="section-block" id="tugas">
            <div class="section-header">
                <div class="section-title-group">
                    <span class="section-badge">{{ __('ui.perangkat_tupoksi') }}</span>
                    <h2 class="section-title">{{ __('ui.perangkat_duties') }}</h2>
                </div>
            </div>
            <div class="tupoksi-grid">
                <div
                    style="background:#fff;border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow-sm);border-left:4px solid var(--red);">
                    <h4 style="font-size:16px;font-weight:800;color:var(--red);margin-bottom:14px;"><i
                            class="fa fa-user-tie"></i> {{ __('ui.perangkat_lurah') }}</h4>
                    <ul style="display:flex;flex-direction:column;gap:8px;">
                        @foreach (__('ui.perangkat_lurah_duties') as $duty)
                            <li style="font-size:13.5px;color:var(--gray-700);display:flex;gap:8px;"><span
                                    style="color:var(--orange);font-weight:700;">›</span> {{ $duty }}</li>
                        @endforeach
                    </ul>
                </div>
                <div
                    style="background:#fff;border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow-sm);border-left:4px solid var(--orange);">
                    <h4 style="font-size:16px;font-weight:800;color:var(--orange);margin-bottom:14px;"><i
                            class="fa fa-user-friends"></i> {{ __('ui.perangkat_secretary') }}</h4>
                    <ul style="display:flex;flex-direction:column;gap:8px;">
                        @foreach (__('ui.perangkat_secretary_duties') as $duty)
                            <li style="font-size:13.5px;color:var(--gray-700);display:flex;gap:8px;"><span
                                    style="color:var(--orange);font-weight:700;">›</span> {{ $duty }}</li>
                        @endforeach
                    </ul>
                </div>
                <div
                    style="background:#fff;border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow-sm);border-left:4px solid #27AE60;">
                    <h4 style="font-size:16px;font-weight:800;color:#27AE60;margin-bottom:14px;"><i
                            class="fa fa-landmark"></i> {{ __('ui.perangkat_kasi_pem') }}</h4>
                    <ul style="display:flex;flex-direction:column;gap:8px;">
                        @foreach (__('ui.perangkat_kasi_pem_duties') as $duty)
                            <li style="font-size:13.5px;color:var(--gray-700);display:flex;gap:8px;"><span
                                    style="color:var(--orange);font-weight:700;">›</span> {{ $duty }}</li>
                        @endforeach
                    </ul>
                </div>
                <div
                    style="background:#fff;border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow-sm);border-left:4px solid #2980B9;">
                    <h4 style="font-size:16px;font-weight:800;color:#2980B9;margin-bottom:14px;"><i
                            class="fa fa-briefcase"></i> {{ __('ui.perangkat_kasi_ekbang') }}</h4>
                    <ul style="display:flex;flex-direction:column;gap:8px;">
                        @foreach (__('ui.perangkat_kasi_ekbang_duties') as $duty)
                            <li style="font-size:13.5px;color:var(--gray-700);display:flex;gap:8px;"><span
                                    style="color:var(--orange);font-weight:700;">›</span> {{ $duty }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

    </div>
@endsection
