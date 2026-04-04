<?php

namespace App\Http\Controllers;

use App\Models\InformationCategory;
use App\Models\Potential;
use App\Models\Official;

class PotensiController extends Controller
{
    public function index()
    {
        $query = Potential::published();

        if (request('kategori')) {
            $cat = InformationCategory::where('slug', request('kategori'))->first();
            if ($cat) {
                $query->where('information_category_id', $cat->id);
            }
        }

        $potentials = $query->paginate(12);
        $categories = InformationCategory::forPotential()->active()->orderBy('order')->get();
        $lurah = Official::where('level', 'lurah')->active()->first();

        return view('potensi.index', compact('potentials', 'categories', 'lurah'));
    }

    public function show(Potential $potential)
    {
        if (!$potential->is_published) {
            abort(404);
        }

        $relatedPotentials = Potential::published()
            ->where('id', '!=', $potential->id)
            ->where('information_category_id', $potential->information_category_id)
            ->take(4)
            ->get();

        return view('potensi.show', compact('potential', 'relatedPotentials'));
    }
}
