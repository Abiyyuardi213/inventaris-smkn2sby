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
    public function index(): View
    {
        // Eager load jurusan untuk menghindari query N+1 di view
        $ruangans = Ruangan::with('jurusan')->latest()->get();

        return view('ruangans.index', compact('ruangans'));
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
