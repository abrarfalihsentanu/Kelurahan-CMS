<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationCategoryController extends Controller
{
    public function index()
    {
        $categories = InformationCategory::orderBy('order')
            ->withCount(['infographics', 'potentials'])
            ->get();
        return view('admin.information-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.information-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'nullable|max:100|unique:information_categories',
            'type' => 'required|in:infographic,potential',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        InformationCategory::create($validated);

        return redirect()->route('admin.information-categories.index')
            ->with('success', 'Kategori informasi berhasil ditambahkan.');
    }

    public function edit(InformationCategory $informationCategory)
    {
        return view('admin.information-categories.edit', compact('informationCategory'));
    }

    public function update(Request $request, InformationCategory $informationCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'nullable|max:100|unique:information_categories,slug,' . $informationCategory->id,
            'type' => 'required|in:infographic,potential',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $informationCategory->update($validated);

        return redirect()->route('admin.information-categories.index')
            ->with('success', 'Kategori informasi berhasil diperbarui.');
    }

    public function destroy(InformationCategory $informationCategory)
    {
        $usageCount = $informationCategory->infographics()->count() + $informationCategory->potentials()->count();

        if ($usageCount > 0) {
            return redirect()->route('admin.information-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }

        $informationCategory->delete();
        return redirect()->route('admin.information-categories.index')
            ->with('success', 'Kategori informasi berhasil dihapus.');
    }
}
