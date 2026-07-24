<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisModal;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisModalController extends Controller
{
    public function index(): View
    {
        $jenisModals = JenisModal::latest()->get();

        return view('jenis_modals.index', compact('jenisModals'));
    }

    public function create(): View
    {
        return view('jenis_modals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // kode_jenis_modal tidak divalidasi karena di-generate otomatis oleh Model event creating
        $validated = $request->validate([
            'nama_jenis_modal' => 'required|string|max:100|unique:jenis_modals,nama_jenis_modal',
        ]);

        JenisModal::create($validated);

        return redirect()->route('jenis-modals.index')->with('success', 'Jenis Modal berhasil ditambahkan.');
    }

    public function show(JenisModal $jenisModal): View
    {
        return view('jenis_modals.show', compact('jenisModal'));
    }

    public function edit(JenisModal $jenisModal): View
    {
        return view('jenis_modals.edit', compact('jenisModal'));
    }

    public function update(Request $request, JenisModal $jenisModal): RedirectResponse
    {
        // Exclude ID jenis modal saat ini agar unique rule tidak menolak nama yang tidak berubah
        $validated = $request->validate([
            'nama_jenis_modal' => 'required|string|max:100|unique:jenis_modals,nama_jenis_modal,' . $jenisModal->id,
        ]);

        $jenisModal->update($validated);

        return redirect()->route('jenis-modals.index')->with('success', 'Jenis Modal berhasil diperbarui.');
    }

    public function destroy(JenisModal $jenisModal): RedirectResponse
    {
        try {
            // Exception dilempar oleh Model event deleting jika jenis modal masih dipakai inventaris
            $jenisModal->delete();

            return redirect()->route('jenis-modals.index')->with('success', 'Jenis Modal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
