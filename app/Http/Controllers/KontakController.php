<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('kontak');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'type.required' => 'Jenis pesan wajib dipilih.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Isi pesan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $contact = Contact::create($validated);

        return redirect()->route('kontak.tracking', ['ticket' => $contact->ticket_number])
            ->with('success', 'Pesan Anda berhasil dikirim! Simpan nomor tiket berikut untuk melacak tanggapan.');
    }

    public function tracking(Request $request)
    {
        $contact = null;
        $ticket = $request->ticket;

        if ($ticket) {
            $contact = Contact::where('ticket_number', $ticket)->first();
        }

        return view('kontak-tracking', compact('contact', 'ticket'));
    }
}
