<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::ordered()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'type' => 'required|in:image,video',
            'video_url' => 'required_if:type,video|nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ], [
            'image.required_if' => 'Gambar wajib diunggah untuk tipe Gambar.',
            'video_url.required_if' => 'URL Video wajib diisi untuk tipe Video.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        } else {
            $validated['image'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');
        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'type' => 'required|in:image,video',
            'video_url' => 'required_if:type,video|nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ], [
            'video_url.required_if' => 'URL Video wajib diisi untuk tipe Video.',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
