<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $categories = ComplaintCategory::all();
        $complaints = Complaint::with('category')->latest()->paginate(10);
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
                $attachmentPaths[] = $file->store('complaints', 'public');
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
        }

        $categories = ComplaintCategory::all();

        return view('pengaduan-tracking', compact('complaint', 'ticket', 'categories'));
    }
}
