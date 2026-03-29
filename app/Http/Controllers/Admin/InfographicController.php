<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infographic;
use App\Models\InformationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfographicController extends Controller
{
    public function index()
    {
        $infographics = Infographic::with('informationCategory')->ordered()->get();
        return view('admin.infographics.index', compact('infographics'));
    }

    public function create()
    {
        $categories = InformationCategory::forInfographic()->active()->ordered()->get();
        return view('admin.infographics.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'information_category_id' => 'nullable|exists:information_categories,id',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('infographics', 'public');
        }

        // Sync text category field for backward compatibility
        if (!empty($validated['information_category_id'])) {
            $validated['category'] = InformationCategory::find($validated['information_category_id'])?->name;
        }

        $validated['is_published'] = $request->boolean('is_published');
        Infographic::create($validated);

        return redirect()->route('admin.infographics.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit(Infographic $infographic)
    {
        $categories = InformationCategory::forInfographic()->active()->ordered()->get();
        return view('admin.infographics.edit', compact('infographic', 'categories'));
    }

    public function update(Request $request, Infographic $infographic)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'information_category_id' => 'nullable|exists:information_categories,id',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($infographic->image) {
                Storage::disk('public')->delete($infographic->image);
            }
            $validated['image'] = $request->file('image')->store('infographics', 'public');
        }

        // Sync text category field for backward compatibility
        if (!empty($validated['information_category_id'])) {
            $validated['category'] = InformationCategory::find($validated['information_category_id'])?->name;
        } else {
            $validated['category'] = null;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $infographic->update($validated);

        return redirect()->route('admin.infographics.index')
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy(Infographic $infographic)
    {
        if ($infographic->image) {
            Storage::disk('public')->delete($infographic->image);
        }
        $infographic->delete();

        return redirect()->route('admin.infographics.index')
            ->with('success', 'Infografis berhasil dihapus.');
    }
}
