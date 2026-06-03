<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Jurusan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Inventaris::count();
        $kondisiBaik = Inventaris::where('kondisi', 'baik')->count();
        $kondisiRusak = Inventaris::where('kondisi', 'rusak')->count();
        $kondisiLayak = Inventaris::where('kondisi', 'layak')->count();

        $persenBaik = $totalBarang > 0 ? ($kondisiBaik / $totalBarang) * 100 : 0;
        $persenRusak = $totalBarang > 0 ? ($kondisiRusak / $totalBarang) * 100 : 0;
        $persenLayak = $totalBarang > 0 ? ($kondisiLayak / $totalBarang) * 100 : 0;

        $sebaranJurusan = Jurusan::withCount('inventaris')->get();

        $chartLabels = $sebaranJurusan->map(function ($j) {
            $parts = explode('-', $j->kode_jurusan);
            return $parts[0] ?? $j->nama_jurusan;
        });

        $chartData = $sebaranJurusan->pluck('inventaris_count')->map(fn($val) => $val ?? 0);

        return view('dashboard', compact(
            'totalBarang',
            'kondisiBaik',
            'kondisiRusak',
            'kondisiLayak',
            'persenBaik',
            'persenRusak',
            'persenLayak',
            'chartLabels',
            'chartData'
        ));
    }
}

