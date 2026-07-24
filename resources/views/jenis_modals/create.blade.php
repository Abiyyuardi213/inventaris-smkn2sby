@extends('layouts.app')

@section('title', 'Tambah Jenis Modal - Inventaris SMKN 2 SBY')
@section('page_title', 'Tambah Jenis Modal')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('jenis-modals.index') }}" class="hover:text-zinc-900 transition-colors">Jenis Modal</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Tambah Jenis Modal</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('jenis-modals.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Jenis Modal
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Tambah Jenis Modal Baru</h2>
        <p class="text-sm text-zinc-500">Isi nama jenis modal — kode akan di-generate otomatis oleh sistem.</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('jenis-modals.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Jenis Modal --}}
            <div class="space-y-2">
                <label for="nama_jenis_modal" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Jenis Modal <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_jenis_modal"
                    name="nama_jenis_modal"
                    value="{{ old('nama_jenis_modal') }}"
                    placeholder="Contoh: Modal Peralatan dan Mesin, Modal Gedung dan Bangunan"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_jenis_modal') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors"
                    required
                    autofocus
                >
                @error('nama_jenis_modal')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Info: Kode Auto-Generate --}}
            <div class="rounded-md bg-teal-50 border border-teal-200/60 px-4 py-3 flex items-start gap-3">
                <svg class="w-4 h-4 text-teal-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <div>
                    <p class="text-xs font-semibold text-teal-700">Kode Jenis Modal akan di-generate otomatis</p>
                    <p class="text-xs text-teal-600 mt-0.5">
                        Sistem akan membuat kode dari singkatan huruf kapital tiap kata + nomor urut.<br>
                        Contoh: <span class="font-mono font-semibold">"Modal Peralatan dan Mesin"</span>
                        → <span class="font-mono font-semibold bg-teal-100 px-1 rounded">MPM-001</span>
                    </p>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('jenis-modals.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan Jenis Modal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
