<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JurusanController extends Controller
{
    public function index(): View
    {
        // Hitung jumlah ruangan per jurusan tanpa query N+1
        $jurusans = Jurusan::withCount('ruangans')->latest()->get();

        return view('jurusans.index', compact('jurusans'));
    }

    public function create(): View
    {
        return view('jurusans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // kode_jurusan tidak divalidasi karena di-generate otomatis oleh Model event creating
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan',
        ]);

        Jurusan::create($validated);

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(Jurusan $jurusan): View
    {
        // Eager load ruangan milik jurusan ini
        $jurusan->load('ruangans');

        return view('jurusans.show', compact('jurusan'));
    }

    public function edit(Jurusan $jurusan): View
    {
        return view('jurusans.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan): RedirectResponse
    {
        // Exclude ID jurusan saat ini agar unique rule tidak menolak nama yang tidak berubah
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan,' . $jurusan->id,
        ]);

        $jurusan->update($validated);

        return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        try {
            // Exception dilempar oleh Model event deleting jika masih ada ruangan terdaftar
            $jurusan->delete();

            return redirect()->route('jurusans.index')->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
