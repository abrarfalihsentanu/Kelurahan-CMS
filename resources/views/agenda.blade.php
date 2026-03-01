@extends('layouts.app')

@section('title', __('ui.agenda_title'))

@push('styles')
    <style>
        .calendar-container {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .calendar-header {
            background: linear-gradient(135deg, var(--red), var(--red-mid));
            color: #fff;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendar-header h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .calendar-nav {
            display: flex;
            gap: 8px;
        }

        .calendar-nav a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background 0.2s;
        }

        .calendar-nav a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .calendar-day-header {
            padding: 12px 8px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            color: var(--gray-600);
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }

        .calendar-day-header.weekend {
            color: var(--red);
        }

        .calendar-day {
            min-height: 90px;
            padding: 8px;
            border: 1px solid var(--gray-100);
            border-top: none;
            border-left: none;
            background: #fff;
            position: relative;
            transition: background 0.2s;
        }

        .calendar-day:hover {
            background: var(--gray-50);
        }

        .calendar-day.other-month {
            background: var(--gray-50);
        }

        .calendar-day.other-month .day-number {
            color: var(--gray-400);
        }

        .calendar-day.today {
            background: #FEF3E2;
        }

        .calendar-day.today .day-number {
            background: var(--orange);
            color: #fff;
        }

        .day-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 4px;
        }

        .day-agenda {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 4px;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            transition: transform 0.1s;
        }

        .day-agenda:hover {
            transform: scale(1.02);
        }

        .day-agenda.upcoming {
            background: #E3F2FD;
            color: var(--blue);
        }

        .day-agenda.ongoing {
            background: #FFF3E0;
            color: var(--orange);
        }

        .day-agenda.completed {
            background: var(--gray-100);
            color: var(--gray-500);
        }

        .agenda-detail-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .agenda-detail-modal.active {
            display: flex;
        }

        .agenda-modal-content {
            background: #fff;
            border-radius: var(--radius-lg);
            max-width: 500px;
            width: 100%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
        }

        .agenda-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .agenda-modal-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .agenda-modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--gray-100);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .agenda-modal-body {
            padding: 24px;
        }

        .table-container {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-200);
        }

        .table-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .agenda-table {
            width: 100%;
            border-collapse: collapse;
        }

        .agenda-table th {
            background: var(--gray-50);
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-600);
            text-transform: uppercase;
            border-bottom: 2px solid var(--gray-200);
        }

        .agenda-table td {
            padding: 16px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 13.5px;
            color: var(--gray-700);
        }

        .agenda-table tr:hover td {
            background: var(--gray-50);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-badge.upcoming {
            background: #E3F2FD;
            color: var(--blue);
        }

        .status-badge.ongoing {
            background: #FFF3E0;
            color: var(--orange);
        }

        .status-badge.completed {
            background: var(--gray-100);
            color: var(--gray-500);
        }

        .pagination-wrapper {
            padding: 16px 24px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: center;
        }

        .dt-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid var(--gray-200);
            gap: 12px;
            flex-wrap: wrap;
        }

        .dt-length {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--gray-600);
        }

        .dt-length select {
            padding: 5px 10px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 13px;
            color: var(--gray-700);
            background: #fff;
            cursor: pointer;
            outline: none;
        }

        .dt-length select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 2px rgba(30, 64, 175, .12);
        }

        .dt-search {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--gray-600);
        }

        .dt-search input {
            padding: 6px 12px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 13px;
            color: var(--gray-700);
            outline: none;
            width: 180px;
        }

        .dt-search input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 2px rgba(30, 64, 175, .12);
        }

        .dt-info-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
            gap: 12px;
        }

        .dt-info {
            font-size: 13px;
            color: var(--gray-500);
        }

        .dt-pagination {
            display: flex;
            gap: 4px;
        }

        .dt-pagination button {
            padding: 6px 12px;
            border: 1px solid var(--gray-300);
            background: #fff;
            border-radius: 6px;
            font-size: 13px;
            color: var(--gray-600);
            cursor: pointer;
            transition: all .15s;
        }

        .dt-pagination button:hover:not(:disabled) {
            background: var(--gray-50);
            border-color: var(--blue);
            color: var(--blue);
        }

        .dt-pagination button.active {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .dt-pagination button:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .agenda-table th.sortable {
            cursor: pointer;
            user-select: none;
            position: relative;
            padding-right: 24px;
        }

        .agenda-table th.sortable:hover {
            background: var(--gray-100);
        }

        .sort-icons {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 1px;
            font-size: 8px;
            color: var(--gray-400);
            line-height: 1;
        }

        .sort-icons .active-asc,
        .sort-icons .active-desc {
            color: var(--gray-700);
        }

        .upcoming-sidebar {
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .upcoming-header {
            background: linear-gradient(135deg, var(--blue-mid), var(--blue-light));
            color: #fff;
            padding: 16px 20px;
        }

        .upcoming-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .upcoming-list {
            padding: 16px;
        }

        .upcoming-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .upcoming-item:last-child {
            border-bottom: none;
        }

        .upcoming-date {
            width: 48px;
            text-align: center;
            flex-shrink: 0;
        }

        .upcoming-date .day {
            font-size: 20px;
            font-weight: 800;
            color: var(--red);
            line-height: 1;
        }

        .upcoming-date .month {
            font-size: 11px;
            color: var(--gray-500);
            text-transform: uppercase;
        }

        .upcoming-info h5 {
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 4px;
        }

        .upcoming-info p {
            font-size: 11px;
            color: var(--gray-500);
            margin: 0;
        }

        @media (max-width: 768px) {
            .calendar-day {
                min-height: 60px;
                padding: 4px;
            }

            .day-number {
                width: 24px;
                height: 24px;
                font-size: 11px;
            }

            .day-agenda {
                font-size: 9px;
                padding: 2px 4px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- PAGE BANNER -->
    <section class="page-banner">
        <div class="page-banner-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('ui.breadcrumb_home') }}</a>
                <i class="fa fa-chevron-right"></i>
                <a href="{{ route('informasi') }}">Informasi</a>
                <i class="fa fa-chevron-right"></i>
                <span>{{ __('ui.agenda_title') }}</span>
            </div>
            <h1><i class="fa fa-calendar-alt"></i> {{ __('ui.agenda_title') }}</h1>
            <p>{{ __('ui.agenda_desc') }}</p>
        </div>
    </section>

    <div style="max-width:1320px;margin:0 auto;padding:44px 24px;">
        <div class="agenda-layout">
            <div>
                <!-- CALENDAR -->
                <div class="calendar-container" style="margin-bottom:30px;">
                    <div class="calendar-header">
                        <h3><i class="fa fa-calendar-alt"></i> {{ $calendarData['monthName'] }}</h3>
                        <div class="calendar-nav">
                            <a href="{{ route('agenda', ['month' => $calendarData['prevMonth'], 'year' => $calendarData['prevYear']]) }}"
                                title="Bulan Sebelumnya">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a href="{{ route('agenda', ['month' => now()->month, 'year' => now()->year]) }}"
                                title="{{ __('ui.agenda_today') }}" style="font-size:12px;width:auto;padding:0 12px;">
                                {{ __('ui.agenda_today') }}
                            </a>
                            <a href="{{ route('agenda', ['month' => $calendarData['nextMonth'], 'year' => $calendarData['nextYear']]) }}"
                                title="Bulan Berikutnya">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="calendar-grid">
                        <div class="calendar-day-header weekend">{{ __('ui.agenda_sun') }}</div>
                        <div class="calendar-day-header">{{ __('ui.agenda_mon') }}</div>
                        <div class="calendar-day-header">{{ __('ui.agenda_tue') }}</div>
                        <div class="calendar-day-header">{{ __('ui.agenda_wed') }}</div>
                        <div class="calendar-day-header">{{ __('ui.agenda_thu') }}</div>
                        <div class="calendar-day-header">{{ __('ui.agenda_fri') }}</div>
                        <div class="calendar-day-header weekend">{{ __('ui.agenda_sat') }}</div>

                        @foreach ($calendarData['weeks'] as $week)
                            @foreach ($week as $day)
                                <div
                                    class="calendar-day {{ !$day['isCurrentMonth'] ? 'other-month' : '' }} {{ $day['isToday'] ? 'today' : '' }}">
                                    <div class="day-number">{{ $day['date']->format('j') }}</div>
                                    @foreach ($day['agendas'] as $agenda)
                                        <div class="day-agenda {{ $agenda->status }}"
                                            onclick="showAgendaDetail({{ json_encode($agenda) }})"
                                            title="{{ $agenda->title }}">
                                            {{ Str::limit($agenda->title, 15) }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-container" id="agendaDataTable">
                    <div class="table-header">
                        <h3><i class="fa fa-list"></i> {{ __('ui.agenda_list_title') }}</h3>
                    </div>
                    <div class="dt-controls">
                        <div class="dt-length">
                            <span>Show</span>
                            <select id="dtPerPage" onchange="dtRender()">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>entries</span>
                        </div>
                        <div class="dt-search">
                            <span>Search:</span>
                            <input type="text" id="dtSearch" placeholder="" oninput="dtRender()">
                        </div>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="agenda-table" id="dtTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-col="0" onclick="dtSort(0)">{{ __('ui.agenda_event') }}
                                        <span class="sort-icons"><i class="fa fa-caret-up"></i><i
                                                class="fa fa-caret-down"></i></span></th>
                                    <th class="sortable" data-col="1" onclick="dtSort(1)">{{ __('ui.agenda_date') }}
                                        <span class="sort-icons"><i class="fa fa-caret-up"></i><i
                                                class="fa fa-caret-down"></i></span></th>
                                    <th class="sortable" data-col="2" onclick="dtSort(2)">{{ __('ui.agenda_time') }}
                                        <span class="sort-icons"><i class="fa fa-caret-up"></i><i
                                                class="fa fa-caret-down"></i></span></th>
                                    <th class="sortable" data-col="3" onclick="dtSort(3)">{{ __('ui.agenda_location') }}
                                        <span class="sort-icons"><i class="fa fa-caret-up"></i><i
                                                class="fa fa-caret-down"></i></span></th>
                                    <th class="sortable" data-col="4" onclick="dtSort(4)">{{ __('ui.agenda_status') }}
                                        <span class="sort-icons"><i class="fa fa-caret-up"></i><i
                                                class="fa fa-caret-down"></i></span></th>
                                </tr>
                            </thead>
                            <tbody id="dtBody"></tbody>
                        </table>
                    </div>
                    <div class="dt-info-pagination">
                        <div class="dt-info" id="dtInfo"></div>
                        <div class="dt-pagination" id="dtPagination"></div>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div>
                <div class="upcoming-sidebar">
                    <div class="upcoming-header">
                        <h4><i class="fa fa-clock"></i> {{ __('ui.agenda_upcoming') }}</h4>
                    </div>
                    <div class="upcoming-list">
                        @forelse($upcomingAgendas as $agenda)
                            <div class="upcoming-item">
                                <div class="upcoming-date">
                                    <div class="day">{{ $agenda->event_date->format('d') }}</div>
                                    <div class="month">{{ $agenda->event_date->translatedFormat('M') }}</div>
                                </div>
                                <div class="upcoming-info">
                                    <h5>{{ Str::limit($agenda->title, 40) }}</h5>
                                    <p><i class="fa fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB</p>
                                    <p><i class="fa fa-map-marker-alt"></i> {{ $agenda->location }}</p>
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;padding:20px;">
                                <i class="fa fa-calendar-check"
                                    style="font-size:32px;color:var(--gray-300);margin-bottom:12px;"></i>
                                <p style="font-size:13px;color:var(--gray-500);">{{ __('ui.agenda_no_upcoming') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div
                    style="margin-top:20px;background:#fff;border-radius:var(--radius-lg);padding:20px;box-shadow:var(--shadow-sm);">
                    <h4 style="font-size:14px;font-weight:700;color:var(--gray-900);margin-bottom:12px;">
                        <i class="fa fa-info-circle" style="color:var(--blue);"></i> {{ __('ui.agenda_color_legend') }}
                    </h4>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="width:16px;height:16px;border-radius:4px;background:#E3F2FD;"></span>
                            <span
                                style="font-size:12px;color:var(--gray-700);">{{ __('ui.agenda_status_upcoming') }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="width:16px;height:16px;border-radius:4px;background:#FFF3E0;"></span>
                            <span
                                style="font-size:12px;color:var(--gray-700);">{{ __('ui.agenda_status_ongoing_long') }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="width:16px;height:16px;border-radius:4px;background:var(--gray-100);"></span>
                            <span style="font-size:12px;color:var(--gray-700);">{{ __('ui.agenda_status_done') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Agenda -->
    <div class="agenda-detail-modal" id="agendaModal">
        <div class="agenda-modal-content">
            <div class="agenda-modal-header">
                <h4 id="modalTitle">{{ __('ui.agenda_detail') }}</h4>
                <button class="agenda-modal-close" onclick="closeAgendaModal()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="agenda-modal-body">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showAgendaDetail(agenda) {
            const modal = document.getElementById('agendaModal');
            const content = document.getElementById('modalContent');

            const statusLabels = {
                'upcoming': '<span class="status-badge upcoming">{{ __('ui.agenda_status_upcoming') }}</span>',
                'ongoing': '<span class="status-badge ongoing">{{ __('ui.agenda_status_ongoing') }}</span>',
                'completed': '<span class="status-badge completed">{{ __('ui.agenda_status_done') }}</span>'
            };

            const eventDate = new Date(agenda.event_date);
            const formattedDate = eventDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            content.innerHTML = `
            <div style="margin-bottom:16px;">
                ${statusLabels[agenda.status] || ''}
            </div>
            <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:16px;">${agenda.title}</h3>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <i class="fa fa-calendar" style="color:var(--red);width:20px;"></i>
                    <span style="font-size:13px;color:var(--gray-700);">${formattedDate}</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <i class="fa fa-clock" style="color:var(--orange);width:20px;"></i>
                    <span style="font-size:13px;color:var(--gray-700);">${agenda.start_time.substring(0,5)} - ${agenda.end_time.substring(0,5)} WIB</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <i class="fa fa-map-marker-alt" style="color:var(--blue);width:20px;"></i>
                    <span style="font-size:13px;color:var(--gray-700);">${agenda.location}</span>
                </div>
                ${agenda.organizer ? `
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <i class="fa fa-users" style="color:var(--gray-500);width:20px;"></i>
                                        <span style="font-size:13px;color:var(--gray-700);">${agenda.organizer}</span>
                                    </div>
                                    ` : ''}
            </div>
            ${agenda.description ? `
                                <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--gray-200);">
                                    <h5 style="font-size:13px;font-weight:700;color:var(--gray-700);margin-bottom:8px;">{{ __('ui.agenda_description') }}</h5>
                                    <p style="font-size:13px;color:var(--gray-600);line-height:1.6;">${agenda.description}</p>
                                </div>
                                ` : ''}
        `;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeAgendaModal() {
            const modal = document.getElementById('agendaModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal on outside click
        document.getElementById('agendaModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAgendaModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAgendaModal();
            }
        });

        // ==================== DATATABLE ====================
        const dtData = @json($allAgendasJson);

        let dtPage = 1;
        let dtSortCol = 1;
        let dtSortDir = 'desc';

        const statusLabelsTable = {
            'upcoming': '<span class="status-badge upcoming">{{ __('ui.agenda_status_upcoming') }}</span>',
            'ongoing': '<span class="status-badge ongoing">{{ __('ui.agenda_status_ongoing') }}</span>',
            'completed': '<span class="status-badge completed">{{ __('ui.agenda_status_done') }}</span>'
        };

        function dtGetFiltered() {
            const q = document.getElementById('dtSearch').value.toLowerCase().trim();
            if (!q) return [...dtData];
            return dtData.filter(r =>
                r.title.toLowerCase().includes(q) ||
                r.event_date_display.toLowerCase().includes(q) ||
                r.location.toLowerCase().includes(q) ||
                r.status.toLowerCase().includes(q) ||
                (r.description && r.description.toLowerCase().includes(q))
            );
        }

        function dtGetSorted(data) {
            const keys = ['title', 'event_date', 'start_time', 'location', 'status'];
            const key = keys[dtSortCol];
            return data.sort((a, b) => {
                let va = (a[key] || '').toLowerCase();
                let vb = (b[key] || '').toLowerCase();
                if (va < vb) return dtSortDir === 'asc' ? -1 : 1;
                if (va > vb) return dtSortDir === 'asc' ? 1 : -1;
                return 0;
            });
        }

        function dtSort(col) {
            if (dtSortCol === col) {
                dtSortDir = dtSortDir === 'asc' ? 'desc' : 'asc';
            } else {
                dtSortCol = col;
                dtSortDir = 'asc';
            }
            dtPage = 1;
            dtRender();
        }

        function dtRender() {
            const perPage = parseInt(document.getElementById('dtPerPage').value);
            let filtered = dtGetFiltered();
            let sorted = dtGetSorted(filtered);
            const total = sorted.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));
            if (dtPage > totalPages) dtPage = totalPages;

            const start = (dtPage - 1) * perPage;
            const pageData = sorted.slice(start, start + perPage);

            // Render tbody
            const tbody = document.getElementById('dtBody');
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:40px;">
                    <i class="fa fa-calendar-times" style="font-size:32px;color:var(--gray-300);margin-bottom:12px;"></i>
                    <p style="color:var(--gray-500);">{{ __('ui.agenda_no_match') }}</p></td></tr>`;
            } else {
                tbody.innerHTML = pageData.map(r => `<tr>
                    <td><strong>${r.title}</strong>${r.description ? `<p style="font-size:12px;color:var(--gray-500);margin:4px 0 0;">${r.description}</p>` : ''}</td>
                    <td><strong>${r.event_date_display.split(' ')[0]}</strong> <span style="color:var(--gray-500);">${r.event_date_display.split(' ').slice(1).join(' ')}</span></td>
                    <td style="white-space:nowrap;">${r.start_time} - ${r.end_time}</td>
                    <td>${r.location}</td>
                    <td>${statusLabelsTable[r.status] || r.status}</td>
                </tr>`).join('');
            }

            // Render info
            const infoEl = document.getElementById('dtInfo');
            if (total === 0) {
                infoEl.textContent = 'Showing 0 to 0 of 0 entries' + (dtData.length !== total ?
                    ` (filtered from ${dtData.length} total entries)` : '');
            } else {
                infoEl.textContent = `Showing ${start + 1} to ${Math.min(start + perPage, total)} of ${total} entries` + (
                    dtData.length !== total ? ` (filtered from ${dtData.length} total entries)` : '');
            }

            // Render pagination
            const pagEl = document.getElementById('dtPagination');
            let pagHtml = `<button onclick="dtGoPage(${dtPage - 1})" ${dtPage <= 1 ? 'disabled' : ''}>Previous</button>`;
            let startP = Math.max(1, dtPage - 2);
            let endP = Math.min(totalPages, startP + 4);
            if (endP - startP < 4) startP = Math.max(1, endP - 4);
            for (let i = startP; i <= endP; i++) {
                pagHtml += `<button class="${i === dtPage ? 'active' : ''}" onclick="dtGoPage(${i})">${i}</button>`;
            }
            pagHtml += `<button onclick="dtGoPage(${dtPage + 1})" ${dtPage >= totalPages ? 'disabled' : ''}>Next</button>`;
            pagEl.innerHTML = pagHtml;

            // Update sort icons
            document.querySelectorAll('#dtTable th.sortable').forEach(th => {
                const col = parseInt(th.dataset.col);
                const icons = th.querySelector('.sort-icons');
                const up = icons.querySelector('.fa-caret-up');
                const down = icons.querySelector('.fa-caret-down');
                up.className = 'fa fa-caret-up';
                down.className = 'fa fa-caret-down';
                if (col === dtSortCol) {
                    if (dtSortDir === 'asc') up.className = 'fa fa-caret-up active-asc';
                    else down.className = 'fa fa-caret-down active-desc';
                }
            });
        }

        function dtGoPage(p) {
            const perPage = parseInt(document.getElementById('dtPerPage').value);
            const total = dtGetFiltered().length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));
            if (p < 1 || p > totalPages) return;
            dtPage = p;
            dtRender();
        }

        // Initial render
        dtRender();
    </script>
@endpush
