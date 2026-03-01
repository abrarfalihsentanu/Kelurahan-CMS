<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Get all agendas for calendar
        $agendas = Agenda::published()
            ->whereYear('event_date', $year)
            ->whereMonth('event_date', $month)
            ->orderBy('event_date', 'asc')
            ->get();

        // Get all agendas for table
        $allAgendas = Agenda::published()
            ->orderBy('event_date', 'desc')
            ->get();

        // Prepare data for DataTable JS
        $allAgendasJson = $allAgendas->map(function ($a) {
            return [
                'title' => $a->title,
                'description' => \Illuminate\Support\Str::limit($a->description, 60),
                'event_date' => $a->event_date->format('Y-m-d'),
                'event_date_display' => $a->event_date->format('d') . ' ' . $a->event_date->translatedFormat('M Y'),
                'start_time' => Carbon::parse($a->start_time)->format('H:i'),
                'end_time' => Carbon::parse($a->end_time)->format('H:i'),
                'location' => $a->location,
                'status' => $a->status,
            ];
        })->values();

        // Get upcoming agendas
        $upcomingAgendas = Agenda::published()
            ->where('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // Generate calendar data
        $calendarData = $this->generateCalendar($year, $month, $agendas);

        return view('agenda', compact(
            'agendas',
            'allAgendas',
            'allAgendasJson',
            'upcomingAgendas',
            'calendarData',
            'month',
            'year'
        ));
    }

    private function generateCalendar($year, $month, $agendas)
    {
        $firstDay = Carbon::createFromDate($year, $month, 1);
        $lastDay = $firstDay->copy()->endOfMonth();
        $startOfCalendar = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);

        $weeks = [];
        $current = $startOfCalendar->copy();

        while ($current <= $endOfCalendar) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dayAgendas = $agendas->filter(function ($agenda) use ($current) {
                    return $agenda->event_date->isSameDay($current);
                });

                $week[] = [
                    'date' => $current->copy(),
                    'isCurrentMonth' => $current->month == $month,
                    'isToday' => $current->isToday(),
                    'agendas' => $dayAgendas
                ];
                $current->addDay();
            }
            $weeks[] = $week;
        }

        return [
            'weeks' => $weeks,
            'monthName' => Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y'),
            'prevMonth' => $month == 1 ? 12 : $month - 1,
            'prevYear' => $month == 1 ? $year - 1 : $year,
            'nextMonth' => $month == 12 ? 1 : $month + 1,
            'nextYear' => $month == 12 ? $year + 1 : $year,
        ];
    }

    public function getAgendaByDate(Request $request)
    {
        $date = $request->get('date');
        $agendas = Agenda::published()
            ->whereDate('event_date', $date)
            ->orderBy('start_time', 'asc')
            ->get();

        return response()->json($agendas);
    }
}
