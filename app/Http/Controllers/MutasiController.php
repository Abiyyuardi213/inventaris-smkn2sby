<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\Inventaris;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MutasiController extends Controller
{
    public function index(): View
    {
        $mutasis = Mutasi::with(['inventaris', 'ruanganAsal', 'ruanganTujuan', 'user'])
            ->latest()
            ->get();

        return view('mutasis.index', compact('mutasis'));
    }

    public function create(): View
    {
        $inventarisList = Inventaris::with(['ruangan', 'jurusan'])
            ->where('jumlah_total', '>', 0)
            ->get();

        $ruangans = Ruangan::with('jurusan')->orderBy('nama_ruangan')->get();

        $defaultNomor = 'MUT-' . date('Ymd') . '-' . str_pad(Mutasi::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        return view('mutasis.create', compact('inventarisList', 'ruangans', 'defaultNomor'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_mutasi' => 'required|string|max:100|unique:mutasis,nomor_mutasi',
            'inventaris_id' => 'required|exists:inventaris,id',
            'ruangan_tujuan_id' => 'required|exists:ruangans,id',
            'jumlah_dipindah' => 'required|integer|min:1',
            'tanggal_mutasi' => 'required|date',
            'keterangan_pindah' => 'required|string',
            'penanggung_jawab' => 'required|string|max:255',
        ]);

        $original = Inventaris::findOrFail($validated['inventaris_id']);

        // Validasi jumlah_dipindah tidak boleh melebihi jumlah_total saat ini
        if ($validated['jumlah_dipindah'] > $original->jumlah_total) {
            return back()
                ->withErrors(['jumlah_dipindah' => 'Jumlah yang dipindah melebihi stok barang saat ini (' . $original->jumlah_total . ' unit).'])
                ->withInput();
        }

        // Validasi ruangan tujuan tidak boleh sama dengan ruangan asal
        if ($original->ruangan_id === $validated['ruangan_tujuan_id']) {
            return back()
                ->withErrors(['ruangan_tujuan_id' => 'Ruangan tujuan tidak boleh sama dengan ruangan asal barang.'])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $original) {
                $targetRuangan = Ruangan::findOrFail($validated['ruangan_tujuan_id']);
                $targetJurusanId = $targetRuangan->jurusan_id;
                $ruanganAsalId = $original->ruangan_id;

                if ($validated['jumlah_dipindah'] === $original->jumlah_total) {
                    // Pindah seluruhnya: cukup update ruangan & jurusan pada record yang ada
                    $original->update([
                        'ruangan_id' => $validated['ruangan_tujuan_id'],
                        'jurusan_id' => $targetJurusanId
                    ]);
                    $inventarisIdForLog = $original->id;
                } else {
                    // Pindah sebagian: kurangi jumlah asal, buat record baru di ruangan tujuan
                    $original->decrement('jumlah_total', $validated['jumlah_dipindah']);

                    // Generate kode inventaris baru untuk barang hasil mutasi
                    $baseCode = $original->kode_inventaris;
                    $suffix = 1;
                    $newCode = $baseCode . '-M' . $suffix;
                    while (Inventaris::where('kode_inventaris', $newCode)->exists()) {
                        $suffix++;
                        $newCode = $baseCode . '-M' . $suffix;
                    }

                    $newInventaris = Inventaris::create([
                        'kode_inventaris' => $newCode,
                        'nama_barang' => $original->nama_barang,
                        'merek' => $original->merek,
                        'spesifikasi' => $original->spesifikasi,
                        'bahan' => $original->bahan,
                        'warna' => $original->warna,
                        'kategori_id' => $original->kategori_id,
                        'jurusan_id' => $targetJurusanId,
                        'ruangan_id' => $validated['ruangan_tujuan_id'],
                        'jumlah_total' => $validated['jumlah_dipindah'],
                        'harga_satuan' => $original->harga_satuan,
                        'sumber_dana' => $original->sumber_dana,
                        'nama_penyedia' => $original->nama_penyedia,
                        'nomor_surat_bast' => $original->nomor_surat_bast,
                        'kondisi' => $original->kondisi,
                        'tanggal_pengadaan' => $original->tanggal_pengadaan,
                        'foto_url' => $original->foto_url,
                    ]);
                    $inventarisIdForLog = $newInventaris->id;
                }

                // Simpan log mutasi
                Mutasi::create([
                    'nomor_mutasi' => $validated['nomor_mutasi'],
                    'inventaris_id' => $inventarisIdForLog,
                    'ruangan_asal_id' => $ruanganAsalId,
                    'ruangan_tujuan_id' => $validated['ruangan_tujuan_id'],
                    'jumlah_dipindah' => $validated['jumlah_dipindah'],
                    'tanggal_mutasi' => $validated['tanggal_mutasi'],
                    'keterangan_pindah' => $validated['keterangan_pindah'],
                    'penanggung_jawab' => $validated['penanggung_jawab'],
                    'user_id' => auth()->id(),
                ]);
            });

            return redirect()->route('mutasis.index')->with('success', 'Mutasi barang berhasil dilakukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses mutasi: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Mutasi $mutasi): View
    {
        $mutasi->load(['inventaris.kategori', 'ruanganAsal.jurusan', 'ruanganTujuan.jurusan', 'user']);
        return view('mutasis.show', compact('mutasi'));
    }
}
