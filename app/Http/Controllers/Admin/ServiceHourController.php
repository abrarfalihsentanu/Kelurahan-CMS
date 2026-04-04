<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceHour;
use Illuminate\Http\Request;

class ServiceHourController extends Controller
{
    public function index()
    {
        $serviceHours = ServiceHour::orderBy('day_order')->get();
        return view('admin.service-hours.index', compact('serviceHours'));
    }

    public function create()
    {
        return view('admin.service-hours.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|max:20',
            'open_time' => 'required',
            'close_time' => 'required',
            'is_closed' => 'boolean',
            'note' => 'nullable|max:255',
            'order' => 'nullable|integer',
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');
        ServiceHour::create($validated);

        return redirect()->route('admin.service-hours.index')
            ->with('success', 'Jam layanan berhasil ditambahkan.');
    }

    public function edit(ServiceHour $serviceHour)
    {
        return view('admin.service-hours.edit', compact('serviceHour'));
    }

    public function update(Request $request, ServiceHour $serviceHour)
    {
        $validated = $request->validate([
            'day' => 'required|max:20',
            'open_time' => 'required',
            'close_time' => 'required',
            'is_closed' => 'boolean',
            'note' => 'nullable|max:255',
            'order' => 'nullable|integer',
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');
        $serviceHour->update($validated);

        return redirect()->route('admin.service-hours.index')
            ->with('success', 'Jam layanan berhasil diperbarui.');
    }

    public function destroy(ServiceHour $serviceHour)
    {
        $serviceHour->delete();
        return redirect()->route('admin.service-hours.index')
            ->with('success', 'Jam layanan berhasil dihapus.');
    }
}
