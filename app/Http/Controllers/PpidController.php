<?php

namespace App\Http\Controllers;

use App\Models\PpidCategory;
use App\Models\PpidDocument;
use App\Models\PpidRequest;
use Illuminate\Http\Request;

class PpidController extends Controller
{
    public function index()
    {
        $categories = PpidCategory::orderBy('order')->with('documents')->get();
        $documents = PpidDocument::published()->with('category')->get();

        return view('ppid', compact('categories', 'documents'));
    }

    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'information_type' => 'required|string|max:255',
            'information_detail' => 'required|string|max:2000',
            'purpose' => 'required|string|max:255',
            'method' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'No. telepon wajib diisi.',
            'information_type.required' => 'Tujuan permohonan wajib dipilih.',
            'information_detail.required' => 'Informasi yang diminta wajib diisi.',
            'purpose.required' => 'Tujuan penggunaan wajib dipilih.',
        ]);

        $validated['type'] = 'permohonan';
        $ppidRequest = PpidRequest::create($validated);

        return redirect()->route('ppid.tracking', ['ticket' => $ppidRequest->ticket_number])
            ->with('success', 'Permohonan informasi berhasil dikirim!');
    }

    public function storeKeberatan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'reference_number' => 'nullable|string|max:100',
            'information_type' => 'required|string|max:255',
            'information_detail' => 'required|string|max:5000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'No. telepon wajib diisi.',
            'information_type.required' => 'Alasan keberatan wajib dipilih.',
            'information_detail.required' => 'Uraian keberatan wajib diisi.',
        ]);

        $validated['type'] = 'keberatan';
        $validated['purpose'] = 'Pengajuan Keberatan';
        $ppidRequest = PpidRequest::create($validated);

        return redirect()->route('ppid.tracking', ['ticket' => $ppidRequest->ticket_number])
            ->with('success', 'Pengajuan keberatan berhasil dikirim!');
    }

    public function tracking(Request $request)
    {
        $ticket = $request->query('ticket');
        $ppidRequest = null;

        if ($ticket) {
            $ppidRequest = PpidRequest::where('ticket_number', $ticket)->first();
        }

        return view('ppid-tracking', compact('ppidRequest', 'ticket'));
    }

    public function download(PpidDocument $document)
    {
        $document->incrementDownloads();
        return response()->download(storage_path('app/public/' . $document->file));
    }
}
