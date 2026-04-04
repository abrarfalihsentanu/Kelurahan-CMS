<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\FileValidator;
use App\Models\News;
use App\Models\NewsCategory;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest()->paginate(25);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::active()->orderBy('order')->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:news',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Enhanced file validation
        if ($request->hasFile('image')) {
            $result = FileValidator::validate($request->file('image'), 'image', 2048);
            if (!$result['valid']) {
                return back()
                    ->withErrors(['image' => implode(', ', $result['errors'])])
                    ->withInput();
            }

            $sanitizedName = FileValidator::sanitizeFilename($request->file('image')->getClientOriginalName());
            $validated['image'] = $request->file('image')->storeAs('news', $sanitizedName, 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'news');
        }

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::active()->orderBy('order')->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:news,slug,' . $news->id,
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($news->image) {
                StorageHelper::deleteFromBoth($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'news');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['is_published'] && !$news->published_at && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            StorageHelper::deleteFromBoth($news->image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
