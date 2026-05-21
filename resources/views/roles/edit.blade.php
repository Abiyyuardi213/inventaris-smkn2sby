@extends('layouts.app')

@section('title', 'Ubah Peran - Inventaris SMKN 2 SBY')
@section('page_title', 'Ubah Peran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back link and Title -->
    <div>
        <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Peran
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Ubah Peran</h2>
        <p class="text-sm text-zinc-500">Edit data peran "{{ $role->nama_role }}". Perubahan slug dapat mempengaruhi pengecekan middleware.</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nama Role -->
            <div class="space-y-2">
                <label for="nama_role" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Role <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_role" 
                    name="nama_role" 
                    value="{{ old('nama_role', $role->nama_role) }}"
                    placeholder="Contoh: Admin Sarpras, Petugas Lab"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_role') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    required
                >
                @error('nama_role')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="space-y-2">
                <label for="slug" class="text-sm font-medium leading-none text-zinc-900">
                    Slug
                </label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    value="{{ old('slug', $role->slug) }}"
                    placeholder="Contoh: admin-sarpras, petugas-lab"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('slug') ? 'border-red-500 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
                <p class="text-xs text-zinc-400">
                    Biarkan apa adanya jika Anda tidak ingin mengubah format route middleware yang sudah terintegrasi.
                </p>
                @error('slug')
                    <p class="text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('roles.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    Perbarui Peran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
