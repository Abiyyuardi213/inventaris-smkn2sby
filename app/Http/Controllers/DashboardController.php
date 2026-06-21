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

        $barangPopuler = Inventaris::query()
            ->select('nama_barang', 'jumlah_total')
            ->get()
            ->groupBy(fn (Inventaris $inventaris) => $this->kelompokBarangPopuler($inventaris->nama_barang))
            ->map(function ($items, string $kelompok) {
                return [
                    'nama' => $kelompok,
                    'jumlah' => (int) $items->sum('jumlah_total'),
                    'jenis' => $items->pluck('nama_barang')->unique()->count(),
                ];
            })
            ->sortByDesc('jumlah')
            ->take(8)
            ->values();

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
            'overdueList',
            'barangPopuler'
        ));
    }

    private function kelompokBarangPopuler(string $namaBarang): string
    {
        $normalized = mb_strtolower($namaBarang);

        $keywords = [
            'Kursi' => ['kursi', 'chair'],
            'Meja' => ['meja', 'desk', 'table'],
            'Komputer' => ['komputer', 'pc', 'cpu'],
            'Laptop' => ['laptop', 'notebook'],
            'Printer' => ['printer'],
            'Monitor' => ['monitor', 'lcd', 'led display'],
            'Proyektor' => ['proyektor', 'projector'],
            'Lemari' => ['lemari', 'cabinet'],
            'Rak' => ['rak', 'shelf'],
            'Router' => ['router', 'mikrotik'],
            'Switch' => ['switch'],
            'AC' => ['ac', 'air conditioner', 'pendingin ruangan'],
            'Papan' => ['papan', 'whiteboard', 'board'],
            'Scanner' => ['scanner'],
            'Kamera' => ['kamera', 'camera', 'cctv'],
            'Speaker' => ['speaker', 'sound'],
        ];

        foreach ($keywords as $label => $words) {
            foreach ($words as $word) {
                if (preg_match('/(^|[^a-z0-9])' . preg_quote($word, '/') . '([^a-z0-9]|$)/', $normalized)) {
                    return $label;
                }
            }
        }

        $words = preg_split('/\s+/', trim(preg_replace('/[^a-z0-9\s]/i', ' ', $namaBarang)));
        $firstWord = $words[0] ?? $namaBarang;

        return ucwords(mb_strtolower($firstWord));
    }
}
