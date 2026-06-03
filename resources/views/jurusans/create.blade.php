@extends('layouts.app')

@section('title', 'Tambah Unit Kerja - Inventaris SMKN 2 SBY')
@section('page_title', 'Tambah Unit Kerja')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('jurusans.index') }}" class="hover:text-zinc-900 transition-colors">Unit Kerja</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Tambah Unit Kerja</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('jurusans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Unit Kerja
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Tambah Unit Kerja Baru</h2>
        <p class="text-sm text-zinc-500">Isi nama unit kerja — kode akan di-generate otomatis oleh sistem.</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('jurusans.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Unit Kerja --}}
            <div class="space-y-2">
                <label for="nama_jurusan" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Unit Kerja <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_jurusan"
                    name="nama_jurusan"
                    value="{{ old('nama_jurusan') }}"
                    placeholder="Contoh: Tata Usaha"
                    class="flex h-10 w-full rounded-md border {{ $errors->has('nama_jurusan') ? 'border-red-400 focus:ring-red-500' : 'border-zinc-200 focus:ring-zinc-950' }} bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors"
                    required
                    autofocus
                >
                @error('nama_jurusan')
                    <p class="text-xs font-medium text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Info: Kode Auto-Generate --}}
            <div class="rounded-md bg-indigo-50 border border-indigo-200/60 px-4 py-3 flex items-start gap-3">
                <svg class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <div>
                    <p class="text-xs font-semibold text-indigo-700">Kode Unit Kerja akan di-generate otomatis</p>
                    <p class="text-xs text-indigo-600 mt-0.5">
                        Sistem akan membuat kode dari singkatan huruf kapital tiap kata + nomor urut.<br>
                        Contoh: <span class="font-mono font-semibold">"Tata Usaha"</span>
                        → <span class="font-mono font-semibold bg-indigo-100 px-1 rounded">TU-001</span>
                    </p>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('jurusans.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan Unit Kerja
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
