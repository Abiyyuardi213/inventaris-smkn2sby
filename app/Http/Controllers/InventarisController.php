<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use App\Models\JenisModal;
use App\Models\Jurusan;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InventarisController extends Controller
{
    public function index(): View
    {
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::when(request('jurusan_id'), fn ($query) => $query->where('jurusan_id', request('jurusan_id')))
            ->orderBy('nama_ruangan')
            ->get();
        $isSqlite = DB::getDriverName() === 'sqlite';
        $yearExpression = $isSqlite ? "strftime('%Y', tanggal_pengadaan)" : "YEAR(tanggal_pengadaan)";

        $tahunPengadaans = Inventaris::query()
            ->selectRaw("{$yearExpression} as tahun")
            ->whereNotNull('tanggal_pengadaan')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Filter opsional by jenis modal, jurusan, ruangan, tahun pengadaan, kondisi, atau search (nama, merk, atau type)
        $inventaris = Inventaris::with(['jenisModal', 'jurusan', 'ruangan'])
            ->when(request('search'), function($q) {
                $search = request('search');
                $q->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('merek', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->when(request('jenis_modal_id'), fn($q) => $q->where('jenis_modal_id', request('jenis_modal_id')))
            ->when(request('jurusan_id'), fn($q) => $q->where('jurusan_id', request('jurusan_id')))
            ->when(request('ruangan_id'), fn($q) => $q->where('ruangan_id', request('ruangan_id')))
            ->when(request('tahun_pengadaan'), fn($q) => $q->whereYear('tanggal_pengadaan', request('tahun_pengadaan')))
            ->when(request('kondisi'), fn($q) => $q->where('kondisi', request('kondisi')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inventaris.index', compact('inventaris', 'jenisModals', 'jurusans', 'ruangans', 'tahunPengadaans'));
    }

    public function printPdf(): View
    {
        $ruangans = Ruangan::with([
                'jurusan',
                'inventaris' => fn ($query) => $query
                    ->with('jenisModal')
                    ->orderBy('nama_barang'),
            ])
            ->withCount('inventaris')
            ->withSum('inventaris as total_unit', 'jumlah_total')
            ->whereHas('inventaris')
            ->orderBy('nama_ruangan')
            ->get();

        $totalJenis = $ruangans->sum('inventaris_count');
        $totalUnit = $ruangans->sum(fn (Ruangan $ruangan) => $ruangan->total_unit ?? 0);

        return view('inventaris.print-pdf', compact('ruangans', 'totalJenis', 'totalUnit'));
    }

    public function scan(): View
    {
        return view('inventaris.scan');
    }

    public function resolveScan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'value' => 'required|string|max:2048',
        ]);

        $scanValue = trim($validated['value']);
        $candidate = $this->extractInventarisIdentifier($scanValue);

        $inventaris = Inventaris::with(['jenisModal', 'jurusan', 'ruangan'])
            ->where('id', $candidate)
            ->orWhere('kode_inventaris', $candidate)
            ->first();

        if (! $inventaris && $candidate !== $scanValue) {
            $inventaris = Inventaris::with(['jenisModal', 'jurusan', 'ruangan'])
                ->where('id', $scanValue)
                ->orWhere('kode_inventaris', $scanValue)
                ->first();
        }

        if (! $inventaris) {
            return response()->json([
                'found' => false,
                'message' => 'Data inventaris tidak ditemukan dari hasil scan tersebut.',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'redirect_url' => route('inventaris.show', $inventaris->id),
            'item' => [
                'id' => $inventaris->id,
                'kode_inventaris' => $inventaris->kode_inventaris,
                'nama_barang' => $inventaris->nama_barang,
                'merek' => $inventaris->merek,
                'type' => $inventaris->type ?? '-',
                'spesifikasi' => $inventaris->spesifikasi,
                'bahan' => $inventaris->bahan ?? '-',
                'warna' => $inventaris->warna ?? '-',
                'jumlah_total' => $inventaris->jumlah_total,
                'harga_satuan' => 'Rp ' . number_format($inventaris->harga_satuan ?? 0, 0, ',', '.'),
                'harga_total' => 'Rp ' . number_format($inventaris->harga_total ?? 0, 0, ',', '.'),
                'sumber_dana' => $inventaris->sumber_dana ?? '-',
                'nama_penyedia' => $inventaris->nama_penyedia ?? '-',
                'nomor_surat_bast' => $inventaris->nomor_surat_bast ?? '-',
                'kondisi' => $inventaris->kondisi,
                'kategori' => $inventaris->jenisModal?->nama_jenis_modal,
                'jurusan' => $inventaris->jurusan?->nama_jurusan,
                'ruangan' => $inventaris->ruangan?->nama_ruangan,
                'tanggal_pengadaan' => $inventaris->tanggal_pengadaan?->format('d M Y'),
            ],
        ]);
    }

    private function extractInventarisIdentifier(string $scanValue): string
    {
        $path = parse_url($scanValue, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return $scanValue;
        }

        $segments = array_values(array_filter(explode('/', trim($path, '/'))));
        $inventarisIndex = array_search('inventaris', $segments, true);

        if ($inventarisIndex === false || ! isset($segments[$inventarisIndex + 1])) {
            return $scanValue;
        }

        return $segments[$inventarisIndex + 1];
    }

    public function create(): View
    {
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.create', compact('jenisModals', 'jurusans', 'ruangans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_inventaris' => 'required|string|max:100|unique:inventaris,kode_inventaris',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'required|string|max:100',
            'type' => 'nullable|string|max:255',
            'spesifikasi' => 'required|string',
            'bahan' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'jenis_modal_id' => 'required|exists:jenis_modals,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'ruangan_id' => [
                'required',
                'exists:ruangans,id',
                // Ruangan harus berada pada jurusan yang dipilih
                function ($attribute, $value, $fail) use ($request) {
                    $ruangan = Ruangan::find($value);
                    if ($ruangan && $ruangan->jurusan_id !== $request->jurusan_id) {
                        $fail('Ruangan yang dipilih harus sesuai dengan jurusan yang dipilih.');
                    }
                }
            ],
            'jumlah_total' => 'required|integer|min:0',
            'harga_satuan' => 'required|integer|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'nama_penyedia' => 'nullable|string|max:255',
            'nomor_surat_bast' => 'nullable|string|max:255',
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        Inventaris::create($validated);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    public function show(Inventaris $inventari): View
    {
        $inventari->load(['jenisModal', 'jurusan', 'ruangan']);
        return view('inventaris.show', ['inventaris' => $inventari]);
    }

    public function edit(Inventaris $inventari): View
    {
        $jenisModals = JenisModal::orderBy('nama_jenis_modal')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.edit', [
            'inventaris' => $inventari,
            'jenisModals' => $jenisModals,
            'jurusans' => $jurusans,
            'ruangans' => $ruangans
        ]);
    }

    public function update(Request $request, Inventaris $inventari): RedirectResponse
    {
        $validated = $request->validate([
            'kode_inventaris' => [
                'required',
                'string',
                'max:100',
                Rule::unique('inventaris')->ignore($inventari->id),
            ],
            'nama_barang' => 'required|string|max:255',
            'merek' => 'required|string|max:100',
            'type' => 'nullable|string|max:255',
            'spesifikasi' => 'required|string',
            'bahan' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'jenis_modal_id' => 'required|exists:jenis_modals,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'ruangan_id' => [
                'required',
                'exists:ruangans,id',
                // Ruangan harus berada pada jurusan yang dipilih
                function ($attribute, $value, $fail) use ($request) {
                    $ruangan = Ruangan::find($value);
                    if ($ruangan && $ruangan->jurusan_id !== $request->jurusan_id) {
                        $fail('Ruangan yang dipilih harus sesuai dengan jurusan yang dipilih.');
                    }
                }
            ],
            'jumlah_total' => 'required|integer|min:0',
            'harga_satuan' => 'required|integer|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'nama_penyedia' => 'nullable|string|max:255',
            'nomor_surat_bast' => 'nullable|string|max:255',
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        $inventari->update($validated);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventari): RedirectResponse
    {
        try {
            // Hapus file QR code di storage sebelum data barang dihapus
            if ($inventari->qr_code_path) {
                Storage::disk('public')->delete($inventari->qr_code_path);
            }
            $inventari->delete();
            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman cetak label untuk satu barang inventaris.
     *
     * @param  \App\Models\Inventaris  $inventari
     * @return \Illuminate\View\View
     */
    public function printLabel(Inventaris $inventari): View
    {
        $inventari->load(['jenisModal', 'jurusan', 'ruangan']);
        
        // Pastikan QR code sudah ter-generate (jika data lama belum ada atau bukan format svg)
        if (empty($inventari->qr_code_path) || !str_ends_with($inventari->qr_code_path, '.svg') || !Storage::disk('public')->exists($inventari->qr_code_path)) {
            $inventari->generateQrCode();
            $inventari->saveQuietly();
        }
 
        return view('inventaris.print-label', ['item' => $inventari]);
    }
 
    /**
     * Tampilkan halaman cetak label massal untuk barang inventaris terpilih.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function printLabelBulk(Request $request)
    {
        $itemsQuery = Inventaris::with(['jenisModal', 'jurusan', 'ruangan']);
 
        if ($request->boolean('all')) {
            $itemsQuery
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search;
                    $query->where(function ($query) use ($search) {
                        $query->where('nama_barang', 'like', "%{$search}%")
                              ->orWhere('merek', 'like', "%{$search}%")
                              ->orWhere('type', 'like', "%{$search}%");
                    });
                })
                ->when($request->filled('jenis_modal_id'), fn ($query) => $query->where('jenis_modal_id', $request->jenis_modal_id))
                ->when($request->filled('jurusan_id'), fn ($query) => $query->where('jurusan_id', $request->jurusan_id))
                ->when($request->filled('ruangan_id'), fn ($query) => $query->where('ruangan_id', $request->ruangan_id))
                ->when($request->filled('tahun_pengadaan'), fn ($query) => $query->whereYear('tanggal_pengadaan', $request->tahun_pengadaan))
                ->when($request->filled('kondisi'), fn ($query) => $query->where('kondisi', $request->kondisi));
        } else {
            // Mendapatkan array ID dari input (misal 'ids' query string atau form array)
            $ids = $request->input('ids');

            if (empty($ids)) {
                return redirect()->back()->with('error', 'Pilih minimal satu barang untuk mencetak label.');
            }

            // Jika dikirim sebagai string terpisah koma (misal ?ids=uuid1,uuid2)
            if (is_string($ids)) {
                $ids = explode(',', $ids);
            }

            $itemsQuery->whereIn('id', $ids);
        }

        $items = $itemsQuery
            ->orderBy('nama_barang')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Pilih minimal satu barang untuk mencetak label.');
        }
 
        // Pastikan QR code masing-masing item sudah ter-generate (jika data lama belum ada atau bukan format svg)
        foreach ($items as $item) {
            if (empty($item->qr_code_path) || !str_ends_with($item->qr_code_path, '.svg') || !Storage::disk('public')->exists($item->qr_code_path)) {
                $item->generateQrCode();
                $item->saveQuietly();
            }
        }
 
        return view('inventaris.print-label-bulk', compact('items'));
    }

    /**
     * Regenerasi QR code secara manual untuk satu barang inventaris.
     *
     * @param  \App\Models\Inventaris  $inventari
     * @return \Illuminate\Http\RedirectResponse
     */
    public function regenerateQr(Inventaris $inventari): RedirectResponse
    {
        try {
            $inventari->generateQrCode();
            $inventari->saveQuietly();
            return redirect()->back()->with('success', 'QR Code berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui QR Code: ' . $e->getMessage());
        }
    }

    /**
     * Hapus beberapa barang inventaris terpilih.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBulk(Request $request): RedirectResponse
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu barang untuk dihapus.');
        }

        try {
            $items = Inventaris::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                if ($item->qr_code_path) {
                    Storage::disk('public')->delete($item->qr_code_path);
                }
                $item->delete();
            }
            return redirect()->route('inventaris.index')->with('success', count($items) . ' data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data inventaris terpilih: ' . $e->getMessage());
        }
    }

    /**
     * Hapus seluruh data barang inventaris.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAll(): RedirectResponse
    {
        try {
            $items = Inventaris::all();
            foreach ($items as $item) {
                if ($item->qr_code_path) {
                    Storage::disk('public')->delete($item->qr_code_path);
                }
                $item->delete();
            }
            return redirect()->route('inventaris.index')->with('success', 'Seluruh data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus seluruh data inventaris: ' . $e->getMessage());
        }
    }
}
