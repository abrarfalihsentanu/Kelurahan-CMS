<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('order')->get();
        return view('admin.service-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'nullable|max:100|unique:service_categories',
            'icon' => 'nullable|max:100',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        ServiceCategory::create($validated);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service-categories.edit', [
            'serviceCategory' => $serviceCategory,
            'category' => $serviceCategory,
        ]);
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'nullable|max:100|unique:service_categories,slug,' . $serviceCategory->id,
            'icon' => 'nullable|max:100',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $serviceCategory->update($validated);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori layanan berhasil diperbarui.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->services()->count() > 0) {
            return redirect()->route('admin.service-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki layanan.');
        }
        $serviceCategory->delete();
        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori layanan berhasil dihapus.');
    }
}
