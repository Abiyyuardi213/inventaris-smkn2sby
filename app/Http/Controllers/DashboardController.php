<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Jurusan;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Inventaris::sum('jumlah_total');
        $totalJenisBarang = Inventaris::count();
        $kondisiBaik = Inventaris::where('kondisi', 'baik')->sum('jumlah_total');
        $kondisiRusak = Inventaris::where('kondisi', 'rusak')->sum('jumlah_total');
        $kondisiLayak = Inventaris::where('kondisi', 'layak')->sum('jumlah_total');

        $persenBaik = $totalBarang > 0 ? ($kondisiBaik / $totalBarang) * 100 : 0;
        $persenRusak = $totalBarang > 0 ? ($kondisiRusak / $totalBarang) * 100 : 0;
        $persenLayak = $totalBarang > 0 ? ($kondisiLayak / $totalBarang) * 100 : 0;

        $sebaranJurusan = Jurusan::withSum('inventaris as total_unit', 'jumlah_total')
            ->orderBy('nama_jurusan')
            ->get();

        $chartLabels = $sebaranJurusan->map(function ($j) {
            $parts = explode('-', $j->kode_jurusan);
            return $parts[0] ?? $j->nama_jurusan;
        });

        $chartData = $sebaranJurusan->pluck('total_unit')->map(fn($val) => (int) ($val ?? 0));

        $overdueList = Peminjaman::with('inventaris')
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->whereNotNull('tanggal_estimasi_kembali')
            ->whereDate('tanggal_estimasi_kembali', '<', now()->toDateString())
            ->orderBy('tanggal_estimasi_kembali')
            ->limit(5)
            ->get()
            ->map(function (Peminjaman $peminjaman) {
                $peminjaman->hari_terlambat = $peminjaman->tanggal_estimasi_kembali
                    ? (int) $peminjaman->tanggal_estimasi_kembali->copy()->startOfDay()->diffInDays(now()->startOfDay())
                    : 0;

                return $peminjaman;
            });

        return view('dashboard', compact(
            'totalBarang',
            'totalJenisBarang',
            'kondisiBaik',
            'kondisiRusak',
            'kondisiLayak',
            'persenBaik',
            'persenRusak',
            'persenLayak',
            'chartLabels',
            'chartData',
            'overdueList'
        ));
    }
}
