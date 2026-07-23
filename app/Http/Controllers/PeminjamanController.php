<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        $peminjamans = Peminjaman::with(['inventaris', 'user'])
            ->latest()
            ->get();

        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create(): View
    {
        $inventarisList = Inventaris::with(['ruangan', 'jurusan'])
            ->where('jumlah_total', '>', 0)
            ->get();

        $defaultNomor = 'PIN-' . date('Ymd') . '-' . str_pad(Peminjaman::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        return view('peminjamans.create', compact('inventarisList', 'defaultNomor'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'inventaris_id' => 'required|exists:inventaris,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_estimasi_kembali' => 'nullable|date',
            'status' => 'nullable|in:Dipinjam,Dikembalikan,Terlambat',
        ]);

        $original = Inventaris::findOrFail($validated['inventaris_id']);

        if ($validated['jumlah_pinjam'] > $original->jumlah_total) {
            return back()
                ->withErrors(['jumlah_pinjam' => 'Jumlah yang dipinjam melebihi stok barang saat ini (' . $original->jumlah_total . ' unit).'])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $original) {
                // Kurangi stok pada inventaris
                $original->decrement('jumlah_total', $validated['jumlah_pinjam']);

                // Simpan log peminjaman
                Peminjaman::create([
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'instansi' => $validated['instansi'] ?? null,
                    'kontak' => $validated['kontak'] ?? null,
                    'inventaris_id' => $original->id,
                    'jumlah_pinjam' => $validated['jumlah_pinjam'],
                    'tanggal_pinjam' => $validated['tanggal_pinjam'],
                    'tanggal_estimasi_kembali' => $validated['tanggal_estimasi_kembali'] ?? null,
                    'status' => $validated['status'] ?? 'Dipinjam',
                    'user_id' => auth()->id(),
                ]);
            });

            return redirect()->route('peminjamans.index')->with('success', 'Peminjaman barang berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses peminjaman: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['inventaris.kategori', 'user']);
        return view('peminjamans.show', compact('peminjaman'));
    }

    public function kembalikan(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status === 'Dikembalikan') {
            return back()->with('error', 'Barang ini sudah dikembalikan.');
        }

        try {
            DB::transaction(function () use ($peminjaman) {
                if ($peminjaman->inventaris) {
                    $peminjaman->inventaris->increment('jumlah_total', $peminjaman->jumlah_pinjam);
                }
                $peminjaman->update([
                    'status' => 'Dikembalikan'
                ]);
            });

            return redirect()->route('peminjamans.show', $peminjaman->id)->with('success', 'Barang berhasil dikembalikan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengembalikan barang: ' . $e->getMessage());
        }
    }
}
