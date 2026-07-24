<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApprovalKepsekController extends Controller
{
    /**
     * Tampilkan usulan pengadaan yang sedang menunggu persetujuan Kepala Sekolah (tahap 2).
     */
    public function index(): View
    {
        // Ambil usulan yang berstatus 'disetujui_admin' (menunggu review Kepsek)
        $menungguKepsekPengadaans = Pengadaan::with(['jenisModal', 'jurusan', 'pengusul', 'approvedByAdmin'])
            ->where('status_usulan', 'disetujui_admin')
            ->latest()
            ->get();

        return view('approvals-kepsek.index', compact('menungguKepsekPengadaans'));
    }

    /**
     * Setujui usulan pengadaan secara final oleh Kepala Sekolah.
     */
    public function approve(Request $request, Pengadaan $pengadaan): RedirectResponse
    {
        // Guard: pastikan usulan sedang menunggu persetujuan Kepsek (disetujui_admin)
        if (! $pengadaan->isMenungguKepsek()) {
            return redirect()->back()
                ->with('error', 'Usulan ini bukan dalam status menunggu persetujuan Anda.');
        }

        // Validasi catatan persetujuan jika dikirimkan oleh user
        $validated = $request->validate([
            'catatan_kepsek' => 'nullable|string|max:1000',
        ]);

        // Simpan keputusan persetujuan final
        $pengadaan->update([
            'status_usulan' => 'disetujui_kepsek',
            'approved_by_kepsek' => auth()->id(),
            'approved_by_kepsek_at' => now(),
            'catatan_kepsek' => $validated['catatan_kepsek'] ?? null,
        ]);

        return redirect()->route('approvals-kepsek.index')
            ->with('success', 'Usulan pengadaan disetujui final.');
    }

    /**
     * Tolak usulan pengadaan oleh Kepala Sekolah di tahap akhir.
     */
    public function tolak(Request $request, Pengadaan $pengadaan): RedirectResponse
    {
        // Guard: pastikan usulan sedang menunggu persetujuan Kepsek (disetujui_admin)
        if (! $pengadaan->isMenungguKepsek()) {
            return redirect()->back()
                ->with('error', 'Usulan ini bukan dalam status menunggu persetujuan Anda.');
        }

        // Validasi catatan penolakan jika dikirimkan oleh user
        $validated = $request->validate([
            'catatan_kepsek' => 'nullable|string|max:1000',
        ]);

        // Simpan keputusan penolakan final beserta catatannya
        $pengadaan->update([
            'status_usulan' => 'ditolak_kepsek',
            'approved_by_kepsek' => auth()->id(),
            'approved_by_kepsek_at' => now(),
            'catatan_kepsek' => $validated['catatan_kepsek'] ?? null,
        ]);

        return redirect()->route('approvals-kepsek.index')
            ->with('success', 'Usulan pengadaan ditolak.');
    }

    /**
     * Tampilkan riwayat keputusan yang pernah diambil oleh Kepala Sekolah (Audit Trail).
     */
    public function riwayat(Request $request): View
    {
        // Query riwayat keputusan Kepala Sekolah (disetujui_kepsek atau ditolak_kepsek)
        $query = Pengadaan::with(['jenisModal', 'jurusan', 'pengusul', 'approvedByAdmin', 'approvedByKepsek'])
            ->whereIn('status_usulan', ['disetujui_kepsek', 'ditolak_kepsek']);

        // Filter opsional berdasarkan status dari query string (?status=...)
        if ($request->filled('status') && in_array($request->status, ['disetujui_kepsek', 'ditolak_kepsek'], true)) {
            $query->where('status_usulan', $request->status);
        }

        // Urutkan berdasarkan waktu keputusan kepala sekolah terbaru
        $riwayatPengadaans = $query->orderBy('approved_by_kepsek_at', 'desc')->get();

        return view('approvals-kepsek.riwayat', compact('riwayatPengadaans'));
    }
}
