<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Achievement;
use App\Models\Infographic;
use App\Models\Potential;
use App\Models\Official;
use App\Models\PpidDocument;
use App\Models\PeriodicInformation;

class InformasiController extends Controller
{
    public function index()
    {
        $agendas = Agenda::published()->orderBy('event_date', 'desc')->take(5)->get();
        $achievements = Achievement::published()->get();
        $infographics = Infographic::published()->get();
        $potentials = Potential::published()->get();
        $lurah = Official::where('level', 'lurah')->active()->first();
        $ppidDocuments = PpidDocument::published()->ordered()->with('category')->get();
        $periodicInformations = PeriodicInformation::published()->ordered()->get();

        return view('informasi', compact('agendas', 'achievements', 'infographics', 'potentials', 'lurah', 'ppidDocuments', 'periodicInformations'));
    }
}
