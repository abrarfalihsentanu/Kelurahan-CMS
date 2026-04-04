<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button_text' => 'nullable|max:100',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'sliders');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button_text' => 'nullable|max:100',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                StorageHelper::deleteFromBoth($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['image'], 'sliders');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            StorageHelper::deleteFromBoth($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
