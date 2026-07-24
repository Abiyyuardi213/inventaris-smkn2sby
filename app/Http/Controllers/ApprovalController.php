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
        $pendingPengadaans = Pengadaan::with(['jenisModal', 'jurusan', 'pengusul'])
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

        // Update status ke disetujui_admin dan catat audit trail untuk Super Admin
        $pengadaan->update([
            'status_usulan' => 'disetujui_admin',
            'approved_by_admin' => auth()->id(),
            'approved_by_admin_at' => now(),
        ]);

        return redirect()->route('approvals.index')
            ->with('success', 'Usulan disetujui dan diteruskan ke Kepala Sekolah untuk persetujuan final.');
    }

    public function tolak(Pengadaan $pengadaan): RedirectResponse
    {
        // Proteksi double-process: cek status sebelum mengubah apapun
        // Mencegah tolak dua kali atau tolak usulan yang sudah disetujui
        if (! $pengadaan->isPending()) {
            return redirect()->back()
                ->with('error', 'Usulan ini sudah diproses sebelumnya.');
        }

        // Update status ke ditolak dan catat audit trail untuk Super Admin
        $pengadaan->update([
            'status_usulan' => 'ditolak',
            'approved_by_admin' => auth()->id(),
            'approved_by_admin_at' => now(),
        ]);

        return redirect()->route('approvals.index')
            ->with('success', 'Usulan berhasil ditolak.');
    }
}
