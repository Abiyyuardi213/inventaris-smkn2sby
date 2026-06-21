<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use App\Models\Kategori;
use App\Models\Jurusan;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::when(request('jurusan_id'), fn ($query) => $query->where('jurusan_id', request('jurusan_id')))
            ->orderBy('nama_ruangan')
            ->get();
        $tahunPengadaans = Inventaris::query()
            ->selectRaw('YEAR(tanggal_pengadaan) as tahun')
            ->whereNotNull('tanggal_pengadaan')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Filter opsional by kategori, jurusan, ruangan, tahun pengadaan, atau kondisi
        $inventaris = Inventaris::with(['kategori', 'jurusan', 'ruangan'])
            ->when(request('kategori_id'), fn($q) => $q->where('kategori_id', request('kategori_id')))
            ->when(request('jurusan_id'), fn($q) => $q->where('jurusan_id', request('jurusan_id')))
            ->when(request('ruangan_id'), fn($q) => $q->where('ruangan_id', request('ruangan_id')))
            ->when(request('tahun_pengadaan'), fn($q) => $q->whereYear('tanggal_pengadaan', request('tahun_pengadaan')))
            ->when(request('kondisi'), fn($q) => $q->where('kondisi', request('kondisi')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inventaris.index', compact('inventaris', 'kategoris', 'jurusans', 'ruangans', 'tahunPengadaans'));
    }

    public function printPdf(): View
    {
        $ruangans = Ruangan::with([
                'jurusan',
                'inventaris' => fn ($query) => $query
                    ->with('kategori')
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

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.create', compact('kategoris', 'jurusans', 'ruangans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_inventaris' => 'required|string|max:100|unique:inventaris,kode_inventaris',
            'nama_barang' => 'required|string|max:255',
            'merek' => 'required|string|max:100',
            'spesifikasi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
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
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
            'foto_url' => 'nullable|url|max:2048',
        ]);

        Inventaris::create($validated);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    public function show(Inventaris $inventari): View
    {
        $inventari->load(['kategori', 'jurusan', 'ruangan']);
        return view('inventaris.show', ['inventaris' => $inventari]);
    }

    public function edit(Inventaris $inventari): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        return view('inventaris.edit', [
            'inventaris' => $inventari,
            'kategoris' => $kategoris,
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
            'spesifikasi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
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
        $inventari->load(['kategori', 'jurusan', 'ruangan']);
        
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
        // Mendapatkan array ID dari input (misal 'ids' query string atau form array)
        $ids = $request->input('ids');
 
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu barang untuk mencetak label.');
        }
 
        // Jika dikirim sebagai string terpisah koma (misal ?ids=uuid1,uuid2)
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
 
        // Fetch all matching items with necessary relations
        $items = Inventaris::with(['kategori', 'jurusan', 'ruangan'])
            ->whereIn('id', $ids)
            ->get();
 
        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Barang inventaris tidak ditemukan.');
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
}
