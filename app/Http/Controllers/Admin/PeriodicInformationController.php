<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodicInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeriodicInformationController extends Controller
{
    public function index()
    {
        $documents = PeriodicInformation::ordered()->get();
        return view('admin.periodic-informations.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.periodic-informations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
            'category' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2000|max:2100',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('periodic-informations', 'public');
            $validated['file_size'] = $request->file('file')->getSize();
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $validated['is_published'] = $request->boolean('is_published');
        PeriodicInformation::create($validated);

        return redirect()->route('admin.periodic-informations.index')
            ->with('success', 'Informasi Berkala berhasil ditambahkan.');
    }

    public function edit(PeriodicInformation $periodicInformation)
    {
        return view('admin.periodic-informations.edit', compact('periodicInformation'));
    }

    public function update(Request $request, PeriodicInformation $periodicInformation)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
            'category' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2000|max:2100',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($periodicInformation->file) {
                Storage::disk('public')->delete($periodicInformation->file);
            }
            $validated['file'] = $request->file('file')->store('periodic-informations', 'public');
            $validated['file_size'] = $request->file('file')->getSize();
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $validated['is_published'] = $request->boolean('is_published');
        $periodicInformation->update($validated);

        return redirect()->route('admin.periodic-informations.index')
            ->with('success', 'Informasi Berkala berhasil diperbarui.');
    }

    public function destroy(PeriodicInformation $periodicInformation)
    {
        if ($periodicInformation->file) {
            Storage::disk('public')->delete($periodicInformation->file);
        }
        $periodicInformation->delete();

        return redirect()->route('admin.periodic-informations.index')
            ->with('success', 'Informasi Berkala berhasil dihapus.');
    }
}
