<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceHour;
use App\Models\Official;

class LayananController extends Controller
{
    public function index()
    {
        $services = Service::active()->with('category')->get();
        $categories = ServiceCategory::with('services')->get();
        $serviceHours = ServiceHour::ordered()->get();
        $lurah = Official::where('level', 'lurah')->first();

        return view('layanan', compact('services', 'categories', 'serviceHours', 'lurah'));
    }
}
