<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationCategory;
use App\Models\Potential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotentialController extends Controller
{
    public function index()
    {
        $potentials = Potential::with('informationCategory')->ordered()->get();
        return view('admin.potentials.index', compact('potentials'));
    }

    public function create()
    {
        $categories = InformationCategory::forPotential()->active()->ordered()->get();
        return view('admin.potentials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'information_category_id' => 'nullable|exists:information_categories,id',
            'location' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        // Sync text category field for backward compatibility
        if (!empty($validated['information_category_id'])) {
            $validated['category'] = InformationCategory::find($validated['information_category_id'])?->name;
        }

        $validated['is_published'] = $request->boolean('is_published');
        Potential::create($validated);

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi berhasil ditambahkan.');
    }

    public function edit(Potential $potential)
    {
        $categories = InformationCategory::forPotential()->active()->ordered()->get();
        return view('admin.potentials.edit', compact('potential', 'categories'));
    }

    public function update(Request $request, Potential $potential)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'information_category_id' => 'nullable|exists:information_categories,id',
            'location' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($potential->image) {
                Storage::disk('public')->delete($potential->image);
            }
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        // Sync text category field for backward compatibility
        if (!empty($validated['information_category_id'])) {
            $validated['category'] = InformationCategory::find($validated['information_category_id'])?->name;
        } else {
            $validated['category'] = null;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $potential->update($validated);

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi berhasil diperbarui.');
    }

    public function destroy(Potential $potential)
    {
        if ($potential->image) {
            Storage::disk('public')->delete($potential->image);
        }
        $potential->delete();

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi berhasil dihapus.');
    }
}
