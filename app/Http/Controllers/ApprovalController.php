<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function index(): View
    {
        // Hanya tampilkan usulan yang masih pending di halaman approval Super Admin
        // Eager load relasi untuk menghindari query N+1 di view
        $pendingPengadaans = Pengadaan::with(['kategori', 'jurusan', 'pengusul'])
            ->where('status_usulan', 'pending')
            ->latest()
            ->get();

        return view('approvals.index', compact('pendingPengadaans'));
    }

    public function approve(Pengadaan $pengadaan): RedirectResponse
    {
        // Proteksi double-process: cek status sebelum mengubah apapun
        // Mencegah approve dua kali atau approve usulan yang sudah ditolak
        if (! $pengadaan->isPending()) {
            return redirect()->back()
                ->with('error', 'Usulan ini sudah diproses sebelumnya.');
        }

        // Hanya update kolom status_usulan — tidak menyentuh kolom lain
        // Model event updating akan meloloskan perubahan ini karena
        // satu-satunya kolom yang dirty adalah 'status_usulan'
        $pengadaan->update(['status_usulan' => 'disetujui']);

        return redirect()->route('approvals.index')
            ->with('success', 'Usulan berhasil disetujui.');
    }

    public function tolak(Pengadaan $pengadaan): RedirectResponse
    {
        // Proteksi double-process: cek status sebelum mengubah apapun
        // Mencegah tolak dua kali atau tolak usulan yang sudah disetujui
        if (! $pengadaan->isPending()) {
            return redirect()->back()
                ->with('error', 'Usulan ini sudah diproses sebelumnya.');
        }

        // Hanya update kolom status_usulan — tidak menyentuh kolom lain
        $pengadaan->update(['status_usulan' => 'ditolak']);

        return redirect()->route('approvals.index')
            ->with('success', 'Usulan berhasil ditolak.');
    }
}
