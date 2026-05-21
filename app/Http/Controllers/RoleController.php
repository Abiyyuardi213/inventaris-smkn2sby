<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::latest()->get();

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role',
            'slug' => 'nullable|string|max:255|unique:roles,slug',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_role']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Peran berhasil dibuat.');
    }

    public function show(Role $role): View
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role,' . $role->id,
            'slug' => 'nullable|string|max:255|unique:roles,slug,' . $role->id,
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_role']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Peran berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->users()->exists()) {
            return redirect()->back()->with('error', 'Peran tidak dapat dihapus karena masih digunakan oleh beberapa pengguna.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Peran berhasil dihapus.');
    }
}
