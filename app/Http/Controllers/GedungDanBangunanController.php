<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\JenisModal;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GedungDanBangunanController extends Controller
{
    public function index(Request $request): View
    {
        $jenisModalGedung = JenisModal::where('nama_jenis_modal', 'like', '%Gedung%')
            ->orWhere('nama_jenis_modal', 'like', '%Bangunan%')
            ->first();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::when($request->jurusan_id, fn ($query) => $query->where('jurusan_id', $request->jurusan_id))
            ->orderBy('nama_ruangan')
            ->get();

        $isSqlite = DB::getDriverName() === 'sqlite';
        $yearExpression = $isSqlite ? "strftime('%Y', tanggal_catat_aset)" : "YEAR(tanggal_catat_aset)";

        $tahunPengadaans = Inventaris::query()
            ->when($jenisModalGedung, fn($q) => $q->where('jenis_modal_id', $jenisModalGedung->id))
            ->selectRaw("{$yearExpression} as tahun")
            ->whereNotNull('tanggal_catat_aset')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->filter()
            ->values();

        $query = Inventaris::with(['jenisModal', 'kategori', 'jurusan', 'ruangan']);

        if ($jenisModalGedung) {
            $query->where('jenis_modal_id', $jenisModalGedung->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_inventaris', 'like', "%{$search}%")
                  ->orWhere('lokasi_alamat', 'like', "%{$search}%")
                  ->orWhere('dokumen_nomor', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('tahun_pengadaan')) {
            $query->whereYear('tanggal_catat_aset', $request->tahun_pengadaan);
        }
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        // Ringkasan Statistik Gedung & Bangunan
        $statsQuery = Inventaris::query();
        if ($jenisModalGedung) {
            $statsQuery->where('jenis_modal_id', $jenisModalGedung->id);
        }
        $totalBangunan = (clone $statsQuery)->count();
        $totalLuasLantai = (clone $statsQuery)->sum('luas_lantai') ?: 0;
        $totalNilai = (clone $statsQuery)->selectRaw('SUM(jumlah_total * harga_satuan) as total')->value('total') ?? 0;
        $totalKondisiBaik = (clone $statsQuery)->where('kondisi', 'baik')->count();

        return view('gedung_dan_bangunan.index', compact(
            'items',
            'jenisModalGedung',
            'kategoris',
            'jurusans',
            'ruangans',
            'tahunPengadaans',
            'totalBangunan',
            'totalLuasLantai',
            'totalNilai',
            'totalKondisiBaik'
        ));
    }

    public function create(): View
    {
        $jenisModalGedung = JenisModal::where('nama_jenis_modal', 'like', '%Gedung%')
            ->orWhere('nama_jenis_modal', 'like', '%Bangunan%')
            ->first();
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        // Standard auto-generated code
        $lastInventaris = Inventaris::where('kode_inventaris', 'like', 'GDG-%')
            ->orderBy('created_at', 'desc')
            ->first();
        $nextNum = $lastInventaris ? ((int) substr($lastInventaris->kode_inventaris, 4)) + 1 : 1;
        $autoKode = 'GDG-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        return view('gedung_dan_bangunan.create', compact(
            'jenisModalGedung',
            'jenisModals',
            'kategoris',
            'jurusans',
            'ruangans',
            'autoKode'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_inventaris' => 'required|string|max:50|unique:inventaris,kode_inventaris',
            'nama_barang' => 'required|string|max:255',
            'jenis_modal_id' => 'nullable|exists:jenis_modals,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_sedang,rusak_berat,layak,rusak,kurang_baik',
            'konstruksi_bertingkat' => 'required|string|max:50',
            'konstruksi_beton' => 'required|string|max:50',
            'luas_lantai' => 'nullable|numeric|min:0',
            'lokasi_alamat' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:100',
            'luas_tanah' => 'nullable|numeric|min:0',
            'status_tanah' => 'nullable|string|max:100',
            'nomor_kode_tanah' => 'nullable|string|max:100',
            'sumber_dana' => 'nullable|string|max:100',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah_total' => 'required|integer|min:1',
            'tanggal_catat_aset' => 'required|date',
            'merek' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable|string',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        $validated['merek'] = $validated['merek'] ?? '-';
        $validated['spesifikasi'] = $validated['spesifikasi'] ?? '-';
        $validated['bahan'] = $validated['bahan'] ?? '-';

        Inventaris::create($validated);

        return redirect()->route('gedung-dan-bangunan.index')->with('success', 'Data Gedung dan Bangunan berhasil ditambahkan.');
    }

    public function edit(Inventaris $gedungDanBangunan): View
    {
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('gedung_dan_bangunan.edit', compact(
            'gedungDanBangunan',
            'jenisModals',
            'kategoris',
            'jurusans',
            'ruangans'
        ));
    }

    public function update(Request $request, Inventaris $gedungDanBangunan): RedirectResponse
    {
        $validated = $request->validate([
            'kode_inventaris' => [
                'required',
                'string',
                'max:50',
                Rule::unique('inventaris', 'kode_inventaris')->ignore($gedungDanBangunan->id),
            ],
            'nama_barang' => 'required|string|max:255',
            'jenis_modal_id' => 'nullable|exists:jenis_modals,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_sedang,rusak_berat,layak,rusak,kurang_baik',
            'konstruksi_bertingkat' => 'required|string|max:50',
            'konstruksi_beton' => 'required|string|max:50',
            'luas_lantai' => 'nullable|numeric|min:0',
            'lokasi_alamat' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:100',
            'luas_tanah' => 'nullable|numeric|min:0',
            'status_tanah' => 'nullable|string|max:100',
            'nomor_kode_tanah' => 'nullable|string|max:100',
            'sumber_dana' => 'nullable|string|max:100',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah_total' => 'required|integer|min:1',
            'tanggal_catat_aset' => 'required|date',
            'merek' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable|string',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        $validated['merek'] = $validated['merek'] ?? '-';
        $validated['spesifikasi'] = $validated['spesifikasi'] ?? '-';
        $validated['bahan'] = $validated['bahan'] ?? '-';

        $gedungDanBangunan->update($validated);

        return redirect()->route('gedung-dan-bangunan.index')->with('success', 'Data Gedung dan Bangunan berhasil diperbarui.');
    }

    public function show(Inventaris $gedungDanBangunan): View
    {
        $gedungDanBangunan->load(['jenisModal', 'kategori', 'jurusan', 'ruangan']);

        return view('gedung_dan_bangunan.show', compact('gedungDanBangunan'));
    }

    public function destroy(Inventaris $gedungDanBangunan): RedirectResponse
    {
        $gedungDanBangunan->delete();

        return redirect()->route('gedung-dan-bangunan.index')->with('success', 'Data Gedung dan Bangunan berhasil dihapus.');
    }

    public function printKibC(Request $request): View
    {
        return app(InventarisController::class)->printKibC($request);
    }
}
