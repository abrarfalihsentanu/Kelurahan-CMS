<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $categories = ComplaintCategory::all();
        $complaints = Complaint::with('category')->latest()->paginate(10);

        // Convert attachment paths to URLs
        foreach ($complaints as $complaint) {
            if ($complaint->attachments && is_array($complaint->attachments)) {
                $complaint->attachment_urls = array_map(fn($path) => Storage::url($path), $complaint->attachments);
            }
        }

        return view('pengaduan', compact('categories', 'complaints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'complaint_category_id' => 'required|exists:complaint_categories,id',
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'rt_rw' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location' => 'nullable|string|max:255',
            'incident_date' => 'nullable|date',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints', 'public');
                $attachmentPaths[] = $path;
                // Auto-copy to public_html/storage for shared hosting
                StorageHelper::copyToPublic($path, 'complaints');
            }
        }

        $validated['attachments'] = !empty($attachmentPaths) ? $attachmentPaths : null;

        $complaint = Complaint::create($validated);

        return redirect()->route('pengaduan.tracking', ['ticket' => $complaint->ticket_number])
            ->with('success', 'Pengaduan berhasil dikirim! Nomor tiket Anda: ' . $complaint->ticket_number);
    }

    public function tracking(Request $request)
    {
        $complaint = null;
        $ticket = $request->ticket;

        if ($ticket) {
            $complaint = Complaint::with('category')->where('ticket_number', $ticket)->first();

            // Convert attachment paths to URLs
            if ($complaint && $complaint->attachments && is_array($complaint->attachments)) {
                $complaint->attachment_urls = array_map(fn($path) => Storage::url($path), $complaint->attachments);
            }
        }

        $categories = ComplaintCategory::all();

        return view('pengaduan-tracking', compact('complaint', 'ticket', 'categories'));
    }
}
