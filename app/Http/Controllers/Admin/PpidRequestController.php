<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PpidRequestController extends Controller
{
    public function index()
    {
        $requests = PpidRequest::latest()->get();
        return view('admin.ppid-requests.index', compact('requests'));
    }

    public function show(PpidRequest $ppidRequest)
    {
        if (!$ppidRequest->is_read) {
            $ppidRequest->update(['is_read' => true]);
        }
        return view('admin.ppid-requests.show', compact('ppidRequest'));
    }

    public function update(Request $request, PpidRequest $ppidRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,approved,rejected',
            'response' => 'required|string|max:5000',
        ], [
            'response.required' => 'Tanggapan wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $ppidRequest->update([
            'status' => $validated['status'],
            'response' => $validated['response'],
            'responded_at' => now(),
            'responded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.ppid-requests.show', $ppidRequest)
            ->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function destroy(PpidRequest $ppidRequest)
    {
        $ppidRequest->delete();
        return redirect()->route('admin.ppid-requests.index')
            ->with('success', 'Permohonan berhasil dihapus.');
    }
}
