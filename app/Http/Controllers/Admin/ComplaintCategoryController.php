<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;

class ComplaintCategoryController extends Controller
{
    public function index()
    {
        $categories = ComplaintCategory::withCount('complaints')->ordered()->get();
        return view('admin.complaint-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.complaint-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        ComplaintCategory::create($validated);

        return redirect()->route('admin.complaint-categories.index')
            ->with('success', 'Kategori pengaduan berhasil ditambahkan.');
    }

    public function edit(ComplaintCategory $complaintCategory)
    {
        return view('admin.complaint-categories.edit', compact('complaintCategory'));
    }

    public function update(Request $request, ComplaintCategory $complaintCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $complaintCategory->update($validated);

        return redirect()->route('admin.complaint-categories.index')
            ->with('success', 'Kategori pengaduan berhasil diperbarui.');
    }

    public function destroy(ComplaintCategory $complaintCategory)
    {
        if ($complaintCategory->complaints()->count() > 0) {
            return redirect()->route('admin.complaint-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki pengaduan.');
        }
        $complaintCategory->delete();
        return redirect()->route('admin.complaint-categories.index')
            ->with('success', 'Kategori pengaduan berhasil dihapus.');
    }
}
