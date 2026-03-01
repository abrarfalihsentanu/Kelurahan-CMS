<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function respond(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:5000',
            'status' => 'required|in:pending,process,resolved',
        ], [
            'response.required' => 'Tanggapan wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $contact->update([
            'response' => $validated['response'],
            'status' => $validated['status'],
            'responded_at' => now(),
            'responded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
