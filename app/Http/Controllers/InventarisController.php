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

class InventarisController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        // Filter opsional by kategori, jurusan, ruangan, atau kondisi
        $inventaris = Inventaris::with(['kategori', 'jurusan', 'ruangan'])
            ->when(request('kategori_id'), fn($q) => $q->where('kategori_id', request('kategori_id')))
            ->when(request('jurusan_id'), fn($q) => $q->where('jurusan_id', request('jurusan_id')))
            ->when(request('ruangan_id'), fn($q) => $q->where('ruangan_id', request('ruangan_id')))
            ->when(request('kondisi'), fn($q) => $q->where('kondisi', request('kondisi')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('inventaris.index', compact('inventaris', 'kategoris', 'jurusans', 'ruangans'));
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
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
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
            'kondisi' => 'required|in:baik,layak,rusak',
            'tanggal_pengadaan' => 'required|date',
        ]);

        $inventari->update($validated);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventari): RedirectResponse
    {
        try {
            $inventari->delete();
            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
