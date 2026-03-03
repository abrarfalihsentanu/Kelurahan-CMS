<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Statistic;
use App\Models\News;
use App\Models\Service;
use App\Models\Agenda;
use App\Models\Official;
use App\Models\ServiceHour;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $statistics = Statistic::active()->get();
        $news = News::published()->with('category')->take(4)->get();
        $services = Service::active()->take(6)->get();
        $agendas = Agenda::published()->upcoming()->take(4)->get();
        $lurah = Official::where('level', 'lurah')->active()->first();
        $serviceHours = ServiceHour::ordered()->get();
        $galleries = Gallery::where('is_active', true)->orderBy('order')->take(8)->get();

        return view('home', compact(
            'sliders',
            'statistics',
            'news',
            'services',
            'agendas',
            'lurah',
            'serviceHours',
            'galleries'
        ));
    }
}
