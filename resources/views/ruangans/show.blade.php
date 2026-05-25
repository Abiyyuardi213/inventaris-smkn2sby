@extends('layouts.app')

@section('title', 'Detail Ruangan - Inventaris SMKN 2 SBY')
@section('page_title', 'Detail Ruangan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <a href="{{ route('ruangans.index') }}" class="hover:text-zinc-900 transition-colors">Ruangan</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Detail Ruangan</span>
    </nav>

    {{-- Page Heading --}}
    <div>
        <a href="{{ route('ruangans.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar Ruangan
        </a>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Detail Ruangan</h2>
        <p class="text-sm text-zinc-500">Informasi lengkap ruangan dan inventaris yang terdaftar.</p>
    </div>

    {{-- Info Card --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/60 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-zinc-900 text-sm">{{ $ruangan->nama_ruangan }}</p>
                <span class="inline-flex items-center rounded-md bg-violet-50 px-2 py-0.5 text-xs font-semibold text-violet-700 border border-violet-200/60">
                    {{ $ruangan->jurusan->nama_jurusan ?? '-' }}
                </span>
            </div>
        </div>

        {{-- Card Body: Info Grid --}}
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Nama Ruangan</span>
                <span class="text-base font-semibold text-zinc-900">{{ $ruangan->nama_ruangan }}</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Jurusan</span>
                @if ($ruangan->jurusan)
                    <a href="{{ route('jurusans.show', $ruangan->jurusan->id) }}"
                        class="inline-flex items-center gap-1.5 rounded-md bg-violet-50 px-2.5 py-1 text-sm font-semibold text-violet-700 border border-violet-200/60 hover:bg-violet-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                        {{ $ruangan->jurusan->nama_jurusan }}
                    </a>
                @else
                    <span class="text-sm text-zinc-400 italic">Tidak ada jurusan</span>
                @endif
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Tanggal Dibuat</span>
                <span class="text-sm text-zinc-700">{{ $ruangan->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
            <div>
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider block mb-1">Terakhir Diperbarui</span>
                <span class="text-sm text-zinc-700">{{ $ruangan->updated_at->format('d F Y, H:i') }} WIB</span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-zinc-100 bg-zinc-50/40">
            <a href="{{ route('ruangans.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Kembali ke Daftar
            </a>
            <a href="{{ route('ruangans.edit', $ruangan->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.83 20.013a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
                Edit Ruangan
            </a>
        </div>
    </div>

    {{-- Inventaris Placeholder --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        {{-- Section Header --}}
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <h3 class="text-sm font-semibold text-zinc-900">Inventaris di Ruangan Ini</h3>
            </div>
            <span class="inline-flex items-center gap-1 text-xs text-amber-600 bg-amber-50 border border-amber-200/60 px-2.5 py-1 rounded-full font-medium">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Segera Hadir
            </span>
        </div>

        {{-- Empty / Coming Soon State --}}
        <div class="px-6 py-14 text-center">
            <div class="flex flex-col items-center justify-center gap-3">
                <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-zinc-700 text-sm">Modul Inventaris Belum Tersedia</p>
                    <p class="text-xs text-zinc-400 mt-1 max-w-xs mx-auto">
                        Daftar inventaris yang berada di ruangan ini akan ditampilkan di sini setelah modul Inventaris selesai dibangun.
                    </p>
                </div>
                <div class="mt-1 inline-flex items-center gap-1.5 text-xs text-amber-700 bg-amber-50 border border-amber-200/60 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    Fitur ini akan tersedia pada versi berikutnya
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
