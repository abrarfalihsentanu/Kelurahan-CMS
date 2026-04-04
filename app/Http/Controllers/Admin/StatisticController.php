<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::orderBy('order')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|max:100',
            'value' => 'required|max:50',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Statistic::create($validated);

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function edit(Statistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'label' => 'required|max:100',
            'value' => 'required|max:50',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil dihapus.');
    }
}
