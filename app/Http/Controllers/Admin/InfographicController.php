<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infographic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfographicController extends Controller
{
    public function index()
    {
        $infographics = Infographic::ordered()->get();
        return view('admin.infographics.index', compact('infographics'));
    }

    public function create()
    {
        return view('admin.infographics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'category' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('infographics', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        Infographic::create($validated);

        return redirect()->route('admin.infographics.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit(Infographic $infographic)
    {
        return view('admin.infographics.edit', compact('infographic'));
    }

    public function update(Request $request, Infographic $infographic)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'category' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($infographic->image) {
                Storage::disk('public')->delete($infographic->image);
            }
            $validated['image'] = $request->file('image')->store('infographics', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
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
