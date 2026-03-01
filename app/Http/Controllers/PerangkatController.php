<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Official;

class PerangkatController extends Controller
{
    public function index()
    {
        $officials = Official::active()->with('division')->get();
        $divisions = Division::active()->with('officials')->get();

        $lurah = $officials->where('level', 'lurah')->first();
        $sekretaris = $officials->where('level', 'sekretaris')->first();
        $kasiList = $officials->where('level', 'kasi');

        return view('perangkat', compact('officials', 'divisions', 'lurah', 'sekretaris', 'kasiList'));
    }
}
