<?php

namespace App\Http\Controllers;

use App\Models\Infographic;
use App\Models\InformationCategory;
use App\Models\Official;

class InfografisController extends Controller
{
    public function index()
    {
        $query = Infographic::published();

        if (request('kategori')) {
            $cat = InformationCategory::where('slug', request('kategori'))->first();
            if ($cat) {
                $query->where('information_category_id', $cat->id);
            }
        }

        $infographics = $query->paginate(12);
        $categories = InformationCategory::forInfographic()->active()->ordered()->get();
        $lurah = Official::where('level', 'lurah')->active()->first();

        return view('infografis.index', compact('infographics', 'categories', 'lurah'));
    }

    public function show(Infographic $infographic)
    {
        if (!$infographic->is_published) {
            abort(404);
        }

        $relatedInfographics = Infographic::published()
            ->where('id', '!=', $infographic->id)
            ->where('information_category_id', $infographic->information_category_id)
            ->take(4)
            ->get();

        return view('infografis.show', compact('infographic', 'relatedInfographics'));
    }
}
