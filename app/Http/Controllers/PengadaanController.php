<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\JenisModal;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengadaanController extends Controller
{
    public function index(): View
    {
        // Eager load semua relasi untuk menghindari query N+1 di view
        // Filter opsional by status_usulan via GET parameter ?status=pending|disetujui|ditolak
        $pengadaans = Pengadaan::with(['jenisModal', 'kategori', 'jurusan', 'pengusul'])
            ->when(request('status'), fn($q) => $q->where('status_usulan', request('status')))
            ->latest()
            ->get();

        return view('pengadaans.index', compact('pengadaans'));
    }


    public function create(): View
    {
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $kategoris   = Kategori::orderBy('nama_kategori')->get();
        $jurusans    = Jurusan::orderBy('nama_jurusan')->get();

        return view('pengadaans.create', compact('jenisModals', 'kategoris', 'jurusans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang_usulan' => 'required|string|max:255',
            'jenis_modal_id'     => 'required|exists:jenis_modals,id',
            'kategori_id'        => 'nullable|exists:kategoris,id',
            'jurusan_id'         => 'required|exists:jurusans,id',
            'jumlah'             => 'required|integer|min:1',
            'perkiraan_harga'    => 'required|integer|min:0',
            'alasan_pengadaan'   => 'required|string',
        ]);

        // status_usulan selalu 'pending' saat pertama dibuat — tidak dari input user
        // user_id diambil dari sesi auth yang sedang login (Admin Sarpras)
        $validated['status_usulan'] = 'pending';
        $validated['user_id']       = auth()->id();

        Pengadaan::create($validated);

        return redirect()->route('pengadaans.index')
            ->with('success', 'Usulan pengadaan berhasil dibuat.');
    }

    public function show(Pengadaan $pengadaan): View
    {
        $pengadaan->load(['jenisModal', 'kategori', 'jurusan', 'pengusul']);

        return view('pengadaans.show', compact('pengadaan'));
    }

    public function edit(Pengadaan $pengadaan): View
    {
        // Hanya usulan berstatus 'pending' yang boleh diedit
        // Jika sudah diproses, arahkan ke detail dengan pesan error
        if (! $pengadaan->isPending()) {
            return redirect()->route('pengadaans.show', $pengadaan)
                ->with('error', 'Usulan yang sudah diproses tidak dapat diedit.');
        }

        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $kategoris   = Kategori::orderBy('nama_kategori')->get();
        $jurusans    = Jurusan::orderBy('nama_jurusan')->get();

        return view('pengadaans.edit', compact('pengadaan', 'jenisModals', 'kategoris', 'jurusans'));
    }

    public function update(Request $request, Pengadaan $pengadaan): RedirectResponse
    {
        // Guard awal di Controller — sebelum menyentuh DB
        // Model event updating juga akan menangkap ini sebagai lapisan kedua
        if (! $pengadaan->isPending()) {
            return redirect()->back()
                ->with('error', 'Usulan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_barang_usulan' => 'required|string|max:255',
            'jenis_modal_id'     => 'required|exists:jenis_modals,id',
            'kategori_id'        => 'nullable|exists:kategoris,id',
            'jurusan_id'         => 'required|exists:jurusans,id',
            'jumlah'             => 'required|integer|min:1',
            'perkiraan_harga'    => 'required|integer|min:0',
            'alasan_pengadaan'   => 'required|string',
        ]);

        try {
            // Model event updating memberikan lapisan proteksi kedua
            // jika ada race condition (status berubah antara edit dan submit)
            $pengadaan->update($validated);

            return redirect()->route('pengadaans.show', $pengadaan)
                ->with('success', 'Usulan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Pengadaan $pengadaan): RedirectResponse
    {
        try {
            // Exception dilempar oleh Model event deleting
            // jika status_usulan bukan 'pending'
            $pengadaan->delete();

            return redirect()->route('pengadaans.index')
                ->with('success', 'Usulan pengadaan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
