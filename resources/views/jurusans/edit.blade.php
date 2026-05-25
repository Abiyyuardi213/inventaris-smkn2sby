@extends('layouts.app')

@section('title', 'Edit Jurusan - Inventaris SMKN 2 SBY')
@section('page_title', 'Edit Jurusan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('jurusans.index') }}" class="hover:text-zinc-900 transition-colors">Jurusan</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Edit Jurusan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('jurusans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Jurusan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Edit Jurusan</h2>
        <p class="text-sm text-zinc-500">Perbarui nama jurusan. Kode jurusan tidak dapat diubah.</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <form action="{{ route('jurusans.update', $jurusan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Kode Jurusan (readonly) --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-medium leading-none text-zinc-900">
                        Kode Jurusan
                    </label>
                    {{-- Tooltip badge --}}
                    <span class="inline-flex items-center gap-1 text-xs text-amber-600 bg-amber-50 border border-amber-200/60 px-2 py-0.5 rounded-full font-medium">
                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Kode tidak dapat diubah
                    </span>
                </div>
                <div class="flex h-10 w-full items-center rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm cursor-not-allowed">
                    <span class="inline-flex items-center rounded bg-indigo-50 px-2 py-0.5 text-xs font-mono font-semibold text-indigo-700 border border-indigo-200/60 tracking-wide">
                        {{ $jurusan->kode_jurusan }}
                    </span>
                </div>
                <p class="text-xs text-zinc-400">
                    Kode ini di-generate otomatis saat jurusan pertama kali dibuat dan bersifat permanen.
                </p>
            </div>

            {{-- Nama Jurusan --}}
            <div class="space-y-2">
                <label for="nama_jurusan" class="text-sm font-medium leading-none text-zinc-900">
                    Nama Jurusan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama_jurusan"
                    name="nama_jurusan"
                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}"
                    placeholder="Contoh: Teknik Komputer Jaringan"
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

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <a href="{{ route('jurusans.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Update Jurusan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
