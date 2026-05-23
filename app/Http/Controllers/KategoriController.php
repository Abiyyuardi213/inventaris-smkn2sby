<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::latest()->get();

        return view('kategoris.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('kategoris.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // kode_kategori tidak divalidasi karena di-generate otomatis oleh Model event creating
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori): View
    {
        return view('kategoris.show', compact('kategori'));
    }

    public function edit(Kategori $kategori): View
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        // Exclude ID kategori saat ini agar unique rule tidak menolak nama yang tidak berubah
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        try {
            // Exception dilempar oleh Model event deleting jika kategori masih dipakai inventaris
            $kategori->delete();

            return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
