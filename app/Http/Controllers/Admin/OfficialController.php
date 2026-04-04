<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Division;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::with('division')->orderBy('order')->get();
        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        $divisions = Division::active()->orderBy('order')->get();
        return view('admin.officials.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'position' => 'required|max:100',
            'nip' => 'nullable|max:50',
            'division_id' => 'nullable|exists:divisions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'level' => 'required|in:lurah,sekretaris,kasi,staff',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['photo'], 'officials');
        }

        $validated['is_active'] = $request->boolean('is_active');
        Official::create($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Pejabat berhasil ditambahkan.');
    }

    public function edit(Official $official)
    {
        $divisions = Division::active()->orderBy('order')->get();
        return view('admin.officials.edit', compact('official', 'divisions'));
    }

    public function update(Request $request, Official $official)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'position' => 'required|max:100',
            'nip' => 'nullable|max:50',
            'division_id' => 'nullable|exists:divisions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'level' => 'required|in:lurah,sekretaris,kasi,staff',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($official->photo) {
                StorageHelper::deleteFromBoth($official->photo);
            }
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
            // Auto-copy to public_html/storage for shared hosting
            StorageHelper::copyToPublic($validated['photo'], 'officials');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $official->update($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Pejabat berhasil diperbarui.');
    }

    public function destroy(Official $official)
    {
        if ($official->photo) {
            StorageHelper::deleteFromBoth($official->photo);
        }
        $official->delete();

        return redirect()->route('admin.officials.index')
            ->with('success', 'Pejabat berhasil dihapus.');
    }
}
