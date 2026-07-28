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
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori Barang berhasil ditambahkan.');
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
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori Barang berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        try {
            $kategori->delete();

            return redirect()->route('kategoris.index')->with('success', 'Kategori Barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
