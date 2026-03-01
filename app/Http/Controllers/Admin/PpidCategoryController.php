<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidCategory;
use Illuminate\Http\Request;

class PpidCategoryController extends Controller
{
    public function index()
    {
        $categories = PpidCategory::withCount('documents')->ordered()->get();
        return view('admin.ppid-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.ppid-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:500',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        PpidCategory::create($validated);

        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori PPID berhasil ditambahkan.');
    }

    public function edit(PpidCategory $ppidCategory)
    {
        return view('admin.ppid-categories.edit', compact('ppidCategory'));
    }

    public function update(Request $request, PpidCategory $ppidCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:500',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $ppidCategory->update($validated);

        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori PPID berhasil diperbarui.');
    }

    public function destroy(PpidCategory $ppidCategory)
    {
        if ($ppidCategory->documents()->count() > 0) {
            return redirect()->route('admin.ppid-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen.');
        }
        $ppidCategory->delete();
        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori PPID berhasil dihapus.');
    }
}
