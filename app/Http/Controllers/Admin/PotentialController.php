<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotentialController extends Controller
{
    public function index()
    {
        $potentials = Potential::ordered()->get();
        return view('admin.potentials.index', compact('potentials'));
    }

    public function create()
    {
        return view('admin.potentials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|max:100',
            'location' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        Potential::create($validated);

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi berhasil ditambahkan.');
    }

    public function edit(Potential $potential)
    {
        return view('admin.potentials.edit', compact('potential'));
    }

    public function update(Request $request, Potential $potential)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category' => 'nullable|max:100',
            'location' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($potential->image) {
                Storage::disk('public')->delete($potential->image);
            }
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
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
