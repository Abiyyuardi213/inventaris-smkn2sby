<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RuanganController extends Controller
{
    public function monitor(): View
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $ruangans = Ruangan::with([
                'jurusan',
                'inventaris' => fn ($query) => $query
                    ->with('kategori')
                    ->orderBy('nama_barang'),
            ])
            ->withCount('inventaris')
            ->withSum('inventaris as total_unit', 'jumlah_total')
            ->when(request('jurusan_id'), fn($q) => $q->where('jurusan_id', request('jurusan_id')))
            ->orderBy('nama_ruangan')
            ->get();

        $roomAssets = $ruangans->mapWithKeys(fn (Ruangan $ruangan) => [
            $ruangan->id => [
                'nama' => $ruangan->nama_ruangan,
                'unitKerja' => $ruangan->jurusan?->nama_jurusan ?? 'Tanpa Unit Kerja',
                'kodeUnit' => $ruangan->jurusan?->kode_jurusan ?? 'Unit Kerja',
                'totalJenis' => $ruangan->inventaris_count,
                'totalUnit' => $ruangan->total_unit ?? 0,
                'assets' => $ruangan->inventaris->map(fn ($item) => [
                    'kode' => $item->kode_inventaris,
                    'nama' => $item->nama_barang,
                    'merek' => $item->merek,
                    'kategori' => $item->kategori?->nama_kategori ?? '-',
                    'jumlah' => $item->jumlah_total,
                    'kondisi' => $item->kondisi,
                ])->values(),
            ],
        ]);

        return view('ruangans.monitor', compact('ruangans', 'jurusans', 'roomAssets'));
    }

    public function index(): View
    {
        // $jurusans dikirim ke view untuk dropdown filter by jurusan
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        // Filter opsional by jurusan_id via GET parameter dengan pagination 10 per halaman
        $ruangans = Ruangan::with('jurusan')
            ->when(request('jurusan_id'), fn($q) => $q->where('jurusan_id', request('jurusan_id')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('ruangans.index', compact('ruangans', 'jurusans'));
    }

    public function create(): View
    {
        // Data jurusan untuk dropdown pilihan di form create
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        return view('ruangans.create', compact('jurusans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            // Unique kombinasi: nama_ruangan harus unik per jurusan,
            // bukan unik secara global — satu nama bisa ada di jurusan berbeda
            'nama_ruangan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ruangans')->where('jurusan_id', $request->jurusan_id),
            ],
        ]);

        Ruangan::create($validated);

        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Ruangan $ruangan): View
    {
        $ruangan->load('jurusan');

        return view('ruangans.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan): View
    {
        // Data jurusan untuk dropdown pilihan di form edit
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();

        return view('ruangans.edit', compact('ruangan', 'jurusans'));
    }

    public function update(Request $request, Ruangan $ruangan): RedirectResponse
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            // Unique kombinasi dengan pengecualian ID ruangan saat ini,
            // agar nama yang tidak berubah tidak dianggap duplikat
            'nama_ruangan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ruangans')
                    ->where('jurusan_id', $request->jurusan_id)
                    ->ignore($ruangan->id),
            ],
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        try {
            // Exception dilempar oleh Model event deleting jika masih ada data inventaris
            $ruangan->delete();

            return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
