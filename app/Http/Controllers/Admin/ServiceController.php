<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->orderBy('order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::active()->orderBy('order')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:services',
            'category_id' => 'required|exists:service_categories,id',
            'description' => 'nullable',
            'requirements' => 'nullable',
            'procedure' => 'nullable',
            'duration' => 'nullable|max:100',
            'cost' => 'nullable|max:100',
            'icon' => 'nullable|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['service_category_id'] = $validated['category_id'];
        unset($validated['category_id']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'services');
        }

        $validated['is_active'] = $request->boolean('is_active');
        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::active()->orderBy('order')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:services,slug,' . $service->id,
            'category_id' => 'required|exists:service_categories,id',
            'description' => 'nullable',
            'requirements' => 'nullable',
            'procedure' => 'nullable',
            'duration' => 'nullable|max:100',
            'cost' => 'nullable|max:100',
            'icon' => 'nullable|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['service_category_id'] = $validated['category_id'];
        unset($validated['category_id']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                StorageHelper::deleteFromBoth($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'services');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            StorageHelper::deleteFromBoth($service->image);
        }
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
