<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderBy('order')->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'year' => 'nullable|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon' => 'nullable|max:100',
            'level' => 'nullable|max:100',
            'organizer' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('achievements', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'achievements');
        }

        $validated['is_published'] = $request->boolean('is_published');
        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'year' => 'nullable|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon' => 'nullable|max:100',
            'level' => 'nullable|max:100',
            'organizer' => 'nullable|max:255',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($achievement->image) {
                StorageHelper::deleteFromBoth($achievement->image);
            }
            $validated['image'] = $request->file('image')->store('achievements', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'achievements');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image) {
            StorageHelper::deleteFromBoth($achievement->image);
        }
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
