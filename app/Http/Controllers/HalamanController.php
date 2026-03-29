<?php

namespace App\Http\Controllers;

use App\Models\Page;

class HalamanController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();

        return view('halaman.show', compact('page'));
    }
}
