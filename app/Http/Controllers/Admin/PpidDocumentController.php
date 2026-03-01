<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use App\Models\PpidCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidDocumentController extends Controller
{
    public function index()
    {
        $documents = PpidDocument::with('category')->ordered()->get();
        return view('admin.ppid-documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = PpidCategory::active()->ordered()->get();
        return view('admin.ppid-documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:ppid_categories,id',
            'description' => 'nullable',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'year' => 'nullable|integer|min:2000|max:2100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('ppid-documents', 'public');
            $validated['file_size'] = $request->file('file')->getSize();
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $validated['is_active'] = $request->boolean('is_active');
        PpidDocument::create($validated);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil ditambahkan.');
    }

    public function edit(PpidDocument $ppidDocument)
    {
        $categories = PpidCategory::active()->ordered()->get();
        return view('admin.ppid-documents.edit', compact('ppidDocument', 'categories'));
    }

    public function update(Request $request, PpidDocument $ppidDocument)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:ppid_categories,id',
            'description' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'year' => 'nullable|integer|min:2000|max:2100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($ppidDocument->file_path) {
                Storage::disk('public')->delete($ppidDocument->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('ppid-documents', 'public');
            $validated['file_size'] = $request->file('file')->getSize();
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $validated['is_active'] = $request->boolean('is_active');
        $ppidDocument->update($validated);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil diperbarui.');
    }

    public function destroy(PpidDocument $ppidDocument)
    {
        if ($ppidDocument->file_path) {
            Storage::disk('public')->delete($ppidDocument->file_path);
        }
        $ppidDocument->delete();

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil dihapus.');
    }
}
