<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Complaint;
use App\Models\Contact;
use App\Models\PpidRequest;
use App\Models\Official;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news' => News::count(),
            'complaints' => Complaint::count(),
            'complaints_pending' => Complaint::where('status', 'pending')->count(),
            'contacts' => Contact::count(),
            'ppid_requests' => PpidRequest::count(),
            'officials' => Official::count(),
            'services' => Service::count(),
        ];

        $latestComplaints = Complaint::with('category')
            ->latest()
            ->take(5)
            ->get();

        $latestContacts = Contact::latest()
            ->take(5)
            ->get();

        $latestNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestComplaints', 'latestContacts', 'latestNews'));
    }
}
