<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Official;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('category')->latest('published_at');

        if ($request->kategori) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $news = $query->paginate(12);
        $categories = NewsCategory::withCount('news')->get();
        $lurah = Official::where('level', 'lurah')->first();

        return view('berita.index', compact('news', 'categories', 'lurah'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->published()->with(['category', 'author'])->firstOrFail();
        $news->increment('views');

        $categories = NewsCategory::all();

        $latestNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $previousNews = News::published()
            ->where('published_at', '<', $news->published_at)
            ->latest('published_at')
            ->first();

        $nextNews = News::published()
            ->where('published_at', '>', $news->published_at)
            ->oldest('published_at')
            ->first();

        return view('berita.show', compact('news', 'categories', 'latestNews', 'previousNews', 'nextNews'));
    }
}
